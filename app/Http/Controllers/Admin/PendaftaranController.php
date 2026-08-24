<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use App\Models\Lomba;
use App\Models\AuditLog;
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
        $status = $request->get('status');

        $query = Pendaftaran::with('lomba')
            ->when($lomba_id, function($q) use ($lomba_id) {
                $q->where('lomba_id', $lomba_id);
            })
            ->when($status, function($q) use ($status) {
                $q->where('status', $status);
            })
            ->orderBy('nama', 'asc');

        $data = $query->get();

        $lombaModel = $lomba_id ? Lomba::find($lomba_id) : null;
        $lombaTitle = $lombaModel ? $lombaModel->nama_lomba : 'SEMUA LOMBA';
        
        if ($status) {
            $lombaTitle .= ' (' . strtoupper($status) . ')';
        }

        $jumlah_baris = max((int) $request->get('jumlah_baris', 30), $data->count());
        $pdf = Pdf::loadView('layouts.admin.pendaftaran.daftar_hadir_pdf', compact('data', 'lombaTitle', 'jumlah_baris'))
            ->setPaper('a4', 'portrait')
            ->setOptions(['isHtml5ParserEnabled' => true, 'isPhpEnabled' => true]);

        $cleanTitle = strtolower(str_replace([' ', '(', ')'], ['_', '', ''], $lombaTitle));
        $filename = "daftar_hadir_{$cleanTitle}_" . date('Y-m-d') . ".pdf";

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
        
        // Simpan data lama untuk pencocokan di tabel participants
        $oldNama = $pendaftaran->nama;
        $oldSekolah = $pendaftaran->sekolah;
        $oldLombaId = $pendaftaran->lomba_id;

        // Normalisasi data baru sebelum disimpan (menghindari spasi ganda/berlebih)
        $validated['nama'] = preg_replace('/\s+/u', ' ', trim((string) $validated['nama']));
        $validated['sekolah'] = preg_replace('/\s+/u', ' ', trim((string) $validated['sekolah']));

        $pendaftaran->update($validated);

        AuditLog::log('update_pendaftaran', "Mengupdate pendaftar: {$validated['nama']}", $pendaftaran);

        // Sinkronisasi: Update data di tabel participants agar tetap nyambung dengan voting
        \App\Models\Participant::where('nama', $oldNama)
            ->where('sekolah', $oldSekolah)
            ->where('lomba_id', $oldLombaId)
            ->update([
                'nama' => $validated['nama'],
                'sekolah' => $validated['sekolah'],
                'lomba_id' => $validated['lomba_id'],
            ]);

        return redirect()->route('admin.pendaftaran.index')->with('success', 'Data pendaftar berhasil diperbarui dan disinkronkan dengan voting');
    }

    public function destroy($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);

        $nama = $pendaftaran->nama;
        // Hapus juga data participant voting yang terkait
        \App\Models\Participant::where('nama', $pendaftaran->nama)
            ->where('sekolah', $pendaftaran->sekolah)
            ->where('lomba_id', $pendaftaran->lomba_id)
            ->delete();

        $pendaftaran->delete();

        AuditLog::log('delete_pendaftaran', "Menghapus pendaftar: {$nama}", $pendaftaran);

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

        // Excel logic using SimpleXLSXGen
        $filename = "pendaftar_" . date('Y-m-d') . ".xlsx";
        $columns = ['Nama', 'Email', 'No. WhatsApp', 'Sekolah', 'Mata Lomba', 'Tipe', 'Pembina', 'No. HP Pembina', 'Pembayaran', 'Tanggal Daftar'];
        
        $rows = [$columns];
        foreach ($data as $item) {
            $rows[] = [
                $item->nama,
                $item->email,
                $item->no_wa,
                $item->sekolah,
                $item->lomba->nama_lomba ?? '-',
                ucfirst($item->lomba->tipe_lomba ?? '-'),
                $item->nama_pembina ?? '-',
                $item->no_hp_pembina ?? '-',
                strtoupper((string) $item->metode_pembayaran),
                $item->created_at ? $item->created_at->format('d M Y H:i') : '-'
            ];
        }

        $xlsxOutput = (string) \Shuchkin\SimpleXLSXGen::fromArray($rows);

        return response($xlsxOutput)
            ->header('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"')
            ->header('Cache-Control', 'max-age=0');
    }

    public function deleteAll()
    {
        $count = Pendaftaran::count();
        // Menggunakan delete() alih-alih truncate() agar tidak error terhadap foreign key constraints (tabel votes)
        Pendaftaran::query()->delete();
        \App\Models\Participant::query()->delete();

        AuditLog::log('delete_all_pendaftaran', "Menghapus semua data pendaftar ($count data) dan voting.");

        return back()->with('success', "Berhasil menghapus semua $count data pendaftar dan data voting.");
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:pendaftarans,id',
        ]);

        $pendaftarans = Pendaftaran::whereIn('id', $request->ids)->get();
        
        foreach ($pendaftarans as $p) {
            \App\Models\Participant::where('nama', $p->nama)
                ->where('sekolah', $p->sekolah)
                ->where('lomba_id', $p->lomba_id)
                ->delete();
        }

        $count = Pendaftaran::whereIn('id', $request->ids)->delete();

        AuditLog::log('bulk_delete_pendaftaran', "Menghapus $count pendaftar terpilih.", null, ['ids' => $request->ids]);

        return back()->with('success', "Berhasil menghapus $count data pendaftar terpilih.");
    }
}
