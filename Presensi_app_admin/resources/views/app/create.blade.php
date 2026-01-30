@php use Carbon\Carbon; @endphp
@extends($layout)

@section($layout=='layouts.app' ? 'title' : 'header_title', 'Buat Presensi')

@section('content')

    <div class="max-w-2xl w-full mx-auto space-y-8">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Input Presensi Manual</h2>
                <p class="mt-1 text-sm text-gray-500">Form untuk admin memasukkan data kehadiran karyawan secara
                    manual.</p>
            </div>
            <a href="{{ url('/') }}"
               class="text-sm text-blue-600 hover:text-blue-500 font-medium flex items-center gap-1">
                &larr; Kembali ke Dashboard
            </a>
        </div>

        {{-- Alert Error --}}
        @if($errors->any())
            <div class="rounded-md bg-red-50 p-4 border border-red-200 shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                             fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan:</h3>
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

            <form action="{{ url('/presensi/store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- 1. Pilih Karyawan --}}
                <div>
                    <label for="user_id" class="block text-sm font-medium text-gray-700">Nama Karyawan</label>
                    <div class="mt-1">
                        <select name="user_id" id="user_id" required
                                class="block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white">
                            <option value="" disabled selected>-- Pilih Karyawan --</option>
                            @foreach($users ?? [] as $karyawan)
                                <option value="{{ $karyawan->user_id }}">{{ $karyawan->Nama_Pengguna }}
                                    - {{ $karyawan->NIP }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- 2. Pilih Kode QR (Sesi Apel) --}}
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-100">
                    <label for="Id_QR" class="block text-sm font-medium text-blue-800 mb-1">
                        Sesi QR Code (Apel Pagi)
                    </label>
                    <div class="mt-1">
                        <select name="Id_QR" id="Id_QR"
                                class="block w-full px-3 py-3 border border-blue-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white text-gray-700">
                            <option value="" selected>-- Pilih Tanggal/Sesi QR --</option>

                            {{-- Loop Data QR dari Controller --}}
                            @foreach($daftar_qr ?? [] as $qr)
                                <option value="{{ $qr->Id_QR }}">
                                    {{ Carbon::parse($qr->Created_at)->format('d M Y') }}
                                    (Token: {{ Str::limit($qr->token, 8) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <p class="mt-2 text-xs text-blue-600">
                        <i class="fas fa-info-circle mr-1"></i> Pilih tanggal QR yang sesuai jika input ini untuk
                        menggantikan scan QR Apel.
                    </p>
                </div>

                {{-- 3. Tanggal & Jam Absensi --}}
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                    <div>
                        <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal Presensi</label>
                        <div class="mt-1">
                            <input type="date" name="tanggal" id="tanggal" value="{{ date('Y-m-d') }}" required
                                   class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label for="jam_masuk" class="block text-sm font-medium text-gray-700">Jam Masuk/Absen</label>
                        <div class="mt-1">
                            <input type="time" name="jam_masuk" id="jam_masuk" value="{{ date('H:i') }}" required
                                   class="appearance-none block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                    </div>
                </div>

                {{-- 4. Status Kehadiran --}}
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status Kehadiran</label>
                    <div class="mt-1 relative">
                        <select name="status" id="status" required
                                class="block w-full px-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white">
                            <option value="" disabled selected>-- Pilih Status --</option>
                            <option value="Hadir">Hadir</option>
                            <option value="Izin">Izin</option>
                            <option value="Sakit">Sakit</option>
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-6">
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ url('/') }}"
                           class="bg-white py-2.5 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none transition-colors">
                            Batal
                        </a>
                        <button type="submit"
                                class="inline-flex justify-center py-2.5 px-4 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all transform hover:-translate-y-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan Data
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

@endsection
