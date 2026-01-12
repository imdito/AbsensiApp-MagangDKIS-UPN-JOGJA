<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Presensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen py-12 px-4 sm:px-6 lg:px-8 flex items-center justify-center">

<div class="max-w-2xl w-full space-y-8">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Perbarui Presensi</h2>
            <p class="mt-1 text-sm text-gray-500">Edit data kehadiran karyawan.</p>
        </div>
        <a href="{{ url('/') }}" class="text-sm text-blue-600 hover:text-blue-500 font-medium flex items-center gap-1">
            &larr; Kembali ke Dashboard
        </a>
    </div>

    {{-- Alert Error Validasi --}}
    @if($errors->any())
        <div class="rounded-md bg-red-50 p-4 border border-red-200 shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Gagal memperbarui data:</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white py-8 px-6 shadow-xl rounded-2xl sm:px-10 border border-gray-100">

        {{-- Form Update --}}
        <form action="{{ url('/presensi/update/' . $presensi->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT') {{-- Wajib untuk method Update --}}

            {{-- 1. Nama Karyawan --}}
            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700">Nama Karyawan</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <select name="user_id" id="user_id" required
                            class="block w-full pl-3 pr-10 py-3 border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-lg bg-white">

                        {{-- Loop Data User --}}
                        @foreach($users as $user)
                            <option value="{{ $user->id }}"
                                {{-- Cek: Jika ID user sama dengan user_id di data presensi, maka 'selected' --}}
                                {{ old('user_id', $presensi->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->nama ?? $user->Nama_Pengguna }}
                            </option>
                        @endforeach

                    </select>
                </div>
            </div>

            {{-- 2. Tanggal --}}
            <div>
                <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal Presensi</label>
                <div class="mt-1">
                    <input type="date" name="tanggal" id="tanggal"
                           value="{{ old('tanggal', $presensi->tanggal) }}" required
                           class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
            </div>

            {{-- 3. Jam Masuk & Pulang --}}
            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                <div>
                    <label for="jam_masuk" class="block text-sm font-medium text-gray-700">Jam Masuk</label>
                    <div class="mt-1 relative">
                        <input type="time" name="jam_masuk" id="jam_masuk"
                               value="{{ old('jam_masuk', $presensi->jam_masuk) }}"
                               class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                </div>

                <div>
                    <label for="jam_pulang" class="block text-sm font-medium text-gray-700">Jam Pulang</label>
                    <div class="mt-1 relative">
                        <input type="time" name="jam_pulang" id="jam_pulang"
                               value="{{ old('jam_pulang', $presensi->jam_pulang) }}"
                               class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                </div>
            </div>

            {{-- 4. Status (Dropdown) --}}
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status Kehadiran</label>
                <div class="mt-1">
                    <select name="status" id="status" required
                            class="block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white">

                        <option value="Hadir" {{ old('status', $presensi->status) == 'Hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="Izin" {{ old('status', $presensi->status) == 'Izin' ? 'selected' : '' }}>Izin</option>
                        <option value="Tidak Hadir" {{ old('status', $presensi->status) == 'Tidak Hadir' ? 'selected' : '' }}>Tidak Hadir</option>

                    </select>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100">
                <a href="{{ url('/') }}" class="bg-white py-2.5 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    Batal
                </a>
                <button type="submit" class="inline-flex justify-center py-2.5 px-4 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all transform hover:-translate-y-0.5">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>

</div>

</body>
</html>
