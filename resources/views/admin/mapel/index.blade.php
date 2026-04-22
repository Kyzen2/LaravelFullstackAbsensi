<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.master.data') }}" class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 border border-white/10 hover:bg-white/10 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">
                Master Hub / <span class="text-white">Mata Pelajaran</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-10 pb-32">
        <div class="max-w-7xl mx-auto px-6">
            
            @if(session('success'))
            <div class="mb-8 p-6 bg-emerald-500/10 border border-emerald-500/20 rounded-[32px] text-emerald-400 text-[10px] font-black uppercase tracking-widest">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="mb-8 p-6 bg-rose-500/10 border border-rose-500/20 rounded-[32px] text-rose-500 text-[10px] font-black uppercase tracking-widest">
                {{ session('error') }}
            </div>
            @endif

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
                <div>
                    <h1 class="text-4xl font-black text-white tracking-tighter mb-4">Master Kurikulum</h1>
                    <p class="text-slate-500 font-medium">Definisikan mata pelajaran yang diajarkan di sekolah.</p>
                </div>
                <button onclick="document.getElementById('modal-tambah-mapel').classList.remove('hidden')" class="px-8 py-4 bg-rose-500 hover:bg-rose-600 text-white text-[10px] font-black uppercase tracking-widest rounded-2xl transition-all shadow-lg shadow-rose-500/20 active:scale-95">
                    Tambah Mata Pelajaran
                </button>
            </div>

            <!-- List Mapel -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($mapels as $m)
                <div class="glass-card p-8 rounded-[40px] border-white/5 group hover:bg-white/[0.03] transition-all duration-500 relative overflow-hidden">
                    <div class="relative z-10 space-y-6">
                        <div class="flex items-start justify-between">
                            <div class="w-12 h-12 bg-rose-500/20 rounded-2xl flex items-center justify-center text-rose-400 border border-rose-500/20 font-black text-xs uppercase">
                                {{ substr($m->nama_mapel, 0, 2) }}
                            </div>
                            <div class="flex gap-2">
                                <form action="{{ route('admin.mapel.destroy', $m) }}" method="POST" onsubmit="return confirm('Hapus mapel ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-slate-600 hover:text-rose-500 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-white tracking-tight leading-tight group-hover:text-rose-400 transition-colors">{{ $m->nama_mapel }}</h3>
                            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mt-2 italic">ID Pelajaran: #{{ $m->id }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Modal Tambah Mapel -->
    <div id="modal-tambah-mapel" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-sm">
        <div class="glass-card p-10 rounded-[40px] border-white/10 w-full max-w-md mx-6">
            <h3 class="text-2xl font-black text-white mb-6">Tambah Mapel</h3>
            <form action="{{ route('admin.mapel.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Nama Mata Pelajaran</label>
                    <input type="text" name="nama_mapel" required placeholder="Cth: Pendidikan Kewarganegaraan" class="w-full bg-white/5 border-white/10 rounded-2xl text-white px-4 py-3 text-sm focus:border-rose-500 transition-all">
                </div>
                <div class="flex gap-4 pt-4">
                    <button type="button" onclick="document.getElementById('modal-tambah-mapel').classList.add('hidden')" class="flex-1 px-6 py-4 bg-white/5 text-white text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-white/10 transition-all">Batal</button>
                    <button type="submit" class="flex-1 px-6 py-4 bg-rose-500 text-white text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-rose-600 transition-all">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
