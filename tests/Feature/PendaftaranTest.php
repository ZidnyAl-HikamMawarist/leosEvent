<?php

namespace Tests\Feature;

use App\Models\Lomba;
use App\Models\Pendaftaran;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PendaftaranTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Setting::create(['id' => 1, 'nama_event' => 'Test Event']);
    }

    private function createLomba(array $overrides = []): Lomba
    {
        return Lomba::create(array_merge([
            'nama_lomba' => 'Lomba Cerdas Cermat',
            'slug' => 'lomba-cerdas-cermat-abc12',
            'kategori' => 'Akademik',
            'tanggal_pelaksanaan' => '2026-12-01',
            'tingkat' => 'SMP',
            'deskripsi' => 'Deskripsi lomba test.',
            'poster' => 'lomba/test.jpg',
            'status' => 'aktif',
            'event_year' => 2026,
            'tipe_lomba' => 'solo',
        ], $overrides));
    }

    public function test_pendaftaran_page_loads_successfully(): void
    {
        $this->createLomba();
        $response = $this->get('/pendaftaran');
        $response->assertStatus(200);
    }

    public function test_user_can_submit_pendaftaran(): void
    {
        $lomba = $this->createLomba();

        $response = $this->post('/pendaftaran', [
            'nama' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'no_wa' => '08123456789',
            'sekolah' => 'SMP Negeri 1',
            'lomba_id' => $lomba->id,
            'metode_pembayaran' => 'transfer',
        ]);

        $response->assertRedirect(route('pendaftaran'));
        $this->assertDatabaseHas('pendaftarans', [
            'nama' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'lomba_id' => $lomba->id,
            'status' => 'pending',
        ]);
    }

    public function test_pendaftaran_validates_required_fields(): void
    {
        $response = $this->post('/pendaftaran', []);

        $response->assertSessionHasErrors(['nama', 'email', 'no_wa', 'sekolah', 'lomba_id', 'metode_pembayaran']);
    }

    public function test_pendaftaran_validates_email_format(): void
    {
        $lomba = $this->createLomba();

        $response = $this->post('/pendaftaran', [
            'nama' => 'Budi',
            'email' => 'invalid-email',
            'no_wa' => '08123456789',
            'sekolah' => 'SMP 1',
            'lomba_id' => $lomba->id,
            'metode_pembayaran' => 'transfer',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_duplicate_pendaftaran_is_rejected(): void
    {
        $lomba = $this->createLomba();

        // Daftar pertama kali
        $this->post('/pendaftaran', [
            'nama' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'no_wa' => '08123456789',
            'sekolah' => 'SMP Negeri 1',
            'lomba_id' => $lomba->id,
            'metode_pembayaran' => 'transfer',
        ]);

        // Daftar ulang dengan data yang sama
        $response = $this->post('/pendaftaran', [
            'nama' => 'Budi Santoso',
            'email' => 'budi2@example.com', // Email beda
            'no_wa' => '08199999999',       // WA beda
            'sekolah' => 'SMP Negeri 1',
            'lomba_id' => $lomba->id,
            'metode_pembayaran' => 'tunai',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertEquals(1, Pendaftaran::where('lomba_id', $lomba->id)->count());
    }

    public function test_pendaftaran_closed_after_tanggal_tm(): void
    {
        $lomba = $this->createLomba();
        Setting::first()->update(['tanggal_tm' => now()->subDay()]);

        $response = $this->post('/pendaftaran', [
            'nama' => 'Budi',
            'email' => 'budi@example.com',
            'no_wa' => '08123456789',
            'sekolah' => 'SMP 1',
            'lomba_id' => $lomba->id,
            'metode_pembayaran' => 'transfer',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    public function test_kelompok_lomba_maps_pemimpin_regu(): void
    {
        $lomba = $this->createLomba(['tipe_lomba' => 'kelompok']);

        $this->post('/pendaftaran', [
            'nama' => 'Ketua Tim',
            'email' => 'ketua@example.com',
            'no_wa' => '08123456789',
            'sekolah' => 'SMP 1',
            'lomba_id' => $lomba->id,
            'metode_pembayaran' => 'transfer',
        ]);

        $this->assertDatabaseHas('pendaftarans', [
            'nama_pemimpin_regu' => 'Ketua Tim',
            'no_hp_pemimpin_regu' => '08123456789',
        ]);
    }
}
