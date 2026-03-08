<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('teacher.attendance.index') }}" class="w-8 h-8 rounded-lg bg-slate-500/10 flex items-center justify-center text-slate-400 border border-white/5 hover:bg-slate-500/20 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">Pilih Sesi</h2>
        </div>
    </x-slot>

    <div class="py-10 pb-32 min-h-screen bg-[#020617] relative overflow-hidden">
        <!-- Background Orbs -->
        <div class="absolute top-0 right-0 -mr-32 -mt-32 w-96 h-96 bg-indigo-500/10 blur-[120px] rounded-full"></div>
        <div class="absolute bottom-10 left-0 -ml-32 w-96 h-96 bg-emerald-500/10 blur-[120px] rounded-full"></div>

        <div class="max-w-md mx-auto px-6 relative z-10">
            <div class="mb-10 text-center">
                <h1 class="text-3xl font-black text-white tracking-tighter uppercase mb-2">{{ $kelas->nama_kelas }}</h1>
                <p class="text-slate-500 text-[10px] font-black uppercase tracking-[0.2em]">Silahkan pilih sesi untuk input absensi</p>
            </div>

            <!-- Session List -->
            <div class="space-y-4">
                @forelse($sessions as $sesi)
                <a href="{{ route('teacher.session.detail', $sesi) }}" class="block glass-card p-6 rounded-[2.5rem] border-white/5 group hover:border-emerald-500/30 active:scale-[0.98] transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-emerald-400 border border-emerald-500/10 group-hover:bg-emerald-500/20 transition-colors text-xs font-black">
                                {{ \Carbon\Carbon::parse($sesi->tanggal)->format('d') }}
                                <br>
                                {{ \Carbon\Carbon::parse($sesi->tanggal)->format('M') }}
                            </div>
                            <div>
                                <h3 class="text-white font-black text-sm leading-tight mb-1 group-hover:text-emerald-400 transition-colors">{{ $sesi->jadwal->mapel->nama_mapel }}</h3>
                                <div class="flex items-center gap-2">
                                    <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">{{ \Carbon\Carbon::parse($sesi->tanggal)->format('l, d F Y') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-white/5 flex items-center justify-center text-slate-500 group-hover:text-emerald-400 group-hover:bg-emerald-500/10 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                    </div>
                </a>
                @empty
                <div class="py-20 text-center">
                    <div class="w-20 h-20 bg-slate-500/5 rounded-full flex items-center justify-center mx-auto mb-6 border border-white/5">
                        <svg class="w-8 h-8 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">Belum ada sesi absensi</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
