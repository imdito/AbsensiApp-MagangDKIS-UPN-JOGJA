@php use Carbon\Carbon; @endphp
@extends('layouts.app')

@section('title', 'Generator QR Apel Pagi')

@section('content')
    <div class="min-h-screen bg-gray-100 flex flex-col items-center justify-center py-6 px-4 sm:px-6 lg:px-8"
         id="fullscreen-container">

        {{-- Header: Jam & Tanggal --}}
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900">
                Presensi Apel Pagi
            </h2>
            <p class="mt-2 text-lg text-gray-600 font-medium">
                {{ Carbon::now()->isoFormat('dddd, D MMMM Y') }}
            </p>
            {{-- Jam Realtime (JS) --}}
            <div class="mt-2 text-4xl font-mono font-bold text-blue-600 tracking-wider" id="realtime-clock">
                00:00:00
            </div>
        </div>

        {{-- Card Utama --}}
        <div class="max-w-md w-full bg-white shadow-2xl rounded-2xl overflow-hidden border border-gray-200">

            <div class="p-8 text-center">

                @if($todayQR)
                    {{-- STATE 1: QR CODE SUDAH DIGENERATE --}}

                    <div class="mb-6 relative group">
                        <div
                            class="flex justify-center items-center bg-white p-4 rounded-xl border-2 border-dashed border-gray-300">
                            {{-- Ganti ini dengan library QR Code Anda, misal: simple-qrcode --}}
                             {!! QrCode::size(250)->generate($todayQR->token) !!}
                        </div>
                        <p class="mt-4 text-xs text-gray-500">Scan QR di atas melalui aplikasi mobile</p>
                    </div>

                    <div class="space-y-4">

                        <div class="flex gap-2 justify-center">
                            {{-- Tombol Fullscreen --}}
                            <button onclick="toggleFullScreen()"
                                    class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                                </svg>
                                Layar Penuh
                            </button>

                            {{-- Tombol Print --}}
                            <button onclick="window.print()"
                                    class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                </svg>
                                Cetak
                            </button>
                        </div>
                    </div>

                @else
                    {{-- STATE 2: BELUM ADA QR HARI INI --}}

                    <div class="py-10">
                        <div
                            class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-blue-100 mb-6 animate-pulse">
                            <svg class="h-12 w-12 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">QR Code Belum Tersedia</h3>
                        <p class="mt-1 text-sm text-gray-500">Klik tombol di bawah untuk membuat QR Apel Pagi hari
                            ini.</p>

                        <form action="{{route('presensi.generateQR')}}" method="GET" class="mt-8">
                            @csrf
                            <button type="submit"
                                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all transform hover:scale-105">
                                Generate QR Code Sekarang
                            </button>
                        </form>
                    </div>

                @endif

            </div>

            {{-- Footer Card --}}
            <div class="bg-gray-50 px-4 py-4 sm:px-6">
                <div class="text-xs text-center text-gray-400">
                    Sistem Presensi Digital &copy; {{ date('Y') }}
                </div>
            </div>
        </div>

        {{-- Instruksi Cepat --}}
        <div class="mt-8 text-center">
            <p class="text-sm text-gray-500">
                <span class="font-semibold">Tips:</span> Pastikan kecerahan layar monitor maksimal agar mudah dipindai.
            </p>
        </div>

    </div>

    {{-- Script Jam & Fullscreen --}}
    <script>
        // 1. Update Jam Realtime
        function updateClock() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', {hour12: false});
            document.getElementById('realtime-clock').textContent = timeString;
        }

        setInterval(updateClock, 1000);
        updateClock(); // Run immediately

        // 2. Toggle Fullscreen
        function toggleFullScreen() {
            const elem = document.getElementById("fullscreen-container");
            if (!document.fullscreenElement) {
                elem.requestFullscreen().catch(err => {
                    alert(`Error attempting to enable full-screen mode: ${err.message} (${err.name})`);
                });
            } else {
                document.exitFullscreen();
            }
        }
    </script>
@endsection
