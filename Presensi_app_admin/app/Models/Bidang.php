<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bidang extends Model
{

    use softDeletes;
    // Beritahu Laravel nama tabel barunya
    protected $table = 'bidang';

    // Beritahu nama primary key barunya
    protected $primaryKey = 'id_bidang';

    // Jika tidak menggunakan created_at/updated_at default Laravel
    public $timestamps = false;

    protected $fillable = [
        'kode_bidang',
        'nama_bidang',
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

    // Relasi ke User (Satu bidang punya banyak user)
    public function users()
    {
        return $this->hasMany(User::class, 'id_bidang', 'id_bidang');
    }
}
