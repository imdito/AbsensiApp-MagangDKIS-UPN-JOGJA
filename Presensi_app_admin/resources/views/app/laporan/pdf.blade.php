<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Karyawan</title>
    <style>
        /* 1. SETUP KERTAS & MARGIN TIPIS */
        @page {
            /* Atas-Bawah: 1cm (agar Kop Surat aman saat diprint) */
            /* Kiri-Kanan: 0.5cm (agar lebar konten MAKSIMAL) */
            margin: 1cm 0.5cm;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            margin: 0; /* Reset margin body karena sudah diatur di @page */
            padding: 0;
        }

        /* 2. HEADER / KOP SURAT */
        .kop-header {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
            /* Pastikan tabel kop juga mengikuti lebar maksimal */
            table-layout: fixed;
        }

        .kop-logo-cell {
            width: 15%;
            text-align: center;
            vertical-align: middle;
        }

        .kop-text-cell {
            width: 85%; /* Sisa dari logo (100% - 15%) */
            text-align: center;
            vertical-align: middle;
            padding-right: 15px; /* Sedikit padding agar center visual pas */
        }

        .pemkot-name {
            font-size: 14pt;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 2px;
        }
        .instansi-name {
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 2px;

        }
        .alamat-text {
            font-size: 10pt;
            margin-bottom: 2px;
        }
        .kontak-text {
            font-size: 9pt;
        }

        .garis-pemisah {
            border-top: 3px solid black;
            height: 2px;
            border-bottom: 1px solid black;
            margin-bottom: 20px;
        }

        /* 3. TABEL DATA (LEBAR MAKSIMAL) */
        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table-data th, .table-data td {
            border: 1px solid black;
            padding: 4px 6px; /* Padding sedikit diperkecil agar muat banyak */
            font-size: 10pt;  /* Ukuran font disesuaikan agar rapi */
            vertical-align: middle;
        }

        .table-data th {
            background-color: #f0f0f0;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* Zebra Striping (Opsional: Agar baris ganjil/genap beda warna dikit biar enak dibaca) */
        .table-data tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .col-no { width: 5%; }
        .col-nip { width: 20%; }
        .col-nama { width: 20%; }
        .col-bidang { width: 33%; }
        .col-tgl { width: 12%; }
        .col-ket { width: 10%; }

    </style>
</head>
<body>

<table class="kop-header">
    <tr>
        <td class="kop-logo-cell">
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

<div style="text-align: center; margin-bottom: 20px;">
    <h3 style="text-decoration: underline; margin-bottom: 5px; margin-top: 0;">LAPORAN DATA ASN</h3>
    @if(isset($info['start_date']) && isset($info['end_date']))
        <p style="margin: 0; font-size: 11pt;">Periode: {{ $info['start_date'] }} s/d {{ $info['end_date'] }}</p>
    @endif
</div>

<table class="table-data">
    <thead>
    <tr>
        <th class="col-no text-center">No</th>
        <th class="col-nip text-center">NIP</th>
        <th class="col-nama text-left">Nama</th>
        <th class="col-bidang text-center">Bidang</th>
        <th class="col-tgl text-center">Tanggal</th>
        <th class="col-ket text-left">Ket</th>

    </tr>
    </thead>
    <tbody>
    @forelse($data as $index => $item)
        <tr>
            <td style="text-align: center;">{{ $index + 1 }}</td>
            <td>{{ $item->user->NIP }}</td>
            <td>{{ $item->user->Nama_Pengguna ?? '-' }}</td>
            <td style="text-align: center">{{$item->user->bidang->nama_bidang}}</td>
            <td style="text-align: center;">{{ $item->tanggal }}</td>
            <td>{{ $item->status }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="5" style="text-align: center; font-style: italic;">Tidak ada data pada periode ini.</td>
        </tr>
    @endforelse
    </tbody>
</table>

</body>
</html>
