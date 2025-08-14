<nav>
    <!-- User Profile -->
    <div class="flex items-center mb-6">
        <img src="{{ Auth::user()->profile_photo ? Storage::url(Auth::user()->profile_photo) : 'https://via.placeholder.com/40' }}"
            alt="Profile Photo" class="w-10 h-10 rounded-full mr-3 flex-shrink-0">

        {{-- Div pembungkus untuk teks --}}
        <div>
            <p class="text-lg font-semibold leading-tight">{{ Auth::user()->name }}</p>
            <div class="text-sm text-gray-300">
                @if (Auth::user()->role === 'unit_kerja' && Auth::user()->unitKerja)
                    {{-- Jika rolenya unit_kerja dan unitnya ada, tampilkan nama unit --}}
                    <span>{{ Auth::user()->unitKerja->nama_unit }}</span>
                @else
                    {{-- Jika tidak, tampilkan nama role seperti biasa --}}
                    <span class="capitalize">{{ str_replace('_', ' ', Auth::user()->role) }}</span>
                @endif
            </div>
        </div>
    </div>
    <hr class="border-gray-600 mb-4">

    <!-- Menu -->
    <ul class="space-y-2">
        @if ($role === 'tim_sakip')
            <li>
                <a href="{{ route('pohon-kinerja.index') }}"
                    class="flex items-center px-4 py-2 rounded hover:bg-blue-700 {{ Route::is('pohon-kinerja.index') ? 'bg-blue-700' : '' }}">
                    <i class="fas fa-sitemap mr-2"></i> Kelola Pohon Kinerja
                </a>
            </li>
            <li>
                <a href="{{ route('monitoring.laporan.index') }}"
                    class="flex items-center px-4 py-2 rounded hover:bg-blue-700 {{ Route::is('monitoring.laporan.index') ? 'bg-blue-700' : '' }}">
                    <i class="fas fa-binoculars mr-2"></i> Monitoring Laporan
                </a>
            </li>

            <li>
                <a href="{{ route('users.index') }}"
                    class="flex items-center px-4 py-2 rounded hover:bg-blue-700 {{ Route::is('users.*') ? 'bg-blue-700' : '' }}">
                    <i class="fas fa-users mr-2"></i> Manajemen User
                </a>
            </li>

            <li>
                <a href="{{ route('unit-kerja.index') }}"
                    class="flex items-center px-4 py-2 rounded hover:bg-blue-700 {{ Route::is('unit-kerja.*') ? 'bg-blue-700' : '' }}">
                    <i class="fas fa-building mr-2"></i> Manajemen Unit Kerja
                </a>
            </li>

            <li>
                <a href="{{ route('laporan.index') }}"
                    class="flex items-center px-4 py-2 rounded hover:bg-blue-700 {{ Route::is('laporan.index') ? 'bg-blue-700' : '' }}">
                    <i class="fas fa-download mr-2"></i> Download Laporan
                </a>
            </li>
            <li>
                <a href="{{ route('laporan.pdf') }}"
                    class="flex items-center px-4 py-2 rounded hover:bg-blue-700 {{ Route::is('laporan.pdf') ? 'bg-blue-700' : '' }}">
                    <i class="fas fa-file-pdf mr-2"></i> Report PDF
                </a>
            </li>
        @elseif($role === 'evaluator')
            <li>
                <a href="{{ route('evaluator.dashboard') }}"
                    class="flex items-center px-4 py-2 rounded hover:bg-blue-700 {{ Route::is('evaluator.dashboard') ? 'bg-blue-700' : '' }}">
                    <i class="fas fa-tasks mr-2"></i> Dashboard Evaluator
                </a>
            </li>
        @elseif($role === 'unit_kerja')
            <li>
                <a href="{{ route('realisasi.index') }}"
                    class="flex items-center px-4 py-2 rounded hover:bg-blue-700 {{ Route::is('realisasi.*') ? 'bg-blue-700' : '' }}">
                    <i class="fas fa-pen-alt mr-2"></i> Lapor Realisasi Kinerja
                </a>
            </li>
        @endif
        <li>
            <a href="{{ route('profile.edit') }}"
                class="flex items-center px-4 py-2 rounded hover:bg-blue-700 {{ Route::is('profile.edit') ? 'bg-blue-700' : '' }}">
                <i class="fas fa-user-edit mr-2"></i> Update Profile
            </a>
        </li>
        <hr class="border-gray-600 my-2">
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center w-full text-left px-4 py-2 rounded hover:bg-blue-700">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </button>
            </form>
        </li>
    </ul>
</nav>
