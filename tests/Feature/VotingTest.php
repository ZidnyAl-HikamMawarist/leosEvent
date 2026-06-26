<?php

namespace Tests\Feature;

use App\Models\Lomba;
use App\Models\Participant;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VotingTest extends TestCase
{
    use RefreshDatabase;

    private function createParticipant(): Participant
    {
        $lomba = Lomba::create([
            'nama_lomba' => 'Lomba Test',
            'slug' => 'lomba-test-abc12',
            'kategori' => 'Akademik',
            'tanggal_pelaksanaan' => '2026-12-01',
            'tingkat' => 'SMP',
            'deskripsi' => 'Test.',
            'poster' => 'test.jpg',
            'status' => 'aktif',
            'event_year' => 2026,
            'tipe_lomba' => 'solo',
        ]);

        return Participant::create([
            'nama' => 'Peserta Test',
            'sekolah' => 'SMP 1',
            'lomba_id' => $lomba->id,
            'source' => 'web',
            'vote_count' => 0,
        ]);
    }

    public function test_user_can_vote(): void
    {
        $participant = $this->createParticipant();

        $response = $this->postJson('/vote', [
            'participant_id' => $participant->id,
        ]);

        $response->assertStatus(200)
            ->assertJson(['status' => 'success']);

        $this->assertDatabaseHas('votes', [
            'participant_id' => $participant->id,
        ]);

        $this->assertEquals(1, $participant->fresh()->vote_count);
    }

    public function test_same_ip_cannot_vote_same_participant_within_cooldown(): void
    {
        $participant = $this->createParticipant();

        // Vote pertama
        $this->postJson('/vote', ['participant_id' => $participant->id]);

        // Vote kedua dari IP yang sama
        $response = $this->postJson('/vote', ['participant_id' => $participant->id]);

        $response->assertStatus(422)
            ->assertJson(['status' => 'error']);
    }

    public function test_different_fingerprint_blocked_from_voting(): void
    {
        $participant = $this->createParticipant();

        // Vote pertama dengan fingerprint
        $this->postJson('/vote', [
            'participant_id' => $participant->id,
            'fingerprint' => 'fp-unique-123',
        ]);

        // Vote kedua dengan fingerprint yang sama (IP berbeda tidak bisa disimulasikan di test)
        $response = $this->postJson('/vote', [
            'participant_id' => $participant->id,
            'fingerprint' => 'fp-unique-123',
        ]);

        $response->assertStatus(422);
    }

    public function test_daily_vote_limit_per_ip(): void
    {
        $participant = $this->createParticipant();

        // Simulasi 20 vote (batas harian) dengan participant berbeda
        for ($i = 0; $i < 20; $i++) {
            $p = Participant::create([
                'nama' => "Peserta $i",
                'sekolah' => "SMP $i",
                'lomba_id' => $participant->lomba_id,
                'source' => 'web',
                'vote_count' => 0,
            ]);

            Vote::create([
                'participant_id' => $p->id,
                'ip_address' => '127.0.0.1',
                'created_at' => now(),
            ]);
        }

        // Vote ke-21 harusnya diblokir
        $newParticipant = Participant::create([
            'nama' => 'Peserta Baru',
            'sekolah' => 'SMP Baru',
            'lomba_id' => $participant->lomba_id,
            'source' => 'web',
            'vote_count' => 0,
        ]);

        $response = $this->postJson('/vote', [
            'participant_id' => $newParticipant->id,
        ]);

        $response->assertStatus(422)
            ->assertJsonPath('message', 'Kamu sudah mencapai batas vote harian. Coba lagi besok! 🚫');
    }

    public function test_vote_requires_valid_participant_id(): void
    {
        $response = $this->postJson('/vote', [
            'participant_id' => 99999,
        ]);

        $response->assertStatus(422);
    }
}
