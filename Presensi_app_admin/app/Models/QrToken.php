<?php

namespace App\Models;

use App\Enums\Tipe_QR;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrToken extends Model
{
    use hasfactory;

    protected $table = 'qr';
    protected $primaryKey = 'Id_QR';
    public $timestamps = false;


    protected $casts = [
        'Tipe_QR' => Tipe_QR::class,
    ];

    protected $fillable = [
        'token',
        'Tipe_QR',
        'Tanggal',
        'Created_at',
        'Expired_at'
    ];
}
