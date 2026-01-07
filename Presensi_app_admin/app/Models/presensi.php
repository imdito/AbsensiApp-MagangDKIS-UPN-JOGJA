<?php

namespace App\Models;

use App\Enums\PresensiStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class presensi extends Model
{
    use hasfactory;
    protected $table = 'presensi';
    public $timestamps = false;
    protected $attributes = [
        'jam_masuk' => '00:00:00',
        'jam_pulang' => '00:00:00',
    ];

    protected $casts = [
        'status' => PresensiStatus::class,
    ];
    protected $fillable = [
      'user_id',
        'id_QR',
        'status',
      'tanggal',
      'jam_masuk',
        'jam_pulang',
        'longitude',
        'latitude',
      'created_at'
    ];

    public function User(){
        return $this->belongsTo(User::class, 'user_id','user_id'); // menambah foreignkey pada table presensi
    }
}
