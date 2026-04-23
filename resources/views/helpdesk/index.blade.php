<x-app-layout>
    <x-slot name="header">
        <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">
            Layanan <span class="text-white">Helpdesk Terpadu</span>
        </h2>
    </x-slot>

    <div class="py-10 pb-32">
        <div class="max-w-7xl mx-auto px-6">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
                <div>
                    <h1 class="text-4xl font-black text-white tracking-tighter mb-2">Pusat Bantuan</h1>
                    <p class="text-slate-500 font-medium text-sm">Laporkan kendala teknis (gagal scan, lupa absen, dsb) kepada Operator.</p>
                </div>
                <a href="{{ route('helpdesk.create') }}" class="px-8 py-4 bg-indigo-500 hover:bg-indigo-600 text-white text-[10px] font-black uppercase tracking-widest rounded-2xl transition-all shadow-lg shadow-indigo-500/20 active:scale-95 text-center">
                    + Buat Tiket Aduan
                </a>
            </div>

            <!-- Dashboard Statistik User -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="glass-card p-6 rounded-[32px] border-white/5 border-l-4 border-l-slate-500">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Total Tiket</p>
                    <h3 class="text-3xl font-black text-white">{{ str_pad($stats['total'], 2, '0', STR_PAD_LEFT) }}</h3>
                </div>
                <div class="glass-card p-6 rounded-[32px] border-white/5 border-l-4 border-l-amber-500">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Sedang Diproses</p>
                    <h3 class="text-3xl font-black text-amber-400">{{ str_pad($stats['in_progress'], 2, '0', STR_PAD_LEFT) }}</h3>
                </div>
                <div class="glass-card p-6 rounded-[32px] border-white/5 border-l-4 border-l-emerald-500">
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Selesai</p>
                    <h3 class="text-3xl font-black text-emerald-400">{{ str_pad($stats['resolved'], 2, '0', STR_PAD_LEFT) }}</h3>
                </div>
            </div>

            <!-- Pesan Sukses -->
            @if(session('success'))
            <div class="mb-8 p-6 bg-emerald-500/10 border border-emerald-500/20 rounded-[32px] text-emerald-400 text-[10px] font-black uppercase tracking-widest">
                {{ session('success') }}
            </div>
            @endif

            <!-- List Tiket Saya -->
            <div class="glass-card rounded-[40px] border-white/5 overflow-hidden">
                <div class="px-8 py-6 border-b border-white/5 bg-white/[0.02]">
                    <h3 class="text-lg font-black text-white tracking-tight">Riwayat Aduan Saya</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-900/50">
                                <th class="px-8 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Tiket</th>
                                <th class="px-8 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Subjek Kendala</th>
                                <th class="px-8 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest">Status</th>
                                <th class="px-8 py-4 text-[10px] font-black text-slate-500 uppercase tracking-widest text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($tickets as $t)
                            <tr class="hover:bg-white/[0.02] transition-colors">
                                <td class="px-8 py-6 text-xs font-mono text-slate-400">#HLP-{{ str_pad($t->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-8 py-6">
                                    <div class="text-sm font-bold text-white mb-1">{{ $t->subject }}</div>
                                    <div class="text-[10px] text-slate-500">{{ $t->created_at->format('d M Y, H:i') }}</div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="px-3 py-1 bg-white/5 text-white text-[10px] font-bold rounded-lg uppercase tracking-widest border border-white/10">{{ $t->status }}</span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <a href="{{ route('helpdesk.show', $t->id) }}" class="px-6 py-2 bg-white/5 hover:bg-indigo-500/20 text-white hover:text-indigo-400 text-[10px] font-black uppercase tracking-widest rounded-lg transition-all inline-block border border-white/5 hover:border-indigo-500/30">
                                        Lihat / Balas
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="px-8 py-10 text-center text-slate-500 font-bold uppercase text-xs">Anda belum pernah membuat aduan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
