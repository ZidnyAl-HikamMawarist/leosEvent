<?php

namespace App\Http\Controllers;

use App\Models\Lomba;
use Illuminate\Http\Request;

class LombaDetailController extends Controller
{
    public function show(Lomba $lomba)
    {
        return view('layouts.user.lomba-detail', compact('lomba'));
    }
}