<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Presensi')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

@include('layouts.navbar')

<main class="py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- @yield adalah penanda "Isi konten di sini" --}}
        @yield('content')
    </div>
</main>

<div class="mt-4 mb-4 text-center">
    <p class="text-xs text-gray-400">&copy; {{ date('Y') }} Sistem Presensi ASN</p>
</div>

</body>
</html>
