<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lomba;
use App\Models\Carousel;
use App\Models\Timeline;
use App\Models\Galeri;
use App\Models\Setting;
use App\Models\Faq;
use App\Models\Pendaftaran;

class PageController extends Controller
{
    public function home(Request $request)
    {
        // Mengambil tahun dari request, default ke tahun sekarang jika tidak ada
        $selectedYear = $request->get('year', date('Y'));

        // Opsional: Jika ingin otomatis menampilkan tahun terbaru yang ada di database
        // $selectedYear = $request->get('year', Lomba::max('event_year') ?? date('Y'));
        return view('layouts.user.home', [
            'carousels' => Carousel::where('status', 'aktif')->get(),
            'timelines' => Timeline::where('status', 'aktif')->orderBy('tanggal')->get(),
            'galeris' => Galeri::where('status', 'aktif')->get(),
            'faqs' => Faq::where('status', 'aktif')->get(),
            'lombas' => Lomba::where('status', 'aktif')
                ->where('event_year', $selectedYear)
                ->get(),
            'selectedYear' => $selectedYear,
            'availableYears' => Lomba::distinct()->pluck('event_year')->sortDesc()
        ]);
    }

    public function lomba(Request $request)
    {
        $selectedYear = $request->get('year', date('Y'));
        $lombas = Lomba::where('status', 'aktif')
            ->where('event_year', $selectedYear)
            ->get();
        $availableYears = Lomba::distinct()->pluck('event_year')->sortDesc();

        return view('layouts.user.lomba', compact('lombas', 'selectedYear', 'availableYears'));
    }

    public function timeline()
    {
        $timelines = Timeline::where('status', 'aktif')
            ->orderBy('urutan')
            ->get();
        return view('layouts.user.timeline', compact('timelines'));
    }

    public function galeri()
    {
        $galeris = Galeri::where('status', 'aktif')->get();
        return view('layouts.user.galeri', compact('galeris'));
    }

    public function pendaftaran()
    {
        $lombas = Lomba::where('status', 'aktif')->get();
        // If there is a lomba_id in query params, get it
        $selectedLomba = null;
        if (request()->has('lomba_id')) {
            $selectedLomba = Lomba::find(request('lomba_id'));
        }
        return view('layouts.user.pendaftaran', compact('lombas', 'selectedLomba'));
    }

    public function storePendaftaran(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_wa' => 'required|string|max:20',
            'sekolah' => 'required|string|max:255',
            'lomba_id' => 'required|exists:lombas,id',
            'nama_pembina' => 'required|string|max:255',
            'no_hp_pembina' => 'required|string|max:20',
            'metode_pembayaran' => 'required|in:transfer,tunai',
        ]);

        $data = $request->only([
            'nama',
            'email',
            'no_wa',
            'sekolah',
            'lomba_id',
            'nama_pembina',
            'no_hp_pembina',
            'metode_pembayaran'
        ]);

        $data['status'] = 'pending';

        Pendaftaran::create($data);

        return redirect()->route('pendaftaran')->with('success', 'Pendaftaran berhasil dikirim! Kami akan menghubungi Anda segera.');
    }

    public function faq()
    {
        $faqs = Faq::where('status', 'aktif')->get();
        return view('layouts.user.faq', compact('faqs'));
    }

    public function about()
    {
        return view('layouts.user.about');
    }

    public function kontak()
    {
        return view('layouts.user.kontak');
    }
}
