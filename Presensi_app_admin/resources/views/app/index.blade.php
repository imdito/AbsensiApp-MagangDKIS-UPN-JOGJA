<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Presensi Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Data Presensi Karyawan</h4>
        </div>
        <div class="card-body">

            <div class="mb-3 text-end">
                <a href="{{ url('/tambah')}}" class="btn btn-warning">
                    + Input Karyawan Baru
                </a>
                <a href="{{ route('presensi') }}" class="btn btn-success">
                    + Input Presensi Baru
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Karyawan</th>
                        <th>Divisi</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    {{-- @forelse adalah loop @foreach yang punya fitur pengecekan jika data kosong --}}
                    @forelse($daftar_presensi as $item)
                        <tr>
                            {{-- Loop iteration untuk nomor urut otomatis (1, 2, 3...) --}}
                            <td>{{ $loop->iteration }}</td>

                            {{-- Mengambil data dari Relasi User --}}
                            <td>
                                <strong>{{ $item->user->nama ?? 'User Terhapus' }}</strong>
                                <br>
                                <small class="text-muted">{{ $item->user->email ?? '-' }}</small>
                            </td>

                            <td>
                                        <span class="badge bg-info text-dark">
                                            {{ $item->user->divisi ?? '-' }}
                                        </span>
                            </td>

                            {{-- Sesuaikan nama kolom di bawah ini dengan tabel presensi Anda --}}
                            <td>{{ $item->tanggal }}</td>
                            <td>{{ $item->jam_masuk }}</td>
                            <td>{{ $item->jam_pulang ?? '--:--' }}</td>
                            <td>{{ $item->status ?? 'Hadir' }}</td>
                            <td>
                                <a href="{{ url('/presensi/edit/' . $item->id) }}" class="btn btn-warning btn-sm">
                                    Edit
                                </a>
                                <form action="{{ url('/presensi/delete', ['id' => $item->id]) }}" method="post">
                                    <input class="btn btn-danger btn-sm mt-2" type="submit" value="Delete" />
                                    @method('DELETE')
                                    @csrf
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada data presensi.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
