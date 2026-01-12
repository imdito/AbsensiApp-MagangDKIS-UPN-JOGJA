<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Dibatasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center px-4">

<div class="max-w-md w-full bg-white shadow-xl rounded-2xl overflow-hidden text-center">
    <div class="bg-indigo-600 p-6 flex justify-center">
        <div class="bg-white p-3 rounded-full shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
            </svg>
        </div>
    </div>

    <div class="p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Halo, {{ Auth::user()->nama ?? 'User' }}!</h2>

        <p class="text-gray-500 text-sm mb-6">
            Akun Anda terdaftar sebagai <strong>Karyawan</strong>. <br>
            Website ini khusus untuk Administrator. Silakan gunakan <strong>Aplikasi Mobile</strong> untuk melakukan presensi dan melihat riwayat.
        </p>

        <div class="space-y-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full bg-red-50 hover:bg-red-100 text-red-600 font-semibold py-3 px-4 rounded-lg border border-red-200 transition duration-200 flex items-center justify-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Keluar (Logout)
                </button>
            </form>
        </div>
    </div>

    <div class="bg-gray-50 p-4 border-t border-gray-100">
        <p class="text-xs text-gray-400">Sistem Presensi & QR Code</p>
    </div>
</div>

</body>
</html>
