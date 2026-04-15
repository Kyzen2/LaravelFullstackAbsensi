<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">
                Master Hub / <span class="text-white">Gamifikasi & Fleksibilitas</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-10 pb-32">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Header Section -->
            <div class="mb-12">
                <h1 class="text-4xl font-black text-white tracking-tighter mb-2">Rule Builder & Marketplace</h1>
                <p class="text-slate-500 font-medium text-sm">Kelola aturan poin kedisiplinan dan token kelonggaran (Marketplace).</p>
            </div>

            @if(session('success'))
            <div class="mb-6 px-6 py-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl flex items-center gap-3 text-emerald-400 text-xs font-bold uppercase tracking-widest animate-fade-in">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                {{ session('success') }}
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- ============================== -->
                <!-- RULE BUILDER SECTION           -->
                <!-- ============================== -->
                <div class="glass-card rounded-[40px] border-white/5 overflow-hidden p-8 bg-slate-900/50">
                    <h2 class="text-xl font-bold text-indigo-400 mb-6 uppercase tracking-wider">Rule Builder (Mesin Poin)</h2>
                    
                    <form action="{{ route('admin.gamification.rules.store') }}" method="POST" class="space-y-4 mb-8 bg-white/5 p-6 rounded-2xl border border-white/10">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Nama Aturan</label>
                            <input type="text" name="rule_name" class="w-full bg-slate-800 border-white/10 rounded-xl text-white placeholder-slate-500" placeholder="Cth: Datang Pagi Banget" required>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Berlaku Untuk</label>
                                <select name="target_role" class="w-full bg-slate-800 border-white/10 rounded-xl text-white">
                                    <option value="siswa">Siswa</option>
                                    <option value="guru">Guru</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Poin Diberikan</label>
                                <input type="number" name="point_modifier" class="w-full bg-slate-800 border-white/10 rounded-xl text-white" placeholder="Cth: 5 atau -3" required>
                            </div>
                        </div>

                        <div class="pt-2">
                            <label class="block text-xs font-bold text-indigo-400 uppercase tracking-widest mb-2">Statement Logika Rule</label>
                            <div class="flex items-center gap-3 bg-indigo-900/30 p-4 rounded-xl border border-indigo-500/30">
                                <span class="font-bold text-indigo-300 text-sm">JIKA Waktu/Telat</span>
                                <select name="condition_operator" class="bg-indigo-950 border-indigo-500/50 rounded text-indigo-200 text-sm py-1" required>
                                    <option value="<">Kurang Dari (<)</option>
                                    <option value=">">Lebih Dari (>)</option>
                                </select>
                                <input type="text" name="condition_value" class="w-24 bg-indigo-950 border-indigo-500/50 rounded text-indigo-200 text-sm py-1" placeholder="15 / 06:30" required>
                                <span class="font-bold text-indigo-300 text-sm">Menit/Jam</span>
                            </div>
                        </div>
                        
                        <button type="submit" class="w-full mt-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl transition-all">Suntik Rule Engine</button>
                    </form>

                    <!-- TABLE RULES -->
                    <div class="overflow-x-auto rounded-xl border border-white/5">
                        <table class="w-full text-left">
                            <thead class="bg-white/5">
                                <tr>
                                    <th class="px-4 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">Rule</th>
                                    <th class="px-4 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">Kondisi</th>
                                    <th class="px-4 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5 text-sm">
                                @forelse($rules as $rule)
                                <tr class="hover:bg-white/5">
                                    <td class="px-4 py-3">
                                        <div class="font-bold text-white">{{ $rule->rule_name }}</div>
                                        <div class="text-xs {{ $rule->point_modifier >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">Poin: {{ $rule->point_modifier > 0 ? '+'.$rule->point_modifier : $rule->point_modifier }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-slate-400 text-xs">If {{ $rule->condition_operator }} {{ $rule->condition_value }}</td>
                                    <td class="px-4 py-3">
                                        <form action="{{ route('gamification.rules.destroy', $rule->id) }}" method="POST" onsubmit="return confirm('Hapus rule ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-rose-400 hover:text-rose-300">Del</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="text-center py-4 text-slate-500 text-xs">Belum ada rule di database.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- ============================== -->
                <!-- MARKETPLACE MANAGER SECTION    -->
                <!-- ============================== -->
                <div class="glass-card rounded-[40px] border-white/5 overflow-hidden p-8 bg-slate-900/50">
                    <h2 class="text-xl font-bold text-amber-400 mb-6 uppercase tracking-wider">Marketplace Manager</h2>
                    
                    <form action="{{ route('admin.gamification.items.store') }}" method="POST" class="space-y-4 mb-8 bg-white/5 p-6 rounded-2xl border border-white/10">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Nama Token Kelonggaran</label>
                            <input type="text" name="item_name" class="w-full bg-slate-800 border-white/10 rounded-xl text-white placeholder-slate-500" placeholder="Cth: Bebas Telat 30 Menit" required>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Deskripsi Kegunaan</label>
                            <input type="text" name="description" class="w-full bg-slate-800 border-white/10 rounded-xl text-white placeholder-slate-500" placeholder="Menghapus penalti terlambat.">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Harga (Poin)</label>
                                <input type="number" name="point_cost" class="w-full bg-slate-800 border-white/10 rounded-xl text-white" placeholder="Cth: 50" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Batas Stok</label>
                                <input type="number" name="stock_limit" class="w-full bg-slate-800 border-white/10 rounded-xl text-white" placeholder="Kosongi jika unli">
                            </div>
                        </div>
                        
                        <button type="submit" class="w-full mt-4 bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-4 rounded-xl transition-all">Publish ke Toko</button>
                    </form>

                    <!-- TABLE ITEMS -->
                    <div class="overflow-x-auto rounded-xl border border-white/5">
                        <table class="w-full text-left">
                            <thead class="bg-white/5">
                                <tr>
                                    <th class="px-4 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">Token</th>
                                    <th class="px-4 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">Harga</th>
                                    <th class="px-4 py-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5 text-sm">
                                @forelse($items as $item)
                                <tr class="hover:bg-white/5">
                                    <td class="px-4 py-3">
                                        <div class="font-bold text-white">{{ $item->item_name }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-amber-400 font-bold text-xs">{{ $item->point_cost }} Pts</td>
                                    <td class="px-4 py-3">
                                        <form action="{{ route('gamification.items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus Token ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-rose-400 hover:text-rose-300">Del</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="3" class="text-center py-4 text-slate-500 text-xs">Belum ada token di marketplace.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
