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
                            @php
                                $displayName = Auth::user()->biodata->nama_lengkap ?? Auth::user()->name;
                                $displayInitial = substr($displayName, 0, 2);
                                $displayShortName = explode(' ', $displayName)[0];
                                $unreadNotifs = Auth::user()->unreadNotifications;
                            @endphp

                            {{-- Notification Bell --}}
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" @click.outside="open = false"
                                    class="relative p-2 text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-xl transition-all">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    </svg>
                                    @if ($unreadNotifs->count() > 0)
                                        <span
                                            class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-red-500 rounded-full ring-2 ring-white dark:ring-gray-900 border-none"></span>
                                    @endif
                                </button>

                                {{-- Notification Dropdown --}}
                                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                    x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                                    class="absolute right-0 mt-3 w-80 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-xl overflow-hidden z-50 text-left"
                                    style="display: none;">
                                    <div
                                        class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-800/50">
                                        <h3
                                            class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-wider">
                                            Notifikasi</h3>
                                        @if ($unreadNotifs->count() > 0)
                                            <form action="{{ route('masyarakat.notifications.readAll') }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="text-[10px] font-bold text-blue-600 dark:text-blue-400 hover:underline">Tandai
                                                    Semua Dibaca</button>
                                            </form>
                                        @endif
                                    </div>
                                    <div class="max-h-80 overflow-y-auto">
                                        @forelse($unreadNotifs as $notification)
                                            <div
                                                class="p-4 border-b border-gray-50 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors {{ $notification->read_at ? 'opacity-75' : '' }}">
                                                <p class="text-xs font-bold text-gray-900 dark:text-gray-100">
                                                    {{ $notification->data['message'] ?? 'Status pengajuan diperbarui.' }}
                                                </p>
                                                <div class="mt-2 flex items-center justify-between">
                                                    <span
                                                        class="text-[10px] text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                                                    @if (isset($notification->data['url']))
                                                        <a href="{{ $notification->data['url'] }}"
                                                            class="text-[10px] font-bold text-blue-600 dark:text-blue-400 hover:underline inline-flex items-center gap-1">Lihat
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M9 5l7 7-7 7" />
                                                            </svg></a>
                                                    @endif
                                                </div>
                                            </div>
                                        @empty
                                            <div class="p-6 text-center">
                                                <svg class="w-8 h-8 mx-auto text-gray-300 dark:text-gray-600 mb-2"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                                </svg>
                                                <p class="text-xs font-bold text-gray-500">Belum ada notifikasi</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                            {{-- Account Dropdown --}}
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" @click.outside="open = false"
                                    class="inline-flex items-center gap-2 pl-3 pr-2 py-1.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-all shadow-sm">
                                    <div
                                        class="w-7 h-7 bg-blue-600 rounded-lg flex items-center justify-center text-white text-[10px] font-black uppercase ring-2 ring-blue-50 dark:ring-blue-900/40">
                                        {{ $displayInitial }}
                                    </div>
                                    <span
                                        class="text-sm font-semibold text-gray-700 dark:text-gray-200 hidden sm:block">{{ $displayShortName }}</span>
                                    <svg class="w-4 h-4 text-gray-400 transition-transform"
                                        :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                {{-- Dropdown Panel --}}
                                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                    x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                                    class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-xl z-50 overflow-hidden"
                                    style="display: none;">

                                    <div
                                        class="px-4 py-3 bg-gray-50/50 dark:bg-gray-700/30 border-b border-gray-100 dark:border-gray-700">
                                        <p
                                            class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-0.5">
                                            Akun Terdaftar</p>
                                        <p class="text-sm font-black text-gray-900 dark:text-white truncate">
                                            {{ $displayName }}</p>
                                    </div>

                                    <div class="p-1.5">
                                        <a href="{{ route('masyarakat.profile') }}"
                                            class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/60 rounded-xl transition-colors group">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                            Profil & Data Diri
                                        </a>
                                        <a href="{{ route('masyarakat.pengajuan.index') }}"
                                            class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/60 rounded-xl transition-colors group">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 flex items-center justify-center group-hover:bg-amber-600 group-hover:text-white transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            Riwayat Pengajuan
                                        </a>

                                        <div class="my-1.5 border-t border-gray-100 dark:border-gray-700"></div>

                                        <form method="POST" action="{{ route('auth.logout') }}">
                                            @csrf
                                            <button type="submit"
                                                class="w-full flex items-center gap-3 px-3 py-2.5 text-sm font-bold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-colors group">
                                                <div
                                                    class="w-8 h-8 rounded-lg bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 flex items-center justify-center group-hover:bg-red-600 group-hover:text-white transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                                    </svg>
                                                </div>
                                                Keluar Aplikasi
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('dashboard') }}"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm">
                                Panel Admin
                            </a>
                        @endif
                    @else
                        <a href="{{ Auth::check() && Auth::user()->role === 'masyarakat' ? route('masyarakat.pengajuan.index') : route('auth.phone') }}"
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
