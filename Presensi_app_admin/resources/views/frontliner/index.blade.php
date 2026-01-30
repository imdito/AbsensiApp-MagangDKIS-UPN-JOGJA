@php use Carbon\Carbon;
    Carbon::setLocale('id');
@endphp
@extends('layouts.frontliner')

@section('title', 'Display Presensi Wide')

@section('content')
    <div class="min-h-screen bg-white flex flex-col transition-all duration-500" id="fullscreen-container">

        <div class="flex-1 flex flex-col lg:flex-row h-full">

            <div class="w-full lg:w-1/2 flex flex-col justify-center items-center lg:items-start p-12 lg:pl-24 bg-slate-50 border-r border-gray-100">
                <div class="space-y-2">
                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-black bg-blue-100 text-blue-700 tracking-widest uppercase mb-4">
                    Sesi Apel Pagi
                </span>
                    <h2 class="text-3xl lg:text-5xl font-bold text-slate-500 uppercase tracking-tight">
                        {{ Carbon::now()->isoFormat('dddd') }}
                    </h2>
                    <h3 class="text-2xl lg:text-4xl font-medium text-slate-400">
                        {{ Carbon::now()->isoFormat('D MMMM YYYY') }}
                    </h3>
                    <div class="text-[8rem] lg:text-[12rem] font-black text-blue-700 leading-none tabular-nums drop-shadow-md" id="realtime-clock">
                        00:00:00
                    </div>
                    <div class="pt-8 no-print">
                        <button onclick="toggleFullScreen()" class="group flex items-center px-6 py-4 bg-slate-800 text-white rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-black transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 group-hover:scale-125 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                            </svg>
                            Aktifkan Mode TV / Fullscreen
                        </button>
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-12 bg-white relative">

                @if($todayQR)
                    <div class="relative group">
                        <div class="bg-gray-100 p-12 lg:p-16 rounded-[4rem] border-2 border-dashed border-gray-200 shadow-inner">
                            <div class="bg-white p-8 rounded-[2.5rem] shadow-2xl border border-gray-50 transition-transform duration-500 group-hover:scale-105">
                                {!! QrCode::size(400)->generate($todayQR->token) !!}
                            </div>
                        </div>

                        <div class="mt-10 text-center">
                            <div class="flex items-center justify-center space-x-3 mb-4">
                            <span class="relative flex h-4 w-4">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-4 w-4 bg-green-500"></span>
                            </span>
                                <span class="text-2xl font-black text-slate-800 tracking-tighter uppercase italic">Silakan Scan Sekarang</span>
                            </div>
                            <p class="text-slate-400 font-bold uppercase text-sm tracking-widest">Posisikan QR di tengah kamera HP Anda</p>
                        </div>
                    </div>
                @else
                    <div class="text-center">
                        <div class="w-32 h-32 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-8 animate-bounce">
                            <svg class="w-16 h-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <h3 class="text-4xl font-black text-slate-800 mb-4 uppercase">QR Belum Siap</h3>
                    </div>
                @endif

                <div class="absolute bottom-8 right-12 text-right">
                    <p class="text-xs font-black text-slate-300 uppercase tracking-widest">
                        DKIS Kota Cirebon &bull; 2026
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            document.getElementById('realtime-clock').textContent = now.toLocaleTimeString('id-ID', { hour12: false });
        }
        setInterval(updateClock, 1000);
        updateClock();

        function toggleFullScreen() {
            const elem = document.getElementById("fullscreen-container");
            if (!document.fullscreenElement) {
                elem.requestFullscreen().catch(err => {
                    alert(`Error: ${err.message}`);
                });
            } else {
                document.exitFullscreen();
            }
        }
    </script>

    <style>
        #fullscreen-container:fullscreen {
            width: 100vw;
            height: 100vh;
            overflow: hidden;
        }

        svg {
            max-width: 100%;
            height: auto;
        }
    </style>
@endsection
