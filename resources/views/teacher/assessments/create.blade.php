<x-app-layout>
    <style>
        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
            gap: 12px;
        }
        .star-rating input {
            display: none;
        }
        .star-rating label {
            cursor: pointer;
            width: 48px;
            height: 48px;
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            color: #475569;
        }
        .star-rating label svg {
            width: 24px;
            height: 24px;
        }
        .star-rating label:hover,
        .star-rating label:hover ~ label,
        .star-rating input:checked ~ label {
            background-color: rgba(79, 70, 229, 0.1);
            border-color: rgba(79, 70, 229, 0.5);
            color: #818cf8;
            transform: scale(1.1);
        }
    </style>

    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('teacher.assessments.index') }}" class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 border border-white/10 hover:bg-white/10 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">
                Mulai Penilaian / <span class="text-white">Form Evaluasi</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-10 pb-32">
        <div class="max-w-4xl mx-auto px-6">
            <form action="{{ route('teacher.assessments.store') }}" method="POST" class="space-y-8">
                @csrf
                <input type="hidden" name="evaluatee_id" value="{{ $studentUser->id }}">
                <input type="hidden" name="period" value="{{ $period }}">

                <!-- Student Profile Card -->
                <div class="glass-card rounded-[40px] border-white/5 p-8 md:p-12">
                    <div class="flex flex-col md:flex-row items-center gap-8 md:gap-12 text-center md:text-left">
                        <div class="w-32 h-32 rounded-[40px] bg-slate-800 border-4 border-indigo-500/20 shadow-2xl flex items-center justify-center text-4xl font-black text-slate-600">
                           {{ substr($studentUser->name, 0, 1) }}
                        </div>
                        <div>
                            <h1 class="text-4xl font-black text-white tracking-tighter mb-2 uppercase">{{ $studentUser->name }}</h1>
                            <p class="text-indigo-400 font-bold text-sm tracking-widest uppercase mb-4">{{ $studentUser->serial_number }}</p>
                            <span class="px-4 py-2 bg-white/5 rounded-full border border-white/10 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                Periode: {{ $period }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Assessment Indicators -->
                <div class="space-y-6">
                    @foreach($categories as $category)
                    <div class="glass-card rounded-[40px] border-white/5 p-10 group hover:bg-white/[0.02] transition-colors">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-10">
                            <div class="max-w-md">
                                <h3 class="text-xl font-black text-white tracking-tight mb-2 group-hover:text-indigo-400 transition-colors uppercase">{{ $category->name }}</h3>
                                <p class="text-xs text-slate-500 font-medium leading-relaxed">{{ $category->description ?? 'Indikator penilaian kompetensi.' }}</p>
                            </div>
                            
                            <div class="star-rating">
                                @for($i = 5; $i >= 1; $i--)
                                <input type="radio" id="star-{{ $category->id }}-{{ $i }}" name="scores[{{ $category->id }}]" value="{{ $i }}" required>
                                <label for="star-{{ $category->id }}-{{ $i }}" title="{{ $i }} Bintang">
                                    <svg viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                    </svg>
                                </label>
                                @endfor
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Notes -->
                <div class="glass-card rounded-[40px] border-white/5 p-10">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 block ml-2">Catatan Perbaikan / Feedback</label>
                    <textarea name="general_notes" rows="6" placeholder="Berikan masukan konstruktif untuk pengembangan diri siswa..."
                        class="w-full bg-white/5 border border-white/10 rounded-3xl py-6 px-8 text-sm font-bold text-white placeholder-slate-700 focus:outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/10 transition-all transition-all leading-relaxed"></textarea>
                </div>

                <!-- Actions -->
                <div class="flex flex-col md:flex-row items-center justify-end gap-6 pt-10">
                    <a href="{{ route('teacher.assessments.index') }}" class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] hover:text-white transition-colors">
                        Batalkan Sesi
                    </a>
                    
                    <div class="flex gap-4 w-full md:w-auto">
                        <button type="submit" name="action" value="save" class="flex-1 md:flex-none py-5 px-12 bg-white/5 border border-white/10 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] text-white hover:bg-white/10 transition-all">
                            Simpan Draft
                        </button>
                        <button type="submit" name="action" value="save_next" class="flex-1 md:flex-none btn-premium py-5 px-12 text-[10px] uppercase tracking-widest text-white shadow-[0_20px_50px_rgba(79,70,229,0.3)]">
                            Simpan & Lanjut ke Orang Berikutnya
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
