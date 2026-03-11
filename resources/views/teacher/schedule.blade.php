<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-indigo-500/20 flex items-center justify-center text-indigo-400 border border-indigo-500/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">
                Jadwal {{ $hariIni }}
            </h2>
        </div>
    </x-slot>

    <div class="py-10 pb-32 min-h-screen bg-[#020617] relative overflow-hidden">
        <!-- Background Orbs -->
        <div class="absolute top-0 right-0 -mr-32 -mt-32 w-96 h-96 bg-indigo-500/10 blur-[120px] rounded-full"></div>
        <div class="absolute bottom-10 left-0 -ml-32 w-96 h-96 bg-emerald-500/10 blur-[120px] rounded-full"></div>

        <div class="max-w-md mx-auto px-6 relative z-10">
            <!-- Header Section -->
            <div class="mb-10">
                <h2 class="text-3xl font-black text-white tracking-tighter uppercase leading-none mb-2">Jadwal Mengajar</h2>
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 rounded-full bg-indigo-500/20 text-indigo-400 text-[10px] font-black uppercase tracking-widest border border-indigo-500/20">
                        Hari Ini: {{ $hariIni }}
                    </span>
                    <span class="text-slate-500 text-[10px] font-bold uppercase tracking-widest">
                        {{ now()->format('d M Y') }}
                    </span>
                </div>
            </div>

            <!-- Schedule List -->
            <div class="space-y-4">
                @forelse($schedules as $item)
                <div class="glass-card p-5 rounded-[2rem] border-white/5 relative overflow-hidden group hover:border-indigo-500/30 transition-all duration-500">
                    <div class="flex items-start justify-between relative z-10">
                        <div class="flex gap-4">
                            <!-- Subject Initial -->
                            <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 border border-white/5 flex items-center justify-center text-indigo-400 font-black text-lg group-hover:scale-110 transition-transform duration-500">
                                {{ strtoupper(substr($item->mapel->nama_mapel, 0, 1)) }}
                            </div>
                            
                            <div>
                                <h3 class="text-white font-black text-base leading-tight mb-1 group-hover:text-indigo-400 transition-colors">{{ $item->mapel->nama_mapel }}</h3>
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center gap-1.5 text-slate-500">
                                        <svg class="w-3 h-3 text-indigo-500/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        <span class="text-[10px] font-bold uppercase tracking-wider">{{ $item->kelas->nama_kelas }}</span>
                                    </div>
                                    <div class="w-1 h-1 rounded-full bg-slate-800"></div>
                                    <div class="flex items-center gap-1.5 text-slate-500">
                                        <svg class="w-3 h-3 text-emerald-500/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <span class="text-[10px] font-bold uppercase tracking-wider">{{ $item->lokasi->nama_lokasi }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Time Badge -->
                        <div class="text-right">
                            <span class="block text-white font-black text-sm tracking-tight">{{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }}</span>
                            <span class="block text-slate-500 text-[9px] font-black uppercase tracking-tighter opacity-60">sampai {{ \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') }}</span>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('teacher.qr.current') }}" class="w-full py-4 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center gap-2 text-indigo-400 hover:bg-indigo-500 hover:text-white transition-all duration-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 17h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                            <span class="text-[9px] font-black uppercase tracking-widest">Buka Sesi Presensi</span>
                        </a>
                    </div>

                    <!-- Hover Gradient -->
                    <div class="absolute inset-0 bg-gradient-to-r from-indigo-500/0 via-indigo-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none"></div>
                </div>
                @empty
                <div class="glass-card p-12 rounded-[3rem] border-white/5 text-center flex flex-col items-center justify-center">
                    <div class="w-20 h-20 bg-slate-500/10 rounded-[2.5rem] flex items-center justify-center text-slate-600 mb-6 border border-white/5">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-white tracking-tight uppercase mb-2">Tidak Ada Kelas Hari Ini</h3>
                    <p class="text-slate-500 text-[10px] font-bold uppercase tracking-[0.2em]">Selamat beristirahat, Bapak/Ibu Guru!</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
