@extends('layouts.app')

@section('title', 'Cetak Laporan Presensi')

@section('content')
    <div class="max-w-7xl mx-auto px-4"> {{-- Container diperlebar sedikit jadi max-w-7xl agar muat --}}

        <div class="grid grid-cols-1 gap-6">

            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Filter Laporan ASN</h2>
                    <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">Preview Mode</span>
                </div>

                <form action="{{ route('laporan.print') }}" method="POST" target="pdf_preview">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">NIP ASN</label>
                            <input type="text" name="nip" class="w-full px-3 py-2 border rounded shadow-sm focus:outline-none focus:ring focus:border-indigo-300" placeholder="Cari NIP...">
                        </div>

                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Bidang</label>
                            <select name="id_bidang" class="w-full px-3 py-2 border rounded shadow-sm focus:outline-none focus:ring focus:border-indigo-300 bg-white">
                                <option value="">-- Semua Bidang --</option>
                                @if(isset($daftar_bidang))
                                    @foreach($daftar_bidang as $bidang)
                                        <option value="{{ $bidang->id_bidang }}">{{ $bidang->nama_bidang }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Rentang Waktu</label>
                            <div class="flex space-x-2">
                                <input type="date" name="start_date" class="w-1/2 px-3 py-2 border rounded shadow-sm focus:outline-none focus:ring focus:border-indigo-300">
                                <span class="self-center text-gray-400 font-bold">-</span>
                                <input type="date" name="end_date" class="w-1/2 px-3 py-2 border rounded shadow-sm focus:outline-none focus:ring focus:border-indigo-300">
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 flex justify-end">
                        <button type="reset" class="mr-2 px-4 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded text-sm font-medium transition">
                            Reset
                        </button>
                        <button type="submit" class="bg-indigo-600 text-white font-bold py-2 px-6 rounded hover:bg-indigo-700 transition shadow-lg flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Tampilkan PDF
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-lg shadow-md border border-gray-100 overflow-hidden">
                <div class="bg-gray-50 px-4 py-2 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-sm font-semibold text-gray-600">Preview Dokumen</h3>
                    <div class="flex space-x-1">
                        <div class="w-3 h-3 rounded-full bg-red-400"></div>
                        <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                        <div class="w-3 h-3 rounded-full bg-green-400"></div>
                    </div>
                </div>

                <div class="pdf-container relative bg-slate-200">
                    <iframe name="pdf_preview" class="w-full h-full border-0" style="height: 800px" title="PDF Preview">
                        <p class="text-center p-10 text-gray-500">Browser Anda tidak mendukung iFrame.</p>
                    </iframe>
                    <div class="absolute inset-0 flex items-center justify-center -z-0 pointer-events-none">
                        <p class="text-gray-400 font-medium">Hasil PDF akan muncul di sini...</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        const iframe = document.querySelector('iframe[name="pdf_preview"]');
        iframe.addEventListener('load', () => {
            const placeholder = iframe.parentElement.querySelector('div.absolute');
            try {
                if (iframe.contentDocument && iframe.contentDocument.body.innerHTML.trim() !== '') {
                    placeholder.style.display = 'none';
                }
            } catch(e) {
                placeholder.style.display = 'none';
            }
        });
    </script>
@endsection
