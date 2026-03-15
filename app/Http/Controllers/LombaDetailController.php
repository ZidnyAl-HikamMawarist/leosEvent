<?php

namespace App\Http\Controllers;

use App\Models\Lomba;
use Illuminate\Http\Request;

class LombaDetailController extends Controller
{
    public function show(Lomba $lomba)
    {
        $participants = \App\Models\Participant::where('lomba_id', $lomba->id)
            ->orderBy('vote_count', 'desc')
            ->get();
            
        return view('layouts.user.lomba-detail', compact('lomba', 'participants'));
    }
}