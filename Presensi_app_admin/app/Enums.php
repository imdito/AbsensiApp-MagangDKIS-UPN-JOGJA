<?php

namespace App\Enums;

enum PresensiStatus: string {
    case Hadir = 'Hadir';
    case Izin = 'Izin';
    case TidakHadir = 'Tidak Hadir';
}
