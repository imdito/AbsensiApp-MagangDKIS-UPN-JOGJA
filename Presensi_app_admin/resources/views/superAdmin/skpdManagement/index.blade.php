@extends('layouts.admin')

@section('header_title', 'Manajemen SKPD')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">

        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-gray-800">Daftar Instansi (SKPD)</h3>
            <a href="{{ route('skpd.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                <i class="fa-solid fa-plus mr-2"></i> Tambah SKPD
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 text-green-700 p-4 rounded-lg mb-4 text-sm border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-3">No</th>
                    <th class="px-6 py-3">Nama SKPD</th>
                    <th class="px-6 py-3">Alamat</th>
                    <th class="px-6 py-3">Telepon</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                @foreach($skpds as $index => $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-gray-500">{{ $skpds->firstItem() + $index }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $item->nama }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $item->alamat ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $item->telepon ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('skpd.edit', $item->id) }}" class="text-yellow-500 hover:text-yellow-600 border border-yellow-200 bg-yellow-50 px-3 py-1 rounded-md transition-colors">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <form action="{{ route('skpd.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus SKPD ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600 border border-red-200 bg-red-50 px-3 py-1 rounded-md transition-colors">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $skpds->links() }}
        </div>
    </div>
@endsection
