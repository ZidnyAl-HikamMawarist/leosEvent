<?php

namespace Tests\Unit;

use App\Services\DuplicateCheckerService;
use Tests\TestCase;

class DuplicateCheckerServiceTest extends TestCase
{
    public function test_to_alpha_numeric_removes_special_chars(): void
    {
        $this->assertEquals('budisantoso', DuplicateCheckerService::toAlphaNumeric('Budi Santoso'));
        $this->assertEquals('smpnegeri1', DuplicateCheckerService::toAlphaNumeric('SMP Negeri 1'));
        $this->assertEquals('test123', DuplicateCheckerService::toAlphaNumeric('Test!@# 123'));
    }

    public function test_normalize_phone_removes_non_digits(): void
    {
        $this->assertEquals('081234567890', DuplicateCheckerService::normalizePhone('+62-812-3456-7890'));
        $this->assertEquals('081234567890', DuplicateCheckerService::normalizePhone('0812 3456 7890'));
    }

    public function test_normalize_text_trims_and_cleans(): void
    {
        $this->assertEquals('hello world', DuplicateCheckerService::normalizeText('  hello   world  '));
        $this->assertEquals('', DuplicateCheckerService::normalizeText(''));
        $this->assertNull(DuplicateCheckerService::normalizeText(null));
    }

    public function test_is_duplicate_for_import_exact_match(): void
    {
        $newData = ['nama' => 'Budi Santoso', 'sekolah' => 'SMP 1', 'email' => '', 'no_wa' => '', 'nama_pembina' => ''];
        $dbRecord = ['nama' => 'Budi Santoso', 'sekolah' => 'SMP 1', 'email' => '', 'no_wa' => '', 'nama_pembina' => ''];

        $this->assertTrue(DuplicateCheckerService::isDuplicateForImport($newData, $dbRecord));
    }

    public function test_is_duplicate_for_import_different_name(): void
    {
        $newData = ['nama' => 'Budi Santoso', 'sekolah' => 'SMP 1', 'email' => '', 'no_wa' => '', 'nama_pembina' => ''];
        $dbRecord = ['nama' => 'Andi Wijaya', 'sekolah' => 'SMP 1', 'email' => '', 'no_wa' => '', 'nama_pembina' => ''];

        $this->assertFalse(DuplicateCheckerService::isDuplicateForImport($newData, $dbRecord));
    }

    public function test_is_duplicate_for_import_same_name_same_email(): void
    {
        $newData = ['nama' => 'Budi', 'sekolah' => 'SMP 2', 'email' => 'budi@test.com', 'no_wa' => '', 'nama_pembina' => ''];
        $dbRecord = ['nama' => 'Budi', 'sekolah' => 'SMP 1', 'email' => 'budi@test.com', 'no_wa' => '', 'nama_pembina' => ''];

        $this->assertTrue(DuplicateCheckerService::isDuplicateForImport($newData, $dbRecord));
    }

    public function test_is_duplicate_for_import_with_dash_sekolah(): void
    {
        $newData = ['nama' => 'Budi', 'sekolah' => '-', 'email' => '', 'no_wa' => '', 'nama_pembina' => ''];
        $dbRecord = ['nama' => 'Budi', 'sekolah' => 'SMP 1', 'email' => '', 'no_wa' => '', 'nama_pembina' => ''];

        // Nama sama + salah satu sekolah '-' = duplikat
        $this->assertTrue(DuplicateCheckerService::isDuplicateForImport($newData, $dbRecord));
    }
}
