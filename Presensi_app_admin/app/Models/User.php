<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, softDeletes;

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

    public function presensi(){
        return $this->hasMany(Presensi::class, 'user_id', 'user_id');
    }

    public function getSkpdIdAttribute()
    {
        // Cek dulu user punya bidang atau tidak (takutnya super admin NULL)
        return $this->bidang ? $this->bidang->id_skpd : null;
    }

// Di Model User.php
    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'id_bidang', 'id_bidang');
    }

    public function creator()
    {
        // Relasi ke siapa yang membuat data
        return $this->belongsTo(User::class, 'created_id')->withTrashed();
    }

    public function updater()
    {
        // Relasi ke siapa yang terakhir mengubah data
        return $this->belongsTo(User::class, 'updated_id')->withTrashed();
    }

    public function destroyer()
    {
        // Relasi ke siapa yang menghapus data
        return $this->belongsTo(User::class, 'deleted_id')->withTrashed();
    }



    public function scopeTenanted(Builder $query)
    {
        $user = auth()->user();

        if ($user->role === 'super_admin') {
            return $query;
        }

        $skpdIdAdmin = $user->bidang->id_skpd ?? null;

        if ($skpdIdAdmin) {
            return $query->whereHas('bidang', function($q) use ($skpdIdAdmin) {
                $q->where('id_skpd', $skpdIdAdmin);
            });
        }

        return $query->where('id', 0);
    }

}
