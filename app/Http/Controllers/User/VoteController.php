<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vote;
use App\Models\Participant;

class VoteController extends Controller
{
    /**
     * Waktu cooldown voting dalam menit (per kombinasi IP+fingerprint+participant).
     */
    private const COOLDOWN_MINUTES = 60;

    /**
     * Maksimal vote per IP per hari (untuk semua peserta).
     */
    private const MAX_VOTES_PER_IP_PER_DAY = 20;

    public function vote(Request $request)
    {
        $request->validate([
            'participant_id' => 'required|exists:participants,id',
            'fingerprint' => 'nullable|string|max:255',
        ]);

        $ip = $request->ip();
        $participantId = $request->participant_id;
        $fingerprint = $request->input('fingerprint');
        $userAgent = $request->userAgent();

        // --- Layer 1: Cek duplikasi berdasarkan IP + Fingerprint (jika ada) ---
        $cooldownTime = now()->subMinutes(self::COOLDOWN_MINUTES);

        $duplicateQuery = Vote::where('participant_id', $participantId)
            ->where('created_at', '>=', $cooldownTime);

        // Cek berdasarkan IP
        $duplicateByIp = (clone $duplicateQuery)->where('ip_address', $ip)->exists();

        if ($duplicateByIp) {
            return $this->errorResponse($request, 'Kamu sudah memberikan suara untuk jagoan ini baru-baru ini. Coba lagi nanti! ⏳');
        }

        // Cek berdasarkan fingerprint (lebih akurat dari IP saja)
        if ($fingerprint) {
            $duplicateByFingerprint = (clone $duplicateQuery)->where('fingerprint', $fingerprint)->exists();

            if ($duplicateByFingerprint) {
                return $this->errorResponse($request, 'Perangkat ini sudah memberikan suara untuk jagoan ini. Coba lagi nanti! ⏳');
            }
        }

        // --- Layer 2: Rate limit global per IP per hari ---
        $dailyVoteCount = Vote::where('ip_address', $ip)
            ->whereDate('created_at', today())
            ->count();

        if ($dailyVoteCount >= self::MAX_VOTES_PER_IP_PER_DAY) {
            return $this->errorResponse($request, 'Kamu sudah mencapai batas vote harian. Coba lagi besok! 🚫');
        }

        // --- Layer 3: Simpan vote ---
        Vote::create([
            'participant_id' => $participantId,
            'ip_address' => $ip,
            'fingerprint' => $fingerprint,
            'user_agent' => $userAgent,
        ]);

        $participant = Participant::find($participantId);
        $participant->increment('vote_count');

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => "Terima kasih! Dukunganmu untuk {$participant->nama} sudah tercatat. 🚀",
                'new_vote_count' => $participant->vote_count
            ]);
        }

        return back()->with('success_vote', "Terima kasih! Dukunganmu untuk {$participant->nama} sudah tercatat. 🚀");
    }

    /**
     * Helper untuk mengirim response error (AJAX atau redirect).
     */
    private function errorResponse(Request $request, string $message)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => 'error',
                'message' => $message
            ], 422);
        }
        return back()->with('error_vote', $message);
    }
}
