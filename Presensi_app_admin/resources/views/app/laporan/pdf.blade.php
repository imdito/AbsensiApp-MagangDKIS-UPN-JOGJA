<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Karyawan</title>
    <style>
        /* SETUP KERTAS & MARGIN */
        @page { margin: 1cm 0.5cm; }
        body { font-family: "Times New Roman", Times, serif; margin: 0; padding: 0; }

        /* KOP SURAT */
        .kop-header { width: 100%; border-collapse: collapse; margin-bottom: 5px; table-layout: fixed; }
        .kop-logo-cell { width: 15%; text-align: center; vertical-align: middle; }
        .kop-text-cell { width: 85%; text-align: center; vertical-align: middle; padding-right: 15px; }
        .pemkot-name { font-size: 14pt; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 2px; }
        .instansi-name { font-size: 16pt; font-weight: bold; text-transform: uppercase; margin-bottom: 2px; }
        .alamat-text { font-size: 10pt; margin-bottom: 2px; }
        .kontak-text { font-size: 9pt; }
        .garis-pemisah { border-top: 3px solid black; height: 2px; border-bottom: 1px solid black; margin-bottom: 15px; }

        /* TABEL DATA PRESENSI */
        .table-data { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table-data th, .table-data td { border: 1px solid black; padding: 4px 6px; font-size: 10pt; vertical-align: middle; }
        .table-data th { background-color: #f0f0f0; text-align: center; font-weight: bold; text-transform: uppercase; }
        .table-data tr:nth-child(even) { background-color: #f9f9f9; }

        /* TABEL IDENTITAS (KHUSUS FILTER NIP) */
        .table-identitas { width: 100%; border-collapse: collapse; font-size: 11pt; margin-bottom: 10px; }
        .table-identitas td { border: none; padding: 2px; vertical-align: top; }
        .label { font-weight: bold; width: 15%; }
        .separator { width: 2%; text-align: center; }

        /* LEBAR KOLOM TABEL DATA */
        .col-no { width: 5%; }
        .col-nip { width: 18%; }
        .col-nama { width: 22%; }
        .col-bidang { width: 30%; }
        .col-tgl { width: 15%; }
        .col-ket { width: 10%; }
    </style>
</head>
<body>

{{-- 1. KOP SURAT --}}
<table class="kop-header">
    <tr>
        <td class="kop-logo-cell">
            {{-- Pastikan path logo benar --}}
            <img src="{{ public_path('logo-pemkot.png') }}" width="90" height="auto" alt="Logo">
        </td>
        <td class="kop-text-cell">
            <div class="pemkot-name">PEMERINTAH KOTA CIREBON</div>
            <div class="instansi-name">DINAS KOMUNIKASI, INFORMATIKA DAN STATISTIK</div>
            <div class="alamat-text">Jalan Dr. Sudarsono No. 40, Cirebon 45134 Telepon (0231) 8804620, 209324</div>
            <div class="kontak-text">Email dkis@cirebonkota.go.id Website dkis.cirebonkota.go.id</div>
        </td>
    </tr>
</table>
<div class="garis-pemisah"></div>

{{-- 2. JUDUL & FILTER INFO --}}
<div style="margin-bottom: 20px;">
    <h3 style="text-align: center; text-decoration: underline; margin-bottom: 15px; margin-top: 0;">
        LAPORAN KEHADIRAN APEL PAGI
    </h3>

    {{-- LOGIC: Jika Filter NIP (Perorangan) --}}
    @if(isset($info['nip']) && $info['nip'])
        @php
            // Ambil data user dari row pertama (jika ada data) untuk menampilkan Nama & Bidang
            $firstUser = $data->first()->user ?? null;
            $namaUser  = $firstUser->Nama_Pengguna ?? '-';
            $namaBidang= $firstUser->bidang->nama_bidang ?? '-';
        @endphp

        {{-- Tabel Identitas Diri --}}
        <table class="table-identitas">
            <tr>
                <td class="label">NAMA</td>
                <td class="separator">:</td>
                <td>{{ $namaUser }}</td>
            </tr>
            <tr>
                <td class="label">NIP</td>
                <td class="separator">:</td>
                <td>{{ $info['nip'] }}</td>
            </tr>
            <tr>
                <td class="label">BIDANG</td>
                <td class="separator">:</td>
                <td>{{ $namaBidang }}</td>
            </tr>
        </table>

        {{-- LOGIC: Jika Filter Bidang (Per Divisi) --}}
    @elseif(isset($info['id_bidang']) && $info['id_bidang'])
        @php
            // Ambil nama bidang dari row pertama
            $namaBidang = $data->first()->user->bidang->nama_bidang ?? 'Data Bidang Kosong';
        @endphp

        {{-- Judul Bidang Tengah --}}
        <div style="text-align: center; font-size: 12pt; font-weight: bold; margin-bottom: 5px; text-transform: uppercase;">
            BIDANG: {{ $namaBidang }}
        </div>

    @endif

    {{-- Tanggal Periode (Selalu Muncul) --}}
    @if(isset($info['start_date']) && isset($info['end_date']))
        <div style="{{ isset($info['nip']) ? 'text-align: left; margin-top: 5px;' : 'text-align: center;' }} font-size: 11pt;">
            <span style="{{ isset($info['nip']) ? 'font-weight: bold; display: inline-block; width: 15%;' : '' }}">Periode</span>
            <span style="{{ isset($info['nip']) ? 'display: inline-block; width: 2%; text-align: center;' : '' }}">{{ isset($info['nip']) ? ':' : '' }}</span>
            {{ \Carbon\Carbon::parse($info['start_date'])->translatedFormat('d F Y') }}
            s/d
            {{ \Carbon\Carbon::parse($info['end_date'])->translatedFormat('d F Y') }}
        </div>
    @endif
</div>

{{-- 3. TABEL DATA UTAMA --}}
<table class="table-data">
    <thead>
    <tr>
        <th class="col-no">No</th>

        {{-- Jika Filter NIP, kolom NIP dan Nama sebenarnya redundan, tapi opsional bisa disembunyikan --}}
        <th class="col-nip">NIP</th>
        <th class="col-nama">Nama</th>

        {{-- Sembunyikan kolom Bidang jika sudah filter Bidang/NIP agar tabel lebih lega (Opsional) --}}
        @if(!isset($info['id_bidang']) && !isset($info['nip']))
            <th class="col-bidang">Bidang</th>
        @endif

        <th class="col-tgl">Tanggal</th>
        <th class="col-ket">Ket</th>
    </tr>
    </thead>
    <tbody>
    @forelse($data as $index => $item)
        <tr>
            <td style="text-align: center;">{{ $index + 1 }}</td>

            <td style="text-align: center;">{{ $item->user->NIP }}</td>
            <td>{{ $item->user->Nama_Pengguna ?? '-' }}</td>

            @if(!isset($info['id_bidang']) && !isset($info['nip']))
                <td style="text-align: center">{{ $item->user->bidang->nama_bidang ?? '-' }}</td>
            @endif

            <td style="text-align: center;">
                {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
            </td>

            {{-- Pewarnaan Status Sederhana --}}
            <td style="text-align: center; font-weight: bold;">
                {{ $item->status }}
            </td>
        </tr>
    @empty
        <tr>
            {{-- Colspan menyesuaikan jumlah kolom yang tampil --}}
            <td colspan="{{ (!isset($info['id_bidang']) && !isset($info['nip'])) ? 6 : 5 }}"
                style="text-align: center; font-style: italic; padding: 20px;">
                Data presensi tidak ditemukan pada periode ini.
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

{{-- Tanda Tangan (Opsional) --}}
<div style="margin-top: 50px; float: right; width: 200px; text-align: center;">
    <p>Cirebon, {{ now()->translatedFormat('d F Y') }}</p>
    <br><br><br>
    <p><strong>Administrator</strong></p>
</div>

</body>
</html>
