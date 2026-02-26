<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carousel;
use Illuminate\Http\Request;

class CarouselController extends Controller
{
    public function index()
    {
        $maxAllowed = \App\Models\Lomba::where('status', 'aktif')->count();
        $carousels = Carousel::latest()->get();
        return view('layouts.admin.carousel.index', compact('carousels', 'maxAllowed'));
    }

    public function create()
    {
        return view('layouts.admin.carousel.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'link_url' => 'nullable|string',
            'gambar' => 'required|image|mimes:jpg,png,jpeg|max:5120',
        ]);

        $maxAllowed = \App\Models\Lomba::where('status', 'aktif')->count();
        if (Carousel::count() >= $maxAllowed) {
            return back()->with('error', "Maksimal kapasitas Carousel adalah {$maxAllowed} (sesuai jumlah lomba aktif). Harap hapus carousel lama jika ingin menambah yang baru.");
        }

        $data['gambar'] = $request->file('gambar')->store('carousel', 'public');

        Carousel::create($data);

        return redirect()->route('carousel.index')
            ->with('success', 'Carousel berhasil ditambahkan');
    }

    public function edit(Carousel $carousel)
    {
        return view('layouts.admin.carousel.edit', compact('carousel'));
    }

    public function update(Request $request, Carousel $carousel)
    {
        $data = $request->validate([
            'judul' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'keterangan' => 'nullable|string',
            'link_url' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,png,jpeg|max:5120',
        ]);

        if ($request->hasFile('gambar')) {
            // Delete old image
            if (file_exists(storage_path('app/public/' . $carousel->gambar))) {
                unlink(storage_path('app/public/' . $carousel->gambar));
            }
            $data['gambar'] = $request->file('gambar')->store('carousel', 'public');
        } else {
            unset($data['gambar']);
        }

        $carousel->update($data);

        return redirect()->route('carousel.index')
            ->with('success', 'Carousel berhasil diperbarui');
    }

    public function destroy(Carousel $carousel)
    {
        // Delete image
        if (file_exists(storage_path('app/public/' . $carousel->gambar))) {
            unlink(storage_path('app/public/' . $carousel->gambar));
        }
        $carousel->delete();
        return back()->with('success', 'Carousel dihapus');
    }
}
