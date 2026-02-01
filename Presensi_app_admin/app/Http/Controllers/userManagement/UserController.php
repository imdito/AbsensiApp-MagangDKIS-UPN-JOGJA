<?php

namespace App\Http\Controllers\userManagement;

use App\Http\Controllers\Controller;
use App\Models\Bidang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Mockery\Exception;

class UserController extends Controller
{
    public function index(){
        $daftar_divisi = Bidang::tenanted()->lazy();
        return $this->viewWithLayout('userManagement.tambahuser', ['daftar_divisi' => $daftar_divisi]);
    }

    public function store(Request $request){
        // Tentukan jabatan apa saja yang dilarang bagi user yang sedang login
        $restrictedRoles = '';
        if (auth()->user()->Jabatan !== 'superadmin') {
            $restrictedRoles = '|not_in:superadmin,admin';
        }

        $request->validate([
            'Nama_Pengguna' => 'required',
            'email'         => 'required|email|unique:users,email',
            'NIP'           => 'required|unique:users,NIP',
            'id_bidang'     => 'required|integer',
            'Jabatan'       => 'required|string' . $restrictedRoles,
            'password'      => 'nullable|min:6',
        ]);

        $data = [
            'Nama_Pengguna' => $request->input('Nama_Pengguna'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'NIP' => $request->input('NIP'),
            'Jabatan' => $request->input('Jabatan'),
            'id_bidang' => $request->input('id_bidang'),
        ];
        User::create($data);
        return redirect('/karyawan')->with('sukses','Data berhasil ditambahkan');
    }

    public function listUsers()
    {
        $karyawan = User::with('bidang')->tenanted()->lazy();
        return $this->viewWithLayout('userManagement.indexUser', ['karyawan' => $karyawan]);
    }

    public function update(Request $request, $id){
        // Tentukan jabatan apa saja yang dilarang bagi user yang sedang login
        $restrictedRoles = '';
        if (auth()->user()->Jabatan !== 'superadmin') {
            $restrictedRoles = '|not_in:superadmin,admin';
        }

        $request->validate([
            'Nama_Pengguna' => 'required',
            'email'         => 'required|email|unique:users,email,' . $id . ',user_id',
            'nip'           => 'required|unique:users,NIP,' . $id . ',user_id',
            'id_bidang'     => 'required|integer',
            'Jabatan'       => 'required|string' . $restrictedRoles,
            'password'      => 'nullable|min:6',
        ]);

        $data = [
            'Nama_Pengguna' => $request->input('Nama_Pengguna'),
            'email' => $request->input('email'),
            'NIP' => $request->input('nip'),
            'id_bidang' => $request->input('id_bidang'),
            'Jabatan' => $request->input('Jabatan'),
            'updated_at' => now()->toDateTimeString(),
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        User::where('user_id', $id)->update($data);
        return redirect('/karyawan')->with('sukses', 'Data berhasil diupdate');

    }


    public function updateApi(Request $request) {
        // 1. Pastikan validasi menggunakan user_id yang benar
        $request->validate([
            'Nama_Pengguna' => 'required',
            'email'         => 'required|email|unique:users,email,' . $request->user()->user_id . ',user_id',
            'password'      => 'nullable|min:6',
        ]);

        try {
            // 2. Cari user-nya
            $user = User::findOrFail($request->user()->user_id);

            // 3. Set data
            $user->Nama_Pengguna = $request->Nama_Pengguna;
            $user->email = $request->email;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            // 4. Simpan
            $user->save();

            return response()->json(['message' => 'Data berhasil diupdate'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id){
        $data = User::find($id);
        $data->delete();
        return redirect('/karyawan')->with('sukses', 'Data berhasil dihapus');
    }

    public function editPage($id){
        $user = User::tenanted()->findOrFail($id);
        $daftar_bidang = Bidang::tenanted()->lazy();
        return $this->viewWithLayout('userManagement.updateUser', ['user' => $user, 'daftar_divisi' => $daftar_bidang]);
    }

}
