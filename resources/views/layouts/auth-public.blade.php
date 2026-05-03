<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Masuk') | SIAPS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
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

<body
    class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 dark:from-gray-950 dark:via-gray-900 dark:to-indigo-950 antialiased">

    <div class="min-h-screen flex flex-col justify-center items-center px-4 py-12">
        {{-- Back to home --}}
        <a href="{{ route('home') }}"
            class="absolute top-6 left-6 flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>

        {{-- Logo --}}
        <div class="mb-8 text-center">
            <a href="/">
                <x-application-logo class="w-24 h-24 mx-auto mb-4 drop-shadow-md" />
            </a>
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">SIAPS</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Sistem Informasi Administrasi Pelayanan Surat</p>
        </div>

        {{-- Card --}}
        <div class="w-full max-w-md">
            <div
                class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl shadow-2xl rounded-3xl border border-white/20 dark:border-gray-800/50 p-8">
                {{ $slot }}
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>
</body>

</html>
