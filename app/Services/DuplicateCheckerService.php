<?php

namespace App\Services;

use App\Models\Pendaftaran;

class DuplicateCheckerService
{
    /**
     * Normalisasi teks ke bentuk alfanumerik lowercase untuk perbandingan.
     */
    public static function toAlphaNumeric(string $value): string
    {
        return preg_replace('/[^a-z0-9]/', '', mb_strtolower($value));
    }

    /**
     * Normalisasi nomor telepon (hanya angka).
     */
    public static function normalizePhone(string $value): string
    {
        return preg_replace('/[^0-9]/', '', $value);
    }

    /**
     * Cek apakah pendaftaran baru merupakan duplikat berdasarkan identitas peserta.
     * Menggunakan Pencocokan Alfanumerik Cerdas.
     *
     * Aturan:
     * 1. Nama + Sekolah (Alfanumerik) sama persis = Duplikat
     * 2. Nama sama persis + (Email ATAU No WA sama) = Duplikat
     *
     * @param string $nama
     * @param string $sekolah
     * @param string $email
     * @param string $noWa
     * @param int $lombaId
     * @param array|null $existingPendaftarans Cache data pendaftaran existing (opsional)
     * @return bool
     */
    public static function isDuplicate(
        string $nama,
        string $sekolah,
        string $email,
        string $noWa,
        int $lombaId,
        ?array $existingPendaftarans = null
    ): bool {
        $newNamaAlpha = self::toAlphaNumeric($nama);
        $newSekolahAlpha = self::toAlphaNumeric($sekolah);
        $newStrAlpha = $newNamaAlpha . $newSekolahAlpha;

        $reqEmail = trim(mb_strtolower($email));
        $reqWa = self::normalizePhone($noWa);

        // Ambil data existing jika belum di-cache
        if ($existingPendaftarans === null) {
            $existingPendaftarans = Pendaftaran::where('lomba_id', $lombaId)
                ->get(['nama', 'sekolah', 'email', 'no_wa'])
                ->toArray();
        }

        foreach ($existingPendaftarans as $existing) {
            if (empty($existing['nama'])) continue;

            $existingNamaAlpha = self::toAlphaNumeric((string) $existing['nama']);
            $existingSekolahAlpha = self::toAlphaNumeric((string) $existing['sekolah']);
            $existingStrAlpha = $existingNamaAlpha . $existingSekolahAlpha;

            // Aturan 1: Nama + Sekolah (Alfanumerik) Sama Persis = Duplikat
            if ($newStrAlpha !== '' && $newStrAlpha === $existingStrAlpha) {
                return true;
            }

            // Aturan 2: Nama Sama + (Email ATAU No WA Sama) = Duplikat
            if ($newNamaAlpha !== '' && $newNamaAlpha === $existingNamaAlpha) {
                $existingEmail = trim(mb_strtolower((string) ($existing['email'] ?? '')));
                $existingWa = self::normalizePhone((string) ($existing['no_wa'] ?? ''));

                if (($reqEmail !== '' && $reqEmail === $existingEmail) ||
                    ($reqWa !== '' && $reqWa === $existingWa)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Cek duplikat dengan aturan lebih lengkap (untuk import CSV/Excel).
     * Termasuk pengecekan terhadap nama pembina.
     *
     * @param array $newData Data baru ['nama', 'sekolah', 'email', 'no_wa', 'nama_pembina']
     * @param array $dbRecord Data existing dari database
     * @return bool
     */
    public static function isDuplicateForImport(array $newData, array $dbRecord): bool
    {
        $newNamaAlpha = self::toAlphaNumeric((string) ($newData['nama'] ?? ''));
        $newSekolahAlpha = self::toAlphaNumeric((string) ($newData['sekolah'] ?? ''));
        $newStrAlpha = $newNamaAlpha . (($newData['sekolah'] ?? '') !== '-' ? $newSekolahAlpha : '');

        $existingNamaAlpha = self::toAlphaNumeric((string) ($dbRecord['nama'] ?? ''));
        $existingSekolahAlpha = self::toAlphaNumeric((string) ($dbRecord['sekolah'] ?? ''));
        $existingStrAlpha = $existingNamaAlpha . (($dbRecord['sekolah'] ?? '') !== '-' ? $existingSekolahAlpha : '');

        // 1. Exact Match (Nama & Sekolah)
        if ($newStrAlpha !== '' && $newStrAlpha === $existingStrAlpha && ($newData['sekolah'] ?? '') !== '-') {
            return true;
        }

        // 2. Nama Sama + Kontak/Pembina sama
        if ($newNamaAlpha !== '' && $newNamaAlpha === $existingNamaAlpha) {
            $reqEmail = trim(mb_strtolower((string) ($newData['email'] ?? '')));
            $reqWa = self::normalizePhone((string) ($newData['no_wa'] ?? ''));
            $reqPembinaAlpha = self::toAlphaNumeric((string) ($newData['nama_pembina'] ?? ''));

            $existingEmail = trim(mb_strtolower((string) ($dbRecord['email'] ?? '')));
            $existingWa = self::normalizePhone((string) ($dbRecord['no_wa'] ?? ''));
            $existingPembina = self::toAlphaNumeric((string) ($dbRecord['nama_pembina'] ?? ''));

            if (($reqEmail !== '' && $reqEmail === $existingEmail) ||
                ($reqWa !== '' && $reqWa === $existingWa) ||
                ($reqPembinaAlpha !== '' && $reqPembinaAlpha === $existingPembina) ||
                (($newData['sekolah'] ?? '') === '-' || ($dbRecord['sekolah'] ?? '') === '-')) {
                return true;
            }
        }

        return false;
    }

    /**
     * Normalisasi teks umum (trim, hapus spasi berlebih, konversi encoding).
     */
    public static function normalizeText(?string $value): ?string
    {
        if ($value === null) return null;
        $value = trim($value);
        if ($value === '') return '';
        if (!mb_check_encoding($value, 'UTF-8')) {
            $converted = @mb_convert_encoding($value, 'UTF-8', 'UTF-8, ISO-8859-1, Windows-1252');
            if ($converted !== false) $value = $converted;
        }
        $value = strtr($value, ["\xC2\xA0" => ' ']);
        $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $value);
        return preg_replace('/\s+/u', ' ', $value);
    }
}
