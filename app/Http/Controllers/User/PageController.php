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
    public function home()
    {
        return view('layouts.user.home', [
            'carousels' => Carousel::where('status', 'aktif')->get(),
            'timelines' => Timeline::where('status', 'aktif')->orderBy('tanggal')->get(),
            'galeris' => Galeri::where('status', 'aktif')->get(),
            'faqs' => Faq::where('status', 'aktif')->get(),
            'setting' => Setting::first(),
            'lombas' => Lomba::where('status', 'aktif')->get(),
        ]);

    }

    public function lomba()
    {
        $lombas = Lomba::where('status', 'aktif')->get();
        $setting = Setting::first();
        return view('layouts.user.lomba', compact('lombas', 'setting'));
    }

    public function timeline()
    {
        $timelines = Timeline::where('status', 'aktif')
            ->orderBy('urutan')
            ->get();
        $setting = Setting::first();
        return view('layouts.user.timeline', compact('timelines', 'setting'));
    }

    public function galeri()
    {
        $galeris = Galeri::where('status', 'aktif')->get();
        $setting = Setting::first();
        return view('layouts.user.galeri', compact('galeris', 'setting'));
    }

    public function pendaftaran()
    {
        $setting = Setting::first();
        $lombas = Lomba::where('status', 'aktif')->get();
        // If there is a lomba_id in query params, get it
        $selectedLomba = null;
        if (request()->has('lomba_id')) {
            $selectedLomba = Lomba::find(request('lomba_id'));
        }
        return view('layouts.user.pendaftaran', compact('setting', 'lombas', 'selectedLomba'));
    }

    public function storePendaftaran(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'sekolah' => 'required|string|max:255',
            'lomba_id' => 'required|exists:lombas,id',
        ]);

        Pendaftaran::create([
            'nama' => $request->nama,
            'sekolah' => $request->sekolah,
            'lomba_id' => $request->lomba_id,
            'status' => 'pending',
        ]);

        return redirect()->route('pendaftaran')->with('success', 'Pendaftaran berhasil dikirim! Kami akan menghubungi Anda segera.');
    }

    public function faq()
    {
        $faqs = Faq::where('status', 'aktif')->get();
        $setting = Setting::first();
        return view('layouts.user.faq', compact('faqs', 'setting'));
    }

    public function about()
    {
        $setting = Setting::first();
        return view('layouts.user.about', compact('setting'));
    }

    public function kontak()
    {
        $setting = Setting::first();
        return view('layouts.user.kontak', compact('setting'));
    }
}
