<nav class="bg-white border-b border-gray-200 sticky top-0 z-50 mb-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- UBAH DISINI: h-16 menjadi h-24 agar lebih tinggi --}}
        <div class="flex justify-between h-24">
            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center gap-3">
                        {{-- UBAH DISINI: h-10 menjadi h-16 agar logo proporsional --}}
                        <img src="{{ asset('logo-pemkot.png') }}"
                             alt="Logo Pemkot"
                             class="h-16 w-auto object-contain">
                        <img src="{{ asset('logoDKIS.png') }}"
                             alt="Logo DKIS"
                             class="h-16 w-auto object-contain">
                    </a>
                </div>
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    <a href="{{ url('/') }}"
                       class="{{ request()->is('/') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Dashboard
                    </a>

                    <a href="{{ url('/karyawan') }}"
                       class="{{ request()->is('karyawan*') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Data ASN
                    </a>

                    <a href="{{url('/bidang') }}"
                       class="{{ request()->routeIs('bidang.index') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Data Bidang
                    </a>

                    <a href="{{ route('laporan.index') }}"
                       class="{{ request()->routeIs('laporan.index') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                        Laporan
                    </a>

                </div>
            </div>
            <div class="flex items-center">
                <form action="{{url('/logout')}}" method="POST">
                    @csrf
                    <button type="submit" class="text-gray-500 hover:text-red-600 px-3 py-2 text-sm font-medium flex items-center gap-2">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
