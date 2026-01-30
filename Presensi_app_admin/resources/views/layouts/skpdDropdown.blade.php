<div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2">Instansi / SKPD</label>
    <select name="id_skpd"
            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white @error('id_skpd') border-red-500 @enderror">
        <option value="" selected disabled>-- Pilih SKPD --</option>
        @foreach($daftar_skpd as $skpd)
            <option value="{{ $skpd->id }}" {{ old('id_skpd') == $skpd->id ? 'selected' : '' }}>
                {{ $skpd->nama }}
            </option>
        @endforeach
    </select>
    @error('id_skpd')
    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
    @enderror
</div>
