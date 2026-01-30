<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lomba;
use App\Models\Galeri;

class DashboardController extends Controller
{

    public function index()
    {
        $totalLomba  = Lomba::count();
        $totalGaleri = Galeri::count();
        $totalFaq    = \App\Models\Faq::count();
        $totalUser   = \App\Models\User::count();

        // grafik
        $lombaAktif = Lomba::where('status', 'aktif')->count();
        $lombaNon  = Lomba::where('status', 'nonaktif')->count();

        return view('layouts.admin.dashboard', compact(
            'totalLomba',
            'totalGaleri',
            'totalFaq',
            'totalUser',
            'lombaAktif',
            'lombaNon'
        ));
    }
}
