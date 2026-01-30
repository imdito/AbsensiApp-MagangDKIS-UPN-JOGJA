@php use Carbon\Carbon; @endphp
@extends($layout)

@section($layout=='layouts.app' ? 'title' : 'header_title', 'Generator QR Apel')

@section('content')
    <div class="max-w-md w-full mx-auto">

        @if($qrData)
            {{-- STATE 1: QR SUDAH ADA (AKTIF) --}}
            <div
                class="bg-white p-8 rounded-[2rem] shadow-2xl text-center border border-gray-100 transition-all animate-fade-in">
                <div class="mb-6">
                    <h1 class="text-2xl font-black text-gray-800 tracking-tight uppercase">Kode QR Apel Pagi</h1>
                    <p class="text-gray-500 font-medium">{{ Carbon::parse($qrData->created_at)->isoFormat('dddd, D MMMM Y') }}</p>

                    <div class="mt-3 flex flex-col items-center gap-2">
                        <span
                            class="inline-flex items-center bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-full border border-green-200">
                            <span class="w-2 h-2 mr-2 bg-green-500 rounded-full animate-ping"></span>
                            SESI AKTIF
                        </span>
                        <p class="text-[10px] text-red-500 font-bold uppercase tracking-widest">
                            Kadaluarsa: {{ Carbon::parse($qrData->expired_at)->format('H:i') }} WIB
                        </p>
                    </div>
                </div>

                {{-- Kotak Abu-abu Background QR --}}
                <div
                    class="flex justify-center items-center mb-6 bg-gray-100 p-6 rounded-[1.5rem] border-2 border-dashed border-gray-200 shadow-inner">
                    <div class="bg-white p-3 rounded-xl shadow-lg border border-gray-50">
                        {!! QrCode::size(250)->backgroundColor(255, 255, 255)->generate($qrData->token) !!}
                    </div>
                </div>

                <div class="space-y-4">
                    <p class="text-xs text-gray-400 leading-relaxed font-medium">
                        Silakan scan QR di atas menggunakan aplikasi mobile. QR akan otomatis tidak berlaku setelah
                        waktu kadaluarsa.
                    </p>

                    <div class="grid grid-cols-1 gap-2">
                        <button onclick="window.location.reload();"
                                class="w-full bg-slate-800 hover:bg-black text-white font-bold py-3 px-4 rounded-xl transition duration-200 flex items-center justify-center gap-2 shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            REFRESH HALAMAN
                        </button>
                    </div>

                    <a href="{{ url('/dashboard') }}"
                       class="block text-xs font-bold text-gray-400 hover:text-blue-600 transition-colors uppercase tracking-widest mt-4">
                        &larr; Kembali ke Dashboard
                    </a>
                </div>
            </div>

        @else
            {{-- STATE 2: QR KOSONG (FORM GENERATE) --}}
            <div class="bg-white p-10 rounded-[2.5rem] shadow-2xl border border-blue-50">
                <div class="text-center mb-8">
                    <div
                        class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-blue-100">
                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-black text-gray-900 uppercase tracking-tight">Generate QR</h2>
                    <p class="text-sm text-gray-500 mt-1 font-medium">Atur waktu berakhirnya sesi presensi hari ini.</p>
                </div>

                <form action="{{ route('presensi.generateQR') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="expired_at"
                               class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">
                            Batas Waktu Presensi (Tanggal & Jam)
                        </label>
                        <input type="datetime-local" name="expired_at" id="expired_at" required
                               class="w-full px-5 py-4 bg-gray-50 border-2 border-gray-100 rounded-2xl focus:border-blue-500 focus:ring-0 transition-all font-bold text-base text-gray-700"
                               value="{{ date('Y-m-d\TH:i', strtotime('+1 hour')) }}">

                        <div class="mt-2 flex items-start gap-1">
                            <svg class="w-3 h-3 text-blue-500 mt-0.5" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-[10px] text-gray-400 italic font-medium">
                                QR akan otomatis hangus setelah waktu yang ditentukan di atas.
                            </p>
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-black text-sm uppercase tracking-widest shadow-xl shadow-blue-100 transition-all transform hover:-translate-y-1 active:scale-95">
                        Aktifkan QR Sekarang
                    </button>

                    <a href="{{ url('/dashboard') }}"
                       class="block text-center text-xs font-bold text-gray-300 hover:text-gray-500 transition-colors uppercase tracking-widest">
                        Batal
                    </a>
                </form>
            </div>
        @endif

    </div>
@endsection
