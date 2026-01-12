<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Karyawan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-gray-50 min-h-screen py-12 px-4 sm:px-6 lg:px-8 flex items-center justify-center">

<div class="max-w-2xl w-full space-y-8">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Karyawan</h2>
            <p class="mt-1 text-sm text-gray-500">Perbarui data profil dan akses akun.</p>
        </div>
        <a href="{{ url('/karyawan') }}" class="text-sm text-indigo-600 hover:text-indigo-500 font-medium flex items-center gap-1">
            &larr; Kembali ke List
        </a>
    </div>

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

        {{-- Pastikan route update menerima parameter ID user --}}
        <form action="{{ url('/karyawan/update/' . $user->user_id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT') {{-- PENTING: Untuk method spoofing --}}

            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <div class="mt-1">
                    <input type="text" name="Nama_Pengguna" id="nama"
                           value="{{ old('nama', $user->Nama_Pengguna) }}" required
                           class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition duration-200">
                </div>
            </div>

            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                <div>
                    <label for="nip" class="block text-sm font-medium text-gray-700">NIP</label>
                    <div class="mt-1">
                        <input type="number" name="nip" id="nip"
                               value="{{ old('nip', $user->NIP) }}" required
                               class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>

                <div>
                    <label for="id_bidang" class="block text-sm font-medium text-gray-700">Divisi</label>
                    <div class="mt-1">
                        <select name="id_bidang" id="id_bidang" required
                                class="block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-white">

                            <option value="" disabled>-- Pilih Divisi --</option>

                            @foreach($daftar_divisi as $item)
                                <option value="{{ $item->id_bidang }}"
                                    {{ old('id_bidang', $user->id_bidang) == $item->id_bidang ? 'selected' : '' }}>

                                    {{ $item->nama_bidang }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                </div>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                <div class="mt-1">
                    <input type="email" name="email" id="email"
                           value="{{ old('email', $user->email) }}" required
                           class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
            </div>

            <div class="border-t border-gray-100 my-6"></div>

            <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-100">
                <label for="password" class="block text-sm font-medium text-yellow-800">
                    Password Baru <span class="font-normal text-yellow-600">(Opsional)</span>
                </label>
                <div class="mt-1">
                    <input type="password" name="password" id="password" placeholder="Biarkan kosong jika tidak ingin mengubah"
                           class="appearance-none block w-full px-3 py-3 border border-yellow-300 rounded-lg shadow-sm placeholder-yellow-400 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500 sm:text-sm bg-white">
                </div>
                <p class="mt-2 text-xs text-yellow-600">
                    Isi hanya jika Anda ingin mereset password pengguna ini.
                </p>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3">
                <a href="{{ url('/karyawan') }}" class="bg-white py-2.5 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Batal
                </a>
                <button type="submit" class="inline-flex justify-center py-2.5 px-4 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:-translate-y-0.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>

</body>
</html>
