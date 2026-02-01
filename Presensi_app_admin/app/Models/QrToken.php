<?php

namespace App\Models;

use App\Enums\Tipe_QR;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QrToken extends Model
{
    use hasfactory, softDeletes;

    protected $table = 'qr';
    protected $primaryKey = 'Id_QR';
    public $timestamps = false;


    protected $casts = [
        'Tipe_QR' => Tipe_QR::class,
    ];

    protected $dates = ['deleted_at'];


    protected $fillable = [
        'token',
        'id_skpd',
        'Tanggal',
        'Created_at',
        'Expired_at'
    ];

    public function scopeTenanted($query)
    {
        $user = auth()->user();

        // Super Admin melihat semuanya
        if ($user->Jabatan === 'superadmin') {
            return $query;
        }

        $skpdIdAdmin = $user->bidang->id_skpd ?? null;

        if ($skpdIdAdmin) {
            // Filter: Hanya tampilkan bidang yang skpd_id nya SAMA dengan skpd admin
            return $query->where('id_skpd', $skpdIdAdmin);
        }

        // Kalau user error/gak punya data, kosongkan hasil
        return $query->where('id', 0);
    }
}
