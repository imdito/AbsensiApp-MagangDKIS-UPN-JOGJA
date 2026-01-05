<?php

namespace App\Http\Controllers\userManagement;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){

        return view('userManagement.tambahuser');
    }

    public function store(Request $request){
        $request->validate([
            'nama' => 'required',
            'email' => 'required',
            'password' => 'required',
            'nip' => 'required',
            'divisi' => 'required',

        ]);

        $data = [
            'nama' => $request->input('nama'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'nip' => $request->input('nip'),
            'divisi' => $request->input('divisi'),
        ];
        User::create($data);
        return redirect('/karyawan')->with('sukses','Data berhasil ditambahkan');
    }

    public function listUsers()
    {
        $karyawan = User::all();
        return view('userManagement.indexUser', ['karyawan' => $karyawan]);
    }

    public function update(Request $request, $id){
        $request->validate([
            'nama' => 'required',
            'email' => 'required',
            'password' => 'required',
            'nip' => 'required',
            'divisi' => 'required',
        ]);

        $data = [
            'nama' => $request->input('nama'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'nip' => $request->input('nip'),
            'divisi' => $request->input('divisi'),
        ];
        User::where('user_id', $id)->update($data);
        return redirect('/karyawan')->with('sukses', 'Data berhasil diupdate');

    }

    public function destroy($id){
        User::where('user_id', $id)->delete();
        return redirect('/karyawan')->with('sukses', 'Data berhasil dihapus');
    }

    public function editPage($id){
        $user = User::find($id);
        return view('userManagement.updateUser', ['user' => $user]);
    }

}
