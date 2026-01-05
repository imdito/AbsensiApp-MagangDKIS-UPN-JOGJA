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
        <h2 class="text-2xl font-bold text-gray-900">Perbarui Presensi</h2>
        <a href="{{ url('/') }}" class="text-sm text-indigo-600 hover:text-indigo-500 font-medium flex items-center gap-1">
            &larr; Kembali ke Dashboard
        </a>
    </div>

    <div class="bg-white py-8 px-6 shadow-xl rounded-2xl sm:px-10 border border-gray-100">

        <form action="{{ url('/presensi/update/' . $presensi->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700">Nama Karyawan</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <select name="user_id" id="user_id" class="block w-full pl-3 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-lg border bg-white">
                        @foreach($users as $user)
                            <option value="{{ $user->user_id }}" {{ $presensi->user_id == $user->user_id ? 'selected' : '' }}>
                                {{ $user->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal Presensi</label>
                <div class="mt-1">
                    <input type="date" name="tanggal" id="tanggal" value="{{ $presensi->tanggal }}"
                           class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                <div>
                    <label for="jam_masuk" class="block text-sm font-medium text-gray-700">Jam Masuk</label>
                    <div class="mt-1 relative">
                        <input type="time" name="jam_masuk" id="jam_masuk" value="{{ $presensi->jam_masuk }}"
                               class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-center">
                    </div>
                </div>

                <div>
                    <label for="jam_pulang" class="block text-sm font-medium text-gray-700">Jam Keluar</label>
                    <div class="mt-1 relative">
                        <input type="time" name="jam_pulang" id="jam_pulang" value="{{ $presensi->jam_pulang }}"
                               class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-center">
                    </div>
                </div>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">
                    Keterangan / Status
                    <span class="text-gray-400 font-normal text-xs ml-1">(Opsional)</span>
                </label>
                <div class="mt-1">
                        <textarea name="status" id="status" rows="3"
                                  class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                  placeholder="Contoh: Izin sakit, WFH, atau Hadir">{{ $presensi->status }}</textarea>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ url('/') }}" class="bg-white py-2.5 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Batal
                </a>
                <button type="submit" class="inline-flex justify-center py-2.5 px-4 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>

    <p class="text-center text-xs text-gray-400">
        Pastikan data yang diinput sudah sesuai dengan bukti kehadiran.
    </p>
</div>

</body>
</html>
