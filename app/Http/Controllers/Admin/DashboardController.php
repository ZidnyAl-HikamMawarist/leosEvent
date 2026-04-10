<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lomba;
use App\Models\Galeri;
use App\Models\Pendaftaran;
use App\Models\Timeline;
use App\Models\Carousel;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        $availableYears = Lomba::distinct()->orderBy('event_year', 'desc')->pluck('event_year');
        $currentYear = $request->get('year', date('Y'));
        
        // Jika tahun yang dipilih tidak ada di Lomba, tapi ada tahun lain, ambil tahun terbaru
        if ($availableYears->isNotEmpty() && !$availableYears->contains($currentYear) && !$request->has('year')) {
            $currentYear = $availableYears->first();
        }

        $totalLomba = Lomba::where('event_year', $currentYear)->count();
        $totalGaleri = Galeri::count();
        $totalFaq = \App\Models\Faq::count();
        $totalUser = \App\Models\User::count();
        $totalCarousel = Carousel::count();
        $totalTimeline = Timeline::count();
        
        // Statistik Pendaftaran (Tahun Ini vs Total)
        $totalPendaftaran = Pendaftaran::whereHas('lomba', function($q) use ($currentYear) {
            $q->where('event_year', $currentYear);
        })->count();
        
        $totalPendaftaranLifetime = Pendaftaran::count();

        // Data untuk grafik jumlah pendaftar per mata lomba (Khusus Tahun Ini)
        $lombaStats = Lomba::where('event_year', $currentYear)->withCount('pendaftarans')->get();
        $chartLabels = $lombaStats->pluck('nama_lomba');
        $chartData = $lombaStats->pluck('pendaftarans_count');

        // Recent registrations (Khusus Tahun Ini)
        $recentRegistrations = Pendaftaran::with('lomba')
            ->whereHas('lomba', function($q) use ($currentYear) {
                $q->where('event_year', $currentYear);
            })
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Top Lombas by registration count (Khusus Tahun Ini)
        $topLombas = Lomba::where('event_year', $currentYear)
            ->withCount('pendaftarans')
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
            'totalPendaftaranLifetime',
            'chartLabels',
            'chartData',
            'recentRegistrations',
            'topLombas',
            'currentYear',
            'availableYears'
        ));
    }
}
