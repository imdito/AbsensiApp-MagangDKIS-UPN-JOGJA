<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Karyawan</title>
    <style>
        /* 1. Reset & Font Dasar */
        body {
            font-family: "Times New Roman", Times, serif; /* Font standar surat dinas */
            margin: 2cm 2cm; /* Margin kertas standar */
            padding: 0;
            width: 100%;
            align-content: flex-start;
        }

        /* 2. Layout Kop Surat (Gunakan Tabel agar rapi di DomPDF) */
        .kop-header {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }

        /* Kolom Logo (Kiri) */
        .kop-logo-cell {
            width: 15%;
            text-align: center;
            vertical-align: middle;
        }

        /* Kolom Teks (Tengah) */
        .kop-text-cell {
            width: 85%;
            text-align: center;
            vertical-align: middle;
            padding-right: 15px; /* Kompensasi visual agar terlihat benar-benar tengah */
        }

        /* 3. Styling Teks Kop */
        .pemkot-name {
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 2px;
        }
        .instansi-name {
            font-size: 18pt;
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

        /* 4. Garis Ganda (Khas Surat Dinas) */
        .garis-pemisah {
            border-top: 3px solid black;    /* Garis tebal di atas */
            height: 2px;                    /* Spasi antar garis */
            border-bottom: 1px solid black; /* Garis tipis di bawah */
            margin-bottom: 20px;
        }

        /* 5. Styling Tabel Data (Opsional, untuk isi laporan) */
        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table-data th, .table-data td {
            border: 1px solid black;
            padding: 6px;
            font-size: 11pt;
        }
        .table-data th {
            background-color: #f0f0f0;
            text-align: center;
        }
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
            <div class="kontak-text">Email dkis@cirebonkota.go.id Website dkis.cirebonkota.go.id </div>
        </td>
    </tr>
</table>

<div class="garis-pemisah"></div>
<div style="text-align: center; margin-bottom: 20px;">
    <h3 style="text-decoration: underline; margin-bottom: 5px;">LAPORAN DATA ASN</h3>
    @if(isset($info['start_date']) && isset($info['end_date']))
        <p style="margin: 0; font-size: 11pt;">Periode: {{ $info['start_date'] }} s/d {{ $info['end_date'] }}</p>
    @endif
</div>

<table class="table-data">
    <thead>
    <tr>
        <th width="5%">No</th>
        <th width="20%">NIP</th>
        <th width="30%">Nama</th>
        <th width="20%">Tanggal</th>
        <th width="25%">Keterangan</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $index => $item)
        <tr>
            <td style="text-align: center;">{{ $index + 1 }}</td>
            <td>{{ $item->user->NIP }}</td>
            <td>{{ $item->user->Nama_Pengguna ?? '-' }}</td>
            <td style="text-align: center;">{{ $item->tanggal }}</td>
            <td>{{ $item->status }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>
