<?php

namespace App\Http\Controllers\presensiManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\presensi; // Ganti dengan Model Anda
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    // Menampilkan Halaman Form Filter
    public function index()
    {
        return view('app.laporan.index');
    }

    // Logic Mencetak PDF
    public function print(Request $request)
    {
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'nip'        => 'nullable|string',
        ]);

        // Mulai Query
        $query = Presensi::query();

        // Filter berdasarkan NIP jika diisi
        if ($request->filled('nip')) {
            $query->join('users', 'presensi.user_id', '=', 'users.user_id')
                  ->where('users.NIP', $request->nip);
        }

        // Filter berdasarkan Rentang Waktu jika diisi
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        }

        $data = $query->get();

        // Load View PDF dengan data
        $pdf = Pdf::loadView('app.laporan.pdf', [
            'data' => $data,
            'info' => $request->all() // Mengirim info filter ke view untuk judul
        ]);

        // Stream (tampilkan di browser) atau Download
        // 'stream' membiarkan user melihat dulu, 'download' langsung unduh file
        return $pdf->stream('laporan-karyawan.pdf');
    }
}
