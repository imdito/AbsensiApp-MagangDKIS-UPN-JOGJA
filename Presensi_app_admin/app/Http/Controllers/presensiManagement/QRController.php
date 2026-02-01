<?php

namespace App\Http\Controllers\presensiManagement;

use App\Http\Controllers\Controller;
use App\Models\QrToken;
use App\Models\Skpd;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class QRController extends Controller
{

    public function index(){

        $qrAktif = QrToken::where('Expired_at', '>', Carbon::now()->toDateTimeString())
                    ->where('id_skpd', auth()->user()->bidang->id_skpd)
                    ->orderBy('Created_at', 'desc')
                    ->first();

        if(auth()->user()->Jabatan == 'superadmin'){
            $skpd = skpd::lazy();
            return $this->viewWithLayout('app.buatQR', ['qrData' => $qrAktif, 'skpds' => $skpd]);
        }

        return $this->viewWithLayout('app.buatQR', ['qrData' => $qrAktif]);
    }

    public function generateQR(Request $request){
        $request->validate([
            'expired_at' => 'required|:after:now',
            'id_skpd' => auth()->user()->Jabatan === 'superadmin' ? 'required|exists:skpd,id' : 'nullable' ,
        ]);


        $expiredAt = Carbon::today()->setTimeFromTimeString($request->expired_at);
        $token = Str::random(32);
        $qr = QrToken::create([
            'token' => $token,
            'id_skpd' => $request->input('id_skpd') ?? auth()->user()->bidang->skpd->id,
            'Expired_at' => $expiredAt,
            'Created_at' => Carbon::now(),
            'Tanggal' => Carbon::now()->toDateString(),
        ]);
        $secondsToExpiry = Carbon::now()->diffInSeconds($request->expired_at);

        if ($secondsToExpiry > 0) {
            // SIMPAN KE REDIS
            Cache::put("active_qr:{$qr->token}_with_skpd:{$qr->id_skpd}",
                [
                    'Id_QR' => $qr->Id_QR,
                    'Expired_at' => $qr->Expired_at
                ],
                $secondsToExpiry);
        }
        return redirect()->route('presensi.QR')->with('success', 'QR Code berhasil dibuat!');
    }

    public function lihatQR(){

        $todayQR = Cache::remember("qr_with_skpd:" . auth()->user()->bidang->skpd->id, 3600, function () {
            return QrToken::whereDate('created_at', Carbon::today())
                ->where('id_skpd', auth()->user()->bidang->id_skpd)
                ->first();
        });

        return $this->viewWithLayout('frontliner.index', compact('todayQR'));
    }

}
