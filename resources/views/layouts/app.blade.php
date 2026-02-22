<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Absensi Siswa') }}</title>

    <!-- Fonts -->
    <!-- <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" /> -->
    <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
    <script src="{{ asset('build/assets/app.js') }}"></script>
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-900 text-white">
    <div class="min-h-screen bg-slate-900">
        {{-- Navigation --}}
        @include('layouts.navigation')

        {{-- Page Header --}}
        @isset($header)
        <header class="bg-slate-800/70 backdrop-blur-md border-b border-slate-700">
            <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                <h1 class="text-xl sm:text-2xl font-semibold text-white">
                    {{ $header }}
                </h1>
            </div>
        </header>
        @endisset

        {{-- Page Content --}}
        <main class="pb-20">
            {{ $slot }}
        </main>

        {{-- Footer --}}
        <footer class="bg-slate-800 border-t border-slate-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 text-center text-sm text-slate-400">
                © {{ date('Y') }} Absensi Siswa • Laravel Fullstack
            </div>
        </footer>

    </div>

    @stack('scripts')
</body>

</html>