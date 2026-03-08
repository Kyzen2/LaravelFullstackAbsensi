    <x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-indigo-500/20 flex items-center justify-center text-indigo-400 border border-indigo-500/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
            </div>
            <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">
                Student Hub
            </h2>
        </div>
    </x-slot>

    <div class="py-6 space-y-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            
            <!-- Hero Header -->
            <div class="relative overflow-hidden rounded-[40px] glass-card p-8 sm:p-12 border-white/5">
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 bg-indigo-500/10 blur-[100px] rounded-full"></div>
                
                <div class="relative space-y-8">
                    <div class="space-y-2">
                        <h1 class="text-4xl sm:text-5xl font-black text-white tracking-tight leading-none">
                            Halo, <span class="text-indigo-400">{{ Auth::user()->name }}</span> 👋
                        </h1>
                        <p class="text-slate-400 text-lg font-medium italic opacity-80">Siap belajar hal baru hari ini?</p>
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
            </div>

            <!-- Scan Action Hero -->
            <div class="relative group rounded-[40px] overflow-hidden p-1 bg-gradient-to-br from-indigo-500/20 to-emerald-500/20 border border-white/5">
                <div class="glass-card p-10 flex flex-col items-center text-center rounded-[38px] border-none shadow-none">
                    <div class="w-24 h-24 bg-indigo-500/10 rounded-[32px] flex items-center justify-center mb-8 border border-indigo-500/20 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
                        <svg class="w-12 h-12 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 17h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-white tracking-tight mb-3">Absensi Masuk</h3>
                    <p class="text-slate-400 text-sm font-medium mb-10 max-w-[280px] leading-relaxed opacity-70">Arahkan kamera ke QR Code yang ditampilkan oleh gurumu untuk mencatat kehadiran.</p>
                    <a href="{{ route('student.scan') }}" class="btn-premium w-full max-w-xs py-5 text-sm uppercase tracking-[0.2em] shadow-indigo-500/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                        Buka Scanner
                    </a>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 gap-6">
                <div class="glass-card p-6 rounded-[32px] group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-400 border border-indigo-500/10">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Lifetime</span>
                    </div>
                    <h3 class="text-3xl font-black text-white tracking-tight">{{ $stats['total_absen'] }}</h3>
                    <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-1">Total Hadir</p>
                </div>

                <div class="glass-card p-6 rounded-[32px] group border-emerald-500/10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-400 border border-emerald-500/10">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Monthly</span>
                    </div>
                    <h3 class="text-3xl font-black text-white tracking-tight text-emerald-400">{{ $stats['absen_bulan_ini'] }}</h3>
                    <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-1">Bulan Ini</p>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-black text-white tracking-tight">Riwayat Absensi</h3>
                    <a href="{{ route('student.history') }}" class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em] px-3 py-1 bg-indigo-400/10 rounded-full border border-indigo-500/10">
                        See All
                    </a>
                </div>

                @if($recentAttendance->isEmpty())
                    <div class="glass-card p-12 rounded-[40px] text-center border-dashed border-white/5 opacity-50">
                        <p class="text-slate-500 font-bold text-xs uppercase tracking-widest">Belum ada riwayat aktivitas</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($recentAttendance as $abs)
                            <div class="glass-card p-5 rounded-[28px] flex items-center justify-between group hover:bg-slate-800/60 transition-all border-white/5">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-700/50 flex items-center justify-center text-white font-black text-sm uppercase border border-white/5">
                                        {{ substr($abs->sesi->jadwal->mapel->nama_mapel, 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="font-black text-white tracking-tight text-sm uppercase group-hover:text-indigo-400 transition-colors">{{ $abs->sesi->jadwal->mapel->nama_mapel }}</h4>
                                        <p class="text-[9px] text-slate-500 font-bold uppercase tracking-widest mt-1">
                                            {{ \Carbon\Carbon::parse($abs->waktu_scan)->format('d M &bull; H:i') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end gap-1">
                                    <span class="px-3 py-1 bg-emerald-500/10 text-emerald-400 rounded-xl text-[9px] font-black uppercase tracking-widest border border-emerald-500/20">
                                        {{ $abs->status }}
                                    </span>
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
