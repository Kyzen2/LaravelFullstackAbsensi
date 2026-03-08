<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

        <title>{{ config('app.name', 'Absensi') }} &mdash; Premium Portal</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased text-white selection:bg-indigo-500/30">
        <div class="min-h-screen bg-[#020617] relative flex flex-col justify-center overflow-hidden">
            <!-- Background Orbs -->
            <div class="absolute top-0 -left-4 w-72 h-72 bg-indigo-600 rounded-full mix-blend-multiply filter blur-[128px] opacity-20 animate-blob"></div>
            <div class="absolute top-0 -right-4 w-72 h-72 bg-emerald-600 rounded-full mix-blend-multiply filter blur-[128px] opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-600 rounded-full mix-blend-multiply filter blur-[128px] opacity-20 animate-blob animation-delay-4000"></div>

            <!-- Content -->
            <div class="relative max-w-7xl mx-auto px-6 py-20 w-full flex flex-col items-center text-center space-y-12">
                <!-- Logo/Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass-card border-white/10 animate-fade-in-down">
                    <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                    <span class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-300">Sistem Absensi Next-Gen</span>
                </div>

                <!-- Main Heading -->
                <div class="space-y-6 max-w-4xl">
                    <h1 class="text-6xl sm:text-8xl font-black tracking-tighter leading-[0.9] text-white">
                        Digital <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-emerald-400">Attendance</span> 
                        <br class="hidden sm:block"> for Schools.
                    </h1>
                    <p class="text-slate-400 text-lg sm:text-xl font-medium max-w-2xl mx-auto leading-relaxed opacity-80">
                        Platform presensi modern berbasis QR Code yang simpel, cepat, dan transparan. Kelola kehadiran kelas hanya dalam satu klik.
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row items-center gap-6 w-full max-w-md justify-center">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-premium w-full py-5 text-sm uppercase tracking-widest shadow-2xl">
                            Buka Dashboard
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-premium w-full py-5 text-sm uppercase tracking-widest shadow-2xl">
                            Masuk Sekarang
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </a>
                        
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="w-full py-5 rounded-2xl border border-white/10 glass-card hover:bg-white/5 transition-all text-sm font-bold uppercase tracking-widest active:scale-95">
                                Daftar Siswa
                            </a>
                        @endif
                    @endauth
                </div>

                <!-- Feature Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 w-full pt-12 border-t border-white/5">
                    <div class="p-6 text-left space-y-4">
                        <div class="w-10 h-10 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-400 font-black">01</div>
                        <h4 class="font-black text-white uppercase tracking-wider text-sm">Scan QR Cepat</h4>
                        <p class="text-xs text-slate-500 font-medium leading-relaxed">Presensi hanya hitungan detik melalui kamera HP siswa.</p>
                    </div>
                    <div class="p-6 text-left space-y-4">
                        <div class="w-10 h-10 rounded-xl bg-emerald-400/10 flex items-center justify-center text-emerald-400 font-black">02</div>
                        <h4 class="font-black text-white uppercase tracking-wider text-sm">Real-time Data</h4>
                        <p class="text-xs text-slate-500 font-medium leading-relaxed">Guru langsung melihat siapa yang hadir secara instan.</p>
                    </div>
                    <div class="p-6 text-left space-y-4">
                        <div class="w-10 h-10 rounded-xl bg-pink-500/10 flex items-center justify-center text-pink-400 font-black">03</div>
                        <h4 class="font-black text-white uppercase tracking-wider text-sm">Keamanan Tinggi</h4>
                        <p class="text-xs text-slate-500 font-medium leading-relaxed">QR Code dinamis untuk mencegah manipulasi kehadiran.</p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="mt-auto py-10 text-center border-t border-white/5">
                 <p class="text-[10px] font-black uppercase tracking-[0.5em] text-slate-600">
                    &copy; {{ date('Y') }} &bull; Next-Gen School Attendance &bull; Laravel + Tailwind
                 </p>
            </footer>
        </div>

        <style>
            @keyframes blob {
                0% { transform: translate(0px, 0px) scale(1); }
                33% { transform: translate(30px, -50px) scale(1.1); }
                66% { transform: translate(-20px, 20px) scale(0.9); }
                100% { transform: translate(0px, 0px) scale(1); }
            }
            .animate-blob {
                animation: blob 7s infinite;
            }
            .animation-delay-2000 {
                animation-delay: 2s;
            }
            .animation-delay-4000 {
                animation-delay: 4s;
            }
        </style>
    </body>
</html>
