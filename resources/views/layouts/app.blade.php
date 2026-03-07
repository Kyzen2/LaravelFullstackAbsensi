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
        <header class="bg-slate-800/70 backdrop-blur-md border-b border-slate-700 sticky top-0 z-40">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-xl sm:text-2xl font-semibold text-white truncate mr-4">
                    {{ $header }}
                </h1>
                
                {{-- Logout Button Desktop/Header (Desktop Only) --}}
                <div class="hidden sm:block">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-xl transition-all text-xs font-black uppercase tracking-widest active:scale-95 shadow-lg shadow-red-900/20">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Keluar
                        </button>
                    </form>
                </div>
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