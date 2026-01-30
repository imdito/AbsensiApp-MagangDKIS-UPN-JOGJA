<?php
namespace App\Http\Controllers;

use App\Http\Services\LocationService;
use App\Models\Presensi;
use App\Models\QrToken;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class PresensiController extends Controller{

    public function create(){
        $users = User::lazy();
        $daftar_qr = QrToken::orderBy('Created_at', 'desc')->lazy();
        return $this->viewWithLayout('app.create', compact('users', 'daftar_qr'));
    }

    public function store(Request $request){
        $request->validate([
            'user_id' => 'required',
            'tanggal' => 'required|date',
            'status' => 'required|in:Hadir,Izin,Tidak Hadir',
            'jam_masuk' => 'required',
            'Id_QR' => 'required',
        ]);

        $data = [
            'user_id' => $request->input('user_id'),
          'tanggal' => $request->input('tanggal'),
          'status' => $request->input('status'),
            'jam_masuk' => $request->input('jam_masuk'),
            'jam_pulang' => $request->input('jam_pulang'),
            'Id_QR' => $request->input('Id_QR'),
            'Longitude' => null,
            'Latitude' => null,
        ];
        Presensi::create($data);
        return redirect('/');
    }

    public function edit($id){
        $presensi = Presensi::tenanted()->find($id);
        $users = User::tenanted()->lazy();
        $daftar_qr = QrToken::orderBy('Created_at', 'desc')->lazy();
        return $this->viewWithLayout('app.edit', compact('presensi', 'users', 'daftar_qr'));

    }

    public function update( Request $request, $id){
        $request->validate([
            'user_id' => 'required',
            'tanggal' => 'required|date',
            'status' => 'required|string',
            'jam_masuk' => 'required',
            'Id_QR' => 'required',
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

        $presensi = Presensi::tenanted()->findorFail($id);
        $presensi->update($data);
        return redirect('/');
    }

    public function storeViaQR(Request $request, LocationService $locationService){
        $request ->validate([
            'qr_token' => 'required',
            'user_id' => 'required',
            'Latitude' => 'required',
            'Longitude' => 'required',
        ]);

        $jam_absen = now()->toTimeString();
        $tepat_waktu = '14:30:00';
        $batas_absen = '16:00:00';

        $status = 'Hadir';
        if($jam_absen > $tepat_waktu && $jam_absen <= $batas_absen){
            $status = 'Izin';
        }elseif($jam_absen > $batas_absen){
            $status = 'Tidak Hadir';
            return response()->json([
                'status' => 'error',
                'message' => 'Anda terlambat melebihi batas absen. Silakan hubungi admin.'
            ], 500);
        }

        $validasiToken =QrToken::where('token', $request->qr_token)
            ->where('Expired_at', '>=', Carbon::now()->toDateTimeString() )->first();

        if(!$validasiToken){
            return response()->json([
                'status' => 'error',
                'message' => 'QR Code sudah kadaluwarsa atau tidak valid. Silakan scan ulang QR terbaru.'
            ],500);
        }

        $isDuplicate = Presensi::where('user_id', $request->user_id)
            ->where('Id_QR', $validasiToken->Id_QR)
            ->exists();

        if ($isDuplicate) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda sudah melakukan presensi untuk sesi ini!',
            ], 422);
        }

        try {
            if($locationService->isWithinRadius($request->Latitude, $request->Longitude, $request->user_id )){
                Presensi::create([
                    'Id_QR' => $validasiToken->Id_QR,
                    'user_id' => $request->user_id,
                    'tanggal' => Carbon::now()->toDateString(),
                    'status' => $status,
                    'jam_masuk' => Carbon::now()->toDateTimeString(),
                    'Longitude' => $request->Longitude,
                    'Latitude' => $request->Latitude,
                ]);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Lokasi Anda berada di luar area yang diizinkan untuk presensi. Silakan coba lagi dari lokasi yang sesuai.'
                ],500);
            }
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
