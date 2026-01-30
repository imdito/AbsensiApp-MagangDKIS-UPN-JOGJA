<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\Skpd;
use Illuminate\Http\Request;


class BidangController extends Controller
{

    public function index()
    {
        $bidang = Bidang::orderBy('nama_bidang', 'asc')->tenanted()->lazy();
        return $this->viewWithLayout('manajemenBidang.index', compact('bidang', ));
    }

    // 2. FORM TAMBAH (CREATE)
    public function create()
    {

        if(auth()->user()->Jabatan === 'superadmin'){
            $daftar_skpd = Skpd::lazy();
        }else{
            $daftar_skpd = Skpd::where('id_skpd', auth()->user()->bidang->id_skpd)->lazy();
        }

        return $this->viewWithLayout('manajemenBidang.create', compact('daftar_skpd'));
    }

    // 3. PROSES SIMPAN (STORE)
    public function store(Request $request)
    {

        $request->validate([
            'kode_bidang' => 'required|unique:bidang,kode_bidang',
            'nama_bidang' => 'required|max:50',
            'id_skpd'    => auth()->user()->Jabatan !== 'superadmin'?'nullable':'required|integer',
        ]);

        $data = [
            'kode_bidang' => $request->input('kode_bidang'),
            'nama_bidang' => $request->input('nama_bidang'),
            'id_skpd'    => auth()->user()->Jabatan !== 'superadmin' ? auth()->user()->bidang->id_skpd : $request->input('id_skpd'),
        ];
        Bidang::create($data);

        return redirect()->route('bidang.index')->with('success', 'Data Berhasil Disimpan');
    }

    // 4. FORM EDIT (EDIT)
    public function edit($id)
    {
        $bidang = Bidang::tenanted()->findOrFail($id);
        $daftar_skpd = Skpd::lazy();
        return $this->viewWithLayout('manajemenBidang.edit', compact('bidang', 'daftar_skpd'));
    }

    // 5. PROSES UPDATE (UPDATE)
    public function update(Request $request, $id)
    {
        $request->validate([
           'nama_bidang' => 'required|max:50',
              'kode_bidang' => 'required|max:10|unique:bidang,kode_bidang,' . $id . ',id_bidang',
            'id_skpd'    => auth()->user()->jabatan !== 'superadmin' ? 'nullable' : 'required' |'integer',
        ]);

        $data = [
            'id_bidang' => $id,
            'kode_bidang' => $request->input('kode_bidang'),
            'nama_bidang' => $request->input('nama_bidang'),
            'id_skpd'    => auth()->user()->Jabatan !== 'superadmin' ? auth()->user()->bidang->id_skpd : $request->input('id_skpd'),
        ];

        $bidang = Bidang::tenanted()->findOrFail($id);
        $bidang->update($data);

        return redirect()->route('bidang.index')->with('success', 'Data Berhasil Diupdate');
    }

    // 6. HAPUS DATA (DELETE)
    public function destroy($id)
    {
        $bidang = Bidang::tenanted()->findOrFail($id);
        $bidang->delete();

        return redirect()->route('bidang.index')->with('success', 'Data Berhasil Dihapus');
    }




}
