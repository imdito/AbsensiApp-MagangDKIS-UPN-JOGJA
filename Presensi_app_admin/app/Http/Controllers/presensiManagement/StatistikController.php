<?php

namespace App\Http\Controllers\presensiManagement;

use App\Http\Controllers\Controller;
use App\Http\Services\StatistikServices;
use App\Models\Bidang;
use App\Models\Presensi;
use App\Models\Skpd;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatistikController extends Controller
{
    public function index()
    {
        $daftar_presensi = Presensi::tenanted()->with(['user.bidang'])->orderBy('tanggal', 'desc')->get();

        $rekap_divisi = Bidang::tenanted()->withCount([
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

    public function superAdmin()
    {
        $data = [
            'total_skpd'    => Skpd::count(),
            'total_bidang'  => Bidang::count(),
            'total_admin'   => User::where('Jabatan', 'admin')->count(),
            'total_pegawai' => User::count(),

            // Grafik: Jumlah Bidang per SKPD
            'chart_skpd'    => Bidang::selectRaw('id_skpd, COUNT(*) as total_bidang')
                                    ->groupBy('id_skpd')
                                    ->with('skpd')
                                    ->get(),

            'recent_skpds'  => Skpd::latest()->take(5)->get(),
        ];

        return view('superAdmin.index', $data);
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
        $data_presensi = Presensi::where('user_id', $id)
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
