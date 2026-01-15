<?php

namespace App\Models;

use App\Enums\Enums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class presensi extends Model
{
    use hasfactory, softDeletes;
    protected $table = 'presensi';
    public $timestamps = false;

    protected $casts = [
        'status' => Enums::class,
    ];
    protected $fillable = [
      'user_id',
        'Id_QR',
        'status',
      'tanggal',
      'jam_masuk',
        'jam_pulang',
        'Longitude',
        'Latitude',
      'created_at',
        'created_id',
        'updated_id',
        'deleted_id',
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

    public function User(){
        return $this->belongsTo(User::class, 'user_id','user_id'); // menambah foreignkey pada table presensi
    }
}
