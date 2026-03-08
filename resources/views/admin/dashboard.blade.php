<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-indigo-500/20 flex items-center justify-center text-indigo-400 border border-indigo-500/20 text-xs font-black">
                ADM
            </div>
            <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">
                System Overdrive
            </h2>
        </div>
    </x-slot>

    <div class="py-10 space-y-10 pb-32">
        <div class="max-w-7xl mx-auto px-6 space-y-10">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Guru Stats -->
                <div class="glass-card p-6 rounded-[32px] border-white/5 flex items-center group hover:bg-white/5 transition-all">
                    <div class="w-14 h-14 bg-indigo-500/10 rounded-2xl flex items-center justify-center text-indigo-400 mr-5 border border-indigo-500/10 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em]">Total Guru</p>
                        <p class="text-3xl font-black text-white tracking-tighter">{{ $stats['guru'] }}</p>
                    </div>
                </div>

                <!-- Siswa Stats -->
                <div class="glass-card p-6 rounded-[32px] border-white/5 flex items-center group hover:bg-white/5 transition-all">
                    <div class="w-14 h-14 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-400 mr-5 border border-emerald-500/10 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em]">Total Siswa</p>
                        <p class="text-3xl font-black text-white tracking-tighter">{{ $stats['siswa'] }}</p>
                    </div>
                </div>

                <!-- Kelas Stats -->
                <div class="glass-card p-6 rounded-[32px] border-white/5 flex items-center group hover:bg-white/5 transition-all">
                    <div class="w-14 h-14 bg-amber-500/10 rounded-2xl flex items-center justify-center text-amber-400 mr-5 border border-amber-500/10 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em]">Total Kelas</p>
                        <p class="text-3xl font-black text-white tracking-tighter">{{ $stats['kelas'] }}</p>
                    </div>
                </div>

                <!-- Live Presence -->
                <div class="glass-card p-6 rounded-[32px] border-white/5 flex items-center group hover:bg-white/5 transition-all">
                    <div class="w-14 h-14 bg-indigo-500/20 rounded-2xl flex items-center justify-center text-indigo-400 mr-5 border border-indigo-500/20 group-hover:scale-110 transition-transform">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-indigo-500"></span>
                        </span>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em]">Live Presence</p>
                        <p class="text-3xl font-black text-white tracking-tighter">{{ $stats['absensi_today'] }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <!-- Recent Activity Table -->
                <div class="lg:col-span-2 glass-card rounded-[40px] border-white/5 overflow-hidden shadow-2xl">
                    <div class="p-8 border-b border-white/5 flex justify-between items-center">
                        <h3 class="text-xl font-black text-white tracking-tight">Recent Activity</h3>
                        <a href="#" class="text-[10px] font-black text-indigo-400 hover:text-white uppercase tracking-[0.2em] transition-colors">Audit All &rarr;</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="bg-white/5">
                                    <th class="px-8 py-5 text-left text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Identity</th>
                                    <th class="px-8 py-5 text-left text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Subject</th>
                                    <th class="px-8 py-5 text-center text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Status</th>
                                    <th class="px-8 py-5 text-right text-[9px] font-black text-slate-400 uppercase tracking-[0.3em]">Timestamp</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @forelse($recent_absences as $abs)
                                    <tr class="hover:bg-white/5 transition-colors group">
                                        <td class="px-8 py-6">
                                            <div class="text-sm font-black text-white tracking-tight group-hover:text-indigo-400 transition-colors">{{ $abs->siswa->nama_siswa }}</div>
                                            <div class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-1">{{ $abs->siswa->nisn }}</div>
                                        </td>
                                        <td class="px-8 py-6">
                                            <div class="text-[11px] font-black text-slate-400 uppercase tracking-wider">{{ $abs->sesi->jadwal->mapel->nama_mapel }}</div>
                                        </td>
                                        <td class="px-8 py-6 text-center">
                                            <span class="px-4 py-1.5 bg-emerald-500/10 text-emerald-400 rounded-xl text-[9px] font-black uppercase tracking-[0.2em] border border-emerald-500/20">
                                                {{ $abs->status }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-6 text-right">
                                            <div class="text-[10px] font-black text-slate-500 font-mono tracking-widest">
                                                {{ \Carbon\Carbon::parse($abs->waktu_scan)->format('H:i:A') }}
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-8 py-20 text-center">
                                            <div class="opacity-20 flex flex-col items-center">
                                                <svg class="w-12 h-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                <p class="text-[10px] font-black uppercase tracking-[0.3em]">No Activity Logged</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Admin Toolbox -->
                <div class="space-y-8">
                    <div class="glass-card rounded-[40px] border-white/5 p-8 bg-indigo-500/5 relative overflow-hidden group">
                        <div class="absolute -right-12 -bottom-12 w-48 h-48 bg-indigo-500/10 blur-3xl rounded-full group-hover:bg-indigo-500/20 transition-all duration-1000"></div>
                        <div class="relative z-10 space-y-6">
                            <h3 class="text-2xl font-black text-white tracking-tighter">Master Hub</h3>
                            <p class="text-slate-500 text-xs font-medium leading-relaxed opacity-80">Centralized control for Teachers, Students, and Curriculum Data.</p>
                            <a href="#" class="btn-premium w-full py-5 text-sm uppercase tracking-[0.2em] shadow-indigo-500/20">
                                Launch Center
                            </a>
                        </div>
                    </div>

                    <div class="glass-card rounded-[40px] border-white/5 p-8 space-y-6 shadow-xl">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xs font-black text-slate-500 uppercase tracking-[0.3em]">System Engine</h3>
                            <span class="px-3 py-1 bg-emerald-500/10 text-emerald-400 rounded-full text-[8px] font-black uppercase tracking-widest border border-emerald-500/20">Operational</span>
                        </div>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center bg-white/5 p-4 rounded-2xl border border-white/5">
                                <span class="text-[10px] font-black text-white/40 uppercase tracking-widest">Database</span>
                                <div class="h-1.5 w-1.5 rounded-full bg-emerald-400 shadow-[0_0_10px_rgba(52,211,153,0.8)]"></div>
                            </div>
                            <div class="flex justify-between items-center bg-white/5 p-4 rounded-2xl border border-white/5">
                                <span class="text-[10px] font-black text-white/40 uppercase tracking-widest">Active Auth</span>
                                <span class="text-[11px] font-black text-white tracking-widest">{{ auth()->user()->count() }} Nodes</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
