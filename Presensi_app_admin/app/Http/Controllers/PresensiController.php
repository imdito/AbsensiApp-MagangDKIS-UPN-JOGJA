<?php
namespace App\Http\Controllers;

use App\Models\presensi;
use App\Models\QrToken;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

    public function generateQR(){

        $token = Str::random(32);
        $qr = QrToken::create([
            'token' => $token,
            'expires_at' => Carbon::now()->addHours(24),
        ]);

        return view('app.buatQR', ['qrData' => $qr['token']]);
    }

    public function storeViaQR(Request $request){
        $request ->validate([
           'qr_token' => 'required',
            'user_id' => 'required',

        ]);

        $validasiToken =QrToken::where('token', $request->qr_token)
            ->where('expires_at', '>=', Carbon::now() )->first();

        if(!$validasiToken){
            return response()->json([
                'status' => 'error',
                'message' => 'QR Code sudah kadaluwarsa atau tidak valid. Silakan scan ulang QR terbaru.'
            ]);
        }
        presensi::create([
           'user_id' => $request->user_id,
            'tanggal' => $request->tanggal,
            'status' => $request->status,
            'jam_masuk' => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang,
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Presensi berhasil dicatat!'
        ],200);
    }
}
