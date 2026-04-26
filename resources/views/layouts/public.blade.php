<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $profil->nama_desa ?? 'Portal Desa' }} - Layanan Administrasi Digital">
    <title>@yield('title', $profil->nama_desa ?? 'Portal Desa') | SIAPS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script>
        if (localStorage.getItem('color-theme') === 'dark' ||
            (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-gray-50 dark:bg-gray-950 text-gray-800 dark:text-gray-200 antialiased">

    {{-- NAVBAR --}}
    <nav
        class="fixed top-0 left-0 right-0 z-50 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md border-b border-gray-200/60 dark:border-gray-700/60 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    @if (!empty($profil->logo_path))
                        <img src="{{ asset('storage/' . $profil->logo_path) }}" alt="Logo"
                            class="h-9 w-9 rounded-full object-cover">
                    @else
                        <div
                            class="h-9 w-9 rounded-full bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                            </svg>
                        </div>
                    @endif
                    <div>
                        <div class="text-sm font-bold text-gray-900 dark:text-white leading-tight">
                            {{ $profil->nama_desa ?? 'Desa Kami' }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $profil->kecamatan ? 'Kec. ' . $profil->kecamatan : 'Portal Layanan Digital' }}</div>
                    </div>
                </a>

                {{-- Desktop Nav --}}
                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('home') }}"
                        class="px-3 py-2 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-blue-600 dark:hover:text-blue-400 transition-colors {{ request()->routeIs('home') ? 'text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20' : '' }}">Beranda</a>
                    <a href="{{ route('public.profil') }}"
                        class="px-3 py-2 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-blue-600 dark:hover:text-blue-400 transition-colors {{ request()->routeIs('public.profil') ? 'text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20' : '' }}">Profil
                        Desa</a>
                    <a href="{{ Auth::check() && Auth::user()->role === 'masyarakat' ? route('masyarakat.pengajuan.index') : route('public.layanan') }}"
                        class="px-3 py-2 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-blue-600 dark:hover:text-blue-400 transition-colors {{ request()->routeIs('public.layanan') || request()->routeIs('masyarakat.pengajuan.*') ? 'text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20' : '' }}">Layanan
                        Surat</a>
                    <a href="{{ route('public.informasi') }}"
                        class="px-3 py-2 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-blue-600 dark:hover:text-blue-400 transition-colors {{ request()->routeIs('public.informasi*') ? 'text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/20' : '' }}">Informasi</a>
                </div>

                {{-- Right side --}}
                <div class="flex items-center gap-3">
                    {{-- Dark Mode Toggle --}}
                    <button id="theme-toggle"
                        class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <svg id="theme-sun" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                clip-rule="evenodd" />
                        </svg>
                        <svg id="theme-moon" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                        </svg>
                    </button>

                    @auth
                        @if (Auth::user()->role === 'masyarakat')
                            <a href="{{ route('masyarakat.profile') }}"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd" />
                                </svg>
                                Akun Saya
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm">
                                Panel Admin
                            </a>
                        @endif
                    @else
                        <a href="{{ route('masyarakat.pengajuan.index') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white text-sm font-semibold rounded-xl transition-all shadow-sm hover:shadow-md">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Ajukan Surat
                        </a>
                    @endauth

                    {{-- Mobile menu button --}}
                    <button id="mobile-menu-btn"
                        class="md:hidden p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div id="mobile-menu"
            class="hidden md:hidden border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 space-y-1">
            <a href="{{ route('home') }}"
                class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">Beranda</a>
            <a href="{{ route('public.profil') }}"
                class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">Profil
                Desa</a>
            <a href="{{ route('public.layanan') }}"
                class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">Layanan
                Surat</a>
            <a href="{{ route('public.informasi') }}"
                class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">Informasi</a>
        </div>
    </nav>

    {{-- MAIN CONTENT --}}
    <main class="pt-16">
        {{-- @if (session('info'))
            <div
                class="bg-blue-50 dark:bg-blue-900/20 border-b border-blue-200 dark:border-blue-800 px-4 py-3 text-center text-sm text-blue-700 dark:text-blue-300">
                {{ session('info') }}
            </div>
        @endif
        @if (session('success'))
            <div
                class="bg-green-50 dark:bg-green-900/20 border-b border-green-200 dark:border-green-800 px-4 py-3 text-center text-sm text-green-700 dark:text-green-300">
                {{ session('success') }}
            </div>
        @endif --}}

        {{ $slot }}
    </main>

    {{-- FOOTER --}}
    <footer class="bg-gray-900 dark:bg-gray-950 text-gray-300 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div
                            class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-bold text-white">{{ $profil->nama_desa ?? 'Desa Kami' }}</div>
                            @if ($profil->kecamatan)
                                <div class="text-xs text-gray-400">Kec. {{ $profil->kecamatan }},
                                    {{ $profil->kabupaten }}</div>
                            @endif
                        </div>
                    </div>
                    @if ($profil->visi)
                        <p class="text-sm text-gray-400 leading-relaxed italic">"{{ Str::limit($profil->visi, 120) }}"
                        </p>
                    @endif
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-4">Navigasi</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="hover:text-blue-400 transition-colors">Beranda</a>
                        </li>
                        <li><a href="{{ route('public.profil') }}"
                                class="hover:text-blue-400 transition-colors">Profil Desa</a></li>
                        <li><a href="{{ route('public.layanan') }}"
                                class="hover:text-blue-400 transition-colors">Layanan Surat</a></li>
                        <li><a href="{{ route('public.informasi') }}"
                                class="hover:text-blue-400 transition-colors">Informasi</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-4">Kontak</h4>
                    <ul class="space-y-2 text-sm">
                        @if ($profil->alamat_kantor)
                            <li class="flex gap-2"><svg class="w-4 h-4 mt-0.5 shrink-0 text-blue-400"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                        clip-rule="evenodd" />
                                </svg>{{ $profil->alamat_kantor }}</li>
                        @endif
                        @if ($profil->telepon)
                            <li class="flex gap-2"><svg class="w-4 h-4 shrink-0 text-blue-400" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>{{ $profil->telepon }}</li>
                        @endif
                        @if ($profil->email)
                            <li class="flex gap-2"><svg class="w-4 h-4 shrink-0 text-blue-400" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>{{ $profil->email }}</li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-6 text-center text-xs text-gray-500">
                &copy; {{ date('Y') }} {{ $profil->nama_desa ?? 'Desa Kami' }}. Sistem Informasi Administrasi
                Pelayanan Surat (SIAPS).
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>
    <script>
        // Dark mode toggle
        const btn = document.getElementById('theme-toggle');
        const moon = document.getElementById('theme-moon');
        const sun = document.getElementById('theme-sun');

        function updateIcons() {
            if (document.documentElement.classList.contains('dark')) {
                sun.classList.remove('hidden');
                moon.classList.add('hidden');
            } else {
                moon.classList.remove('hidden');
                sun.classList.add('hidden');
            }
        }
        updateIcons();
        btn?.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('color-theme', document.documentElement.classList.contains('dark') ? 'dark' :
                'light');
            updateIcons();
        });
        // Mobile menu
        document.getElementById('mobile-menu-btn')?.addEventListener('click', () => {
            document.getElementById('mobile-menu')?.classList.toggle('hidden');
        });
    </script>
    @stack('scripts')
</body>

</html>
