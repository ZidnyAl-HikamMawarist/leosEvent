<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLombaRequest;
use App\Http\Requests\UpdateLombaRequest;
use App\Models\Lomba;
use App\Models\AuditLog;
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
            ->when($request->event_year, function ($q) use ($request) {
                return $q->where('event_year', $request->event_year);
            })
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

    public function store(StoreLombaRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = Str::slug($request->nama_lomba) . '-' . Str::random(5);
        $data['status'] = 'aktif';
        $data['kategori'] = 'Akademik';
        $data['tingkat'] = 'SMP';

        if ($request->hasFile('poster')) {
            $data['poster'] = $request->file('poster')->store('lomba', 'public');
        }

        Lomba::create($data);

        AuditLog::log('create_lomba', "Membuat lomba baru: {$data['nama_lomba']}");

        return redirect()->route('lomba.index')->with('success', 'Lomba berhasil ditambahkan');
    }

    public function edit(Lomba $lomba)
    {
        return view('layouts.admin.lomba.edit', compact('lomba'));
    }

    public function update(UpdateLombaRequest $request, Lomba $lomba)
    {
        $data = $request->validated();

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

        AuditLog::log('update_lomba', "Mengupdate lomba: {$lomba->nama_lomba}", $lomba);

        return redirect()->route('lomba.index')->with('success', 'Lomba berhasil diupdate');
    }

    public function destroy(Lomba $lomba)
    {
        $nama = $lomba->nama_lomba;
        if ($lomba->poster && \Illuminate\Support\Facades\Storage::exists('public/' . $lomba->poster)) {
            \Illuminate\Support\Facades\Storage::delete('public/' . $lomba->poster);
        }
        $lomba->delete();

        AuditLog::log('delete_lomba', "Menghapus lomba: {$nama}", $lomba);

        return back()->with('success', 'Lomba dihapus');
    }


}
