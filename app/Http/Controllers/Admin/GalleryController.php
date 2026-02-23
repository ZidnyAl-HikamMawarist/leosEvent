<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galeris = Galeri::latest()->get();
        return view('layouts.admin.galeri.index', compact('galeris'));
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

        $data['gambar'] = $request->file('gambar')->store('galeri', 'public');

        Galeri::create($data);

        return redirect()->route('galeri.index')
            ->with('success', 'Foto galeri ditambahkan');
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
