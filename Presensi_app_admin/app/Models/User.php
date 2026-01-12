<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected function serializeDate(DateTimeInterface $date) // <--- 2. Tambahkan fungsi ini
    {
        return $date->format('Y-m-d H:i:s');
    }

    protected $primaryKey = 'user_id'; // mengubah default primary key dari id menjadi user_id
    protected $fillable = [
        'Nama_Pengguna',
        'email',
        'password',
        'NIP',
        'id_bidang',
        'updated_at',
        'Jabatan'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        //'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'Password' => 'hashed',
        ];
    }

    public function presensi(){
        return $this->hasMany(presensi::class, 'user_id', 'user_id');
    }

// Di Model User.php
    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'id_bidang', 'id_bidang');
    }
}
