<?php

namespace App\Http\Controllers\userManagement;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        $daftar_divisi = Bidang::tenanted()->lazy();
        return view('userManagement.tambahuser', ['daftar_divisi' => $daftar_divisi]);
    }

    public function store(Request $request){
        $request->validate([
            'Nama_Pengguna' => 'required',
            'email' => 'required',
            'password' => 'required',
            'NIP' => 'required',
            'id_bidang' => 'required',
        ]);

        $data = [
            'Nama_Pengguna' => $request->input('Nama_Pengguna'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'NIP' => $request->input('NIP'),
            'id_bidang' => $request->input('id_bidang'),
        ];
        User::create($data);
        return redirect('/karyawan')->with('sukses','Data berhasil ditambahkan');
    }

    public function listUsers()
    {
        $karyawan = User::with('bidang')->tenanted()->lazy();
        return view('userManagement.indexUser', ['karyawan' => $karyawan]);
    }

    public function update(Request $request, $id){
        $request->validate([
            'Nama_Pengguna' => 'required',
            'email' => 'required',
            'nip' => 'required',
            'id_bidang' => 'required',
            'password'  => 'nullable',
        ]);

        $data = [
            'Nama_Pengguna' => $request->input('Nama_Pengguna'),
            'email' => $request->input('email'),
            'NIP' => $request->input('nip'),
            'id_bidang' => $request->input('id_bidang'),
            'updated_at' => now()->toDateTimeString(),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        User::where('user_id', $id)->update($data);
        return redirect('/karyawan')->with('sukses', 'Data berhasil diupdate');

    }

    public function destroy($id){
        $data = User::find($id);
        $data->delete();
        return redirect('/karyawan')->with('sukses', 'Data berhasil dihapus');
    }

    public function editPage($id){
        $user = User::tenanted()->findOrFail($id);
        $daftar_bidang = Bidang::tenanted()->lazy();
        return view('userManagement.updateUser', ['user' => $user, 'daftar_divisi' => $daftar_bidang]);
    }

}
