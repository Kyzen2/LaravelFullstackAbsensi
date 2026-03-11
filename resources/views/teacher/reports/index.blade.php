<x-app-layout>
    <x-slot name="header">
        <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">Cetak Laporan Absensi</h2>
    </x-slot>

    <div class="py-10 pb-32 min-h-screen bg-[#020617] relative overflow-hidden">
        <!-- Background Orbs -->
        <div class="absolute top-0 right-0 -mr-32 -mt-32 w-96 h-96 bg-indigo-500/10 blur-[120px] rounded-full"></div>
        <div class="absolute bottom-10 left-0 -ml-32 w-96 h-96 bg-emerald-500/10 blur-[120px] rounded-full"></div>

        <div class="max-w-xl mx-auto px-6 relative z-10">
            <!-- Header Section -->
            <div class="mb-10 text-center">
                <h1 class="text-3xl font-black text-white tracking-tighter uppercase leading-tight mb-2">Filter Laporan</h1>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">Tentukan kriteria laporan yang ingin dicetak</p>
            </div>

            @if(session('error'))
            <div class="mb-6 p-4 rounded-2xl bg-rose-500/10 border border-rose-500/20 text-rose-500 text-xs font-bold text-center">
                {{ session('error') }}
            </div>
            @endif

            <form action="{{ route('teacher.reports.export') }}" method="GET" class="space-y-6">
                <!-- Select Mapel -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-2 block">Mata Pelajaran</label>
                    <div class="relative group">
                        <select name="mapel_id" required 
                            class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-sm font-bold text-white focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500/50 transition-all cursor-pointer">
                            <option value="" disabled selected class="bg-slate-900 text-white">Pilih Mata Pelajaran</option>
                            @foreach($mapels as $mapel)
                                <option value="{{ $mapel->id }}" class="bg-slate-900 text-white">{{ strtoupper($mapel->nama_mapel) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Select Kelas -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-2 block">Kelas / Jurusan</label>
                    <div class="relative group">
                        <select name="kelas_id" required 
                            class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-sm font-bold text-white focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500/50 transition-all cursor-pointer">
                            <option value="" disabled selected class="bg-slate-900 text-white">Pilih Kelas</option>
                            @foreach($classes as $kelas)
                                <option value="{{ $kelas->id }}" class="bg-slate-900 text-white">{{ strtoupper($kelas->nama_kelas) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Date Range -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-2 block">Dari Tanggal</label>
                        <input type="date" name="start_date" required 
                            class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-sm font-bold text-white focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500/50 transition-all cursor-pointer">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-2 block">Sampai Tanggal</label>
                        <input type="date" name="end_date" required 
                            class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-sm font-bold text-white focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500/50 transition-all cursor-pointer">
                    </div>
                </div>

                <button type="submit" class="w-full mt-4 bg-indigo-600 hover:bg-indigo-500 text-white font-black py-4 rounded-2xl shadow-lg shadow-indigo-500/20 transition-all duration-300 transform active:scale-95 flex items-center justify-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    CETAK PDF SEKARANG
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
