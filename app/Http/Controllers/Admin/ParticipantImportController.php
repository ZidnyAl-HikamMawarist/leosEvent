<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParticipantImportController extends Controller
{
    public function store(Request $request)
    {
$request->validate([
            'file_csv' => 'required|file|mimes:csv,txt,text/plain,xlsx,xls|max:5120',  // Flexible MIME + size limit 5MB
        ]);

        $file = $request->file('file_csv');
        $filePath = $file->getRealPath();
        
        // --- 1. SMART DELIMITER DETECTION ---
        $delimiters = [",", ";", "\t"];
        $delimiter = ","; 
        $maxCols = 0;
        
        foreach ($delimiters as $d) {
            $testHandle = fopen($filePath, 'r');
            $bom = fread($testHandle, 3);
            if ($bom !== "\xEF\xBB\xBF") rewind($testHandle);
            
            $testHeader = fgetcsv($testHandle, 0, $d);
            fclose($testHandle);
            
            if ($testHeader && count($testHeader) > $maxCols) {
                $maxCols = count($testHeader);
                $delimiter = $d;
            }
        }
        
        $handle = fopen($filePath, 'r');
        $bom = fread($handle, 3);
        if ($bom !== "\xEF\xBB\xBF") rewind($handle);
        $header = fgetcsv($handle, 0, $delimiter);
        
        if (!$header) return back()->with('error', 'File CSV kosong atau tidak valid.');

        $allLombas = \App\Models\Lomba::all();

        // --- 2. ULTRA-FUZZY MATCHING HELPER ---
        $matchLomba = function($text) use ($allLombas) {
            $text = strtolower(trim($text));
            if (empty($text) || strlen($text) < 3) return null;

            foreach ($allLombas as $l) {
                $lName = strtolower(trim($l->nama_lomba));
                
                // Direct/Partial match
                if ($lName == $text || str_contains($text, $lName) || str_contains($lName, $text)) return $l->id;

                // Keyword matching
                $keywords = preg_split('/[\s\-]+/', $lName, -1, PREG_SPLIT_NO_EMPTY);
                $keywords = array_filter($keywords, fn($w) => strlen($w) > 2 && !in_array($w, ['dan', 'atau', 'non']));
                if (empty($keywords)) continue;

                $matchCount = 0;
                foreach ($keywords as $word) {
                    if (str_contains($text, $word)) $matchCount++;
                }
                if ($matchCount / count($keywords) >= 0.5) return $l->id;
            }
            return null;
        };

        $successCount = 0;
        $skipCount = 0;
        $errors = [];
        $batchId = 'batch_' . time();
        $rowNum = 1; // Track row number (excluding header)

        // --- 3. BRUTE-FORCE ROW SCANNING ---
        while (($data = fgetcsv($handle, 0, $delimiter)) !== FALSE) {
            $rowNum++;
            try {
                if (empty(array_filter($data, fn($v) => !is_null($v) && trim($v) !== ''))) continue;

                $foundLombaId = null;
                $pendaftarData = [
                    'nama' => null,
                    'sekolah' => null,
                    'no_wa' => null,
                    'email' => null,
                    'nama_pembina' => null,
                    'no_hp_pembina' => null,
                    'tanggal' => null,
                    'status' => 'confirmed',
                    'metode_pembayaran' => 'tunai',
                ];

                // STEP A: Find Lomba first by scanning ALL cells in the row
                foreach ($data as $idx => $cellValue) {
                    $lId = $matchLomba($cellValue);
                    if ($lId) {
                        $foundLombaId = $lId;
                        break; 
                    }
                }

                // Fallback to Header Scan if not found in Row Cells
                if (!$foundLombaId) {
                    foreach ($header as $idx => $hTitle) {
                        if (isset($data[$idx]) && trim($data[$idx]) !== '') {
                            $lId = $matchLomba($hTitle);
                            if ($lId) {
                                $foundLombaId = $lId;
                                break;
                            }
                        }
                    }
                }

                // Final Fallback to Manual Selection
                if (!$foundLombaId) $foundLombaId = $request->lomba_id;

                if (!$foundLombaId) {
                    $skipCount++;
                    $preview = implode(' | ', array_filter(array_slice($data, 0, 5), fn($v) => trim($v) !== ''));
                    $errors[] = "Baris $rowNum: Kategori Lomba tidak ditemukan. ($preview)";
                    continue;
                }

                // STEP B: Extract other info from the row based on Keyword matching on Headers
                foreach ($header as $idx => $colTitle) {
                    $colTitle = strtolower(trim($colTitle));
                    $val = isset($data[$idx]) ? trim($data[$idx]) : '';
                    if (empty($val) || filter_var($val, FILTER_VALIDATE_URL)) continue;

                    // Nama Peserta: Must contain 'nama' or 'peserta' BUT NOT 'wa', 'hp', 'telp', 'nomor', 'wa'
                    if (str_contains($colTitle, 'nama') || str_contains($colTitle, 'peserta')) {
                        if (str_contains($colTitle, 'pembina')) {
                            $pendaftarData['nama_pembina'] = $val;
                        } else if (!preg_match('/wa|hp|telp|nomor|phone|bukti|formulir/', $colTitle)) {
                            // This is likely the real name
                            if (strlen($val) > 2 && strlen($val) < 100) $pendaftarData['nama'] = $val;
                        }
                    }
                    if (str_contains($colTitle, 'sekolah') || str_contains($colTitle, 'asal')) $pendaftarData['sekolah'] = $val;
                    if (str_contains($colTitle, 'wa') || str_contains($colTitle, 'hp') || str_contains($colTitle, 'whatsapp') || str_contains($colTitle, 'kontak') || str_contains($colTitle, 'telepon')) {
                        if (str_contains($colTitle, 'pembina')) $pendaftarData['no_hp_pembina'] = $val;
                        else $pendaftarData['no_wa'] = $val;
                    }
                    if (str_contains($colTitle, 'email')) $pendaftarData['email'] = $val;
                    if (str_contains($colTitle, 'timestamp') || str_contains($colTitle, 'tanggal')) $pendaftarData['tanggal'] = $val;
                    if (str_contains($colTitle, 'pembayaran') || str_contains($colTitle, 'metode') || str_contains($colTitle, 'bayar')) {
                        $pVal = strtolower(trim($val));
                        if (str_contains($pVal, 'transfer')) {
                            $pendaftarData['metode_pembayaran'] = 'transfer';
                            $pendaftarData['status'] = 'confirmed';
                        } else if (str_contains($pVal, 'tunai')) {
                            $pendaftarData['metode_pembayaran'] = 'tunai';
                            $pendaftarData['status'] = 'pending';
                        }
                    }
                }

                if (empty($pendaftarData['nama']) || empty($pendaftarData['sekolah'])) {
                    $skipCount++;
                    $preview = implode(' | ', array_filter(array_slice($data, 0, 5), fn($v) => trim($v) !== ''));
                    $errors[] = "Baris $rowNum: Nama atau Sekolah kosong. ($preview)";
                    continue;
                }

                // CHECK DUPLIKAT SEBELUM CREATE
                $existing = \App\Models\Pendaftaran::where('nama', $pendaftarData['nama'])
                    ->where('sekolah', $pendaftarData['sekolah'])
                    ->where('lomba_id', $foundLombaId)
                    ->first();
                
                if ($existing) {
                    $skipCount++;
                    $errors[] = "Baris $rowNum: Duplikat '$pendaftarData[nama]' dari $pendaftarData[sekolah] ($foundLombaId). Skip.";
                    continue;
                }

                // Parse Timestamp if exists
                $createdAt = now();
                if (!empty($pendaftarData['tanggal'])) {
                    try {
                        // Carbon handles various formats, including GForm common formats
                        $createdAt = \Carbon\Carbon::parse(str_replace('/', '-', $pendaftarData['tanggal']));
                    } catch (\Exception $e) {
                        $createdAt = now();
                    }
                }

                // --- 4. DATA SAVING ---
                \App\Models\Pendaftaran::create([
                    'nama' => $pendaftarData['nama'],
                    'email' => $pendaftarData['email'],
                    'no_wa' => $pendaftarData['no_wa'],
                    'sekolah' => $pendaftarData['sekolah'],
                    'lomba_id' => $foundLombaId,
                    'nama_pembina' => $pendaftarData['nama_pembina'],
                    'no_hp_pembina' => $pendaftarData['no_hp_pembina'],
                    'status' => $pendaftarData['status'],
                    'metode_pembayaran' => $pendaftarData['metode_pembayaran'], 
                    'import_batch' => $batchId,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);

                \App\Models\Participant::updateOrCreate(
                    ['nama' => $pendaftarData['nama'], 'lomba_id' => $foundLombaId],
                    [
                        'sekolah' => $pendaftarData['sekolah'], 
                        'source' => 'import', 
                        'import_batch' => $batchId,
                        'created_at' => $createdAt,
                        'updated_at' => $createdAt,
                    ]
                );

                $successCount++;
            } catch (\Exception $e) {
                \Log::error("Import error baris $rowNum: " . $e->getMessage());
                $skipCount++;
                $errors[] = "Baris $rowNum: " . $e->getMessage();
            }
        }
        fclose($handle);

        if ($successCount == 0) {
            $errorMsg = "Gagal mengimpor. $skipCount data dilewati.";
            if (!empty($errors)) $errorMsg .= " Detail: " . implode(' | ', array_slice($errors, 0, 3));
            return back()->with('error', $errorMsg);
        }

        $msg = "Berhasil mengimpor $successCount peserta.";
        if ($skipCount > 0) {
            $msg .= " ($skipCount dilewati";
            if (!empty($errors)) $msg .= ": " . implode(' | ', array_slice($errors, 0, 3));
            $msg .= ")";
        }
        return back()->with('success', $msg);
    }

    public function rollback()
    {
        // Try to get latest batch from Pendaftaran first
        $lastBatch = \App\Models\Pendaftaran::whereNotNull('import_batch')
            ->orderBy('id', 'desc')
            ->first();
        
        // If not found, try from Participant (sometimes data might only exists there)
        if (!$lastBatch) {
            $lastBatch = \App\Models\Participant::whereNotNull('import_batch')
                ->where('source', 'import')
                ->orderBy('id', 'desc')
                ->first();
        }

        if (!$lastBatch) {
            return back()->with('error', 'Tidak ada data import yang bisa di-rollback.');
        }

        $batchId = $lastBatch->import_batch;
        $countPendaftaran = \App\Models\Pendaftaran::where('import_batch', $batchId)->delete();
        $countParticipants = \App\Models\Participant::where('import_batch', $batchId)->delete();

        return back()->with('success', "Rollback berhasil! Menghapus $countPendaftaran data pendaftaran dan $countParticipants data voting dari sesi import terakhir ($batchId).");
    }
}
