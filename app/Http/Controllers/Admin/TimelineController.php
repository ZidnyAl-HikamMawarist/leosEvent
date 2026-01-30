<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Timeline;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    public function index()
    {
        $timelines = Timeline::orderBy('urutan')->get();
        return view('layouts.admin.timeline.index', compact('timelines'));
    }

    public function create()
    {
        return view('layouts.admin.timeline.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable',
            'urutan' => 'required|integer'
        ]);

        Timeline::create($data);

        return redirect()->route('timeline.index')
            ->with('success', 'Timeline berhasil ditambahkan');
    }

    public function edit(Timeline $timeline)
    {
        return view('layouts.admin.timeline.edit', compact('timeline'));
    }

    public function update(Request $request, Timeline $timeline)
    {
        $data = $request->validate([
            'judul' => 'required',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable',
            'urutan' => 'required|integer',
            'status' => 'required'
        ]);

        $timeline->update($data);

        return redirect()->route('timeline.index')
            ->with('success', 'Timeline berhasil diperbarui');
    }

    public function destroy(Timeline $timeline)
    {
        $timeline->delete();
        return back()->with('success', 'Timeline dihapus');
    }
}
