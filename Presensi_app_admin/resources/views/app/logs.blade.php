@extends('layouts.app')

@section('title', 'Audit Log Presensi')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Header Section --}}
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Audit Presensi
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Rekaman jejak digital seluruh aktivitas transaksi data presensi.
                </p>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4">
                <button onclick="location.reload()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Refresh Data
                </button>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Terakhir</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pegawai Terkait</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Aktivitas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Oleh (Admin)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Data</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50 transition-colors">

                            {{-- 1. Waktu Kejadian (Logic: Tampilkan Updated, jika beda tampilkan Created dibawahnya) --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">{{ $log->updated_at->format('d M Y') }}</div>
                                <div class="text-xs text-gray-500 font-mono mt-0.5">{{ $log->updated_at->format('H:i:s') }} WIB</div>

                                {{-- Jika pernah diedit (Updated != Created), tampilkan kapan dibuat --}}
                                @if($log->updated_at != $log->created_at)
                                    <div class="mt-2 pt-2 border-t border-gray-100 group">
                                        <span class="text-[10px] text-gray-400 uppercase tracking-wider font-semibold">Dibuat:</span>
                                        <div class="text-xs text-gray-500">
                                            {{ $log->created_at->format('d M Y H:i') }}
                                        </div>
                                    </div>
                                @endif
                            </td>

                            {{-- 2. Pegawai --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs mr-3">
                                        {{ substr($log->user->Nama_Pengguna ?? '?', 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $log->user->Nama_Pengguna ?? 'User Tidak Ditemukan' }}
                                        </div>
                                        <div class="text-xs text-gray-500">ID: {{ $log->user_id }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- 3. Jenis Aktivitas --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($log->trashed())
                                    <div class="flex items-center text-red-600 bg-red-50 px-3 py-1 rounded-full w-max border border-red-100">
                                        <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        <span class="text-xs font-semibold">Dihapus</span>
                                    </div>
                                @elseif($log->updated_at != $log->created_at)
                                    <div class="flex items-center text-yellow-600 bg-yellow-50 px-3 py-1 rounded-full w-max border border-yellow-100">
                                        <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        <span class="text-xs font-semibold">Diperbarui</span>
                                    </div>
                                @else
                                    <div class="flex items-center text-green-600 bg-green-50 px-3 py-1 rounded-full w-max border border-green-100">
                                        <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                        <span class="text-xs font-semibold">Input Baru</span>
                                    </div>
                                @endif
                            </td>

                            {{-- 4. Oleh (Admin) - Logic Prioritas --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    // Tentukan siapa pelaku berdasarkan status terakhir
                                    $adminName = 'System';
                                    $adminID   = '-';

                                    if ($log->trashed()) {
                                        $adminName = $log->destroyer->Nama_Pengguna ?? 'System';
                                        $adminID   = $log->deleted_id;
                                    } elseif ($log->updated_at != $log->created_at) {
                                        $adminName = $log->updater->Nama_Pengguna ?? 'System';
                                        $adminID   = $log->updated_id;
                                    } else {
                                        $adminName = $log->creator->Nama_Pengguna ?? 'System';
                                        $adminID   = $log->created_id;
                                    }
                                @endphp

                                <div class="flex items-center">
                                    <svg class="h-4 w-4 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $adminName }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            ID: {{ $adminID ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- 5. Status Data --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($log->trashed())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                        Soft Deleted
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                        Active
                                    </span>
                                @endif
                            </td>

                            {{-- 6. Aksi --}}
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                @if($log->trashed())
                                    <form action="" method="POST" class="inline-block" onsubmit="return confirm('Kembalikan data ini?')">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 px-3 py-1.5 rounded-md transition-colors border border-green-200 text-xs font-bold uppercase tracking-wider flex items-center gap-1" title="Pulihkan Data">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                            Restore
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-300 text-xs italic">No Action</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="h-10 w-10 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span class="font-medium">Belum ada log aktivitas yang tercatat.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if(method_exists($logs, 'links') && $logs->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
