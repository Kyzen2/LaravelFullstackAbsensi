<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.master.data') }}" class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 border border-white/10 hover:bg-white/10 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">
                Master Hub / <span class="text-white">Kelas & Jurusan</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-10 pb-32">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
                <div>
                    <h1 class="text-4xl font-black text-white tracking-tighter mb-4">Master Kelas</h1>
                    <p class="text-slate-500 font-medium">Kelola struktur kelas dan penugasan wali kelas.</p>
                </div>
                <button onclick="document.getElementById('modal-tambah-kelas').classList.remove('hidden')" class="px-8 py-4 bg-amber-500 hover:bg-amber-600 text-white text-xs font-black uppercase tracking-widest rounded-2xl transition-all shadow-lg shadow-amber-500/20 active:scale-95">
                    Buat Kelas Baru
                </button>
            </div>

            <!-- Notifikasi -->
            @if(session('success'))
            <div class="mb-8 p-6 bg-emerald-500/10 border border-emerald-500/20 rounded-[32px] text-emerald-400 text-[10px] font-black uppercase tracking-widest">
                {{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div class="mb-8 p-6 bg-rose-500/10 border border-rose-500/20 rounded-[32px] text-rose-500 text-[10px] font-bold tracking-widest">
                <p class="uppercase font-black mb-2 tracking-[0.2em]">Terjadi Kesalahan:</p>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Grid Kelas -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($kelas as $k)
                <div class="glass-card p-10 rounded-[48px] border-white/5 group hover:bg-white/[0.03] transition-all duration-500 relative overflow-hidden">
                    <div class="absolute -right-8 -top-8 w-32 h-32 bg-white/5 blur-3xl rounded-full group-hover:bg-amber-500/10 transition-all duration-700"></div>
                    <div class="relative z-10 space-y-6">
                        <div class="flex items-start justify-between">
                            <div class="w-16 h-16 bg-amber-500/20 rounded-[20px] flex items-center justify-center text-amber-400 border border-amber-500/20">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <form action="{{ route('admin.kelas.destroy', $k) }}" method="POST" onsubmit="return confirm('Hapus kelas ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-slate-600 hover:text-rose-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                        <div>
                            <h3 class="text-3xl font-black text-white tracking-tighter mb-1">{{ $k->nama_kelas }}</h3>
                            <div class="flex items-center gap-2">
                                <span class="px-3 py-1 bg-white/5 rounded-full text-[10px] font-black text-slate-400 uppercase tracking-widest border border-white/5">
                                    {{ $k->tahunAjaran->tahun }} ({{ $k->tahunAjaran->semester }})
                                </span>
                            </div>
                        </div>
                        <div class="pt-2">
                            <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1 italic">Wali Kelas:</p>
                            <p class="text-sm font-bold text-slate-300">{{ $k->waliKelas->user->name ?? 'N/A' }}</p>
                        </div>
                        <a href="{{ route('admin.kelas.show', $k) }}" class="flex items-center gap-2 text-[10px] font-black text-amber-400 uppercase tracking-[0.2em] group-hover:gap-4 transition-all pt-4">
                            Kelola Murid <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Modal Tambah Kelas -->
    <div id="modal-tambah-kelas" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-sm">
        <div class="glass-card p-10 rounded-[40px] border-white/10 w-full max-w-md mx-6">
            <h3 class="text-2xl font-black text-white mb-6">Buat Kelas Baru</h3>
            <form action="{{ route('admin.kelas.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Nama Kelas (Cth: X PPLG 1)</label>
                    <input type="text" name="nama_kelas" required class="w-full bg-white/5 border-white/10 rounded-2xl text-white px-4 py-3 focus:border-amber-500 focus:ring-0 transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Tahun Ajaran</label>
                    <select name="tahun_ajaran_id" required class="w-full bg-white/5 border-white/10 rounded-2xl text-white px-4 py-3 focus:border-amber-500 focus:ring-0 transition-all">
                        @foreach($tahunAjarans as $ta)
                        <option value="{{ $ta->id }}" class="bg-slate-900">{{ $ta->tahun }} - {{ $ta->semester }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Wali Kelas</label>
                    <select name="wali_kelas_id" required class="w-full bg-white/5 border-white/10 rounded-2xl text-white px-4 py-3 focus:border-amber-500 focus:ring-0 transition-all">
                        @foreach($gurus as $g)
                        <option value="{{ $g->id }}" class="bg-slate-900">{{ $g->user->name }}</option>
                        @endforeach
                    </select>
                    <p class="text-[9px] text-slate-500 mt-2 font-bold uppercase tracking-wider">*Satu guru hanya bisa jadi wali kelas di satu kelas.</p>
                </div>
                <div class="flex gap-4 pt-4">
                    <button type="button" onclick="document.getElementById('modal-tambah-kelas').classList.add('hidden')" class="flex-1 px-6 py-4 bg-white/5 text-white text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-white/10 transition-all">Batal</button>
                    <button type="submit" class="flex-1 px-6 py-4 bg-amber-500 text-white text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-amber-600 transition-all">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
