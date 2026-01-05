<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>jago</title>
</head>
<body>
    <h1>Selamat datang {{$nama}} Anda Sudah Membuat Route pada Laravel</h1>
    <h3>Belajar Route kirim</h3>
    <form action="/kirim" method="POST">
        @csrf
        <input type="text" name="nama" placeholder="Masukkan Nama">
        <button type="submit">Kirim</button>
    </form>
</body>
</html>