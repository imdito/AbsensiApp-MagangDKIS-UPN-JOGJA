<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{

    protected $table = 'divisi';
    protected $primaryKey = 'Id_Divisi';
    protected $fillable = [
        'Nama_Divisi',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'Id_Divisi', 'Id_Divisi');
    }

}
