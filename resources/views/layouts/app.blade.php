<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title>{{ config('app.name', 'Absensi Siswa') }}</title>

    <!-- Fonts -->
    <!-- <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" /> -->
    <!-- <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}">
    <script src="{{ asset('build/assets/app.js') }}"></script> -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-white selection:bg-indigo-500/30">
    <div class="min-h-screen bg-[#020617] bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-slate-900 via-[#020617] to-[#020617]">
        {{-- Navigation --}}
        @include('layouts.navigation')

        {{-- Page Header --}}
        @isset($header)
        <header class="sticky top-0 z-40 bg-slate-900/50 backdrop-blur-md border-b border-white/5">
            <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-xl sm:text-2xl font-extrabold text-white tracking-tight">
                    {{ $header }}
                </h1>
                
                {{-- Navigation Desktop --}}
                <div class="hidden sm:flex items-center gap-6 mr-8 ml-auto">
                    <a href="{{ route('teacher.dashboard') }}" class="text-xs font-black uppercase tracking-widest {{ request()->routeIs('teacher.dashboard') ? 'text-indigo-400' : 'text-slate-400 hover:text-white' }} transition-colors">Dashboard</a>
                    <a href="{{ route('teacher.schedule') }}" class="text-xs font-black uppercase tracking-widest {{ request()->routeIs('teacher.schedule') ? 'text-indigo-400' : 'text-slate-400 hover:text-white' }} transition-colors">Jadwal</a>
                    <a href="{{ route('teacher.attendance.index') }}" class="text-xs font-black uppercase tracking-widest {{ request()->is('teacher/attendance*') ? 'text-indigo-400' : 'text-slate-400 hover:text-white' }} transition-colors">Rekap</a>
                </div>

                {{-- Logout Button Desktop/Header (Desktop Only) --}}
                <div class="hidden sm:block">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="group flex items-center px-5 py-2.5 bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white rounded-2xl transition-all duration-300 border border-red-500/20 text-xs font-bold uppercase tracking-widest active:scale-95 shadow-lg shadow-red-500/5">
                            <svg class="w-4 h-4 mr-2 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </header>
        @endisset

        {{-- Page Content --}}
        <main class="pb-32 sm:pb-12 pt-6">
            {{ $slot }}
        </main>

        {{-- Footer (Desktop Only) --}}
        <footer class="hidden sm:block py-10 border-t border-white/5 opacity-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-xs font-medium tracking-widest uppercase">
                &copy; {{ date('Y') }} &bull; Absensi Siswa &bull; Premium Experience
            </div>
        </footer>

    </div>

    @stack('scripts')
</body>

</html>