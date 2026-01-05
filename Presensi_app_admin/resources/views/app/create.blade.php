<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Presensi Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Form Input Presensi</h5>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="bg-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>
                                        {{$error}}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else

                    @endif
                    <form action="{{ route('presensi.store')  }}" method="POST">

                        @csrf

                        <div class="mb-3">
                            <label for="user_id" class="form-label">Nama Karyawan</label>
                            <select name="user_id" id="user_id" class="form-select" required>
                                <option value="{{ old('user_id') }}">-- Pilih Karyawan --</option>

                                {{--
                                    NOTE: Variabel $users ini harus dikirim dari Controller
                                    saat memanggil view ini.
                                --}}
                                @foreach($users as $user)
                                    <option value="{{ $user->user_id }}">
                                        {{ $user->nama }} - {{ $user->divisi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="jam_masuk" class="form-label">Jam Masuk</label>
                                <input type="time" value="{{old('jam_masuk')}}" name="jam_masuk" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="jam_pulang" class="form-label">Jam Keluar</label>
                                <input type="time" name="jam_pulang" class="form-control">
                                <div class="form-text text-muted">Kosongkan jika belum pulang.</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan / Status</label>
                            <textarea name="status" class="form-control" rows="3" placeholder="Contoh: Hadir Tepat Waktu, Izin Sakit, WFH, dll..." required>{{old('status')}}</textarea>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <a href="{{ url('/') }}" class="btn btn-secondary">
                                &laquo; Kembali
                            </a>
                            <button type="submit" class="btn btn-success">
                                Simpan Data
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
