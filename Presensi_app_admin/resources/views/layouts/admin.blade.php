<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

<div class="flex h-screen overflow-hidden">

    <aside class="w-64 bg-white border-r border-gray-200 hidden md:flex flex-col">
        <div class="h-16 flex items-center px-8 border-b border-gray-100">
            <i class="fa-solid fa-cube text-indigo-600 text-xl mr-3"></i>
            <span class="text-lg font-bold tracking-tight text-gray-900">E-Presensi</span>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
            <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Main Menu</p>

            <a href="#" class="flex items-center px-4 py-3 Ftext-indigo-600 bg-indigo-50 rounded-lg transition-colors">
                <i class="fa-solid fa-gauge w-6"></i>
                <span class="font-medium">Dashboard</span>
            </a>

            <a href="{{Route('skpd.index')}}" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-indigo-600 rounded-lg transition-colors">
                <i class="fa-solid fa-building w-6"></i>
                <span class="font-medium">Data SKPD</span>
            </a>

            <a href="/" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-indigo-600 rounded-lg transition-colors">
                <i class="fa-solid fa-sitemap w-6"></i>
                <span class="font-medium">Data Bidang</span>
            </a>

            <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mt-6 mb-2">Users</p>

            <a href="/" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-indigo-600 rounded-lg transition-colors">
                <i class="fa-solid fa-users w-6"></i>
                <span class="font-medium">Manajemen User</span>
            </a>
        </nav>

        <div class="p-4 border-t border-gray-100">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex w-full items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                    <i class="fa-solid fa-right-from-bracket w-6"></i>
                    <span class="font-medium">Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">

        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8">
            <h2 class="text-xl font-semibold text-gray-800">@yield('header_title', 'Dashboard')</h2>

            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <span class="text-sm font-medium text-gray-700 hidden md:block">{{ auth()->user()->name }}</span>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-8">
            @yield('content')
        </main>
    </div>
</div>

</body>
</html>
