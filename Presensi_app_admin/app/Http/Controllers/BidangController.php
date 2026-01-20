<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BidangController extends Controller
{
    // 1. TAMPILKAN DATA (READ)
    public function index()
    {
        $bidang = Bidang::orderBy('nama_bidang', 'asc')->get();
        return view('manajemenBidang.index', compact('bidang'));
    }

    // 2. FORM TAMBAH (CREATE)
    public function create()
    {
        return view('manajemenBidang.create');
    }

    // 3. PROSES SIMPAN (STORE)
    public function store(Request $request)
    {
        $request->validate([
            'kode_bidang' => 'required|unique:bidang,kode_bidang|max:10',
            'nama_bidang' => 'required|max:50',
        ]);

        Bidang::create($request->all());

        return redirect()->route('bidang.index')->with('success', 'Data Berhasil Disimpan');
    }

    // 4. FORM EDIT (EDIT)
    public function edit($id)
    {
        $bidang = Bidang::findOrFail($id);
        return view('manajemenBidang.edit', compact('bidang'));
    }

    // 5. PROSES UPDATE (UPDATE)
    public function update(Request $request, $id)
    {
        $request->validate([
           'nama_bidang' => 'required|max:50',
              'kode_bidang' => 'required|max:10|unique:bidang,kode_bidang,'.$id.',id_bidang',
        ]);

        $data = [
            'id_bidang' => $id,
            'kode_bidang' => $request->input('kode_bidang'),
            'nama_bidang' => $request->input('nama_bidang'),
        ];

        $bidang = Bidang::findOrFail($id);
        $bidang->update($data);

        return redirect()->route('bidang.index')->with('success', 'Data Berhasil Diupdate');
    }

    // 6. HAPUS DATA (DELETE)
    public function destroy($id)
    {
        $bidang = Bidang::findOrFail($id);
        $bidang->delete();

        return redirect()->route('bidang.index')->with('success', 'Data Berhasil Dihapus');
    }

    public function statistik($id){
        // 1. Ambil Data Bidang
        $bidang = Bidang::findOrFail($id);

        $hariIni = Carbon::today();

        // 2. Ambil Daftar Pegawai di Bidang ini + Status Presensi Hari Ini
        $karyawan = User::where('id_bidang', $id)
            ->with(['presensi' => function($q) use ($hariIni) {
                // Kita hanya butuh data presensi HARI INI
                $q->whereDate('tanggal', $hariIni);
            }])
            ->orderBy('Nama_Pengguna', 'asc')
            ->get();

        // 3. Hitung Statistik Sederhana untuk Bidang Ini
        $total_pegawai = $karyawan->count();
        $hadir = 0;
        $telat = 0;
        $izin  = 0;

        foreach($karyawan as $k) {
            $p = $k->presensi->first(); // Data presensi hari ini (jika ada)

            if($p) {
                if($p->status->value == 'Hadir') $hadir++;
                if($p->status->value == 'Izin' || $p->status == 'Sakit') $izin++;
                if($p->status->value == 'Telat') $telat++;
            }
        }

        $belum_hadir = $total_pegawai - ($hadir + $izin);

        // 4. Kirim ke View
        return view('app.statistik.index', compact(
            'bidang', 'karyawan', 'hariIni',
            'total_pegawai', 'hadir', 'telat', 'izin', 'belum_hadir'
        ));
    }


}
