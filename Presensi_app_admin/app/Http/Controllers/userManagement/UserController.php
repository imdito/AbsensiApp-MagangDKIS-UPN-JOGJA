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
        return redirect('/')->with('sukses','Data berhasil ditambahkan');
    }

}
