@php use Carbon\Carbon; @endphp
    <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kehadiran - {{ now()->format('dmY') }}</title>
    <style>
        /* 1. SETUP KERTAS A4 PORTRAIT */
        @page {
            size: A4;
            margin: 2cm 2cm 2cm 2cm; /* Margin standar surat resmi */
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 11pt; /* Ukuran font standar surat */
            line-height: 1.3;
            color: #000;
        }

        /* 2. KOP SURAT */
        .kop-table {
            width: 100%;
            border-bottom: 5px double #000; /* Garis ganda tebal tipis */
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .kop-logo {
            width: 15%;
            text-align: center;
            vertical-align: middle;
        }

        .kop-text {
            width: 85%;
            text-align: center;
            vertical-align: middle;
        }

        .pemkot {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .dinas {
            font-size: 18pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 5px 0;
        }

        .alamat {
            font-size: 10pt;
            font-style: italic;
        }

        /* 3. JUDUL & IDENTITAS */
        .judul-laporan {
            text-align: center;
            font-size: 12pt;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .periode {
            text-align: center;
            font-size: 11pt;
            margin-bottom: 20px;
        }

        /* Tabel Identitas (Untuk Filter NIP) */
        .info-table {
            width: 100%;
            margin-bottom: 15px;
            font-size: 11pt;
        }

        .info-table td {
            vertical-align: top;
            padding: 2px 0;
        }

        .info-label {
            width: 15%;
            font-weight: bold;
        }

        .info-sep {
            width: 2%;
            text-align: center;
        }

        .info-val {
            width: 83%;
        }

        /* 4. TABEL DATA PRESENSI */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10pt;
        }

        .data-table th, .data-table td {
            border: 1px solid #000;
            padding: 6px 8px;
            vertical-align: middle;
        }

        .data-table th {
            background-color: #e0e0e0; /* Abu-abu muda untuk header */
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* Zebra Striping (Opsional, agar mudah dibaca) */
        .data-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Status Badges (Text Only untuk PDF Resmi) */
        .status-hadir {
            color: #000;
        }

        /* Tetap hitam formal */
        .status-absen {
            color: #d32f2f;
            font-weight: bold;
            font-style: italic;
        }

        /* Merah untuk absen */
        .status-libur {
            color: #f57c00;
            font-style: italic;
        }

        /* Oranye untuk libur */

        /* 5. TANDA TANGAN */
        .signature-container {
            margin-top: 40px;
            width: 100%;
            page-break-inside: avoid; /* Jangan terpotong halaman */
        }

        .ttd-box {
            float: right;
            width: 40%;
            text-align: center;
        }
    </style>
</head>
<body>

{{-- KOP SURAT --}}
<table class="kop-table">
    <tr>
        <td class="kop-logo">
            {{-- Gunakan public_path agar terbaca oleh DOMPDF --}}
            <img src="{{ public_path('logo-pemkot.png') }}" width="80" alt="Logo">
        </td>
        <td class="kop-text">
            <div class="pemkot">Pemerintah Kota Cirebon</div>
            <div class="dinas">{{$skpd->nama}}</div>
            <div class="alamat">
                {{$skpd->Alamat}} <br>
                Telepon (0231) 8804620, Email: dkis@cirebonkota.go.id
            </div>
        </td>
    </tr>
</table>

{{-- JUDUL LAPORAN --}}
<div class="judul-laporan">Laporan Data Kehadiran Apel Pagi</div>

<div class="periode">
    @if(isset($info['start_date']) && isset($info['end_date']))
        Periode: {{ Carbon::parse($info['start_date'])->translatedFormat('d F Y') }}
        s/d {{ Carbon::parse($info['end_date'])->translatedFormat('d F Y') }}
    @else
        Periode: Semua Data
    @endif
</div>

{{-- LOGIC IDENTITAS: Jika Filter NIP (Perorangan) --}}
@if(isset($info['nip']) && $info['nip'])
    @php
        // Mengambil data user dari item pertama (karena user sama semua)
        // Menggunakan optional() untuk menghindari error jika data kosong
        $sampleItem = $data->first();
        $userNama = $sampleItem->user->Nama_Pengguna ?? 'Data Tidak Ditemukan';
        $userNip  = $sampleItem->user->NIP ?? $info['nip'];
        $userBidang = $sampleItem->user->bidang->nama_bidang ?? '-';
    @endphp
    <table class="info-table">
        <tr>
            <td class="info-label">Nama Pegawai</td>
            <td class="info-sep">:</td>
            <td class="info-val">{{ $userNama }}</td>
        </tr>
        <tr>
            <td class="info-label">NIP</td>
            <td class="info-sep">:</td>
            <td class="info-val">{{ $userNip }}</td>
        </tr>
        <tr>
            <td class="info-label">Unit Kerja</td>
            <td class="info-sep">:</td>
            <td class="info-val">{{ $userBidang }}</td>
        </tr>
    </table>

    {{-- LOGIC IDENTITAS: Jika Filter Bidang (Satu Divisi) --}}
@elseif(isset($info['id_bidang']) && $info['id_bidang'])
    @php
        $namaBidang = $data->first()->user->bidang->nama_bidang ?? 'Bidang Tidak Diketahui';
    @endphp
    <div style="text-align: center; margin-bottom: 15px; font-weight: bold; text-transform: uppercase;">
        UNIT KERJA: {{ $namaBidang }}
    </div>
@endif

{{-- TABEL DATA --}}
<table class="data-table">
    <thead>
    <tr>
        <th style="width: 5%">No</th>

        {{-- Sembunyikan NIP/Nama jika Laporan Perorangan --}}
        @if(!isset($info['nip']))
            <th style="width: 20%">NIP</th>
            <th style="width: 25%">Nama Pegawai</th>
        @endif

        {{-- Sembunyikan Bidang jika Filter Bidang atau NIP --}}
        @if(!isset($info['id_bidang']) && !isset($info['nip']))
            <th style="width: 20%">Bidang</th>
        @endif

        <th style="width: 20%">Tanggal</th>
        <th style="width: 15%">Jam Masuk</th>
        <th style="width: 15%">Status</th>
    </tr>
    </thead>
    <tbody>
    @forelse($data as $index => $item)
        <tr>
            <td style="text-align: center;">{{ $index + 1 }}</td>

            @if(!isset($info['nip']))
                <td style="text-align: center;">{{ $item->user->NIP ?? '-' }}</td>
                <td>{{ $item->user->Nama_Pengguna ?? '-' }}</td>
            @endif

            @if(!isset($info['id_bidang']) && !isset($info['nip']))
                <td style="text-align: center; font-size: 9pt;">
                    {{ $item->user->bidang->nama_bidang ?? '-' }}
                </td>
            @endif

            <td style="text-align: center;">
                {{ Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
            </td>

            <td style="text-align: center;">
                {{ $item->jam_masuk ?? '-' }}
            </td>

            {{-- Logic Pewarnaan Status --}}
            <td style="text-align: center;">
                @php
                    $status = $item->status; // Bisa berupa string atau Enum
                    $statusText = is_object($status) ? $status->value : $status;

                    $class = 'status-hadir';
                    if (stripos($statusText, 'tidak hadir') !== false || stripos($statusText, 'alpa') !== false) {
                        $class = 'status-absen';
                    } elseif (stripos($statusText, 'libur') !== false) {
                        $class = 'status-libur';
                    }
                @endphp
                <span class="{{ $class }}">
                            {{ $statusText }}
                        </span>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" style="text-align: center; padding: 20px; font-style: italic;">
                Tidak ada data presensi untuk periode ini.
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

{{-- TANDA TANGAN --}}
<div class="signature-container">
    <div class="ttd-box">
        <p>Cirebon, {{ now()->translatedFormat('d F Y') }}</p>
        <p>Mengetahui,</p>
        <p style="margin-bottom: 60px;"><strong>Kepala Bidang / Admin</strong></p>

        <p style="text-decoration: underline; font-weight: bold;">
            ( ........................................... )
        </p>
        <p>NIP. ...........................</p>
    </div>
</div>

</body>
</html>
