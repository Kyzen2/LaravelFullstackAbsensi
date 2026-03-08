<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-indigo-500/20 flex items-center justify-center text-indigo-400 border border-indigo-500/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </div>
            <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">
                Activity Log
            </h2>
        </div>
    </x-slot>

    <div class="py-10 space-y-10 pb-32">
        <div class="max-w-7xl mx-auto px-6 space-y-10">
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6">
                <div class="space-y-2">
                    <h2 class="text-4xl font-black text-white tracking-tighter uppercase leading-none">Riwayat Absensi</h2>
                    <p class="text-slate-500 text-sm font-medium italic opacity-70">Jejak kehadiranmu selama satu semester ini.</p>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="glass-card px-6 py-3 rounded-2xl border-white/5 flex items-center gap-3">
                        <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div>
                        <span class="text-[10px] font-black text-white uppercase tracking-widest">Database Sync Active</span>
                    </div>
                </div>
            </div>

            <!-- History List -->
            @if($attendanceHistory->isEmpty())
                <div class="glass-card p-20 rounded-[40px] text-center border-dashed border-white/5">
                    <div class="opacity-20 flex flex-col items-center">
                        <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-xs font-black uppercase tracking-[0.3em] text-white">Belum ada riwayat kehadiran.</p>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($attendanceHistory as $abs)
                        <div class="glass-card p-6 rounded-[32px] border-white/5 group hover:bg-white/5 transition-all duration-500 relative overflow-hidden">
                            <div class="absolute -right-8 -bottom-8 w-24 h-24 bg-indigo-500/5 blur-2xl rounded-full group-hover:bg-indigo-500/10 transition-all"></div>
                            
                            <div class="relative z-10 flex flex-col h-full">
                                <div class="flex items-start justify-between mb-6">
                                    <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 flex items-center justify-center text-indigo-400 border border-indigo-500/10 group-hover:scale-110 transition-transform">
                                        <span class="text-base font-black">{{ substr($abs->sesi->jadwal->mapel->nama_mapel, 0, 1) }}</span>
                                    </div>
                                    <div class="flex flex-col items-end">
                                        <span class="px-3 py-1 bg-emerald-500/10 text-emerald-400 rounded-xl text-[9px] font-black uppercase tracking-widest border border-emerald-500/20">
                                            {{ $abs->status }}
                                        </span>
                                        <span class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-2 font-mono">
                                            {{ \Carbon\Carbon::parse($abs->waktu_scan)->format('H:i A') }}
                                        </span>
                                    </div>
                                </div>

                                <div class="space-y-1">
                                    <h4 class="text-lg font-black text-white tracking-tight uppercase group-hover:text-indigo-400 transition-colors">
                                        {{ $abs->sesi->jadwal->mapel->nama_mapel }}
                                    </h4>
                                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">
                                        {{ \Carbon\Carbon::parse($abs->waktu_scan)->translatedFormat('l, d F Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Custom Pagination -->
                <div class="mt-12">
                    {{ $attendanceHistory->links('vendor.pagination.tailwind-dark') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Go Back (Desktop) -->
    <div class="max-w-7xl mx-auto px-6 pb-20 hidden sm:block">
        <a href="{{ route('student.dashboard') }}" class="inline-flex items-center gap-3 py-4 text-slate-500 hover:text-white transition-all group">
            <div class="w-10 h-10 rounded-xl bg-white/5 border border-white/5 flex items-center justify-center group-hover:bg-indigo-500/20 group-hover:text-indigo-400 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </div>
            <span class="text-[11px] font-black uppercase tracking-[0.2em]">Back to Dashboard</span>
        </a>
    </div>
</x-app-layout>
