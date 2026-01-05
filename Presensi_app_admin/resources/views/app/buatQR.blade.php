<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Absensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 h-screen flex items-center justify-center">

<div class="bg-white p-8 rounded-2xl shadow-xl text-center max-w-md w-full border border-gray-200">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">{{ $namaKelas }}</h1>
        <p class="text-gray-500 mt-1">{{ $tanggal }}</p>
        <span class="inline-block bg-green-100 text-green-700 text-xs font-semibold px-2 py-1 rounded-full mt-2">
                Sesi Aktif
            </span>
    </div>

    <div class="flex justify-center items-center mb-6 bg-gray-50 p-4 rounded-lg border border-dashed border-gray-300">
        <div class="bg-white p-2">
            {!! QrCode::size(250)->backgroundColor(255, 255, 255)->generate($qrData) !!}
        </div>
    </div>

    <div class="space-y-4">
        <p class="text-sm text-gray-600">
            Silakan scan QR di atas menggunakan aplikasi mobile atau kamera HP untuk melakukan presensi.
        </p>

        <button onclick="window.location.reload();" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center justify-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
            Perbarui QR
        </button>

        <a href="{{ url()->previous() }}" class="block text-sm text-gray-400 hover:text-gray-600 mt-4">
            &larr; Kembali ke Dashboard
        </a>
    </div>
</div>

</body>
</html>
