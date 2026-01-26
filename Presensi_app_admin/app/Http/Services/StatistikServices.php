<?php

namespace App\Http\Services;

use App\Enums\Enums;
use App\Models\User;
use App\Models\presensi;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

class StatistikServices{
    public function getLaporanData(?string $nip, ?string $startDate, ?string $endDate, ?string $idBidang): Collection
    {
        // 1. Cek User jika NIP diisi
        $user = null;
        if ($nip) {
            $user = User::where('NIP', $nip)->first();

            // Jika NIP diisi tapi User tidak ketemu, kembalikan collection kosong
            if (!$user) {
                return collect([]);
            }
        }

        // 2. Base Query
        $query = presensi::query();

        if ($user) {
            $query->where('user_id', $user->user_id);
        }elseif ($idBidang) {
            $query->whereHas('user', function($q) use ($idBidang) {
                $q->where('id_bidang', $idBidang);
            });
        }

        // 3. Filter Tanggal Query
        if ($startDate && $endDate) {
            $query->whereBetween('tanggal', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->where('tanggal', '>=', $startDate);
        }

        // 4. Logic Data (Looping CarbonPeriod)
        if ($user && $startDate && $endDate) {

            // Ambil data DB & key by tanggal agar mudah dicari
            $dbData = $query->get()->keyBy(function($item) {
                return $item->tanggal; // Pastikan format di DB Y-m-d, atau gunakan carbon format
            });

            $period = CarbonPeriod::create($startDate, $endDate);
            $finalData = collect();

            foreach ($period as $date) {
                $dateStr = $date->format('Y-m-d');

                if ($dbData->has($dateStr)) {
                    $finalData->push($dbData[$dateStr]);
                } else {
                    // Jika data tidak ada (Bolong), buat Dummy Object
                    $dummy = new presensi();
                    $dummy->user = $user; // Attach object user
                    $dummy->tanggal = $dateStr;
                    $dummy->status = Enums::TidakHadir;
                    $dummy->jam_masuk = '-';

                    // Tambahkan field lain jika view memerlukannya (misal id, lokasi, dll)

                    $finalData->push($dummy);
                }
            }

            return $finalData;

        } else {
            // Jika bukan mode detail per user (Laporan Umum), ambil raw data saja
            return $query->with('user')->get();
        }
    }


    public function getStatistikHarian($bidangId, $tanggal)
    {
        // 1. Ambil Data Karyawan & Presensi Hari Itu
        $karyawan = User::where('id_bidang', $bidangId)
            ->with(['presensi' => function($q) use ($tanggal) {
                $q->whereDate('tanggal', $tanggal);
            }])
            ->orderBy('Nama_Pengguna', 'asc')
            ->get();

        // 2. Logic Hitung Statistik
        $stats = [
            'total_pegawai' => $karyawan->count(),
            'hadir'         => 0,
            'telat'         => 0,
            'izin'          => 0,
            'belum_hadir'   => 0
        ];

        foreach($karyawan as $k) {
            $p = $k->presensi->first();

            if($p) {
                if($p->status->value == 'Hadir') $stats['hadir']++;
                elseif($p->status->value == 'Telat') $stats['telat']++;
                elseif($p->status->value == 'Izin' || $p->status->value == 'Sakit') $stats['izin']++;
            }
        }

        $stats['belum_hadir'] = $stats['total_pegawai'] - ($stats['hadir'] + $stats['izin'] + $stats['telat']); // Atau sesuaikan rumus

        // Kembalikan paket data lengkap
        return [
            'karyawan' => $karyawan,
            'statistik' => $stats
        ];
    }
}
