<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.master.data') }}" class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 border border-white/10 hover:bg-white/10 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">
                Master Hub / <span class="text-white">Tahun Ajaran</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-10 pb-32">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
                <div>
                    <h1 class="text-4xl font-black text-white tracking-tighter mb-4">Pengaturan Periode</h1>
                    <p class="text-slate-500 font-medium">Bentuk struktur waktu akademik sekolah lu bro.</p>
                </div>
                <!-- Tombol Tambah (Modal Trigger) -->
                <button onclick="document.getElementById('modal-tambah').classList.remove('hidden')" class="px-8 py-4 bg-indigo-500 hover:bg-indigo-600 text-white text-xs font-black uppercase tracking-widest rounded-2xl transition-all shadow-lg shadow-indigo-500/20 active:scale-95">
                    Tambah Tahun Ajaran
                </button>
            </div>

            <!-- Table Section -->
            <div class="glass-card rounded-[40px] border-white/5 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-white/5 bg-white/[0.02]">
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tahun</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Semester</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($tahunAjarans as $ta)
                        <tr class="group hover:bg-white/[0.02] transition-colors">
                            <td class="px-8 py-6">
                                <span class="text-white font-bold tracking-tight">{{ $ta->tahun }}</span>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 bg-white/5 rounded-full text-[10px] font-black text-slate-300 uppercase tracking-wider">{{ $ta->semester }}</span>
                            </td>
                            <td class="px-8 py-6">
                                @if($ta->status)
                                <div class="flex items-center gap-2 text-emerald-400">
                                    <div class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></div>
                                    <span class="text-[10px] font-black uppercase tracking-widest">Aktif</span>
                                </div>
                                @else
                                <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="px-8 py-6 text-right">
                                <form action="{{ route('admin.tahun-ajaran.update', $ta) }}" method="POST" class="inline-block">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="tahun" value="{{ $ta->tahun }}">
                                    <input type="hidden" name="semester" value="{{ $ta->semester }}">
                                    <input type="hidden" name="status" value="{{ $ta->status ? 0 : 1 }}">
                                    <button type="submit" class="text-[10px] font-black text-indigo-400 uppercase tracking-widest hover:text-indigo-300 transition-colors">
                                        {{ $ta->status ? 'Matikan' : 'Aktifkan' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.tahun-ajaran.destroy', $ta) }}" method="POST" class="inline-block ml-4">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus tahun ajaran ini?')" class="text-[10px] font-black text-rose-500 uppercase tracking-widest hover:text-rose-400 transition-colors">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Sederhana -->
    <div id="modal-tambah" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-sm">
        <div class="glass-card p-10 rounded-[40px] border-white/10 w-full max-w-md mx-6">
            <h3 class="text-2xl font-black text-white mb-6">Tambah Tahun Ajaran</h3>
            <form action="{{ route('admin.tahun-ajaran.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Tahun (Cth: 2024/2025)</label>
                    <input type="text" name="tahun" required class="w-full bg-white/5 border-white/10 rounded-2xl text-white px-4 py-3 focus:border-indigo-500 focus:ring-0 transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Semester</label>
                    <select name="semester" class="w-full bg-white/5 border-white/10 rounded-2xl text-white px-4 py-3 focus:border-indigo-500 focus:ring-0 transition-all">
                        <option value="Ganjil" class="bg-slate-900">Ganjil</option>
                        <option value="Genap" class="bg-slate-900">Genap</option>
                    </select>
                </div>
                <div class="flex gap-4 pt-4">
                    <button type="button" onclick="document.getElementById('modal-tambah').classList.add('hidden')" class="flex-1 px-6 py-4 bg-white/5 text-white text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-white/10 transition-all">Batal</button>
                    <button type="submit" class="flex-1 px-6 py-4 bg-indigo-500 text-white text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-indigo-600 transition-all">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
