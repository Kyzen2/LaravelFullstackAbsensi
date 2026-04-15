    <x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-indigo-500/20 flex items-center justify-center text-indigo-400 border border-indigo-500/20">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
            </div>
            <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">
                Pusat Siswa
            </h2>
        </div>
    </x-slot>

    <div class="py-6 space-y-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            
            @if(session('success'))
            <div class="mb-6 px-6 py-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl flex items-center gap-3 text-emerald-400 text-xs font-bold uppercase tracking-widest animate-fade-in">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 px-6 py-4 bg-rose-500/10 border border-rose-500/20 rounded-2xl flex items-center gap-3 text-rose-400 text-xs font-bold uppercase tracking-widest animate-fade-in">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                {{ session('error') }}
            </div>
            @endif

            <!-- WALLET HERO (DOMPET INTEGRITAS) -->
            <div class="relative overflow-hidden rounded-[40px] bg-gradient-to-br from-indigo-900 via-slate-900 to-slate-900 p-8 sm:p-12 border border-white/5 shadow-[0_0_50px_rgba(79,70,229,0.15)]">
                <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 bg-indigo-500/20 blur-[100px] rounded-full pointer-events-none"></div>
                
                <div class="relative flex flex-col md:flex-row md:items-center justify-between gap-8">
                    <div class="space-y-4">
                        <div class="text-indigo-400 font-bold uppercase tracking-widest text-xs flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Dompet Integritas
                        </div>
                        <h1 class="text-5xl sm:text-7xl font-black text-white tracking-tighter tabular-nums leading-none flex items-baseline gap-2">
                            {{ $pointBalance }} 
                            <span class="text-2xl text-slate-500 font-medium">Pts</span>
                        </h1>
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500/10 text-amber-500 rounded-full text-[10px] font-black uppercase tracking-widest border border-amber-500/20">
                            ⭐ Peringkat: Disiplin Elite
                        </div>
                    </div>

                    <!-- Right side (Scan Button embedded) / Clock -->
                    <div class="flex flex-col items-center md:items-end gap-4">
                        <div class="text-center md:text-right hidden sm:block">
                            <div id="realtime-clock" class="text-3xl font-black text-white tracking-tighter tabular-nums leading-none">00:00:00</div>
                            <div id="realtime-date" class="text-[10px] font-bold uppercase tracking-[0.2em] text-indigo-400/80 mt-1">Loading date...</div>
                        </div>
                        <a href="{{ route('student.scan') }}" class="btn-premium px-8 py-5 text-sm uppercase tracking-[0.2em] shadow-indigo-500/30 whitespace-nowrap group">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                                Absensi Kamera
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- LEADERBOARD SECTION -->
            <div class="mt-10">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/20 flex items-center justify-center text-amber-400 border border-amber-500/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-white tracking-tight">Leaderboard Integritas</h3>
                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">Top 10 Siswa Terdisiplin</p>
                        </div>
                    </div>
                    <div class="px-4 py-2 bg-indigo-500/10 rounded-full border border-indigo-500/20">
                        <span class="text-[10px] font-black text-indigo-400 uppercase tracking-widest">Rankmu: #{{ $myRank }}</span>
                    </div>
                </div>

                @if($leaderboard->count() > 0)
                <div class="glass-card rounded-[32px] overflow-hidden border border-white/5">
                    @foreach($leaderboard as $index => $leader)
                    @php
                        $isMe = $leader->id === auth()->id();
                        $rankEmojis = ['🥇', '🥈', '🥉'];
                        $rankColors = [
                            0 => ['bg' => 'bg-amber-500/10', 'border' => 'border-amber-500/20', 'text' => 'text-amber-400', 'avatar' => 'bg-amber-500 text-amber-950'],
                            1 => ['bg' => 'bg-slate-400/10', 'border' => 'border-slate-400/20', 'text' => 'text-slate-300', 'avatar' => 'bg-slate-400 text-slate-900'],
                            2 => ['bg' => 'bg-amber-700/10', 'border' => 'border-amber-700/20', 'text' => 'text-amber-600', 'avatar' => 'bg-amber-700 text-amber-100'],
                        ];
                        $isTop3 = $index < 3;
                        $colors = $rankColors[$index] ?? null;
                    @endphp
                    <div class="flex items-center gap-4 px-5 sm:px-6 py-4 border-b border-white/5 last:border-0 transition-colors {{ $isMe ? 'bg-indigo-500/5 border-l-2 border-l-indigo-500' : 'hover:bg-white/[0.02]' }} {{ $isTop3 ? $colors['bg'] : '' }}">
                        {{-- Rank Number --}}
                        <div class="w-9 shrink-0 text-center">
                            @if($isTop3)
                                <span class="text-xl">{{ $rankEmojis[$index] }}</span>
                            @else
                                <span class="text-sm font-black text-slate-500 tabular-nums">#{{ $index + 1 }}</span>
                            @endif
                        </div>

                        {{-- Avatar --}}
                        <div class="w-10 h-10 rounded-full {{ $isTop3 ? $colors['avatar'] : 'bg-slate-700 text-white' }} flex items-center justify-center text-sm font-black shrink-0">
                            {{ strtoupper(substr($leader->name, 0, 1)) }}
                        </div>

                        {{-- Name --}}
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold {{ $isTop3 ? 'text-white' : 'text-slate-300' }} text-sm truncate">
                                {{ $leader->name }}
                                @if($isMe) <span class="text-indigo-400 text-[9px] font-black uppercase tracking-widest ml-1">(Kamu)</span> @endif
                            </h4>
                        </div>

                        {{-- Points --}}
                        <div class="text-right shrink-0">
                            <div class="font-black {{ $isTop3 ? $colors['text'] : 'text-white' }} text-base tabular-nums">{{ $leader->point_balance }}</div>
                            <div class="text-[8px] text-slate-500 font-bold uppercase tracking-widest">Poin</div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="glass-card p-10 rounded-[32px] text-center border-dashed border-white/10">
                    <div class="w-16 h-16 rounded-full bg-white/5 flex items-center justify-center mx-auto mb-4 text-3xl">🏆</div>
                    <h3 class="text-white font-bold mb-1">Belum Ada Peringkat</h3>
                    <p class="text-slate-500 text-sm">Leaderboard akan muncul setelah siswa mulai mengumpulkan poin integritas.</p>
                </div>
                @endif
            </div>

            <!-- GAMIFICATION TABS/SECTIONS -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-10">
                
                <!-- KIRI: Mutasi Poin & History Absen Singkat -->
                <div class="lg:col-span-1 space-y-8">
                    
                    <!-- TAB MUTASI -->
                    <div>
                        <h3 class="text-xl font-black text-white tracking-tight mb-6">Riwayat Mutasi Poin</h3>
                        <div class="glass-card p-2 rounded-[32px] overflow-hidden max-h-[350px] overflow-y-auto custom-scrollbar">
                            @forelse($ledgers as $ledger)
                                <div class="flex items-center gap-4 px-4 py-3 border-b border-white/5 last:border-0 hover:bg-white/5 transition-colors rounded-2xl">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 {{ $ledger->amount > 0 ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-rose-500/10 text-rose-400 border border-rose-500/20' }}">
                                        @if($ledger->amount > 0)
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                        @else
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0 py-1">
                                        <p class="text-xs font-bold text-white line-clamp-2 leading-tight">{{ $ledger->description }}</p>
                                        <p class="text-[9px] uppercase tracking-[0.2em] text-slate-500 mt-1">{{ \Carbon\Carbon::parse($ledger->created_at)->diffForHumans() }}</p>
                                    </div>
                                    <div class="text-sm font-black tabular-nums {{ $ledger->amount > 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                                        {{ $ledger->amount > 0 ? '+'.$ledger->amount : $ledger->amount }}
                                    </div>
                                </div>
                            @empty
                                <p class="text-slate-500 text-xs italic text-center py-8">Belum ada mutasi poin.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- RECENT ATTENDANCE -->
                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-black text-white tracking-tight">Log Kehadiran</h3>
                            <a href="{{ route('student.history') }}" class="text-[9px] font-black text-indigo-400 uppercase tracking-widest px-3 py-1 bg-indigo-500/10 rounded-full border border-indigo-500/20 hover:bg-indigo-500/20 transition-colors">
                                Semua View
                            </a>
                        </div>
                        @if($recentAttendance->isEmpty())
                            <div class="glass-card p-8 rounded-[32px] text-center border-dashed border-white/5 opacity-50">
                                <p class="text-slate-500 font-bold text-[10px] uppercase tracking-widest">Belum ada absen.</p>
                            </div>
                        @else
                            <div class="space-y-3">
                                @foreach($recentAttendance as $abs)
                                    <div class="glass-card p-4 rounded-3xl flex items-center justify-between group">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-slate-800 flex items-center justify-center text-white font-black text-xs uppercase border border-white/5">
                                                {{ substr($abs->sesi->jadwal->mapel->nama_mapel, 0, 1) }}
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-white tracking-tight text-xs uppercase">{{ $abs->sesi->jadwal->mapel->nama_mapel }}</h4>
                                                <p class="text-[9px] text-slate-500 font-bold uppercase tracking-widest mt-0.5">
                                                    {{ \Carbon\Carbon::parse($abs->waktu_scan)->format('dM H:i') }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-end gap-1">
                                            <span class="px-2 py-1 {{ str_contains(strtolower($abs->status), 'terlambat') ? 'bg-rose-500/10 text-rose-400 border-rose-500/20' : 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' }} rounded-lg text-[8px] font-black uppercase tracking-widest border">
                                                {{ explode('(', $abs->status)[0] }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- KANAN: Marketplace & Inventory -->
                <div class="lg:col-span-2 space-y-10">
                    
                    <!-- INVENTORY (TAS PUNGGUNG) -->
                    <div>
                        <div class="flex items-center gap-3 mb-6">
                            <h3 class="text-xl font-black text-white tracking-tight">Tas Sakti (Inventory)</h3>
                            <span class="px-2 py-0.5 bg-indigo-500/20 text-indigo-400 rounded text-[9px] font-black uppercase tracking-widest border border-indigo-500/20">Otomatis Aktif</span>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @forelse($inventory->where('status', 'AVAILABLE') as $token)
                                <div class="glass-card p-4 rounded-3xl border border-indigo-500/30 bg-indigo-500/5 hover:bg-indigo-500/10 transition-all flex items-center gap-4 relative overflow-hidden group">
                                    <div class="w-12 h-12 bg-indigo-500/20 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">🎟️</div>
                                    <div class="z-10">
                                        <h4 class="font-bold text-white text-sm tracking-tight leading-tight mb-1">{{ $token->item->item_name }}</h4>
                                        <p class="text-[9px] text-emerald-400 font-black uppercase tracking-widest flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Siap Intercept
                                        </p>
                                    </div>
                                    <div class="absolute -right-4 -bottom-4 text-6xl opacity-5 pointer-events-none group-hover:rotate-12 transition-transform">🎟️</div>
                                </div>
                            @empty
                                <div class="glass-card p-6 rounded-[32px] border-dashed border-white/10 text-center sm:col-span-2 flex flex-col items-center gap-3">
                                    <div class="w-12 h-12 rounded-full bg-white/5 flex items-center justify-center text-slate-500">🕸️</div>
                                    <p class="text-slate-500 text-[10px] font-black uppercase tracking-widest max-w-[200px]">Tas kosong. Tukarkan poin di bawah untuk membeli perlindungan absensi.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- MARKETPLACE -->
                    <div class="pt-2 border-t border-white/5">
                        <div class="flex items-center gap-3 mb-6">
                            <h3 class="text-xl font-black text-white tracking-tight">Flexibility Marketplace</h3>
                            <span class="px-2 py-0.5 bg-amber-500/20 text-amber-500 rounded text-[9px] font-black uppercase tracking-widest border border-amber-500/20">Tukar Poin</span>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            @foreach($marketItems as $item)
                            <div class="glass-card p-6 rounded-[32px] flex flex-col justify-between group hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                                <!-- Background fx -->
                                <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                
                                <div class="relative z-10">
                                    <div class="w-12 h-12 bg-amber-500/10 border border-amber-500/20 rounded-2xl flex items-center justify-center text-2xl mb-5 shadow-inner">🎁</div>
                                    <h4 class="text-lg font-black text-white leading-tight mb-2 group-hover:text-amber-400 transition-colors">{{ $item->item_name }}</h4>
                                    <p class="text-xs font-medium text-slate-400 mb-6 leading-relaxed">{{ $item->description }}</p>
                                </div>
                                
                                <div class="relative z-10 flex items-center justify-between mt-auto bg-slate-900/50 -mx-6 -mb-6 px-6 py-4 border-t border-white/5">
                                    <div class="text-amber-400 font-black text-xl tabular-nums tracking-tight">
                                        {{ $item->point_cost }} <span class="text-[10px] font-bold text-amber-500/50 uppercase tracking-widest">Pts</span>
                                    </div>
                                    
                                    <form action="{{ route('student.gamification.buy', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $pointBalance >= $item->point_cost ? 'bg-amber-500 hover:bg-amber-400 text-amber-950 shadow-[0_0_20px_rgba(245,158,11,0.2)]' : 'bg-slate-800 text-slate-500 cursor-not-allowed' }}" {{ $pointBalance < $item->point_cost ? 'disabled' : '' }}>
                                            Beli Token
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                </div>
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
