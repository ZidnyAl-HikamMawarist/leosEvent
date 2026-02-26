<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $setting = \App\Models\Setting::first();
        $limit = $setting ? ($setting->galeri_limit ?? 6) : 6;
        $maxAllowed = $limit + 3;

        $galeris = Galeri::latest()->get();
        return view('layouts.admin.galeri.index', compact('galeris', 'maxAllowed', 'limit'));
    }

    public function create()
    {
        return view('layouts.admin.galeri.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required',
            'gambar' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $setting = \App\Models\Setting::first();
        $limit = $setting ? ($setting->galeri_limit ?? 6) : 6;
        $maxAllowed = $limit + 3;

        if (Galeri::count() >= $maxAllowed) {
            return back()->with('error', "Maksimal kapasitas server adalah {$maxAllowed} foto. Harap hapus foto lama terlebih dahulu sebelum menambah baru.");
        }

        $data['gambar'] = $request->file('gambar')->store('galeri', 'public');

        Galeri::create($data);

        return redirect()->route('galeri.index')
            ->with('success', 'Foto galeri ditambahkan');
    }
    public function edit(Galeri $galeri)
    {
        return view('layouts.admin.galeri.edit', compact('galeri'));
    }

    public function update(Request $request, Galeri $galeri)
    {
        $data = $request->validate([
            'judul' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($galeri->gambar && file_exists(storage_path('app/public/' . $galeri->gambar))) {
                unlink(storage_path('app/public/' . $galeri->gambar));
            }
            $data['gambar'] = $request->file('gambar')->store('galeri', 'public');
        } else {
            // Jika tidak ada gambar baru, hapus 'gambar' dari array data agar tidak diupdate null
            unset($data['gambar']);
        }

        $galeri->update($data);

        return redirect()->route('galeri.index')
            ->with('success', 'Foto galeri berhasil diperbarui');
    }

    public function destroy(Galeri $galeri)
    {
        if ($galeri->gambar && file_exists(storage_path('app/public/' . $galeri->gambar))) {
            unlink(storage_path('app/public/' . $galeri->gambar));
        }
        $galeri->delete();
        return back()->with('success', 'Foto galeri dihapus');
    }
}
