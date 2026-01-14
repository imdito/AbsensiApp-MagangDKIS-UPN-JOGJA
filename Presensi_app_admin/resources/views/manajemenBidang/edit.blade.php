@extends('layouts.app')

@section('title', 'Edit Bidang')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h2 class="text-xl font-bold text-gray-800">Edit Bidang</h2>
            <a href="{{ route('bidang.index') }}" class="text-gray-500 hover:text-gray-700 text-sm">&larr; Kembali</a>
        </div>

        <form action="{{ route('bidang.update', $bidang->id_bidang) }}" method="POST">
            @csrf
            @method('PUT') {{-- PENTING: Untuk update data --}}

            {{-- Input Kode Bidang --}}
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Kode Bidang</label>
                <input type="text" name="kode_bidang" value="{{ old('kode_bidang', $bidang->kode_bidang) }}"
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('kode_bidang') border-red-500 @enderror">
                @error('kode_bidang')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Nama Bidang --}}
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Bidang</label>
                <input type="text" name="nama_bidang" value="{{ old('nama_bidang', $bidang->nama_bidang) }}"
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('nama_bidang') border-red-500 @enderror">
                @error('nama_bidang')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Submit --}}
            <div class="flex justify-end gap-3">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700">Update Data</button>
            </div>
        </form>
    </div>
@endsection
