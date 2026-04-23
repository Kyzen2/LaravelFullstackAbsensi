<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">
                Master Hub / <span class="text-white">Helpdesk Terpadu</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-10 pb-32">
        <div class="max-w-7xl mx-auto px-6">
            
            <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <h1 class="text-4xl font-black text-white tracking-tighter mb-2">Helpdesk & SLA Manager</h1>
                    <p class="text-slate-500 font-medium text-sm">Kelola antrean aduan, berikan respons cepat, dan pantau metrik kepuasan pengguna.</p>
                </div>
                
                <!-- Visual Filter Dropdown -->
                <div class="flex items-center p-1 bg-slate-900/50 border border-white/10 rounded-2xl backdrop-blur-md">
                    <a href="?filter=today" class="px-5 py-2 {{ $filter == 'today' ? 'bg-white/10 text-white shadow-lg border border-white/5' : 'text-slate-400 hover:text-white' }} text-[10px] font-black uppercase tracking-widest rounded-xl transition-all">Hari Ini</a>
                    <a href="?filter=week" class="px-5 py-2 {{ $filter == 'week' ? 'bg-white/10 text-white shadow-lg border border-white/5' : 'text-slate-400 hover:text-white' }} text-[10px] font-black uppercase tracking-widest rounded-xl transition-all">Minggu Ini</a>
                    <a href="?filter=month" class="px-5 py-2 {{ $filter == 'month' ? 'bg-white/10 text-white shadow-lg border border-white/5' : 'text-slate-400 hover:text-white' }} text-[10px] font-black uppercase tracking-widest rounded-xl transition-all">Bulan Ini</a>
                </div>
            </div>

            <!-- Dashboard Statistik -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">
                <div class="glass-card p-6 rounded-[32px] border-white/5 border-l-4 border-l-indigo-500">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Menunggu</p>
                    <h3 class="text-3xl font-black text-white">{{ $stats['open'] }}</h3>
                </div>
                <div class="glass-card p-6 rounded-[32px] border-white/5 border-l-4 border-l-amber-500">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Diproses</p>
                    <h3 class="text-3xl font-black text-amber-400">{{ $stats['in_progress'] }}</h3>
                </div>
                <div class="glass-card p-6 rounded-[32px] border-white/5 border-l-4 border-l-emerald-500">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Selesai</p>
                    <h3 class="text-3xl font-black text-emerald-400">{{ $stats['resolved'] }}</h3>
                </div>
                <div class="glass-card p-6 rounded-[32px] border-white/5 border-l-4 border-l-rose-500 relative overflow-hidden">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Rating Kepuasan</p>
                    <h3 class="text-3xl font-black text-white flex items-center gap-2">
                        {{ $stats['avg_rating'] }} <svg class="w-6 h-6 text-rose-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    </h3>
                </div>
            </div>

            <!-- System Performance Chart (Real-Time) -->
            <div class="glass-card p-8 rounded-[40px] border-white/5 mb-8">
                <div class="flex justify-between items-end mb-8">
                    <div>
                        <h3 class="text-xl font-black text-white tracking-tight mb-1">System Performance</h3>
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Rata-rata Response Time per Operator</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-16 gap-y-8">
                    @forelse($topOperators as $index => $op)
                    @php
                        $colors = [
                            ['text' => 'text-indigo-400', 'bg' => 'from-indigo-600 to-indigo-400', 'shadow' => 'shadow-[0_0_15px_rgba(99,102,241,0.5)]'],
                            ['text' => 'text-emerald-400', 'bg' => 'from-emerald-600 to-emerald-400', 'shadow' => 'shadow-[0_0_15px_rgba(16,185,129,0.5)]'],
                            ['text' => 'text-amber-400', 'bg' => 'from-amber-600 to-amber-400', 'shadow' => 'shadow-[0_0_15px_rgba(245,158,11,0.5)]'],
                            ['text' => 'text-rose-400', 'bg' => 'from-rose-600 to-rose-400', 'shadow' => 'shadow-[0_0_15px_rgba(244,63,94,0.5)]'],
                            ['text' => 'text-cyan-400', 'bg' => 'from-cyan-600 to-cyan-400', 'shadow' => 'shadow-[0_0_15px_rgba(6,182,212,0.5)]'],
                        ];
                        $c = $colors[$index % count($colors)];
                    @endphp
                    <div>
                        <div class="flex justify-between text-[10px] font-black uppercase tracking-widest mb-3">
                            <span class="text-white">{{ $op->name }}</span>
                            <span class="{{ $c['text'] }}">{{ $op->avg_response_minutes }} Menit</span>
                        </div>
                        <div class="w-full bg-slate-900/50 rounded-full h-4 border border-white/5 overflow-hidden">
                            <div class="bg-gradient-to-r {{ $c['bg'] }} h-full rounded-full {{ $c['shadow'] }}" style="width: {{ $op->performance_bar }}%"></div>
                        </div>
                    </div>
                    @empty
                    <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest lg:col-span-2 text-center py-4">Belum ada data respons operator.</div>
                    @endforelse
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                <!-- Antrean Tiket -->
                <div class="xl:col-span-2 glass-card rounded-[40px] border-white/5 overflow-hidden">
                    <div class="px-8 py-6 border-b border-white/5 bg-white/[0.02] flex justify-between items-center">
                        <h3 class="text-lg font-black text-white tracking-tight">Antrean Aduan (Prioritas)</h3>
                        <div class="flex gap-3">
                            <span class="px-3 py-1 bg-white/10 rounded-lg text-[10px] font-black text-white uppercase tracking-widest flex items-center">Rata-rata Respon: {{ $stats['avg_response_time'] }}</span>
                            <a href="{{ route('admin.helpdesk.print', ['filter' => $filter]) }}" target="_blank" class="px-3 py-1 bg-indigo-600 hover:bg-indigo-500 rounded-lg text-[10px] font-black text-white uppercase tracking-widest shadow-lg transition-all flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                Cetak PDF
                            </a>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-slate-900/50">
                                    <th class="px-8 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Tiket</th>
                                    <th class="px-8 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Pelapor & Subjek</th>
                                    <th class="px-8 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Status</th>
                                    <th class="px-8 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @forelse($tickets as $t)
                                <tr class="hover:bg-white/[0.02] transition-colors">
                                    <td class="px-8 py-6 text-sm font-mono text-slate-400">#HLP-{{ str_pad($t->id, 4, '0', STR_PAD_LEFT) }}</td>
                                    <td class="px-8 py-6">
                                        <div class="font-bold text-white mb-1">{{ $t->subject }}</div>
                                        <div class="text-[10px] text-slate-500 uppercase tracking-wider">{{ $t->user->name }} • {{ $t->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex flex-col items-start gap-1">
                                            @if($t->priority == 'high')
                                                <span class="px-2 py-1 bg-rose-500/20 text-rose-400 text-[9px] font-black uppercase tracking-widest rounded">HIGH</span>
                                            @elseif($t->priority == 'medium')
                                                <span class="px-2 py-1 bg-amber-500/20 text-amber-400 text-[9px] font-black uppercase tracking-widest rounded">MED</span>
                                            @else
                                                <span class="px-2 py-1 bg-slate-500/20 text-slate-400 text-[9px] font-black uppercase tracking-widest rounded">LOW</span>
                                            @endif
                                            <span class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest mt-1">{{ $t->status }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <a href="{{ route('admin.helpdesk.show', $t->id) }}" class="px-6 py-2 bg-white/5 hover:bg-white/10 text-white text-[10px] font-black uppercase tracking-widest rounded-lg transition-all inline-block">
                                            Tinjau
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="px-8 py-10 text-center text-slate-500 font-bold uppercase text-xs">Belum ada aduan masuk.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Top 5 Operator -->
                <div class="glass-card rounded-[40px] border-white/5 overflow-hidden">
                    <div class="px-8 py-6 border-b border-white/5 bg-white/[0.02]">
                        <h3 class="text-lg font-black text-white tracking-tight">Top 5 Operator</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        @forelse($topOperators as $op)
                        <div class="flex items-center gap-4 p-4 bg-white/5 rounded-2xl border border-white/5 hover:bg-white/10 transition-colors">
                            <div class="w-12 h-12 rounded-xl bg-indigo-500/20 text-indigo-400 border border-indigo-500/20 flex items-center justify-center font-black text-lg">
                                {{ substr($op->name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-white">{{ $op->name }}</h4>
                                <p class="text-[10px] font-black text-emerald-400 uppercase tracking-widest mt-1">{{ $op->resolved_count }} Tiket Selesai</p>
                            </div>
                        </div>
                        @empty
                        <p class="text-slate-500 text-xs text-center py-4 uppercase font-bold tracking-widest">Belum ada data operator.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
