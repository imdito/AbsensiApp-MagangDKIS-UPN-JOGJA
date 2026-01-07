<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrToken extends Model
{
    use hasfactory;

    protected $table = 'qr';
    protected $primaryKey = 'id_QR';

    protected $fillable = [
        'token',
        'Tipe_QR',
        'Tanggal',
        'Created_at',
        'Expired_at'
    ];
}
