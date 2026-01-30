@extends($layout)

@section($layout=='layouts.app' ? 'title' : 'header_title', 'Data Bidang')

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Header --}}
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Dashboard Presensi
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Statistik kehadiran hari ini: <span class="font-bold text-indigo-600">{{ date('d M Y') }}</span>
                </p>
            </div>

            {{-- Tombol Aksi --}}
            <div class="mt-4 flex flex-col md:flex-row gap-3 md:mt-0 md:ml-4">
                <a href="{{ route('presensi.QR')  }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                    Lihat QR Apel Pagi
                </a>
                <a href="{{ route('presensi') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                    Input Manual
                </a>
                <a href="{{ route('logs.presensi') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700">
                    Lihat log aktivitas Presensi
                </a>
            </div>
        </div>

        {{-- --- BAGIAN CARD --- --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-10">

            @foreach($rekap_divisi as $divisi)
                @php
                    // 1. Warna Card
                    $colors = [
                        ['bg' => 'bg-blue-600', 'bar' => 'bg-blue-800'],
                        ['bg' => 'bg-emerald-600', 'bar' => 'bg-emerald-800'],
                        ['bg' => 'bg-violet-600', 'bar' => 'bg-violet-800'],
                        ['bg' => 'bg-orange-600', 'bar' => 'bg-orange-800'],
                    ];
                    $theme = $colors[$loop->index % 4];

                    // 2. Hitung Persentase untuk Progress Bar
                    $persentase = $divisi->total_anggota > 0
                        ? ($divisi->jumlah_hadir / $divisi->total_anggota) * 100
                        : 0;
                @endphp

                <a href="{{ route('bidang.statistik', $divisi->id_bidang) }}" class="{{ $theme['bg'] }} rounded-xl shadow-lg p-5 text-white transform hover:scale-105 transition duration-300 relative overflow-hidden group">

                    <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-white opacity-10 group-hover:scale-150 transition-transform duration-500"></div>

                    <div class="flex justify-between items-start z-10 relative">
                        <div>
                            <p class="text-blue-100 text-xs font-semibold uppercase tracking-wider opacity-80">Bidang</p>
                            <h3 class="text-lg font-bold mt-0.5">{{ $divisi->nama_bidang }}</h3>
                        </div>

                        <div class="bg-white/20 p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>

                    <div class="mt-4 flex items-baseline gap-1 relative z-10">
                        <span class="text-4xl font-bold">{{ $divisi->jumlah_hadir }}</span>
                        <span class="text-xl font-medium text-white/70">/ {{ $divisi->total_anggota }}</span>
                        <span class="text-xs text-white/70 ml-1">Hadir</span>
                    </div>

                    <div class="mt-3 w-full bg-black/20 rounded-full h-1.5 overflow-hidden relative z-10">
                        <div class="bg-white h-1.5 rounded-full transition-all duration-1000 ease-out"
                             style="width: {{ $persentase }}%"></div>
                    </div>

                    <div class="mt-1 text-right">
                        <span class="text-[10px] text-white/80 font-medium">{{ round($persentase) }}% Lengkap</span>
                    </div>

                </a>
            @endforeach


            @if($rekap_divisi->isEmpty())
                <div class="col-span-full text-center py-8 bg-white rounded-xl border-2 border-dashed border-gray-300 text-gray-400">
                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <span class="mt-2 block text-sm font-medium">Belum ada data divisi</span>
                </div>
            @endif
        </div>

        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ASN</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bidang</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Presensi</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($daftar_presensi as $item)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0 bg-indigo-100 rounded-full flex items-center justify-center">
                                        <span class="text-indigo-700 font-bold text-sm">{{ substr($item->user->Nama_Pengguna ?? 'U', 0, 1) }}</span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->user->Nama_Pengguna ?? 'User Terhapus' }}</div>
                                        <div class="text-sm text-gray-500">{{ $item->user->email ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $item->user->bidang->nama_bidang ?? '-' }}
                            </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $item->tanggal }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($item->jam_masuk != null)
                                    <span class="text-green-600 font-medium">{{ $item->jam_masuk }}</span>
                                @else
                                    <span class="text-red-500 font-medium"> -- </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ ($item->status->value ?? 'Hadir') == 'Hadir' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $item->status->value ?? 'Hadir' }}
                            </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end items-center gap-2">
                                    <a href="{{ url('/presensi/edit/' . $item->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-2 rounded-lg">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-10 text-center text-gray-500 bg-gray-50">Belum ada data.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
