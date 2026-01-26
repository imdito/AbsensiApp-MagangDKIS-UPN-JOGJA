@extends('layouts.app')

@section('title', 'Audit Log Data Pegawai')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Header Section --}}
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Audit Data Pegawai
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Riwayat perubahan data profil, jabatan, dan informasi akun karyawan.
                </p>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4">
                <button onclick="location.reload()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Refresh Log
                </button>
            </div>
        </div>

        {{-- Table Card --}}
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Waktu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-48">Target Pegawai</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Aksi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Eksekutor</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50 transition-colors top-0">

                            {{-- 1. Waktu --}}
                            <td class="px-6 py-4 whitespace-nowrap align-top">
                                <div class="text-sm font-bold text-gray-900">{{ $log->created_at->format('d M Y') }}</div>
                                <div class="text-xs text-gray-500 font-mono mt-0.5">{{ $log->created_at->format('H:i:s') }} WIB</div>
                            </td>

                            {{-- 2. Target Pegawai (Subject) --}}
                            <td class="px-6 py-4 whitespace-nowrap align-top">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-xs mr-3">
                                        {{ substr($log->Nama_Pengguna ?? '?', 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $log->Nama_Pengguna ?? 'Pegawai Terhapus' }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            NIP: {{ $log->NIP ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- 3. Jenis Aksi --}}
                            <td class="px-6 py-4 whitespace-nowrap align-top">
                                @if($log->updated_at != $log->created_at)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        Update Data
                                    </span>
                                @elseif($log->trashed())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                        Hapus / Resign
                                    </span>
                                @elseif($log->action == 'restore')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                        Restore
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                        Merekrut / Create
                                    </span>
                                @endif
                            </td>

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

                            {{-- 4. Eksekutor --}}
                            <td class="px-6 py-4 whitespace-nowrap align-top">
                                <div class="flex items-center">
                                    <svg class="h-4 w-4 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
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

                            {{-- 5. Detail Perubahan (JSON Parsing) --}}

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                Belum ada riwayat perubahan data pegawai.
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
