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

        $jam_absen = now()->format('H:i:s');
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
            $tipeAbsen = '';
            if($validasiToken->Tipe_QR == Tipe_QR::QR_Pulang){
                $tipeAbsen = 'jam_pulang';

            }else if ($validasiToken->Tipe_QR == Tipe_QR::QR_Masuk){
                $tipeAbsen = 'jam_masuk';
            }
                presensi::create([
                    'Id_QR' => $validasiToken->Id_QR,
                    'user_id' => $request->user_id,
                    'tanggal' => Carbon::now()->toDateString(),
                    'status' => $status,
                    $tipeAbsen => Carbon::now()->toDateTimeString(),
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
