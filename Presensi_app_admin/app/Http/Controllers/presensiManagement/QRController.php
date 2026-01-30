<?php

namespace App\Http\Controllers\presensiManagement;

use App\Http\Controllers\Controller;
use App\Models\QrToken;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QRController extends Controller
{

    public function index(){
        $qrAktif = QrToken::where('Expired_at', '>', Carbon::now()->toDateTimeString())
                    ->orderBy('Created_at', 'desc')
                    ->first();

        return $this->viewWithLayout('app.buatQR', ['qrData' => $qrAktif]);
    }

    public function generateQR(Request $request){
        $request->validate([
            'expired_at' => 'required|:after:now',
        ]);

        $token = Str::random(32);
        $qr = QrToken::create([
            'token' => $token,
            'Expired_at' => $request->input('expired_at'),
            'Created_at' => Carbon::now(),
            'Tanggal' => Carbon::now()->toDateString(),
        ]);

        return redirect()->route('presensi.QR')->with('success', 'QR Code berhasil dibuat!');
    }

    public function lihatQR(){
        $todayQR = QrToken::whereDate('created_at', Carbon::today())->first();

        return $this->viewWithLayout('frontliner.index', compact('todayQR'));
    }

}
