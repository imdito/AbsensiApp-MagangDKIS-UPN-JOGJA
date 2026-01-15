@extends('layouts.app')

@section('title', 'Tambah Karyawan Baru')

@section('content')

    <div class="max-w-2xl w-full space-y-8 mx-auto">

    <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Registrasi Karyawan</h2>
                <p class="mt-1 text-sm text-gray-500">Buat akun baru untuk akses sistem presensi.</p>
            </div>
            <a href="{{ url('/') }}" class="text-sm text-blue-600 hover:text-blue-500 font-medium flex items-center gap-1">
                &larr; Kembali ke Dashboard
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
                        <h3 class="text-sm font-medium text-red-800">Gagal menyimpan data:</h3>
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
            <form action="{{ url('/tambah-user') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="Nama_Pengguna" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <div class="mt-1">
                        <input type="text" name="Nama_Pengguna" id="Nama_Pengguna" value="{{ old('Nama_Pengguna') }}" required placeholder="Contoh: Budi Santoso"
                               class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-200">
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">

                    <div>
                        <label for="NIP" class="block text-sm font-medium text-gray-700">NIP (Nomor Induk)</label>
                        <div class="mt-1">
                            <input type="number" name="NIP" id="NIP" value="{{ old('nip') }}" required placeholder="12345678"
                                   class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="id_bidang" class="block text-sm font-medium text-gray-700">Bidang</label>
                        <select name="id_bidang" id="id_bidang" required
                                class="block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-white">

                            <option value="" disabled>-- Pilih Bidang --</option>

                            @foreach($daftar_divisi as $item)
                                <option value="{{ $item->id_bidang }}">

                                    {{ $item->nama_bidang }}
                                </option>
                            @endforeach

                        </select>
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                    <div class="mt-1">
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="nama@perusahaan.com"
                               class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi Default</label>
                    <div class="mt-1 relative">
                        <input type="password" name="password" id="password" required placeholder="••••••••"
                               class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <p class="mt-2 text-xs text-gray-500">
                        Disarankan minimal 8 karakter. Karyawan dapat menggantinya nanti.
                    </p>
                </div>

                <div class="border-t border-gray-100 pt-6">
                    <div class="flex items-center justify-end gap-3">

                        <a href="{{ url('/') }}" class="bg-white py-2.5 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            Batal
                        </a>

                        <button type="submit" class="inline-flex justify-center py-2.5 px-4 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all transform hover:-translate-y-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Simpan Karyawan
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

@endsection
