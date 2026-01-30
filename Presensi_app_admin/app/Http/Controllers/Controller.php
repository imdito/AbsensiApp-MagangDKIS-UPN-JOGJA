<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;

abstract class Controller
{
    // Fungsi ini akan otomatis menyiapkan layout dan merender view
    protected function viewWithLayout($viewPath, $data = [])
    {
        // Penentuan layout tetap di sini (Pusat)
        $layout = (auth()->user()->Jabatan == 'superadmin')
            ? 'layouts.admin'
            : 'layouts.app';

        // Gabungkan data compact kamu dengan variabel layout
        $data['layout'] = $layout;

        return view($viewPath, $data);
    }
}
