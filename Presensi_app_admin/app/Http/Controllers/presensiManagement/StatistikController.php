<?php

namespace App\Http\Controllers\presensiManagement;

use App\Http\Controllers\Controller;
use App\Http\Services\StatistikServices;
use App\Models\Bidang;
use App\Models\presensi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatistikController extends Controller
{
    public function index()
    {
        $daftar_presensi = Presensi::with(['user.bidang'])->orderBy('tanggal', 'desc')->get();

        $rekap_divisi = Bidang::withCount([
            'users as total_anggota',
            'users as jumlah_hadir' => function($query) {
                $query->whereHas('presensi', function($q) {
                    $q->whereDate('tanggal', date('Y-m-d'))
                        ->whereIn('status', ['Hadir', 'Telat']);
                });
            }
        ])->get();
        return view('app.index', compact('daftar_presensi', 'rekap_divisi'));
    }

    public function statistik(Request $request, $id, StatistikServices $service)
    {
        $request->validate([
            'tanggal' => 'nullable|date',
        ]);

        $hariIni = $request->tanggal ? Carbon::parse($request->tanggal) : Carbon::today();
        $bidang = Bidang::findOrFail($id);
        $data = $service->getStatistikHarian($id, $hariIni);

        $karyawan      = $data['karyawan'];
        $total_pegawai = $data['statistik']['total_pegawai'];
        $hadir         = $data['statistik']['hadir'];
        $telat         = $data['statistik']['telat'];
        $izin          = $data['statistik']['izin'];
        $belum_hadir   = $data['statistik']['belum_hadir'];

        return view('app.statistik.index', compact(
            'bidang', 'karyawan', 'hariIni',
            'total_pegawai', 'hadir', 'telat', 'izin', 'belum_hadir'
        ));
    }

    public function riwayatPresensi($id){
        $data_presensi = presensi::where('user_id', $id)
            ->orderBy('tanggal', 'desc')
            ->get();

        if($data_presensi->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data presensi tidak ditemukan untuk pengguna ini.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $data_presensi
        ]);
    }


}
