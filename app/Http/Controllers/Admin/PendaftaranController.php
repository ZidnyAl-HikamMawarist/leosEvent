<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Lomba;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PendaftaranController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $lomba_id = $request->query('lomba_id');

        $query = Pendaftaran::with('lomba');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('sekolah', 'LIKE', "%{$search}%");
            });
        }

        if ($lomba_id != '') {
            $query->where('lomba_id', $lomba_id);
        }

        $pendaftarans = $query->latest()->paginate(15);
        $lombas = Lomba::all();
        $hasBatch = Pendaftaran::whereNotNull('import_batch')->exists() || 
                    \App\Models\Participant::whereNotNull('import_batch')->exists();

        return view('layouts.admin.pendaftaran.index', compact('pendaftarans', 'lombas', 'search', 'lomba_id', 'hasBatch'));
    }

    public function daftarHadir(Request $request)
    {
        $lomba_id = $request->get('lomba_id');

        $query = Pendaftaran::with('lomba')
            ->when($lomba_id, function($q) use ($lomba_id) {
                $q->where('lomba_id', $lomba_id);
            })
            ->orderBy('nama', 'asc');  // Alphabetical by nama

        $data = $query->get();

        $lombaTitle = $lomba_id 
            ? ($data->first()->lomba->nama_lomba ?? 'Unknown Lomba') 
            : 'SEMUA LOMBA';

        $jumlah_baris = max((int) $request->get('jumlah_baris', 30), $data->count());
        $pdf = Pdf::loadView('layouts.admin.pendaftaran.daftar_hadir_pdf', compact('data', 'lombaTitle', 'jumlah_baris'))
            ->setPaper('a4', 'portrait')
            ->setOptions(['isHtml5ParserEnabled' => true, 'isPhpEnabled' => true]);

        $filename = $lomba_id 
            ? "daftar_hadir_" . strtolower(str_replace(' ', '_', $lombaTitle)) . "_" . date('Y-m-d') . ".pdf"
            : "daftar_hadir_semua_" . date('Y-m-d') . ".pdf";

        return $pdf->download($filename);
    }

    public function edit($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $lombas = Lomba::all();
        return view('layouts.admin.pendaftaran.edit', compact('pendaftaran', 'lombas'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_wa' => 'required|string|max:20',
            'sekolah' => 'required|string|max:255',
            'lomba_id' => 'required|exists:lombas,id',
            'nama_pembina' => 'nullable|string|max:255',
            'no_hp_pembina' => 'nullable|string|max:20',
            'metode_pembayaran' => 'required|in:transfer,tunai',
            'status' => 'required|in:pending,confirmed,rejected',
        ]);

        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update($validated);

        return redirect()->route('admin.pendaftaran.index')->with('success', 'Data pendaftar berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->delete();

        return back()->with('success', 'Data pendaftar berhasil dihapus');
    }

    public function export(Request $request)
    {
        $type = $request->get('type', 'excel');
        $lomba_id = $request->get('lomba_id');

        $query = Pendaftaran::with('lomba');
        if ($lomba_id) {
            $query->where('lomba_id', $lomba_id);
        }
        $data = $query->latest()->get();

        if ($type == 'pdf') {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('layouts.admin.pendaftaran.export_pdf', compact('data'))
                ->setPaper('a4', 'landscape');
            return $pdf->download("pendaftar_" . date('Y-m-d') . ".pdf");
        }

        // CSV/Excel logic
        $filename = "pendaftar_" . date('Y-m-d') . ".csv";
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = array('Nama', 'Email', 'No. WhatsApp', 'Sekolah', 'Mata Lomba', 'Tipe', 'Pembina', 'No. HP Pembina', 'Pembayaran', 'Tanggal Daftar');

        $callback = function () use ($data, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($data as $item) {
                fputcsv($file, array(
                    $item->nama,
                    $item->email,
                    $item->no_wa,
                    $item->sekolah,
                    $item->lomba->nama_lomba ?? 'N/A',
                    ucfirst($item->lomba->tipe_lomba ?? '-'),
                    $item->nama_pembina ?? '-',
                    $item->no_hp_pembina ?? '-',
                    strtoupper($item->metode_pembayaran),
                    $item->created_at->format('d M Y')
                ));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function deleteAll()
    {
        $count = Pendaftaran::count();
        Pendaftaran::truncate();
        // Also clean up participants that were imported
        \App\Models\Participant::where('source', 'import')->delete();

        return back()->with('success', "Berhasil menghapus semua $count data pendaftar.");
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:pendaftarans,id',
        ]);

        $count = Pendaftaran::whereIn('id', $request->ids)->delete();

        return back()->with('success', "Berhasil menghapus $count data pendaftar terpilih.");
    }
}

