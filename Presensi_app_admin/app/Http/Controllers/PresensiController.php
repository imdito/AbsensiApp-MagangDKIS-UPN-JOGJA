<?php
namespace App\Http\Controllers;

use App\Enums\Tipe_QR;
use App\Models\Bidang;
use App\Models\presensi;
use App\Models\QrToken;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use mysql_xdevapi\Exception;

class PresensiController extends Controller{
    public function index()
    {
        $daftar_presensi = Presensi::with(['user.bidang'])->orderBy('tanggal', 'desc')->get();

        $rekap_divisi = Bidang::withCount([
            'users as total_anggota',
            'users as jumlah_hadir' => function($query) {
                $query->whereHas('presensi', function($q) {
                    $q->whereDate('tanggal', date('Y-m-d'))
                        ->whereIn('status', ['Hadir', 'Telat']);
                });
            }
        ])->get();
        return view('app.index', compact('daftar_presensi', 'rekap_divisi'));
    }

    public function create(){
        $users = User::lazy();
        $daftar_qr = QrToken::orderBy('Created_at', 'desc')->lazy();
        return view('app.create', compact('users', 'daftar_qr'));
    }

    public function store(Request $request){
        $request->validate([
            'tanggal' => 'required|date',
            'status' => 'required|in:Hadir,Izin,Tidak Hadir',
            'jam_masuk' => 'required',

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
        $presensi = presensi::find($id);
        $users = User::lazy();
        $daftar_qr = QrToken::orderBy('Created_at', 'desc')->lazy();
        return view('app.edit', compact('presensi', 'users', 'daftar_qr'));

    }

    public function update( Request $request, $id){
        $request->validate([
            'tanggal' => 'required|date',
            'status' => 'required|string',
            'jam_masuk' => 'required',
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

        $presensi = presensi::findorFail($id);
        $presensi->update($data);
        return redirect('/');
    }

    public function destroy($id)
    {
        $data = presensi::find($id);
        $data->delete();
        return redirect('/');
    }

    public function storeViaQR(Request $request){
        $request ->validate([
            'qr_token' => 'required',
            'user_id' => 'required',
            'Latitude' => 'required',
            'Longitude' => 'required',
        ]);

        $jam_absen = now()->toTimeString();
        $tepat_waktu = '14:30:00';
        $batas_absen = '15:00:00';

        $status = 'Hadir';
        if($jam_absen > $tepat_waktu && $jam_absen <= $batas_absen){
            $status = 'Telat';
        }else if($jam_absen > $batas_absen){
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

        try {
            presensi::create([
                'Id_QR' => $validasiToken->Id_QR,
                'user_id' => $request->user_id,
                'tanggal' => Carbon::now()->toDateString(),
                'status' => $status,
                'jam_masuk' => Carbon::now()->toDateTimeString(),
                'Longitude' => $request->Longitude,
                'Latitude' => $request->Latitude,
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
