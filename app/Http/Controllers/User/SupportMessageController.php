<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupportMessageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'pesan' => 'required|string|max:300',
            'lomba_id' => 'nullable|exists:lombas,id',
        ]);

        \App\Models\SupportMessage::create([
            'nama' => $request->nama,
            'pesan' => $request->pesan,
            'lomba_id' => $request->lomba_id,
            'status' => 'approved',
        ]);

        return back()->with('success_message', 'Pesan dukunganmu berhasil dikirim! 🔥');
    }
}
