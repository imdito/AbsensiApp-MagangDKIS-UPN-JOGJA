<?php

namespace App\Http\Controllers;

use App\Models\presensi;

class LogsController extends Controller
{
    public function presensi()
    {
        $logs = presensi::withTrashed()
            ->with(['user', 'creator', 'updater', 'destroyer'])
            ->latest()
            ->get();

        return view('app.logs', compact('logs'));
    }
}
