<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lomba;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LombaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $lombas = Lomba::withCount('pendaftarans')
            ->when($search, function ($query, $search) {
                return $query->where('nama_lomba', 'LIKE', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('layouts.admin.lomba.index', compact('lombas', 'search'));
    }

    public function checkName(Request $request)
    {
        $exists = Lomba::where('nama_lomba', $request->name)
            ->when($request->exclude_id, function ($q) use ($request) {
                return $q->where('id', '!=', $request->exclude_id);
            })
            ->exists();

        return response()->json(['exists' => $exists]);
    }

    public function create()
    {
        return view('layouts.admin.lomba.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_lomba' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'deskripsi' => 'required',
            'poster' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'event_year' => 'required|digits:4',
            'lokasi' => 'nullable|string',
            'harga_tiket' => 'nullable|numeric',
            'juklak_juknis_link' => 'nullable|url',
            'event_start' => 'nullable|date_format:H:i',
            'event_end' => 'nullable|date_format:H:i',
            'is_save_the_date_active' => 'nullable|boolean',
            'tipe_lomba' => 'required|in:solo,kelompok',
            'whatsapp_panitia' => 'nullable|string',
            'link_grup_wa' => 'nullable|url'
        ]);

        $data['slug'] = Str::slug($request->nama_lomba) . '-' . Str::random(5);
        $data['status'] = 'aktif';
        $data['kategori'] = 'Akademik';
        $data['tingkat'] = 'SMP';

        if ($request->hasFile('poster')) {
            $data['poster'] = $request->file('poster')->store('lomba', 'public');
        }

        Lomba::create($data);

        return redirect()->route('lomba.index')->with('success', 'Lomba berhasil ditambahkan');
    }

    public function edit(Lomba $lomba)
    {
        return view('layouts.admin.lomba.edit', compact('lomba'));
    }

    public function update(Request $request, Lomba $lomba)
    {
        $data = $request->validate([
            'nama_lomba' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'deskripsi' => 'required',
            'status' => 'required|in:aktif,nonaktif',
            'poster' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'event_year' => 'required|digits:4',
            'lokasi' => 'nullable|string',
            'harga_tiket' => 'nullable|numeric',
            'juklak_juknis_link' => 'nullable|url',
            'event_start' => 'nullable|date_format:H:i',
            'event_end' => 'nullable|date_format:H:i',
            'is_save_the_date_active' => 'nullable|boolean',
            'juara_1' => 'nullable|string|max:255',
            'juara_2' => 'nullable|string|max:255',
            'juara_3' => 'nullable|string|max:255',
            'tipe_lomba' => 'required|in:solo,kelompok',
            'whatsapp_panitia' => 'nullable|string',
            'link_grup_wa' => 'nullable|url'
        ]);

        if ($lomba->nama_lomba !== $request->nama_lomba) {
            $data['slug'] = Str::slug($request->nama_lomba) . '-' . Str::random(5);
        }
        $data['kategori'] = 'Akademik';
        $data['tingkat'] = 'SMP';

        if ($request->hasFile('poster')) {
            if ($lomba->poster && \Illuminate\Support\Facades\Storage::exists('public/' . $lomba->poster)) {
                \Illuminate\Support\Facades\Storage::delete('public/' . $lomba->poster);
            }
            $data['poster'] = $request->file('poster')->store('lomba', 'public');
        }

        $lomba->update($data);

        return redirect()->route('lomba.index')->with('success', 'Lomba berhasil diupdate');
    }

    public function destroy(Lomba $lomba)
    {
        if ($lomba->poster && file_exists(storage_path('app/public/' . $lomba->poster))) {
            unlink(storage_path('app/public/' . $lomba->poster));
        }
        $lomba->delete();
        return back()->with('success', 'Lomba dihapus');
    }


}
