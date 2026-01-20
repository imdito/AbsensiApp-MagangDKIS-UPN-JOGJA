@extends('layouts.app')

@section('title', 'Detail Divisi ' . $bidang->nama_bidang)

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- HEADER & NAVIGASI --}}
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ url('/') }}" class="bg-white border border-gray-300 p-2.5 rounded-full hover:bg-gray-50 text-gray-600 transition shadow-sm" title="Kembali ke Dashboard">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Bidang {{ $bidang->nama_bidang }}</h1>
                    <p class="text-sm text-gray-500">Detail kehadiran anggota tanggal <span class="font-semibold text-indigo-600">{{ $hariIni->translatedFormat('d F Y') }}</span></p>
                </div>
            </div>

            {{-- Badge Kode Bidang --}}
            <div class="flex items-center">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                Kode: {{ $bidang->kode_bidang }}
            </span>
            </div>
        </div>

        {{-- STATISTIK SUMMARY CARD --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            {{-- Card 1: Total Anggota --}}
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200">
                <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Total Anggota</div>
                <div class="flex items-end justify-between">
                    <span class="text-3xl font-bold text-gray-800">{{ $total_pegawai }}</span>
                    <div class="p-2 bg-gray-50 rounded-lg text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    </div>
                </div>
            </div>

            {{-- Card 2: Hadir --}}
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 border-l-4 border-l-green-500">
                <div class="text-xs font-semibold text-green-600 uppercase tracking-wider mb-1">Hadir Hari Ini</div>
                <div class="flex items-end justify-between">
                    <span class="text-3xl font-bold text-gray-800">{{ $hadir }}</span>
                    <span class="text-xs text-gray-500 mb-1">Org</span>
                </div>
            </div>

            {{-- Card 3: Terlambat --}}
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 border-l-4 border-l-orange-500">
                <div class="text-xs font-semibold text-orange-600 uppercase tracking-wider mb-1">Terlambat</div>
                <div class="flex items-end justify-between">
                    <span class="text-3xl font-bold text-gray-800">{{ $telat }}</span>
                    <span class="text-xs text-gray-500 mb-1">Org</span>
                </div>
            </div>

            {{-- Card 4: Belum Absen --}}
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-200 border-l-4 border-l-red-500">
                <div class="text-xs font-semibold text-red-600 uppercase tracking-wider mb-1">Belum Absen</div>
                <div class="flex items-end justify-between">
                    <span class="text-3xl font-bold text-gray-800">{{ $belum_hadir }}</span>
                    <span class="text-xs text-gray-500 mb-1">Org</span>
                </div>
            </div>
        </div>

        {{-- TABEL DETAIL ANGGOTA --}}
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wide">Daftar Pegawai & Status</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pegawai</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Kehadiran</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Masuk</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($karyawan as $user)
                        @php $p = $user->presensi->first(); @endphp
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-9 w-9 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-sm mr-3">
                                        {{ substr($user->Nama_Pengguna, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $user->Nama_Pengguna }}</div>
                                        <div class="text-xs text-gray-500">{{ $user->NIP ?? 'NIP: -' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($p)
                                    @if($p->status->value == 'Hadir')
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Hadir
                                        </span>
                                    @elseif($p->status->value == 'Izin')
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Izin
                                        </span>
                                    @elseif($p->status->value == 'Sakit')
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            Sakit
                                        </span>
                                    @endif
                                @else
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Belum Absen
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $p->jam_masuk ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                Belum ada pegawai di bidang ini.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
