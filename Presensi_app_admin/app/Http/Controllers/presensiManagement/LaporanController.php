<?php

namespace App\Http\Controllers\presensiManagement;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Models\Skpd;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Services\StatistikServices;
use Illuminate\Support\Facades\Cache;

// Import Service

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
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
            'nip'        => 'nullable|string',
            'id_bidang'  => 'nullable|integer',
        ]);

        $cacheKey = 'laporan_' . md5(serialize($request->only(['start_date', 'end_date', 'nip', 'id_bidang'])));

        $data = Cache::remember($cacheKey, 3600, function () use ($statistikService, $request) {
            return $statistikService->getLaporanData(
                $request->nip,
                $request->start_date,
                $request->end_date,
                $request->id_bidang
            );
        });

        $skpd = skpd::where('id', auth()->user()->bidang->id_skpd)->first();
        if(!$skpd){
            $skpd->nama = "Kota Cirebon";
            $skpd->alamat = "Jawa Barat, Kota Cirebon";
        }
        $pdf = Pdf::loadView('app.laporan.pdf', [
            'data' => $data,
            'info' => $request->all(),
            'skpd' => $skpd,
        ]);

        return $pdf->stream('laporan-karyawan.pdf');
    }
}
