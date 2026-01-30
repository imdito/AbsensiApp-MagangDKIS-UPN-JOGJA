@extends($layout)

@section($layout=='layouts.app' ? 'title' : 'header_title', 'Data Bidang')

@section('content')
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md border border-gray-100">
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h2 class="text-xl font-bold text-gray-800">Tambah Bidang Baru</h2>
            <a href="{{ route('bidang.index') }}" class="text-gray-500 hover:text-gray-700 text-sm transition-colors">&larr; Kembali</a>
        </div>

        <form action="{{ route('bidang.store') }}" method="POST">
            @csrf

            @if($layout == 'layouts.admin')
                @include('layouts.skpdDropdown', ['daftar_skpd' => $daftar_skpd])
            @endif

            {{-- Input Kode Bidang --}}
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Kode Bidang</label>
                <input type="text" name="kode_bidang" value="{{ old('kode_bidang') }}"
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('kode_bidang') border-red-500 @enderror"
                       placeholder="Contoh: IT">
                @error('kode_bidang')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Nama Bidang --}}
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Bidang</label>
                <input type="text" name="nama_bidang" value="{{ old('nama_bidang') }}"
                       class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('nama_bidang') border-red-500 @enderror"
                       placeholder="Contoh: Information Technology">
                @error('nama_bidang')
                <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Submit --}}
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <button type="reset" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">Reset</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 shadow-md transition-all active:scale-95">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
@endsection
