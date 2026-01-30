<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::all();
        return view('layouts.admin.faq.index', compact('faqs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required',
            'jawaban' => 'required'
        ]);

        Faq::create($request->all());
        return back()->with('success', 'FAQ berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);
        $faq->update($request->all());

        return back()->with('success', 'FAQ berhasil diupdate');
    }

    public function destroy($id)
    {
        Faq::destroy($id);
        return back()->with('success', 'FAQ berhasil dihapus');
    }
}
