<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.kelas.index') }}" class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 border border-white/10 hover:bg-white/10 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">
                Master Kelas / <span class="text-white">{{ $kelas->nama_kelas }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-10 pb-32">
        <div class="max-w-7xl mx-auto px-6">
            
            <div class="flex flex-col lg:flex-row gap-8">
                
                <!-- Info Panel -->
                <div class="w-full lg:w-1/3 space-y-6">
                    <div class="glass-card p-10 rounded-[48px] border-white/5 relative overflow-hidden">
                        <div class="space-y-6 relative z-10">
                            <div class="w-20 h-20 bg-amber-500/20 rounded-[24px] flex items-center justify-center text-amber-400 border border-amber-500/20 mb-8">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <div>
                                <h1 class="text-3xl font-black text-white tracking-tighter">{{ $kelas->nama_kelas }}</h1>
                                <p class="text-slate-500 text-xs font-black uppercase tracking-widest mt-2">{{ $kelas->tahunAjaran->tahun }} — {{ $kelas->tahunAjaran->semester }}</p>
                            </div>
                            <div class="p-6 bg-white/[0.03] rounded-3xl border border-white/5 mt-8">
                                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Wali Kelas Utama</p>
                                <p class="text-white font-bold">{{ $kelas->waliKelas->user->name ?? 'N/A' }}</p>
                                <p class="text-slate-500 text-xs font-semibold mt-1">NIP: {{ $kelas->waliKelas->nip }}</p>
                            </div>
                            <div class="pt-4">
                                <div class="flex justify-between text-[10px] font-black uppercase tracking-widest mb-2">
                                    <span class="text-slate-500">Total Murid Aktif</span>
                                    <span class="text-amber-400">{{ $kelas->anggotaKelas->count() }} Siswa</span>
                                </div>
                                <div class="w-full h-1 bg-white/5 rounded-full overflow-hidden">
                                    <div class="bg-amber-500 h-full" style="width: 100%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Tambah Murid -->
                    <div class="glass-card p-8 rounded-[40px] border-white/5">
                        <h4 class="text-sm font-black text-white uppercase tracking-widest mb-6">Tambah Anggota Kelas</h4>
                        <form action="{{ route('admin.kelas.students.add', $kelas) }}" method="POST" class="space-y-4">
                            @csrf
                            <select name="siswa_id" class="w-full bg-white/5 border-white/10 rounded-2xl text-white px-4 py-3 text-sm focus:border-amber-500 focus:ring-0 transition-all">
                                <option value="" class="bg-slate-900">Pilih Siswa...</option>
                                @foreach($availableStudents as $s)
                                <option value="{{ $s->id }}" class="bg-slate-900">{{ $s->user->name }} ({{ $s->nisn }})</option>
                                @endforeach
                            </select>
                            <button type="submit" class="w-full px-6 py-4 bg-amber-500 text-white text-[10px] font-black uppercase tracking-widest rounded-2xl hover:bg-amber-600 transition-all shadow-lg shadow-amber-500/20">
                                Masukkan ke Kelas
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Students Table -->
                <div class="w-full lg:w-2/3">
                    <div class="glass-card rounded-[40px] border-white/5 overflow-hidden">
                        <div class="px-8 py-6 border-b border-white/5 bg-white/[0.02] flex justify-between items-center">
                            <h3 class="text-xs font-black text-white uppercase tracking-[0.2em]">Daftar Murid Terdaftar</h3>
                            <span class="px-3 py-1 bg-white/5 rounded-full text-[10px] font-black text-slate-400 uppercase tracking-widest">Live Sync</span>
                        </div>
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-white/5">
                                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Lengkap</th>
                                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">NISN</th>
                                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5">
                                @forelse($kelas->anggotaKelas as $anggota)
                                <tr class="group hover:bg-white/[0.02] transition-colors">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded-xl bg-slate-800 border border-white/10 flex items-center justify-center text-slate-400 font-black text-xs uppercase">
                                                {{ substr($anggota->siswa->user->name, 0, 2) }}
                                            </div>
                                            <span class="text-white font-bold">{{ $anggota->siswa->user->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <span class="text-slate-400 font-mono text-xs">{{ $anggota->siswa->nisn }}</span>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <form action="{{ route('admin.kelas.students.remove', [$kelas, $anggota->siswa]) }}" method="POST" onsubmit="return confirm('Keluarkan siswa ini dari kelas?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-rose-500 hover:text-rose-400 transition-colors">
                                                <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1m12-10a2 2 0 012 2 2 2 0 11-2-2m3 7a3 3 0 00-3-3h-1m0 0l-1 1m1-1l1 1m-1-1l-1-1"></path></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-8 py-16 text-center text-slate-600 font-black uppercase text-[10px] tracking-widest">Kelas ini belum memiliki murid.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
