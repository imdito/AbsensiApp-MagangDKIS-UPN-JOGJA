<!DOCTYPE html>
<html lang="id">
<head>
    <title>Cetak Laporan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Tambahan style agar iframe tampil penuh di berbagai layar */
        .pdf-container {
            height: 800px; /* Tinggi default */
        }
        @media (max-height: 800px) {
            .pdf-container { height: 500px; }
        }
    </style>
</head>
<body class="bg-gray-50 pb-10">

{{-- Navbar --}}
<nav class="bg-white border-b border-gray-200 sticky top-0 z-50 mb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    <span class="text-xl font-bold text-indigo-600 tracking-tight">PresensiApp</span>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <a href="{{ url('/') }}"
                       class="{{ request()->is('/') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Dashboard
                    </a>
                    <a href="{{ url('/karyawan') }}"
                       class="{{ request()->is('karyawan*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Data ASN
                    </a>
                    <a href="{{ route('laporan.index') }}"
                       class="{{ request()->routeIs('laporan.index') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Laporan
                    </a>
                </div>
            </div>
            <div class="flex items-center">
                <form action="{{url('/logout')}}" method="POST">
                    @csrf
                    <button type="submit" class="text-gray-500 hover:text-red-600 px-3 py-2 text-sm font-medium flex items-center gap-2">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

{{-- Container Utama (Saya lebarkan agar PDF enak dilihat) --}}
<div class="max-w-6xl mx-auto px-4">

    <div class="grid grid-cols-1 gap-6">

        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800">Filter Laporan Karyawan</h2>
                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">Preview Mode</span>
            </div>

            <form action="{{ route('laporan.print') }}" method="POST" target="pdf_preview">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">NIP Karyawan</label>
                        <input type="text" name="nip" class="w-full px-3 py-2 border rounded shadow-sm focus:outline-none focus:ring focus:border-indigo-300" placeholder="Opsional...">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Rentang Waktu</label>
                        <div class="flex space-x-2">
                            <input type="date" name="start_date" class="w-1/2 px-3 py-2 border rounded shadow-sm focus:outline-none focus:ring focus:border-indigo-300">
                            <span class="self-center text-gray-400">-</span>
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
                <iframe name="pdf_preview" class="w-full h-full border-0" title="PDF Preview">
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
    //skrip menghapus placeholder teks saat iframe terisi
    const iframe = document.querySelector('iframe[name="pdf_preview"]');
    iframe.addEventListener('load', () => {
        const placeholder = iframe.parentElement.querySelector('div.absolute');
        if (iframe.contentDocument.body.innerHTML.trim() !== '') {
            placeholder.style.display = 'none';
        } else {
            placeholder.style.display = 'flex';
        }
    });
</script>
</body>
</html>
