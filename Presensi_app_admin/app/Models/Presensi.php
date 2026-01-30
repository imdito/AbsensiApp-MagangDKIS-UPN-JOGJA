<?php

namespace App\Models;

use App\Enums\Enums;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Presensi extends Model
{
    use hasfactory, softDeletes;
    protected $table = 'presensi';
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
        'created_id',
        'updated_id',
        'deleted_id',
    ];

    protected $dates = ['deleted_at'];


    public function User(){
        return $this->belongsTo(User::class, 'user_id','user_id'); // menambah foreignkey pada table presensi
    }


    public function scopeTenanted(Builder $query)
    {
        $user = auth()->user();

        if ($user->role === 'super_admin') {
            return $query;
        }

        $skpdIdAdmin = $user->bidang->id_skpd ?? null;

        if ($skpdIdAdmin) {
            return $query->whereHas('user.bidang', function($q) use ($skpdIdAdmin) {
                $q->where('id_skpd', $skpdIdAdmin);
            });
        }

        return $query->where('id', 0);
    }

}
