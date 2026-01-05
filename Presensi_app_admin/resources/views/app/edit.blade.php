<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Presensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-warning">
            <h5 class="mb-0">Edit Data Presensi</h5>
        </div>
        <div class="card-body">

            <form action="{{ url('/presensi/update/' . $presensi->id) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Karyawan</label>
                    <select name="user_id" class="form-select">
                        @foreach($users as $user)
                            <option value="{{ $user->user_id }}" {{ $presensi->user_id == $user->user_id ? 'selected' : '' }}>
                                {{ $user->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ $presensi->tanggal }}">
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jam Masuk</label>
                        <input type="time" name="jam_masuk" class="form-control" value="{{ $presensi->jam_masuk }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jam Keluar</label>
                        <input type="time" name="jam_pulang" class="form-control" value="{{ $presensi->jam_pulang }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan</label>
                    <textarea name="status" class="form-control" rows="3">{{ $presensi->status }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="{{ url('/') }}" class="btn btn-secondary">Batal</a>
            </form>

        </div>
    </div>
</div>
</body>
</html>
