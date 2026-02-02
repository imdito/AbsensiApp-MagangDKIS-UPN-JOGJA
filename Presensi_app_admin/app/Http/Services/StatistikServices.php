<?php

namespace App\Http\Services;

use App\Enums\Enums;
use App\Models\QrToken;
use App\Models\User;
use App\Models\Presensi;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class StatistikServices{
    public function getLaporanData(?string $nip, ?string $startDate, ?string $endDate, ?string $idBidang): Collection
    {
        // 1. AMBIL USER TARGET
        $userQuery = User::query()->tenanted();

        if ($nip) {
            $userQuery->where('NIP', $nip);
        } elseif ($idBidang) {
            $userQuery->where('id_bidang', $idBidang);
        }

        // Ambil data user + relasi bidang (untuk kop laporan)
        $users = $userQuery->with('bidang')->orderBy('Nama_Pengguna')->get();

        if ($users->isEmpty()) {
            return collect([]);
        }

        $qrQuery = QrToken::query();

        // Filter tanggal QR sesuai request
        if ($startDate && $endDate) {
            $qrQuery->whereBetween('Tanggal', [$startDate, $endDate]);
        } elseif ($startDate) {
            $qrQuery->where('Tanggal', '>=', $startDate);
        }

        $firstUser = $users->first();
        if ($firstUser && $firstUser->bidang) {
            $qrQuery->where('id_skpd', $firstUser->bidang->id_skpd);
        }

        $activeQrDates = $qrQuery->tenanted()->orderBy('Tanggal')
            ->pluck('Tanggal') // Ambil kolom tanggal saja
            ->map(fn($tgl) => \Carbon\Carbon::parse($tgl)->format('Y-m-d'))
            ->unique()
            ->values()
            ->toArray();

        // Jika tidak ada QR sama sekali dalam periode ini, return kosong
        if (empty($activeQrDates)) {
            return collect([]);
        }

        // 3. AMBIL DATA PRESENSI USER (Hanya di tanggal-tanggal Apel)
        $presensiData = Presensi::whereIn('user_id', $users->pluck('user_id'))
            ->whereIn('tanggal', $activeQrDates)
            ->tenanted()
            ->get()
            ->groupBy('user_id');

        // 4. GENERATE LAPORAN
        $finalReport = collect();

        foreach ($users as $user) {

            $userPresensi = $presensiData->get($user->user_id, collect());

            // KITA LOOPING BERDASARKAN TANGGAL QR YANG ADA SAJA
            foreach ($activeQrDates as $dateStr) {

                // Cek apakah user absen di tanggal apel ini?
                $dataHadir = $userPresensi->firstWhere('tanggal', $dateStr);

                if ($dataHadir) {
                    // KASUS 1: HADIR (Datanya ada di tabel presensi)
                    $finalReport->push($dataHadir);
                } else {
                    // KASUS 2: TIDAK HADIR (Hari itu ada Apel/QR, tapi user tidak absen)
                    // Kita buat Dummy Object untuk menandakan Alpa

                    $dummy = new Presensi();
                    $dummy->user_id = $user->user_id;
                    $dummy->user    = $user; // Attach relasi manual
                    $dummy->tanggal = $dateStr;
                    $dummy->jam_masuk = '-';
                    $dummy->status    = 'Tidak Hadir'; // Vonis langsung karena QR-nya ada

                    $finalReport->push($dummy);
                }
            }
        }

        // 5. Sorting Laporan
        // Opsi: Urutkan berdasarkan Tanggal dulu, baru Nama User
        return $finalReport->sortBy([
            ['tanggal', 'asc'],
            ['user.Nama_Pengguna', 'asc']
        ]);
    }


    public function getStatistikHarian($bidangId, $tanggal)
    {
        // 1. Ambil Data Karyawan & Presensi Hari Itu
        $karyawan = User::tenanted()->where('id_bidang', $bidangId)
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
                if($p->status->value == 'Hadir') {
                    $stats['hadir']++;
                }
                elseif($p->status->value == 'Telat') {
                    $stats['telat']++;
                }
                elseif($p->status->value == 'Izin' || $p->status->value == 'Sakit') {
                    $stats['izin']++;
                }
            }
        }

        $stats['belum_hadir'] = $stats['total_pegawai'] - ($stats['hadir'] + $stats['izin'] + $stats['telat']); // Atau sesuaikan rumus

        return [
            'karyawan' => $karyawan,
            'statistik' => $stats
        ];
    }
}
