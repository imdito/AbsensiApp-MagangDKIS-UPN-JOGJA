<?php

namespace App\Http\Controllers\presensiManagement;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Services\StatistikServices; // Import Service

class LaporanController extends Controller
{
    // Tampilkan Halaman Form
    public function index()
    {
        $daftar_bidang = Bidang::tenanted()->lazy();
        return view('app.laporan.index', compact('daftar_bidang'));
    }

    // Logic Mencetak PDF
    public function print(Request $request, StatistikServices $statistikService)
    {
        // 1. Validasi
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'nip'        => 'nullable|string',
            'id_bidang'  => 'nullable|integer',
        ]);

        // 2. Panggil Service untuk ambil data matang
        $data = $statistikService->getLaporanData(
            $request->nip,
            $request->start_date,
            $request->end_date,
            $request->id_bidang
        );

        // 3. Cetak PDF
        $pdf = Pdf::loadView('app.laporan.pdf', [
            'data' => $data,
            'info' => $request->all() // Mengirim input filter untuk judul laporan
        ]);

        return $pdf->stream('laporan-karyawan.pdf');
    }
}
