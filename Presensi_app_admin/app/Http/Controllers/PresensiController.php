<?php
namespace App\Http\Controllers;

use App\Enums\Tipe_QR;
use App\Models\presensi;
use App\Models\QrToken;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use mysql_xdevapi\Exception;

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
            'status' => 'required|in:Hadir,Izin,Tidak Hadir',
        ]);

        $data = [
            'user_id' => $request->input('user_id'),
          'tanggal' => $request->input('tanggal'),
          'status' => $request->input('status'),
            'jam_masuk' => $request->input('jam_masuk'),
            'jam_pulang' => $request->input('jam_pulang'),
            'created_at' => now(),
            'Id_QR' => 1,
            'Longitude' => null,
            'Latitude' => null,
        ];
        Presensi::create($data);
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
            'Id_QR' => $request->input('Id_QR'),
            'user_id' => $request->input('user_id'),
            'tanggal' => $request->input('tanggal'),
            'status' => $request->input('status'),
            'jam_masuk' => $request->input('jam_masuk'),
            'jam_pulang' => $request->input('jam_pulang'),
            'Longitude' => $request->input('Longitude'),
            'Latitude' => $request->input('Latitude'),
        ];

        Presensi::where('id', $id)->update($data);
        return redirect('/');
    }

    public function destroy($id)
    {
        presensi::where('id', $id)->delete();
        return redirect('/');
    }

    public function storeViaQR(Request $request){
        $request ->validate([
           'qr_token' => 'required',
            'user_id' => 'required',
            'tanggal' => 'required|date',
            'status' => 'required|in:Hadir,Izin,Tidak Hadir',
            'jam_absen' => 'required',
            'Latitude' => 'required',
            'Longitude' => 'required',
        ]);

        $validasiToken =QrToken::where('token', $request->qr_token)
            ->where('Expired_at', '>=', Carbon::now()->toDateTimeString() )->first();

        if(!$validasiToken){
            return response()->json([
                'status' => 'error',
                'message' => 'QR Code sudah kadaluwarsa atau tidak valid. Silakan scan ulang QR terbaru.'
            ],500);
        }

        try {
            $tipeAbsen = '';
            if($validasiToken->Tipe_QR == Tipe_QR::QR_Pulang){
                $tipeAbsen = 'jam_pulang';

            }else if ($validasiToken->Tipe_QR == Tipe_QR::QR_Masuk){
                $tipeAbsen = 'jam_masuk';
            }
                presensi::create([
                    'Id_QR' => $validasiToken->Id_QR,
                    'user_id' => $request->user_id,
                    'tanggal' => $request->tanggal,
                    'status' => $request->status,
                    $tipeAbsen => $request->jam_absen,
                    'Longitude' => $request->Longitude,
                    'Latitude' => $request->Latitude,
                    'created_at' => now(),
                ]);
        }catch (Exception $e){

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan saat mencatat presensi. Silakan coba lagi.',
                'Error: ' => $e->getMessage()
            ],500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Presensi berhasil dicatat!'
        ],200);
    }
}
