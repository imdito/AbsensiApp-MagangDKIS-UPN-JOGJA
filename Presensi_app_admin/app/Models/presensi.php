<?php

namespace App\Models;

use App\Enums\Enums;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class presensi extends Model
{
    use hasfactory;
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
      'created_at'
    ];

    public function User(){
        return $this->belongsTo(User::class, 'user_id','user_id'); // menambah foreignkey pada table presensi
    }
}
