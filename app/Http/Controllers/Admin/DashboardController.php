<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lomba;
use App\Models\Galeri;
use App\Models\Pendaftaran;
use App\Models\Timeline;
use App\Models\Carousel;

class DashboardController extends Controller
{

    public function index()
    {
        $totalLomba = Lomba::count();
        $totalGaleri = Galeri::count();
        $totalFaq = \App\Models\Faq::count();
        $totalUser = \App\Models\User::count();
        $totalCarousel = Carousel::count();
        $totalTimeline = Timeline::count();
        $totalPendaftaran = Pendaftaran::count();

        // Data untuk grafik jumlah pendaftar per mata lomba
        $lombaStats = Lomba::withCount('pendaftarans')->get();
        $chartLabels = $lombaStats->pluck('nama_lomba');
        $chartData = $lombaStats->pluck('pendaftarans_count');

        // Recent registrations
        $recentRegistrations = Pendaftaran::with('lomba')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Top Lombas by registration count
        $topLombas = Lomba::withCount('pendaftarans')
            ->orderBy('pendaftarans_count', 'desc')
            ->limit(5)
            ->get();

        return view('layouts.admin.dashboard', compact(
            'totalLomba',
            'totalGaleri',
            'totalFaq',
            'totalUser',
            'totalCarousel',
            'totalTimeline',
            'totalPendaftaran',
            'chartLabels',
            'chartData',
            'recentRegistrations',
            'topLombas'
        ));
    }
}
