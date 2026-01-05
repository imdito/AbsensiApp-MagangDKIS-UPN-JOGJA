<?php

namespace App\Models;

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
    protected $fillable = [
      'user_id',
      'tanggal',
      'jam_masuk',
        'jam_pulang',
      'status',
      'created_at'
    ];

    public function User(){
        return $this->belongsTo(User::class, 'user_id','user_id'); // menambah foreignkey pada table presensi
    }
}
