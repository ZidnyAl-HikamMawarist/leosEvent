<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Services\DuplicateCheckerService;
use App\Http\Requests\StorePendaftaranRequest;
use App\Models\Lomba;
use App\Models\Carousel;
use App\Models\Timeline;
use App\Models\Galeri;
use App\Models\Setting;
use App\Models\Faq;
use App\Models\Pendaftaran;

class PageController extends Controller
{
    /**
     * Helper untuk mengambil setting dari cache.
     */
    private function getSetting(): ?Setting
    {
        return Cache::remember('app_setting', 3600, function () {
            return Setting::first();
        });
    }

    public function home(Request $request)
    {
        $selectedYear = $request->get('year', date('Y'));
        $setting = $this->getSetting();
        $galeriLimit = $setting->galeri_limit ?? 6;
        $activeLombaCount = Lomba::where('status', 'aktif')->count();

        return view('layouts.user.home', [
            'carousels' => Carousel::where('status', 'aktif')->latest()->take($activeLombaCount)->get(),
            'timelines' => Timeline::where('status', 'aktif')->orderBy('tanggal')->get(),
            'galeris' => Galeri::where('status', 'aktif')->latest()->take($galeriLimit)->get(),
            'faqs' => Faq::where('status', 'aktif')->get(),
            'lombas' => Lomba::where('status', 'aktif')
                ->where('event_year', $selectedYear)
                ->get(),
            'selectedYear' => $selectedYear,
            'availableYears' => Lomba::distinct()->pluck('event_year')->sortDesc(),
            'supportMessages' => \App\Models\SupportMessage::where('status', 'approved')->latest()->take(10)->get(),
            'topParticipants' => \App\Models\Participant::whereExists(function ($query) use ($selectedYear) {
                $query->select(\Illuminate\Support\Facades\DB::raw(1))
                    ->from('pendaftarans')
                    ->join('lombas', 'lombas.id', '=', 'pendaftarans.lomba_id')
                    ->where('lombas.event_year', $selectedYear)
                    ->whereColumn('pendaftarans.nama', 'participants.nama')
                    ->whereColumn('pendaftarans.sekolah', 'participants.sekolah')
                    ->whereColumn('pendaftarans.lomba_id', 'participants.lomba_id');
            })->orderBy('vote_count', 'desc')->take(3)->get(),
            'setting' => $setting,
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
        $setting = $this->getSetting();
        $galeriLimit = $setting->galeri_limit ?? 6;
        $galeris = Galeri::where('status', 'aktif')->latest()->take($galeriLimit)->get();
        return view('layouts.user.galeri', compact('galeris'));
    }

    public function pendaftaran()
    {
        $setting = $this->getSetting();
        $isRegistrationClosed = false;
        
        if ($setting && $setting->tanggal_tm) {
            if (\Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($setting->tanggal_tm))) {
                $isRegistrationClosed = true;
            }
        }

        $lombas = Lomba::where('status', 'aktif')->get();
        // If there is a lomba_id in query params, get it
        $selectedLomba = null;
        if (request()->has('lomba_id')) {
            $selectedLomba = Lomba::find(request('lomba_id'));
        }
        return view('layouts.user.pendaftaran', compact('lombas', 'selectedLomba', 'isRegistrationClosed', 'setting'));
    }

    public function storePendaftaran(StorePendaftaranRequest $request)
    {
        $setting = $this->getSetting();
        if ($setting && $setting->tanggal_tm) {
            if (\Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($setting->tanggal_tm))) {
                return back()->with('error', 'Technical Meeting sudah dilaksanakan, pendaftaran sudah ditutup! Silakan hubungi panitia jika ada kendala.');
            }
        }

        $data = $request->validated();
        $data['status'] = 'pending';

        // Cegah daftar ganda menggunakan DuplicateCheckerService
        $isDuplicate = DuplicateCheckerService::isDuplicate(
            $request->nama,
            $request->sekolah,
            $request->email,
            $request->no_wa,
            $request->lomba_id
        );

        if ($isDuplicate) {
            return back()->withInput()->with('error', 'Peserta dengan nama dan sekolah yang sama sudah terdaftar pada perlombaan ini. Jika ini berbeda peserta, pastikan nama/sekolah dibedakan dengan jelas atau hubungi panitia.');
        }

        // Data sudah dinormalisasi di StorePendaftaranRequest::prepareForValidation()
        $lomba = Lomba::find($request->lomba_id);

        // Map ke kolom pemimpin regu jika tipe lomba kelompok
        if ($lomba && $lomba->tipe_lomba === 'kelompok') {
            $data['nama_pemimpin_regu'] = $data['nama'];
            $data['no_hp_pemimpin_regu'] = $data['no_wa'];
        }

        $pendaftaran = Pendaftaran::create($data);

        // Tambahkan ke tabel participants agar bisa di-vote (Polling)
        \App\Models\Participant::firstOrCreate(
            [
                'nama' => $pendaftaran->nama,
                'sekolah' => $pendaftaran->sekolah,
                'lomba_id' => $pendaftaran->lomba_id,
            ],
            ['source' => 'web']
        );

        return redirect()->route('pendaftaran')->with([
            'success' => 'Pendaftaran berhasil dikirim! Silakan ikuti instruksi selanjutnya.',
            'wa_panitia' => $lomba->whatsapp_panitia,
            'link_grup' => $lomba->link_grup_wa,
            'metode_pembayaran' => $request->metode_pembayaran,
            'nama_lomba' => $lomba->nama_lomba
        ]);
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
