<x-app-layout>
    <x-slot name="header">
        <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">
            Dashboard / <span class="text-white">Penilaian Siswa</span>
        </h2>
    </x-slot>

    <div class="py-10 pb-32">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Header Section with Progress -->
            <div class="glass-card rounded-[40px] border-white/5 p-8 md:p-12 mb-12">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-12">
                    <div class="flex-1">
                        <h1 class="text-4xl font-black text-white tracking-tighter mb-4">Evaluasi Berkala</h1>
                        <p class="text-slate-500 font-medium mb-8">Periode: <span class="text-indigo-400 font-bold uppercase tracking-widest">{{ $period }}</span></p>
                        
                        <!-- Progress info -->
                        <div class="space-y-4">
                            <div class="flex items-center justify-between text-[10px] font-black uppercase tracking-[0.2em]">
                                <span class="text-slate-400 text-xs">Progress Penilaian</span>
                                <span class="text-indigo-400 text-sm tracking-widest">{{ $totalEvaluated }} / {{ $totalStudents }} Siswa</span>
                            </div>
                            <!-- Modern Progress Bar -->
                            <div class="h-6 w-full bg-white/5 rounded-full p-1.5 border border-white/10 relative overflow-hidden shadow-[inset_0_2px_10px_rgba(0,0,0,0.5)]">
                                <div class="h-full bg-gradient-to-r from-indigo-600 via-violet-500 to-indigo-400 rounded-full shadow-[0_0_20px_rgba(79,70,229,0.5)] transition-all duration-1000 relative" style="width: {{ $progress }}%">
                                    <!-- Shine effect -->
                                    <div class="absolute inset-0 bg-white/10 animate-pulse"></div>
                                </div>
                            </div>
                            <p class="text-[10px] text-slate-500 font-bold italic">"Anda telah menilai {{ $totalEvaluated }} dari {{ $totalStudents }} siswa bulan ini."</p>
                        </div>
                    </div>
                    
                    <div class="hidden lg:block w-px h-32 bg-white/5"></div>

                    <div class="hidden lg:flex items-center gap-6">
                        <div class="text-center">
                            <div class="text-4xl font-black text-white mb-1">{{ $totalStudents - $totalEvaluated }}</div>
                            <div class="text-[9px] font-bold text-slate-600 uppercase tracking-widest">Belum Dinilai</div>
                        </div>
                        <div class="w-px h-12 bg-white/5"></div>
                        <div class="text-center">
                            <div class="text-4xl font-black text-emerald-400 mb-1">{{ $totalEvaluated }}</div>
                            <div class="text-[9px] font-bold text-slate-600 uppercase tracking-widest">Sudah Selesai</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Student Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($students as $siswa)
                @php $isEvaluated = in_array($siswa->user_id, $evaluatedIds); @endphp
                
                <div class="glass-card group hover:bg-white/[0.04] transition-all duration-500 rounded-[35px] border-white/5 p-8 relative overflow-hidden flex flex-col items-center text-center {{ $isEvaluated ? 'border-emerald-500/20' : '' }}">
                    
                    <!-- Status Badge -->
                    @if($isEvaluated)
                    <div class="absolute top-6 right-6 flex items-center gap-1.5 px-3 py-1 bg-emerald-500/10 border border-emerald-500/20 rounded-full">
                        <div class="w-1 h-1 rounded-full bg-emerald-400 animate-pulse"></div>
                        <span class="text-[8px] font-black text-emerald-400 uppercase tracking-widest">Selesai</span>
                    </div>
                    @else
                    <div class="absolute top-6 right-6 flex items-center gap-1.5 px-3 py-1 bg-amber-500/10 border border-amber-500/20 rounded-full">
                        <div class="w-1 h-1 rounded-full bg-amber-400"></div>
                        <span class="text-[8px] font-black text-amber-400 uppercase tracking-widest">Menunggu</span>
                    </div>
                    @endif

                    <!-- Avatar -->
                    <div class="w-24 h-24 rounded-[30px] bg-slate-800 border-4 border-white/5 mb-6 overflow-hidden flex items-center justify-center relative shadow-2xl group-hover:scale-105 transition-transform duration-500">
                        <span class="text-3xl font-black text-slate-600">{{ substr($siswa->nama_siswa, 0, 1) }}</span>
                        <!-- Decorative glow -->
                        <div class="absolute inset-0 bg-gradient-to-tr from-indigo-500/20 to-transparent group-hover:opacity-100 opacity-0 transition-opacity"></div>
                    </div>

                    <!-- Info -->
                    <h3 class="text-lg font-black text-white tracking-tight mb-1 group-hover:text-indigo-400 transition-colors uppercase">{{ $siswa->nama_siswa }}</h3>
                    <p class="text-[10px] font-bold text-slate-600 uppercase tracking-widest mb-8">{{ $siswa->nisn }}</p>

                    <!-- Action Button -->
                    <a href="{{ route('teacher.assessments.create', $siswa->user_id) }}" 
                       class="w-full py-4 rounded-2xl border transition-all duration-300 flex items-center justify-center gap-3 text-[10px] font-black uppercase tracking-widest
                              {{ $isEvaluated ? 'bg-white/5 border-white/10 text-white hover:bg-white/10' : 'bg-indigo-600 border-indigo-500 text-white hover:bg-indigo-500 shadow-[0_10px_30px_rgba(79,70,229,0.3)]' }}">
                        {{ $isEvaluated ? 'Ubah Penilaian' : 'Mulai Menilai' }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
