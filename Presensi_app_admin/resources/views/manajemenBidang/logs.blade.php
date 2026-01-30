@extends($layout)

@section($layout=='layouts.app' ? 'title' : 'header_title', 'Audit Log Bidang')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Header Section --}}
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Audit Data Bidang
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Rekaman jejak digital seluruh aktivitas manajemen data master bidang.
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Bidang</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Aktivitas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Oleh (Admin)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Data</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($logs as $log)
                        @php
                            // Tentukan waktu utama yang akan ditampilkan (Pilih yang tidak null)
                            $waktuUtama = $log->updated_at ?? $log->created_at;

                            // Tentukan Aksi & Admin
                            if ($log->trashed()) {
                                $statusLabel = 'Dihapus';
                                $statusColor = 'red';
                                $iconPath    = 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16';
                                $admin       = $log->destroyer;
                                $adminID     = $log->deleted_id;
                            } elseif ($log->updated_at && $log->created_at && $log->updated_at->gt($log->created_at)) {
                                $statusLabel = 'Diperbarui';
                                $statusColor = 'yellow';
                                $iconPath    = 'M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z';
                                $admin       = $log->updater;
                                $adminID     = $log->updated_id;
                            } else {
                                $statusLabel = 'Input Baru';
                                $statusColor = 'green';
                                $iconPath    = 'M12 6v6m0 0v6m0-6h6m-6 0H6';
                                $admin       = $log->creator;
                                $adminID     = $log->created_id;
                            }
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">

                            {{-- 1. Waktu Kejadian (Safe from Null) --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($waktuUtama)
                                    <div class="text-sm font-bold text-gray-900">{{ $waktuUtama->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-500 font-mono mt-0.5">{{ $waktuUtama->format('H:i:s') }} WIB</div>
                                @else
                                    <div class="text-xs text-gray-400 italic">Waktu tidak tercatat</div>
                                @endif

                                {{-- Jika ini adalah update, tampilkan waktu created sebagai info tambahan --}}
                                @if($log->updated_at && $log->created_at && $log->updated_at->gt($log->created_at))
                                    <div class="mt-2 pt-2 border-t border-gray-100">
                                        <span class="text-[10px] text-gray-400 uppercase font-semibold">Dibuat:</span>
                                        <div class="text-xs text-gray-500">
                                            {{ $log->created_at->format('d M Y H:i') }}
                                        </div>
                                    </div>
                                @endif
                            </td>

                            {{-- 2. Nama Bidang --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-lg bg-orange-100 flex items-center justify-center text-orange-600 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m3 4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-900">{{ $log->nama_bidang ?? 'N/A' }}</div>
                                        <div class="text-xs text-gray-500 font-mono tracking-tighter">ID: {{ $log->id_bidang }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- 3. Jenis Aktivitas --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center text-{{ $statusColor }}-600 bg-{{ $statusColor }}-50 px-3 py-1 rounded-full w-max border border-{{ $statusColor }}-100">
                                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}"></path>
                                    </svg>
                                    <span class="text-xs font-semibold">{{ $statusLabel }}</span>
                                </div>
                            </td>

                            {{-- 4. Oleh (Admin) --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <svg class="h-4 w-4 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $admin->Nama_Pengguna ?? 'System' }}</div>
                                        <div class="text-xs text-gray-500">ID: {{ $adminID ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- 5. Status Data --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $log->trashed() ? 'bg-gray-100 text-gray-800' : 'bg-blue-100 text-blue-800' }}">
                                    {{ $log->trashed() ? 'Soft Deleted' : 'Active' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">Belum ada jejak aktivitas.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($logs, 'links') && $logs->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
