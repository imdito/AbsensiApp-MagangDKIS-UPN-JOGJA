<?php

namespace App\Http\Controllers\presensiManagement;

use App\Http\Controllers\Controller;
use App\Models\QrToken;
use Carbon\Carbon;
use Illuminate\Support\Str;

class QRController extends Controller
{
    public function generateQR(){
        $qrAktif = QrToken::where('Expired_at', '>', Carbon::now()->toDateTimeString())
                    ->orderBy('Created_at', 'desc')
                    ->first();

        if ($qrAktif) {
            return view('app.buatQR', ['qrData' => $qrAktif]);
        }

        $token = Str::random(32);
        $qr = QrToken::create([
            'token' => $token,
            'Expired_at' => Carbon::now()->addHours(12)->toDateTimeString(),
            'Created_at' => Carbon::now(),
            'Tanggal' => Carbon::now()->toDateString(),
        ]);

        return view('app.buatQR', ['qrData' => $qr]);
    }

    public function lihatQR(){
        $todayQR = QrToken::whereDate('created_at', Carbon::today())->first();

        return view('frontliner.index', compact('todayQR'));
    }

}
