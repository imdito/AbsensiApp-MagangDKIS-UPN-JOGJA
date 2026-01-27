<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\Presensi;
use App\Models\QrToken;
use App\Models\User;

class LogsController extends Controller
{
    public function presensi()
    {
        $logs = Presensi::tenanted()->withTrashed()
            ->with(['user', 'creator', 'updater', 'destroyer'])
            ->latest()
            ->paginate(8);

        return view('app.logs', compact('logs'));
    }

    public function pegawai()
    {
        $logs = User::tenanted()->withTrashed()
            ->with(['creator', 'updater', 'destroyer'])
            ->latest()
            ->paginate(10);

        return view('userManagement.logs', compact('logs'));
    }

    public function bidang()
    {
        $logs = Bidang::tenanted()->withTrashed()
            ->with(['creator', 'updater', 'destroyer'])
            ->latest()
            ->paginate(4);

        return view('manajemenBidang.logs', compact('logs'));
    }

    public function QrToken()
    {
        $logs = QrToken::withTrashed()
            ->with(['creator', 'updater', 'destroyer'])
            ->latest()
            ->get();
    }

}
