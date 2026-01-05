<?php
namespace App\Http\Controllers;

use App\Models\presensi;
use App\Models\User;
use Illuminate\Http\Request;

class PresensiController extends Controller{
    public function index(){

    // Mengambil semua data presensi DAN data user pemiliknya
    // Pastikan nama relasi di Model Presensi adalah 'user'
    $data_presensi = presensi::with('user')->orderBy('id', 'desc')->get();

    return view('app.index',
        [
            'daftar_presensi' => $data_presensi
        ]);
    }

    public function create(){
        $users = User::all();
        return view('app.create', ['users' => $users]);
    }

    public function store(Request $request){
        $request->validate([
            'tanggal' => 'required|date',
            'status' => 'required|string',
        ]);

        $data = [
            'user_id' => $request->input('user_id'),
          'tanggal' => $request->input('tanggal'),
          'status' => $request->input('status'),
            'jam_masuk' => $request->input('jam_masuk'),
            'jam_pulang' => $request->input('jam_pulang'),
            'created_at' => now(),
        ];
        presensi::create($data);
        return redirect('/');
    }

    public function edit($id){
        $data_presensi = presensi::find($id);
        $users = User::all();
        return view('app.edit', ['presensi' => $data_presensi, 'users' => $users]);

    }

    public function update( Request $request, $id){
        $request->validate([
            'tanggal' => 'required|date',
            'status' => 'required|string',
        ]);

        $data = [
            'user_id' => $request->input('user_id'),
            'tanggal' => $request->input('tanggal'),
            'status' => $request->input('status'),
            'jam_masuk' => $request->input('jam_masuk'),
            'jam_pulang' => $request->input('jam_pulang'),
        ];

        Presensi::where('id', $id)->update($data);
        return redirect('/');
    }

    public function destroy($id)
    {
        presensi::where('id', $id)->delete();
        return redirect('/');
    }
}
