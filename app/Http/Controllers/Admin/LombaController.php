<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lomba;
use Illuminate\Http\Request;

class LombaController extends Controller
{
    public function index()
    {
        $lombas = Lomba::latest()->get();
        return view('layouts.admin.lomba.index', compact('lombas'));
    }

    public function create()
    {
        return view('layouts.admin.lomba.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_lomba' => 'required',
            'kategori' => 'required',
            'tanggal_pelaksanaan' => 'required|date',
            'deskripsi' => 'required',
            'poster' => 'image|mimes:jpg,png,jpeg|max:2048'
        ]);

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
            'nama_lomba' => 'required',
            'kategori' => 'required',
            'tanggal_pelaksanaan' => 'required|date',
            'deskripsi' => 'required',
            'status' => 'required',
            'poster' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

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
        $lomba->delete();
        return back()->with('success', 'Lomba dihapus');
    }


}
