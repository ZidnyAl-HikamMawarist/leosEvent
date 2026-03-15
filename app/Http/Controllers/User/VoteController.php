<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function vote(Request $request)
    {
        $request->validate([
            'participant_id' => 'required|exists:participants,id',
        ]);

        $ip = $request->ip();
        $participantId = $request->participant_id;

        // Simple duplicate check (same IP for same participant within 1 hour)
        $alreadyVoted = \App\Models\Vote::where('participant_id', $participantId)
            ->where('ip_address', $ip)
            ->where('created_at', '>=', now()->subHour())
            ->exists();

        if ($alreadyVoted) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Kamu sudah memberikan suara untuk jagoan ini baru-baru ini. Coba lagi nanti! ⏳'
                ], 422);
            }
            return back()->with('error_vote', 'Kamu sudah memberikan suara untuk jagoan ini baru-baru ini. Coba lagi nanti! ⏳');
        }

        \App\Models\Vote::create([
            'participant_id' => $participantId,
            'ip_address' => $ip,
        ]);

        $participant = \App\Models\Participant::find($participantId);
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
}
