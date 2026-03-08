<x-app-layout>
    <x-slot name="header">
        <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">Pilih Kelas</h2>
    </x-slot>

    <div class="py-10 pb-32 min-h-screen bg-[#020617] relative overflow-hidden">
        <!-- Background Orbs -->
        <div class="absolute top-0 right-0 -mr-32 -mt-32 w-96 h-96 bg-indigo-500/10 blur-[120px] rounded-full"></div>
        <div class="absolute bottom-10 left-0 -ml-32 w-96 h-96 bg-emerald-500/10 blur-[120px] rounded-full"></div>

        <div class="max-w-md mx-auto px-6 relative z-10">
            <!-- Search Bar -->
            <div class="mb-8">
                <form action="{{ route('teacher.attendance.index') }}" method="GET">
                    <div class="relative group">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari kelas atau jurusan..." 
                            class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 pl-12 pr-4 text-white placeholder-slate-500 focus:outline-none focus:border-indigo-500/50 focus:ring-4 focus:ring-indigo-500/10 transition-all">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 group-focus-within:text-indigo-400 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Class Grid -->
            <div class="space-y-4">
                @forelse($classes as $kelas)
                <a href="{{ route('teacher.attendance.class', $kelas) }}" class="block glass-card p-6 rounded-[2.5rem] border-white/5 group hover:border-indigo-500/30 active:scale-[0.98] transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-indigo-500/10 flex items-center justify-center text-indigo-400 border border-indigo-500/10 group-hover:bg-indigo-500/20 transition-colors">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-white font-black text-lg leading-tight mb-1 group-hover:text-indigo-400 transition-colors">{{ $kelas->nama_kelas }}</h3>
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ $kelas->tahunAjaran->tahun }}</span>
                                    <span class="w-1 h-1 rounded-full bg-slate-700"></span>
                                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ $kelas->tahunAjaran->semester }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-slate-500 group-hover:text-indigo-400 group-hover:bg-indigo-500/10 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                    </div>
                </a>
                @empty
                <div class="py-20 text-center">
                    <div class="w-20 h-20 bg-slate-500/5 rounded-full flex items-center justify-center mx-auto mb-6 border border-white/5">
                        <svg class="w-8 h-8 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">Kelas tidak ditemukan</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
