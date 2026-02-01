<div>
    <label for="id_skpd" class="block text-sm font-medium text-gray-700 mb-2">
        Pilih SKPD / Instansi
    </label>
    <div class="relative">
        <select name="id_skpd" id="id_skpd"
                class="appearance-none block w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 text-gray-900 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all cursor-pointer"
                required>
            <option value="" disabled selected>-- Pilih Instansi --</option>
            @foreach($skpds as $skpd)
                <option value="{{ $skpd->id }}">{{ $skpd->nama }}</option>
            @endforeach
        </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </div>
</div>
