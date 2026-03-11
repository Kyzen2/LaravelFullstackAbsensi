<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.assessment-categories.index') }}" class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 border border-white/10 hover:bg-white/10 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">
                Kriteria Nilai / <span class="text-white">Tambah Baru</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-10 pb-32">
        <div class="max-w-3xl mx-auto px-6">
            <div class="mb-12">
                <h1 class="text-4xl font-black text-white tracking-tighter mb-2">Indikator Baru</h1>
                <p class="text-slate-500 font-medium text-sm">Definisikan parameter penilaian baru untuk sistem evaluasi.</p>
            </div>

            <form action="{{ route('admin.assessment-categories.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="glass-card rounded-[40px] border-white/5 p-8 md:p-12">
                    <div class="grid grid-cols-1 gap-8">
                        <!-- Nama Indikator -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-4">Nama Indikator</label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: KEDISIPLINAN, KERAPIHAN" required
                                class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-sm font-bold text-white placeholder-slate-600 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500/50 transition-all uppercase">
                            @error('name') <p class="text-rose-400 text-[10px] font-bold mt-1 ml-4 uppercase tracking-widest">{{ $message }}</p> @enderror
                        </div>

                        <!-- Tipe -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-4">Tipe / Kategori</label>
                            <input type="text" name="type" value="{{ old('type') }}" placeholder="Contoh: SIKAP, KOMPETENSI"
                                class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-sm font-bold text-white placeholder-slate-600 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500/50 transition-all uppercase">
                            @error('type') <p class="text-rose-400 text-[10px] font-bold mt-1 ml-4 uppercase tracking-widest">{{ $message }}</p> @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-4">Deskripsi Indikator</label>
                            <textarea name="description" rows="4" placeholder="Jelaskan detail apa yang dinilai pada indikator ini..."
                                class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-sm font-bold text-white placeholder-slate-600 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500/50 transition-all leading-relaxed">{{ old('description') }}</textarea>
                            @error('description') <p class="text-rose-400 text-[10px] font-bold mt-1 ml-4 uppercase tracking-widest">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4">
                    <a href="{{ route('admin.assessment-categories.index') }}" class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] hover:text-white transition-colors mr-4">
                        Batal
                    </a>
                    <button type="submit" class="btn-premium py-4 px-10 text-[10px] uppercase tracking-widest text-white shadow-[0_20px_50px_rgba(79,70,229,0.2)]">
                        Simpan Indikator
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
