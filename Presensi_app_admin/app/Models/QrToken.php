<?php

namespace App\Models;

use App\Enums\Tipe_QR;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QrToken extends Model
{
    use hasfactory, softDeletes;

    protected $table = 'qr';
    protected $primaryKey = 'Id_QR';
    public $timestamps = false;


    protected $casts = [
        'Tipe_QR' => Tipe_QR::class,
    ];

    protected $dates = ['deleted_at'];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            $model->created_id = auth()->id();
        });
        static::updating(function ($model) {
            $model->updated_id = auth()->id();
        });
        static::deleting(function ($model) {
            $model->deleted_id = auth()->id();
            $model->save();
        });
    }

    protected $fillable = [
        'token',
        'Tipe_QR',
        'Tanggal',
        'Created_at',
        'Expired_at'
    ];
}
