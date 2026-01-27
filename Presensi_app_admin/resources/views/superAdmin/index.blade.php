@extends('layouts.admin')

@section('header_title', 'Overview Sistem')

@section('content')

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-gray-500">Total SKPD</h3>
                <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                    <i class="fa-solid fa-building"></i>
                </div>
            </div>
            <div class="flex items-baseline">
                <h2 class="text-3xl font-bold text-gray-800">{{ $total_skpd }}</h2>
                <span class="ml-2 text-sm text-green-500 font-medium">+Aktif</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-gray-500">Admin Terdaftar</h3>
                <div class="p-2 bg-purple-50 rounded-lg text-purple-600">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
            </div>
            <div class="flex items-baseline">
                <h2 class="text-3xl font-bold text-gray-800">{{ $total_admin }}</h2>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-gray-500">Total Bidang</h3>
                <div class="p-2 bg-orange-50 rounded-lg text-orange-600">
                    <i class="fa-solid fa-sitemap"></i>
                </div>
            </div>
            <div class="flex items-baseline">
                <h2 class="text-3xl font-bold text-gray-800">{{ $total_bidang }}</h2>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-medium text-gray-500">Total Pegawai</h3>
                <div class="p-2 bg-green-50 rounded-lg text-green-600">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
            <div class="flex items-baseline">
                <h2 class="text-3xl font-bold text-gray-800">{{ $total_pegawai }}</h2>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-semibold text-gray-800">SKPD Terbaru</h3>
                <a href="/" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">Nama Instansi</th>
                        <th class="px-6 py-3">Jumlah Bidang</th>
                        <th class="px-6 py-3">Status</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                    @forelse($recent_skpds as $skpd)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $skpd->nama }}</td>
                            <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                {{ $skpd->bidang_count ?? 0 }} Bidang
                            </span>
                            </td>
                            <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Active
                            </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">Belum ada data SKPD.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-semibold text-gray-800 mb-4">Status Server</h3>

            <div class="space-y-4">
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-500">Database Connection</span>
                        <span class="text-green-600 font-medium">Connected</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: 100%"></div>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100">
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-2">Technical Info</p>
                    <div class="flex items-center justify-between text-sm py-1">
                        <span class="text-gray-600">Laravel Version</span>
                        <span class="font-mono text-gray-800">12.x</span>
                    </div>
                    <div class="flex items-center justify-between text-sm py-1">
                        <span class="text-gray-600">PHP Version</span>
                        <span class="font-mono text-gray-800">{{ phpversion() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
