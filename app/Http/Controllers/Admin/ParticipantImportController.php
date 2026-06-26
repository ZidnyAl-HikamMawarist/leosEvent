<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Shuchkin\SimpleXLSX;
use App\Services\DuplicateCheckerService;
use App\Models\AuditLog;

class ParticipantImportController extends Controller
{
    public function store(Request $request)
    {
        // Berikan waktu eksekusi tak terbatas untuk mengantisipasi file CSV yang sangat besar
        set_time_limit(0);

        $request->validate([
            'file_csv' => 'required|file|mimes:csv,txt,xlsx,xls|max:5120',
        ]);

        $file = $request->file('file_csv');
        $filePath = $file->getRealPath();
        $extension = $file->getClientOriginalExtension();

        $rows = [];
        $header = [];

        // --- 1. PARSE FILE (XLSX / CSV) ---
        if (in_array(strtolower($extension), ['xlsx', 'xls'])) {
            if ($xlsx = SimpleXLSX::parse($filePath)) {
                $rawRows = $xlsx->rows();
                if (!empty($rawRows)) {
                    $header = array_shift($rawRows);
                    $rows = $rawRows;
                }
            } else {
                return back()->with('error', 'Gagal membaca file Excel: ' . SimpleXLSX::parseError());
            }
        } else {
            // CSV Parsing with Smart Delimiter
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
            while (($data = fgetcsv($handle, 0, $delimiter)) !== false) {
                $rows[] = $data;
            }
            fclose($handle);
        }

        if (empty($header) || empty($rows)) {
            return back()->with('error', 'File kosong atau tidak valid.');
        }

        $allLombas = \App\Models\Lomba::all();

        // --- 2. HELPERS ---
        $normalizeText = function ($value) {
            return DuplicateCheckerService::normalizeText($value);
        };

        $normalizeCompare = function ($value) use ($normalizeText) {
            $value = strtolower((string) $normalizeText($value));
            $value = preg_replace('/[^a-z0-9\s]/', ' ', $value);
            return trim(preg_replace('/\s+/', ' ', $value));
        };

        $matchLombaWithScore = function ($text) use ($allLombas, $normalizeCompare) {
            $textRaw = $normalizeCompare($text);
            if ($textRaw === '' || strlen($textRaw) < 2) return ['id' => null, 'score' => 0];

            $bestId = null;
            $bestScore = 0;
            foreach ($allLombas as $l) {
                $lName = $normalizeCompare($l->nama_lomba);
                if ($lName === '') continue;

                $score = 0;
                if ($lName === $textRaw) {
                    $score = 100;
                } elseif (str_contains($textRaw, $lName)) {
                    $score = 92;
                } else {
                    $keywords = preg_split('/\s+/', $lName, -1, PREG_SPLIT_NO_EMPTY);
                    $keywords = array_filter($keywords, fn($w) => strlen($w) > 2 && !in_array($w, ['dan', 'atau', 'non']));
                    if (!empty($keywords)) {
                        $hits = 0;
                        foreach ($keywords as $word) {
                            if (str_contains($textRaw, $word)) $hits++;
                        }
                        $ratio = $hits / count($keywords);
                        if ($ratio >= 1) $score = max($score, 90);
                        elseif ($ratio >= 0.75) $score = max($score, 82);
                    }
                }
                if ($score > $bestScore) {
                    $bestScore = $score;
                    $bestId = $l->id;
                }
            }
            return ['id' => $bestId, 'score' => $bestScore];
        };

        $getLombaId = function ($text, $minScore = 82) use ($matchLombaWithScore) {
            $match = $matchLombaWithScore($text);
            return $match['score'] >= $minScore ? $match['id'] : null;
        };

        $findLombaIdFromRow = function ($data, $manualLombaId, $lombaIndexes) use ($getLombaId, $normalizeText) {
            foreach ($lombaIndexes as $idx) {
                if (!isset($data[$idx])) continue;
                $cell = $normalizeText($data[$idx]);
                if ($cell === '') continue;
                $id = $getLombaId($cell, 82);
                if ($id) return $id;
            }
            return !empty($manualLombaId) ? $manualLombaId : null;
        };

        $parseImportedTimestamp = function ($value) use ($normalizeText) {
            if ($value === null || trim((string) $value) === '') return now();
            $raw = $normalizeText($value);
            if (is_numeric($raw)) { // Excel serial date
                $serial = (float) $raw;
                if ($serial > 1000 && $serial < 100000) {
                    $days = (int) floor($serial);
                    $seconds = (int) round(($serial - $days) * 86400);
                    return \Carbon\Carbon::create(1899, 12, 30, 0, 0, 0)->addDays($days)->addSeconds($seconds);
                }
            }
            try { return \Carbon\Carbon::parse(str_replace('.', '/', $raw)); } 
            catch (\Throwable $e) { return now(); }
        };

        // --- 3. SMART COLUMN CLUSTERING ---
        $nameIndexes = $sekolahIndexes = $pembinaIndexes = $pembinaHpIndexes = $hpIndexes = $emailIndexes = $lombaIndexes = $tanggalIndexes = $pembayaranIndexes = [];
        
        foreach ($header as $idx => $hTitleRaw) {
            $hTitle = strtolower(trim((string) $normalizeText($hTitleRaw)));
            if ($hTitle === '') continue;
            
            if (str_contains($hTitle, 'lomba')) {
                $lombaIndexes[] = $idx;
            } elseif (str_contains($hTitle, 'pembayaran') || str_contains($hTitle, 'metode') || str_contains($hTitle, 'bayar')) {
                $pembayaranIndexes[] = $idx;
            } elseif (str_contains($hTitle, 'timestamp') || str_contains($hTitle, 'tanggal')) {
                $tanggalIndexes[] = $idx;
            } elseif (str_contains($hTitle, 'sekolah') || str_contains($hTitle, 'asal')) {
                $sekolahIndexes[] = $idx;
            } elseif (str_contains($hTitle, 'email')) {
                $emailIndexes[] = $idx;
            } elseif (str_contains($hTitle, 'wa') || str_contains($hTitle, 'hp') || str_contains($hTitle, 'whatsapp') || str_contains($hTitle, 'telepon')) {
                if (str_contains($hTitle, 'pembina') || str_contains($hTitle, 'pelatih')) $pembinaHpIndexes[] = $idx;
                else $hpIndexes[] = $idx;
            } elseif (str_contains($hTitle, 'pembina') || str_contains($hTitle, 'pelatih')) {
                $pembinaIndexes[] = $idx;
            } elseif (str_contains($hTitle, 'nama') || str_contains($hTitle, 'peserta') || str_contains($hTitle, 'danton') || str_contains($hTitle, 'ketua') || str_contains($hTitle, 'pasukan')) {
                // Ignore if it has bukti or formulir or anggota or pasukan
                if (!preg_match('/bukti|formulir|wa|hp|email|sekolah|anggota|pasukan/', $hTitle)) {
                    $nameIndexes[] = $idx;
                }
            }
        }

        $findClosest = function($targetIdx, $candidates) {
            if (empty($candidates)) return null;
            $closest = null;
            $minDist = PHP_INT_MAX;
            foreach ($candidates as $c) {
                $dist = abs($c - $targetIdx);
                if ($dist < $minDist) {
                    $minDist = $dist;
                    $closest = $c;
                }
            }
            return $closest;
        };

        $getValue = function($data, $index) use ($normalizeText) {
            return ($index !== null && isset($data[$index])) ? $normalizeText($data[$index]) : null;
        };

        // --- 4. DATA EXTRACTION LOGIC ---
        $successCount = 0; $skipCount = 0;
        $errors = []; $errorDetails = [];
        $seenInCurrentFile = [];
        $batchId = 'batch_' . time();
        $rowNum = 1; // Header is row 1
        $lombaPendaftaransCache = [];

        foreach ($rows as $data) {
            $rowNum++;
            if (empty(array_filter($data, fn($v) => !is_null($v) && trim($v) !== ''))) {
                continue; // Skip empty rows
            }

            // Extract Lomba ID for the whole row
            $foundLombaId = $findLombaIdFromRow($data, $request->lomba_id, $lombaIndexes);
            
            // Extract global row info (Timestamp, Pembayaran) if any
            $globalTanggal = $getValue($data, !empty($tanggalIndexes) ? $tanggalIndexes[0] : null);
            $globalPembayaran = 'tunai';
            $globalStatus = 'pending';
            if (!empty($pembayaranIndexes)) {
                $pVal = strtolower((string)$getValue($data, $pembayaranIndexes[0]));
                if (str_contains($pVal, 'transfer')) {
                    $globalPembayaran = 'transfer';
                    $globalStatus = 'confirmed';
                }
            }

            // A row can contain multiple participants (e.g. Peserta 1, Peserta 2, Danton, etc)
            foreach ($nameIndexes as $nIdx) {
                $nama = $getValue($data, $nIdx);
                if (empty($nama) || filter_var($nama, FILTER_VALIDATE_URL) || $nama == '-' || strlen($nama) < 3) continue;

                $closestSekolahIdx = $findClosest($nIdx, $sekolahIndexes);
                $closestHpIdx = $findClosest($nIdx, $hpIndexes);
                $closestEmailIdx = $findClosest($nIdx, $emailIndexes);
                $closestPembinaIdx = $findClosest($nIdx, $pembinaIndexes);
                $closestPembinaHpIdx = $findClosest($nIdx, $pembinaHpIndexes ?? []);

                $sekolah = $getValue($data, $closestSekolahIdx);
                $no_wa = $getValue($data, $closestHpIdx);
                $email = $getValue($data, $closestEmailIdx);
                $nama_pembina = $getValue($data, $closestPembinaIdx);
                $no_hp_pembina = $getValue($data, $closestPembinaHpIdx);

                if (empty($sekolah)) {
                    // Try to fallback to first sekolah found in the row that has a value
                    foreach ($sekolahIndexes as $sIdx) {
                        $val = $getValue($data, $sIdx);
                        if (!empty($val)) {
                            $sekolah = $val;
                            break;
                        }
                    }
                }

                // Bulletproof: JANGAN PERNAH SKIP WALAUPUN SEKOLAH KOSONG
                if (empty($sekolah)) {
                    $sekolah = '-';
                }

                if (!$foundLombaId) {
                    $skipCount++;
                    $errors[] = "Baris $rowNum: Lomba tidak valid untuk peserta '" . substr($nama, 0, 20) . "'.";
                    continue;
                }

                // Cegah crash SQL panjang karena kolom di form Google 
                // bisa berisi puluhan nama anggota yang dipisah koma. (Limit ke 250 chars)
                if (strlen($nama) > 250) {
                    $nama = substr($nama, 0, 247) . '...';
                }

                // SMART DUPLICATE CHECK WITHIN FILE
                $newNamaAlpha = preg_replace('/[^a-z0-9]/', '', mb_strtolower((string) $nama));
                $newSekolahAlpha = preg_replace('/[^a-z0-9]/', '', mb_strtolower((string) $sekolah));
                $identityKey = $newNamaAlpha . '|' . $newSekolahAlpha . '|' . $foundLombaId;

                if (isset($seenInCurrentFile[$identityKey])) {
                    $skipCount++;
                    $errors[] = "Baris $rowNum: Duplikat dalam file csv/xlsx saat ini ('" . substr($nama, 0, 20) . "').";
                    continue;
                }

                // CHECK DATABASE
                if (!isset($lombaPendaftaransCache[$foundLombaId])) {
                    $lombaPendaftaransCache[$foundLombaId] = \App\Models\Pendaftaran::where('lomba_id', $foundLombaId)->get(['nama', 'sekolah', 'email', 'no_wa', 'nama_pembina', 'no_hp_pembina']);
                }

                $existing = false;
                $newDataForCheck = [
                    'nama' => $nama,
                    'sekolah' => $sekolah,
                    'email' => $email,
                    'no_wa' => $no_wa,
                    'nama_pembina' => $nama_pembina,
                ];

                foreach ($lombaPendaftaransCache[$foundLombaId] as $dbRecord) {
                    if (empty($dbRecord->nama)) continue;
                    
                    $dbRecordArray = $dbRecord->toArray();
                    if (DuplicateCheckerService::isDuplicateForImport($newDataForCheck, $dbRecordArray)) {
                        $existing = true;
                        break;
                    }
                }

                if ($existing) {
                    $skipCount++;
                    $errors[] = "Baris $rowNum: Data duplikat ditemukan di database ('" . substr($nama, 0, 20) . "').";
                    $seenInCurrentFile[$identityKey] = true;
                    continue;
                }

                // AUTO-FILL MISSING DATA DARI DB ATAU DARI DB RECORD DALAM ROW SAMA
                if ($sekolah === '-' || empty($email) || empty($no_wa) || empty($nama_pembina)) {
                    $reference = null;
                    
                    // Coba cari referensi berdasarkan Sekolah Murni
                    if ($sekolah !== '-') {
                        $reference = \App\Models\Pendaftaran::where('sekolah', $sekolah)->whereNotNull('no_wa')->where('no_wa', '!=', '-')->orderBy('created_at', 'desc')->first();
                    }
                    // Jika belum ketemu, coba cari lewat Pembina
                    if (!$reference && !empty($no_hp_pembina) && $no_hp_pembina !== '-') {
                        $reference = \App\Models\Pendaftaran::where('no_hp_pembina', $no_hp_pembina)->where('sekolah', '!=', '-')->first();
                    }
                    
                    if ($reference) {
                        if ($sekolah === '-') $sekolah = $reference->sekolah;
                        if (empty($email) || $email === '-') $email = $reference->email;
                        if (empty($no_wa) || $no_wa === '-') $no_wa = $reference->no_wa;
                        if (empty($nama_pembina) || $nama_pembina === '-') $nama_pembina = $reference->nama_pembina;
                        if (empty($no_hp_pembina) || $no_hp_pembina === '-') $no_hp_pembina = $reference->no_hp_pembina;
                    } else {
                        // Tidak ada samasekali referensi, fallback ke strip.
                        if (empty($email)) $email = '-';
                        if (empty($no_wa)) $no_wa = '-';
                        if (empty($nama_pembina)) $nama_pembina = '-';
                        if (empty($no_hp_pembina)) $no_hp_pembina = '-';
                    }
                }

                // Terakhir: Jika No WA Peserta masih kosong, pinjam No HP Pembina.
                // Sangat umum untuk lomba tim dimana hanya HP Pembina yg ditanyakan di Google Form.
                if (($no_wa === '' || $no_wa === '-') && $no_hp_pembina !== '-' && $no_hp_pembina !== '') {
                    $no_wa = $no_hp_pembina;
                }

                $createdAt = $parseImportedTimestamp($globalTanggal);
                if ($createdAt->greaterThan(now())) $createdAt = now();

                try {
                    DB::transaction(function () use ($nama, $email, $no_wa, $sekolah, $foundLombaId, $nama_pembina, $no_hp_pembina, $globalStatus, $globalPembayaran, $batchId, $createdAt) {
                        \App\Models\Pendaftaran::create([
                            'nama' => $nama,
                            'email' => $email,
                            'no_wa' => $no_wa,
                            'sekolah' => $sekolah,
                            'lomba_id' => $foundLombaId,
                            'nama_pembina' => $nama_pembina,
                            'no_hp_pembina' => $no_hp_pembina,
                            'status' => $globalStatus,
                            'metode_pembayaran' => $globalPembayaran,
                            'import_batch' => $batchId,
                            'created_at' => $createdAt,
                            'updated_at' => $createdAt,
                        ]);

                        \App\Models\Participant::firstOrCreate(
                            ['nama' => $nama, 'sekolah' => $sekolah, 'lomba_id' => $foundLombaId],
                            ['source' => 'import', 'import_batch' => $batchId, 'created_at' => $createdAt, 'updated_at' => $createdAt]
                        );
                    });

                    $seenInCurrentFile[$identityKey] = true;
                    $successCount++;
                } catch (\Throwable $e) {
                    \Log::error("Import error baris $rowNum: " . $e->getMessage());
                    $skipCount++;
                    $errors[] = "Baris $rowNum: " . $e->getMessage();
                }
            }
        }

        // --- 5. FINISHING ---
        $report = [
            'batch_id' => $batchId,
            'generated_at' => now()->toDateTimeString(),
            'success_count' => $successCount,
            'skip_count' => $skipCount,
            'total_processed' => $successCount + $skipCount,
            'error_details' => $errors,
        ];

        Storage::disk('local')->put("import-reports/{$batchId}.json", json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        $reportPath = "storage/app/private/import-reports/{$batchId}.json";

        if ($successCount == 0) {
            $msg = "Gagal mengimpor. $skipCount data dilewati.";
            if (!empty($errors)) $msg .= " Detail: " . implode(' | ', array_slice($errors, 0, 3));
            return back()->with('error', $msg);
        }

        AuditLog::log('import_participants', "Import peserta: $successCount berhasil, $skipCount dilewati.", null, [
            'batch_id' => $batchId,
            'success' => $successCount,
            'skipped' => $skipCount,
        ]);

        $msg = "Berhasil mengimpor $successCount peserta.";
        if ($skipCount > 0) {
            $msg .= " ($skipCount dilewati: " . implode(' | ', array_slice($errors, 0, 2)) . "...)";
        }
        return back()->with('success', $msg);
    }

    public function rollback()
    {
        $lastBatch = \App\Models\Pendaftaran::whereNotNull('import_batch')->orderBy('id', 'desc')->first() 
            ?? \App\Models\Participant::whereNotNull('import_batch')->where('source', 'import')->orderBy('id', 'desc')->first();

        if (!$lastBatch) return back()->with('error', 'Tidak ada data import yang bisa di-rollback.');
        
        $batchId = $lastBatch->import_batch;
        $countPendaftaran = \App\Models\Pendaftaran::where('import_batch', $batchId)->delete();
        $countParticipants = \App\Models\Participant::where('import_batch', $batchId)->where('source', 'import')->delete();

        AuditLog::log('rollback_import', "Rollback import batch $batchId: $countPendaftaran pendaftar, $countParticipants participant.");

        return back()->with('success', "Rollback berhasil! Menghapus $countPendaftaran data pendaftar & voting ($batchId).");
    }
}
