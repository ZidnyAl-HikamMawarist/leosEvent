<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Lomba;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pendaftaran::with('lomba');

        if ($request->has('lomba_id') && $request->lomba_id != '') {
            $query->where('lomba_id', $request->lomba_id);
        }

        $pendaftarans = $query->latest()->get();
        $lombas = Lomba::all();

        return view('layouts.admin.pendaftaran.index', compact('pendaftarans', 'lombas'));
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
            // Simple PDF logic or just return a view for printing
            return view('layouts.admin.pendaftaran.export_pdf', compact('data'));
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

        $columns = array('Nama', 'Sekolah', 'Mata Lomba', 'Tanggal Daftar');

        $callback = function () use ($data, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($data as $item) {
                fputcsv($file, array($item->nama, $item->sekolah, $item->lomba->nama_lomba, $item->created_at->format('d M Y')));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
