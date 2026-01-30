<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carousel;
use Illuminate\Http\Request;

class CarouselController extends Controller
{
    public function index()
    {
        $carousels = Carousel::latest()->get();
        return view('layouts.admin.carousel.index', compact('carousels'));
    }

    public function create()
    {
        return view('layouts.admin.carousel.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'nullable|string',
            'gambar' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $data['gambar'] = $request->file('gambar')->store('carousel', 'public');

        Carousel::create($data);

        return redirect()->route('carousel.index')
            ->with('success', 'Carousel berhasil ditambahkan');
    }

    public function destroy(Carousel $carousel)
    {
        $carousel->delete();
        return back()->with('success', 'Carousel dihapus');
    }
}
