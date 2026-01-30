<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Presensi - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print { .no-print { display: none; } }
        .fade-in { animation: fadeIn 0.5s ease-in; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased overflow-x-hidden">

<nav class="bg-white shadow-md border-b-2 border-blue-500 no-print sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between h-20 items-center">

            <div class="flex items-center space-x-4">
                <img src="{{ asset('logo-pemkot.png') }}" alt="Logo" class="h-12 w-auto">
                <div class="h-8 w-[1.5px] bg-gray-300"></div>
                <img src="{{ asset('logoDKIS.png') }}" alt="Logo" class="h-12 w-auto">
            </div>

            <div class="flex items-center space-x-6">
                <div class="flex items-center bg-gray-50 px-4 py-2 rounded-2xl border border-gray-200">
                    <div class="text-right mr-3">
                        <p class="text-xs font-black text-gray-900">{{ auth()->user()->Nama_Pengguna }}</p>
                        <p class="text-[9px] text-gray-400 font-bold uppercase">Online</p>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold">
                        {{ substr(auth()->user()->Nama_Pengguna, 0, 1) }}
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="flex items-center justify-center p-3 rounded-xl bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all group shadow-sm border border-red-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="max-w-0 overflow-hidden group-hover:max-w-xs group-hover:ml-2 transition-all duration-300 font-bold text-xs uppercase">
                            Keluar
                        </span>
                    </button>
                </form>
            </div>

        </div>
    </div>
</nav>

<main>
    @yield('content')
</main>

<footer class="fixed bottom-0 w-full bg-white border-t border-gray-200 py-3 px-6 no-print">
    <div class="max-w-7xl mx-auto flex justify-between items-center text-[10px] font-bold text-gray-400 uppercase tracking-widest">
        <div>Status Server: <span class="text-green-500">Connected</span></div>
        <div class="flex items-center">
                <span class="relative flex h-2 w-2 mr-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                </span>
            Real-time Monitoring Active
        </div>
    </div>
</footer>

</body>
</html>
