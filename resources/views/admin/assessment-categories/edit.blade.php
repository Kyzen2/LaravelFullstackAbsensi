<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.assessment-categories.index') }}" class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 border border-white/10 hover:bg-white/10 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">
                Kriteria Nilai / <span class="text-white">Edit Data</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-10 pb-32">
        <div class="max-w-3xl mx-auto px-6">
            <div class="mb-12">
                <h1 class="text-4xl font-black text-white tracking-tighter mb-2">Edit Indikator</h1>
                <p class="text-slate-500 font-medium text-sm">Perbarui informasi indikator penilaian: <span class="text-indigo-400 font-bold tracking-tight uppercase">{{ $assessmentCategory->name }}</span></p>
            </div>

            <form action="{{ route('admin.assessment-categories.update', $assessmentCategory) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div class="glass-card rounded-[40px] border-white/5 p-8 md:p-12">
                    <div class="grid grid-cols-1 gap-8">
                        <!-- Nama Indikator -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-4">Nama Indikator</label>
                            <input type="text" name="name" value="{{ old('name', $assessmentCategory->name) }}" placeholder="Contoh: KEDISIPLINAN, KERAPIHAN" required
                                class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-sm font-bold text-white placeholder-slate-600 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500/50 transition-all uppercase">
                            @error('name') <p class="text-rose-400 text-[10px] font-bold mt-1 ml-4 uppercase tracking-widest">{{ $message }}</p> @enderror
                        </div>

                        <!-- Tipe -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-4">Tipe / Kategori</label>
                            <input type="text" name="type" value="{{ old('type', $assessmentCategory->type) }}" placeholder="Contoh: SIKAP, KOMPETENSI"
                                class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-sm font-bold text-white placeholder-slate-600 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500/50 transition-all uppercase">
                            @error('type') <p class="text-rose-400 text-[10px] font-bold mt-1 ml-4 uppercase tracking-widest">{{ $message }}</p> @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-4">Deskripsi Indikator</label>
                            <textarea name="description" rows="4" placeholder="Jelaskan detail apa yang dinilai pada indikator ini..."
                                class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-sm font-bold text-white placeholder-slate-600 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500/50 transition-all leading-relaxed">{{ old('description', $assessmentCategory->description) }}</textarea>
                            @error('description') <p class="text-rose-400 text-[10px] font-bold mt-1 ml-4 uppercase tracking-widest">{{ $message }}</p> @enderror
                        </div>

                        <!-- Status Aktif/Nonaktif -->
                        <div class="space-y-4 pt-4 border-t border-white/5">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-4">Status Indikator</label>
                            <div class="flex items-center gap-4">
                                <label class="flex items-center cursor-pointer group">
                                    <input type="radio" name="is_active" value="1" {{ $assessmentCategory->is_active ? 'checked' : '' }} class="hidden peer">
                                    <div class="px-6 py-3 rounded-2xl bg-white/5 border border-white/10 text-[10px] font-black uppercase tracking-widest text-slate-500 peer-checked:bg-emerald-500/10 peer-checked:border-emerald-500/50 peer-checked:text-emerald-400 transition-all">AKTIF</div>
                                </label>
                                <label class="flex items-center cursor-pointer group">
                                    <input type="radio" name="is_active" value="0" {{ !$assessmentCategory->is_active ? 'checked' : '' }} class="hidden peer">
                                    <div class="px-6 py-3 rounded-2xl bg-white/5 border border-white/10 text-[10px] font-black uppercase tracking-widest text-slate-500 peer-checked:bg-rose-500/10 peer-checked:border-rose-500/50 peer-checked:text-rose-400 transition-all">NONAKTIF</div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4">
                    <a href="{{ route('admin.assessment-categories.index') }}" class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] hover:text-white transition-colors mr-4">
                        Batal
                    </a>
                    <button type="submit" class="btn-premium py-4 px-10 text-[10px] uppercase tracking-widest text-white shadow-[0_20px_50px_rgba(79,70,229,0.2)]">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
