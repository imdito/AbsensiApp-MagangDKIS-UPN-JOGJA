@extends('layouts.admin')

@section('header_title', 'Tambah SKPD Baru')

@section('content')
    <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-sm border border-gray-100 p-8">

        <form action="{{ route('skpd.store') }}" method="POST">
            @csrf

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Instansi / SKPD <span class="text-red-500">*</span></label>
                <input type="text" name="nama_skpd" value="{{ old('nama') }}"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none @error('nama_skpd') border-red-500 @else border-gray-300 @enderror"
                       placeholder="Contoh: Dinas Komunikasi dan Informatika">

                @error('nama_skpd')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Kantor</label>
                <textarea name="alamat" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                          placeholder="Jalan Raya No. 123...">{{ old('alamat') }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon (Opsional)</label>
                <input type="text" name="telepon" value="{{ old('telepon') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                       placeholder="021-xxxxxx">
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('skpd.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-medium">Batal</a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium shadow-md transition-transform transform active:scale-95">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
@endsection

