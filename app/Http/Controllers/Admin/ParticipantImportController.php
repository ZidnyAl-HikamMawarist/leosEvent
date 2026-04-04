<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ParticipantImportController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file_csv' => 'required|file|mimes:csv,txt,text/plain,xlsx,xls|max:5120',
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
            if ($bom !== "\xEF\xBB\xBF") {
                rewind($testHandle);
            }

            $testHeader = fgetcsv($testHandle, 0, $d);
            fclose($testHandle);

            if ($testHeader && count($testHeader) > $maxCols) {
                $maxCols = count($testHeader);
                $delimiter = $d;
            }
        }

        $handle = fopen($filePath, 'r');
        $bom = fread($handle, 3);
        if ($bom !== "\xEF\xBB\xBF") {
            rewind($handle);
        }

        $header = fgetcsv($handle, 0, $delimiter);
        if (!$header) {
            return back()->with('error', 'File CSV kosong atau tidak valid.');
        }

        $allLombas = \App\Models\Lomba::all();

        // --- 2A. TEXT NORMALIZER (encoding + punctuation) ---
        $normalizeText = function ($value) {
            if ($value === null) {
                return null;
            }

            $value = trim((string) $value);
            if ($value === '') {
                return '';
            }

            if (!mb_check_encoding($value, 'UTF-8')) {
                $converted = @mb_convert_encoding($value, 'UTF-8', 'UTF-8, ISO-8859-1, Windows-1252');
                if ($converted !== false) {
                    $value = $converted;
                }
            }

            $value = strtr($value, [
                "\xC2\xA0" => ' ',
                '’' => "'",
                '‘' => "'",
                '“' => '"',
                '”' => '"',
                '–' => '-',
                '—' => '-',
            ]);

            $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $value);
            return preg_replace('/\s+/u', ' ', $value);
        };

        $normalizeCompare = function ($value) use ($normalizeText) {
            $value = strtolower((string) $normalizeText($value));
            $value = preg_replace('/[^a-z0-9\s]/', ' ', $value);
            return trim(preg_replace('/\s+/', ' ', $value));
        };

        // --- 2B. SAFER LOMBA MATCHER (score-based) ---
        $matchLombaWithScore = function ($text) use ($allLombas, $normalizeCompare) {
            $textRaw = $normalizeCompare($text);
            if ($textRaw === '' || strlen($textRaw) < 2) {
                return ['id' => null, 'score' => 0];
            }

            $bestId = null;
            $bestScore = 0;
            foreach ($allLombas as $l) {
                $lName = $normalizeCompare($l->nama_lomba);
                if ($lName === '') {
                    continue;
                }

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
                            if (str_contains($textRaw, $word)) {
                                $hits++;
                            }
                        }

                        $ratio = $hits / count($keywords);
                        if ($ratio >= 1) {
                            $score = max($score, 90);
                        } elseif ($ratio >= 0.75) {
                            $score = max($score, 82);
                        }
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

        // Identify lomba columns from header once
        $lombaColumnIndexes = [];
        foreach ($header as $idx => $hTitleRaw) {
            $hTitle = $normalizeCompare($hTitleRaw);
            if ($hTitle === '') {
                continue;
            }

            if (
                str_contains($hTitle, 'mata lomba') ||
                str_contains($hTitle, 'kategori lomba') ||
                str_contains($hTitle, 'nama lomba') ||
                $hTitle === 'lomba' ||
                (str_contains($hTitle, 'lomba') && !str_contains($hTitle, 'link'))
            ) {
                $lombaColumnIndexes[] = $idx;
            }
        }

        $findLombaIdFromRow = function ($data, $manualLombaId) use ($lombaColumnIndexes, $getLombaId, $normalizeText) {
            // Priority 1: explicit lomba columns
            foreach ($lombaColumnIndexes as $idx) {
                if (!isset($data[$idx])) {
                    continue;
                }

                $cell = $normalizeText($data[$idx]);
                if ($cell === '') {
                    continue;
                }

                $id = $getLombaId($cell, 82);
                if ($id) {
                    return $id;
                }
            }

            // Priority 2: manual fallback from UI
            if (!empty($manualLombaId)) {
                return $manualLombaId;
            }

            // Priority 3: strict full-name row scan only
            foreach ($data as $cellValue) {
                $id = $getLombaId($cellValue, 92);
                if ($id) {
                    return $id;
                }
            }

            return null;
        };

        $successCount = 0;
        $skipCount = 0;
        $errors = [];
        $errorDetails = [];
        $batchId = 'batch_' . time();
        $rowNum = 1;

        // --- 3. ROW SCANNING ---
        while (($data = fgetcsv($handle, 0, $delimiter)) !== false) {
            $rowNum++;
            try {
                if (empty(array_filter($data, fn($v) => !is_null($v) && trim($v) !== ''))) {
                    continue;
                }

                $foundLombaId = $findLombaIdFromRow($data, $request->lomba_id);
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

                if (!$foundLombaId) {
                    $skipCount++;
                    $preview = implode(' | ', array_filter(array_slice($data, 0, 5), fn($v) => trim((string) $v) !== ''));
                    $errors[] = "Baris $rowNum: Kategori Lomba tidak ditemukan. ($preview)";
                    $errorDetails[] = [
                        'row' => $rowNum,
                        'reason' => 'Kategori Lomba tidak ditemukan',
                        'preview' => $preview,
                    ];
                    continue;
                }

                foreach ($header as $idx => $colTitleRaw) {
                    $colTitle = strtolower(trim((string) $normalizeText($colTitleRaw)));
                    $val = isset($data[$idx]) ? $normalizeText($data[$idx]) : '';
                    if (empty($val) || filter_var($val, FILTER_VALIDATE_URL)) {
                        continue;
                    }

                    if (str_contains($colTitle, 'nama') || str_contains($colTitle, 'peserta')) {
                        if (str_contains($colTitle, 'pembina')) {
                            $pendaftarData['nama_pembina'] = $val;
                        } elseif (!preg_match('/wa|hp|telp|nomor|phone|bukti|formulir/', $colTitle)) {
                            if (strlen($val) > 2 && strlen($val) < 100) {
                                $pendaftarData['nama'] = $val;
                            }
                        }
                    }

                    if (str_contains($colTitle, 'sekolah') || str_contains($colTitle, 'asal')) {
                        $pendaftarData['sekolah'] = $val;
                    }

                    if (
                        str_contains($colTitle, 'wa') ||
                        str_contains($colTitle, 'hp') ||
                        str_contains($colTitle, 'whatsapp') ||
                        str_contains($colTitle, 'kontak') ||
                        str_contains($colTitle, 'telepon')
                    ) {
                        if (str_contains($colTitle, 'pembina')) {
                            $pendaftarData['no_hp_pembina'] = $val;
                        } else {
                            $pendaftarData['no_wa'] = $val;
                        }
                    }

                    if (str_contains($colTitle, 'email')) {
                        $pendaftarData['email'] = $val;
                    }

                    if (str_contains($colTitle, 'timestamp') || str_contains($colTitle, 'tanggal')) {
                        $pendaftarData['tanggal'] = $val;
                    }

                    if (str_contains($colTitle, 'pembayaran') || str_contains($colTitle, 'metode') || str_contains($colTitle, 'bayar')) {
                        $pVal = strtolower(trim($val));
                        if (str_contains($pVal, 'transfer')) {
                            $pendaftarData['metode_pembayaran'] = 'transfer';
                            $pendaftarData['status'] = 'confirmed';
                        } elseif (str_contains($pVal, 'tunai')) {
                            $pendaftarData['metode_pembayaran'] = 'tunai';
                            $pendaftarData['status'] = 'pending';
                        }
                    }
                }

                if (empty($pendaftarData['nama']) || empty($pendaftarData['sekolah'])) {
                    $skipCount++;
                    $preview = implode(' | ', array_filter(array_slice($data, 0, 5), fn($v) => trim((string) $v) !== ''));
                    $errors[] = "Baris $rowNum: Nama atau Sekolah kosong. ($preview)";
                    $errorDetails[] = [
                        'row' => $rowNum,
                        'reason' => 'Nama atau Sekolah kosong',
                        'preview' => $preview,
                    ];
                    continue;
                }

                $existing = \App\Models\Pendaftaran::where('nama', $pendaftarData['nama'])
                    ->where('sekolah', $pendaftarData['sekolah'])
                    ->where('lomba_id', $foundLombaId)
                    ->first();

                if ($existing) {
                    $skipCount++;
                    $errors[] = "Baris $rowNum: Duplikat '$pendaftarData[nama]' dari $pendaftarData[sekolah] ($foundLombaId). Skip.";
                    $errorDetails[] = [
                        'row' => $rowNum,
                        'reason' => 'Duplikat',
                        'preview' => $pendaftarData['nama'] . ' | ' . $pendaftarData['sekolah'] . ' | lomba_id=' . $foundLombaId,
                    ];
                    continue;
                }

                $createdAt = now();
                if (!empty($pendaftarData['tanggal'])) {
                    try {
                        $createdAt = \Carbon\Carbon::parse(str_replace('/', '-', $pendaftarData['tanggal']));
                    } catch (\Exception $e) {
                        $createdAt = now();
                    }
                }

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
                $preview = implode(' | ', array_filter(array_map(fn($v) => trim((string) $v), array_slice($data, 0, 5))));
                $errorDetails[] = [
                    'row' => $rowNum,
                    'reason' => $e->getMessage(),
                    'preview' => $preview,
                ];
            }
        }

        fclose($handle);

        // Persist per-batch import report for audit.
        $report = [
            'batch_id' => $batchId,
            'generated_at' => now()->toDateTimeString(),
            'success_count' => $successCount,
            'skip_count' => $skipCount,
            'total_processed' => $successCount + $skipCount,
            'error_details' => $errorDetails,
        ];

        Storage::disk('local')->put(
            "import-reports/{$batchId}.json",
            json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        $reportPath = "storage/app/private/import-reports/{$batchId}.json";

        if ($successCount == 0) {
            $errorMsg = "Gagal mengimpor. $skipCount data dilewati.";
            if (!empty($errors)) {
                $errorMsg .= " Detail: " . implode(' | ', array_slice($errors, 0, 3));
            }
            $errorMsg .= " Laporan: {$reportPath}";
            return back()->with('error', $errorMsg);
        }

        $msg = "Berhasil mengimpor $successCount peserta.";
        if ($skipCount > 0) {
            $msg .= " ($skipCount dilewati";
            if (!empty($errors)) {
                $msg .= ": " . implode(' | ', array_slice($errors, 0, 3));
            }
            $msg .= ")";
        }

        $msg .= " Laporan: {$reportPath}";
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
