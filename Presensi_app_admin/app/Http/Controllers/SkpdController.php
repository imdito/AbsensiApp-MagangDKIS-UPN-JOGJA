<?php

namespace App\Http\Controllers;

use App\Models\Skpd;
use Illuminate\Http\Request;

class SkpdController extends Controller
{
    // Tampilkan List SKPD
    public function index()
    {
        $skpds = Skpd::latest()->paginate(10); // 10 data per halaman
        return view('superAdmin.skpdManagement.index', compact('skpds'));
    }

    // Tampilkan Form Tambah
    public function create()
    {
        return view('superAdmin.skpdManagement.create');
    }

    // Proses Simpan Data Baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_skpd' => 'required|unique:skpds,nama_skpd|max:255',
            'alamat'    => 'required|string',
            'longitude'  => 'required',
            'latitude'   => 'required',
        ]);

        $data = [
            'nama' => $request->input('nama_skpd'),
            'alamat' => $request->input('alamat'),
            'Longitude' => $request->input('longitude'),
            'Latitude' => $request->input('latitude'),
        ];

        Skpd::create($data);

        return redirect()->route('skpd.index')->with('success', 'SKPD berhasil ditambahkan!');
    }

    // Tampilkan Form Edit
    public function edit(Skpd $skpd)
    {
        return view('superAdmin.skpdManagement.edit', compact('skpd'));
    }

    // Proses Update Data
    public function update(Request $request, Skpd $skpd)
    {
        $request->validate([
            'nama' => 'required|unique:skpd,nama,' . $skpd->id . ',id',
            'alamat'    => 'required|string',
            'longitude'  => 'required',
            'latitude'   => 'required',
        ]);

        $data = [
            'nama' => $request->input('nama'),
            'alamat' => $request->input('alamat'),
            'Longitude' => $request->input('longitude'),
            'Latitude' => $request->input('latitude'),
        ];
        $skpd->update($data);

        return redirect()->route('skpd.index')->with('success', 'Data SKPD diperbarui!');
    }

    // Hapus Data
    public function destroy(Skpd $skpd)
    {
        // Opsional: Cek dulu apakah ada bidang/user yang terkait sebelum hapus
        // if($skpd->bidang()->count() > 0) { return back()->with('error', 'Gagal! SKPD ini masih memiliki Bidang.'); }

        $skpd->delete();
        return redirect()->route('skpd.index')->with('success', 'SKPD berhasil dihapus.');
    }
}
