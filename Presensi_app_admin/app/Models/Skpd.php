<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skpd extends Model
{

    use softDeletes;

    protected $table = 'skpd';
    protected $fillable = [
        'nama',
        'kode',
        'alamat',
        'Longitude',
        'Latitude',
        ];

    public function bidang()
    {
        return $this->hasMany(Bidang::class, 'id_skpd');
    }


}
