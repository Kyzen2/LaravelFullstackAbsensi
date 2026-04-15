<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-indigo-500/20 flex items-center justify-center text-indigo-400 border border-indigo-500/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">
                Pusat Guru
            </h2>
        </div>
    </x-slot>

    <div class="py-6 space-y-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

            <!-- Hero Section -->
            <div class="relative overflow-hidden rounded-[40px] glass-card p-8 sm:p-12 border-white/5">
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 bg-indigo-500/10 blur-[100px] rounded-full"></div>
                <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 bg-emerald-500/5 blur-[100px] rounded-full"></div>
                
                <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-10">
                    <div class="space-y-6">
                        <div class="space-y-2">
                            <h1 class="text-4xl sm:text-5xl font-black text-white tracking-tight leading-none">
                                Halo,  <span class="text-indigo-400">{{ Auth::user()->name }}</span> 👋
                            </h1>
                            <p class="text-slate-400 text-lg font-medium max-w-md italic opacity-80">
                                "Mengajar adalah menyentuh masa depan selamanya." 
                            </p>
                        </div>
                        
                        <!-- Real-time Clock -->
                        <div class="inline-flex flex-col p-6 rounded-3xl bg-white/5 border border-white/5 backdrop-blur-xl">
                            <div id="realtime-clock" class="text-5xl sm:text-6xl font-black text-white tracking-tighter tabular-nums leading-none">
                                00:00:00
                            </div>
                            <div id="realtime-date" class="text-xs font-bold uppercase tracking-[0.4em] text-indigo-400/80 mt-3 pl-1">
                                Loading date...
                            </div>
                        </div>
                    </div>
                    
                    <div class="shrink-0">
                        <a href="{{ route('teacher.qr.current') }}" 
                           class="btn-premium group py-5 px-10 text-lg shadow-2xl shadow-indigo-500/40 hover:scale-[1.02] active:scale-95">
                            <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center transition-transform group-hover:rotate-12">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 17h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                            </div>
                            Tampilkan QR Presensi
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Stat Card 1 -->
                <div class="glass-card p-8 rounded-[32px] group hover:border-indigo-500/30 transition-all duration-500">
                    <div class="flex items-center justify-between mb-6">
                        <a href="{{ route('teacher.reports.index') }}" class="w-14 h-14 rounded-2xl bg-indigo-500/10 flex items-center justify-center text-indigo-400 border border-indigo-500/10 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 17v-2m3 2v-4m3 2v-6m-8-4h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </a>
                        <span class="text-[10px] font-black uppercase tracking-widest text-slate-500 group-hover:text-indigo-400 transition-colors">Rekap Laporan</span>
                    </div>
                    <p class="text-slate-400 text-sm font-bold uppercase tracking-wider mb-1">Presensi Hari Ini</p>
                    <h3 class="text-5xl font-black text-white tracking-tight">{{ $todayStats['total_absen'] }} <span class="text-lg text-slate-500 font-medium">Siswa</span></h3>
                </div>

                @if($currentSchedule)
                <!-- Current Session Alert -->
                <div class="md:col-span-2 glass-card p-6 rounded-[32px] border-emerald-500/30 bg-emerald-500/5 relative overflow-hidden flex flex-col sm:flex-row items-center justify-between gap-6 animate-pulse">
                    <div class="flex items-center gap-4 relative z-10">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-500/20 flex items-center justify-center text-emerald-400 border border-emerald-500/20">
                            <span class="relative flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                            </span>
                        </div>
                        <div>
                            <h4 class="text-white font-black text-sm uppercase tracking-widest leading-none mb-1">KBM Sedang Berlangsung</h4>
                            <p class="text-emerald-400/80 text-[10px] font-bold uppercase tracking-[0.2em]">{{ $currentSchedule->mapel->nama_mapel }} &bull; {{ $currentSchedule->kelas->nama_kelas }}</p>
                        </div>
                    </div>
                    
                    @php 
                        $currentSesi = \App\Models\SesiPresensi::where('jadwal_id', $currentSchedule->id)->where('tanggal', now()->format('Y-m-d'))->first();
                    @endphp

                    <div class="flex gap-2 w-full sm:w-auto relative z-10">
                        @if($currentSesi) 
                        <a href="{{ route('teacher.session.detail', $currentSesi) }}" class="flex-1 sm:flex-none px-6 py-3 rounded-2xl bg-emerald-500 text-white font-black text-[10px] uppercase tracking-widest hover:bg-emerald-600 transition-all shadow-lg shadow-emerald-500/20">
                            Kelola Kehadiran
                        </a>
                        @endif
                        <a href="{{ route('teacher.qr.current') }}" class="flex-1 sm:flex-none px-6 py-3 rounded-2xl bg-white/10 text-white font-black text-[10px] uppercase tracking-widest hover:bg-white/20 transition-all border border-white/10">
                            Buka QR
                        </a>
                    </div>
                </div>
                @endif

                <!-- Next Schedule Card -->
                <div class="glass-card p-8 rounded-[32px] group hover:border-emerald-500/30 transition-all duration-500 relative overflow-hidden">
                    @if($nextSchedule)
                    <div class="absolute top-0 right-0 p-4">
                        <span class="px-3 py-1 bg-emerald-500/10 border border-emerald-500/20 rounded-full text-[9px] font-black text-emerald-400 uppercase tracking-widest animate-pulse">Selanjutnya</span>
                    </div>
                    
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-emerald-400 border border-emerald-500/10 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <p class="text-slate-400 text-sm font-bold uppercase tracking-wider mb-1">Mulai Jam {{ \Carbon\Carbon::parse($nextSchedule->jam_mulai)->format('H:i') }}</p>
                    <h3 class="text-2xl font-black text-white tracking-tight leading-tight group-hover:text-emerald-400 transition-colors">
                        {{ $nextSchedule->mapel->nama_mapel }}
                        <span class="block text-sm text-slate-500 font-bold uppercase tracking-widest mt-1">{{ $nextSchedule->kelas->nama_kelas }}</span>
                    </h3>
                    @else
                    <div class="flex items-center justify-between mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-slate-500/10 flex items-center justify-center text-slate-500 border border-white/5 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    </div>
                    <p class="text-slate-400 text-sm font-bold uppercase tracking-wider mb-1">Status Mengajar</p>
                    <h3 class="text-2xl font-black text-slate-500 tracking-tight leading-tight">Tidak Ada Jadwal Lagi</h3>
                    @endif
                </div>
            </div>

            <!-- All Schedules (Desktop Only) -->
            <div class="hidden sm:block space-y-6">
                <div class="flex items-center gap-4">
                    <h3 class="text-2xl font-black text-white tracking-tight">Semua Jadwal</h3>
                    <div class="flex-1 h-px bg-white/5"></div>
                </div>

                @if($schedules->isEmpty())
                <div class="glass-card p-12 rounded-[40px] text-center border-dashed">
                    <div class="w-20 h-20 bg-slate-800/50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-600">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h4 class="text-xl font-bold text-white mb-2">Belum ada jadwal</h4>
                    <p class="text-slate-500">Mungkin saatnya menikmati waktu luang sejenak?</p>
                </div>
                @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($schedules as $j)
                    <div class="glass-card p-6 rounded-[32px] group hover:bg-slate-800/60 transition-all duration-300 relative overflow-hidden">
                        <!-- BG Icon -->
                        <div class="absolute -right-4 -bottom-4 text-white/[0.03] rotate-12 transition-transform group-hover:scale-125 group-hover:text-indigo-500/10">
                            <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2 .172V17a1 1 0 001 1z"></path></svg>
                        </div>

                        <div class="relative space-y-6">
                            <div class="flex items-start justify-between">
                                <div class="w-14 h-14 rounded-2xl bg-slate-700/50 flex items-center justify-center text-2xl font-black text-white border border-white/5 shadow-xl">
                                    {{ strtoupper(substr($j->mapel->nama_mapel, 0, 1)) }}
                                </div>
                                <div class="text-right">
                                    <span class="px-3 py-1 bg-white/5 border border-white/10 rounded-full text-[10px] font-black uppercase tracking-widest text-slate-400 {{ $j->hari == $hariIni ? 'text-indigo-400 border-indigo-500/20 bg-indigo-500/5' : '' }}">
                                        {{ $j->hari }}
                                    </span>
                                </div>
                            </div>

                            <div>
                                <h4 class="text-xl font-black text-white leading-tight mb-2 group-hover:text-indigo-400 transition-colors">{{ $j->mapel->nama_mapel }}</h4>
                                <p class="text-sm text-slate-400 font-bold flex items-center gap-2">
                                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    {{ $j->kelas->nama_kelas }}
                                </p>
                                <p class="text-xs text-slate-500 font-medium mt-1 ml-6 italic">
                                    {{ $j->lokasi->nama_lokasi }}
                                </p>
                            </div>

                            <div class="pt-6 border-t border-white/5 flex items-center justify-between">
                                <div class="flex items-center text-slate-400">
                                    <svg class="w-4 h-4 mr-2 text-indigo-400/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span class="text-[11px] font-black tracking-widest leading-none uppercase">
                                        {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} &mdash; {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            
            const dayName = days[now.getDay()];
            const day = now.getDate();
            const monthName = months[now.getMonth()];
            const year = now.getFullYear();

            const timeEl = document.getElementById('realtime-clock');
            const dateEl = document.getElementById('realtime-date');
            
            if (timeEl) timeEl.textContent = `${hours}:${minutes}:${seconds}`;
            if (dateEl) dateEl.textContent = `${dayName}, ${day} ${monthName} ${year}`;
        }

        setInterval(updateClock, 1000);
        updateClock();
    </script>
    @endpush
</x-app-layout>
