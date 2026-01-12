<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
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

    // Relasi ke User (Satu bidang punya banyak user)
    public function users()
    {
        return $this->hasMany(User::class, 'id_bidang', 'id_bidang');
    }
}
