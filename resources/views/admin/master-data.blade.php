<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 border border-white/10 hover:bg-white/10 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">
                Master Hub / <span class="text-white">Launch Center</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-10 pb-32">
        <div class="max-w-7xl mx-auto px-6">
            <div class="mb-12">
                <h1 class="text-4xl font-black text-white tracking-tighter mb-4">Kontrol Inti Sistem</h1>
                <p class="text-slate-500 font-medium">Kelola dan pantau semua entitas dalam ekosistem absensi.</p>
            </div>

            <!-- Management Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Guru Management -->
                <div class="glass-card p-10 rounded-[48px] border-white/5 group hover:bg-indigo-500/10 transition-all duration-500 relative overflow-hidden">
                    <div class="absolute -right-8 -top-8 w-32 h-32 bg-indigo-500/10 blur-3xl rounded-full group-hover:bg-indigo-500/20 transition-all duration-700"></div>
                    <div class="relative z-10 space-y-6">
                        <div class="w-16 h-16 bg-indigo-500/20 rounded-[20px] flex items-center justify-center text-indigo-400 border border-indigo-500/20">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-white tracking-tight mb-2">Guru & Staf</h3>
                            <p class="text-slate-500 text-xs font-semibold uppercase tracking-widest leading-relaxed">Pengelolaan tenaga pendidik dan kredensial akses.</p>
                        </div>
                        <a href="{{ route('admin.teachers.index') }}" class="flex items-center gap-2 text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em] group-hover:gap-4 transition-all">
                            Konfigurasi Guru <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </div>

                <!-- Siswa Management -->
                <div class="glass-card p-10 rounded-[48px] border-white/5 group hover:bg-emerald-500/10 transition-all duration-500 relative overflow-hidden">
                    <div class="absolute -right-8 -top-8 w-32 h-32 bg-emerald-500/10 blur-3xl rounded-full group-hover:bg-emerald-500/20 transition-all duration-700"></div>
                    <div class="relative z-10 space-y-6">
                        <div class="w-16 h-16 bg-emerald-500/20 rounded-[20px] flex items-center justify-center text-emerald-400 border border-emerald-500/20">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-white tracking-tight mb-2">Direktori Siswa</h3>
                            <p class="text-slate-500 text-xs font-semibold uppercase tracking-widest leading-relaxed">Database semua siswa aktif dan pembagian jadwal kelas.</p>
                        </div>
                        <a href="{{ route('admin.students.index') }}" class="flex items-center gap-2 text-[10px] font-black text-emerald-400 uppercase tracking-[0.2em] group-hover:gap-4 transition-all">
                            Buka Database <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </div>

                <!-- Kelas Management -->
                <div class="glass-card p-10 rounded-[48px] border-white/5 group hover:bg-amber-500/10 transition-all duration-500 relative overflow-hidden">
                    <div class="absolute -right-8 -top-8 w-32 h-32 bg-amber-500/10 blur-3xl rounded-full group-hover:bg-amber-500/20 transition-all duration-700"></div>
                    <div class="relative z-10 space-y-6">
                        <div class="w-16 h-16 bg-amber-500/20 rounded-[20px] flex items-center justify-center text-amber-400 border border-amber-500/20">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-white tracking-tight mb-2">Kelas & Jurusan</h3>
                            <p class="text-slate-500 text-xs font-semibold uppercase tracking-widest leading-relaxed">Struktur kelas akademik dan pengelompokan jurusan.</p>
                        </div>
                        <a href="#" class="flex items-center gap-2 text-[10px] font-black text-amber-400 uppercase tracking-[0.2em] group-hover:gap-4 transition-all">
                            Kelola Struktur <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </div>

                <!-- Mapel Management -->
                <div class="glass-card p-10 rounded-[48px] border-white/5 group hover:bg-rose-500/10 transition-all duration-500 relative overflow-hidden">
                    <div class="absolute -right-8 -top-8 w-32 h-32 bg-rose-500/10 blur-3xl rounded-full group-hover:bg-rose-500/20 transition-all duration-700"></div>
                    <div class="relative z-10 space-y-6">
                        <div class="w-16 h-16 bg-rose-500/20 rounded-[20px] flex items-center justify-center text-rose-400 border border-rose-500/20">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-white tracking-tight mb-2">Kurikulum</h3>
                            <p class="text-slate-500 text-xs font-semibold uppercase tracking-widest leading-relaxed">Daftar mata pelajaran dan konfigurasi silabus pengajaran.</p>
                        </div>
                        <a href="#" class="flex items-center gap-2 text-[10px] font-black text-rose-400 uppercase tracking-[0.2em] group-hover:gap-4 transition-all">
                            Atur Silabus <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </div>

                <!-- Lokasi Management -->
                <div class="glass-card p-10 rounded-[48px] border-white/5 group hover:bg-slate-400/10 transition-all duration-500 relative overflow-hidden">
                    <div class="absolute -right-8 -top-8 w-32 h-32 bg-slate-500/10 blur-3xl rounded-full group-hover:bg-slate-500/20 transition-all duration-700"></div>
                    <div class="relative z-10 space-y-6">
                        <div class="w-16 h-16 bg-slate-500/20 rounded-[20px] flex items-center justify-center text-slate-400 border border-slate-500/20">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-white tracking-tight mb-2">Geofencing</h3>
                            <p class="text-slate-500 text-xs font-semibold uppercase tracking-widest leading-relaxed">Koordinat peta dan radius untuk absensi berbasis lokasi.</p>
                        </div>
                        <a href="#" class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] group-hover:gap-4 transition-all">
                            Sinkronkan Lokasi <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </div>

                <!-- Schedule Management -->
                <div class="glass-card p-10 rounded-[48px] border-white/5 group hover:bg-indigo-400/10 transition-all duration-500 relative overflow-hidden">
                    <div class="absolute -right-8 -top-8 w-32 h-32 bg-indigo-400/10 blur-3xl rounded-full group-hover:bg-indigo-400/20 transition-all duration-700"></div>
                    <div class="relative z-10 space-y-6">
                        <div class="w-16 h-16 bg-indigo-400/20 rounded-[20px] flex items-center justify-center text-indigo-300 border border-indigo-400/20">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-white tracking-tight mb-2">Jadwal Pelajaran</h3>
                            <p class="text-slate-500 text-xs font-semibold uppercase tracking-widest leading-relaxed">Master jadwal mingguan untuk semua kelas dan guru.</p>
                        </div>
                        <a href="{{ route('admin.jadwal.index') }}" class="flex items-center gap-2 text-[10px] font-black text-indigo-300 uppercase tracking-[0.2em] group-hover:gap-4 transition-all">
                            Atur Jadwal <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </div>

                <!-- Assessment Management -->
                <div class="glass-card p-10 rounded-[48px] border-white/5 group hover:bg-emerald-400/10 transition-all duration-500 relative overflow-hidden">
                    <div class="absolute -right-8 -top-8 w-32 h-32 bg-emerald-400/10 blur-3xl rounded-full group-hover:bg-emerald-400/20 transition-all duration-700"></div>
                    <div class="relative z-10 space-y-6">
                        <div class="w-16 h-16 bg-emerald-400/20 rounded-[20px] flex items-center justify-center text-emerald-300 border border-emerald-400/20">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-white tracking-tight mb-2">Kriteria Nilai</h3>
                            <p class="text-slate-500 text-xs font-semibold uppercase tracking-widest leading-relaxed">Kelola kriteria penilaian untuk semua anggota.</p>
                        </div>
                        <a href="{{ route('admin.assessment-categories.index') }}" class="flex items-center gap-2 text-[10px] font-black text-emerald-300 uppercase tracking-[0.2em] group-hover:gap-4 transition-all">
                            Konfigurasi Kriteria <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </div>

                <!-- Gamification Management -->
                <div class="glass-card p-10 rounded-[48px] border-white/5 group hover:bg-cyan-400/10 transition-all duration-500 relative overflow-hidden">
                    <div class="absolute -right-8 -top-8 w-32 h-32 bg-cyan-400/10 blur-3xl rounded-full group-hover:bg-cyan-400/20 transition-all duration-700"></div>
                    <div class="relative z-10 space-y-6">
                        <div class="w-16 h-16 bg-cyan-400/20 rounded-[20px] flex items-center justify-center text-cyan-300 border border-cyan-400/20">
                            <!-- Game controller icon -->
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-black text-white tracking-tight mb-2">Gamifikasi Toko</h3>
                            <p class="text-slate-500 text-xs font-semibold uppercase tracking-widest leading-relaxed">Ekosistem poin aturan dan toko token saktinya.</p>
                        </div>
                        <a href="{{ route('admin.gamification.index') }}" class="flex items-center gap-2 text-[10px] font-black text-cyan-300 uppercase tracking-[0.2em] group-hover:gap-4 transition-all">
                            Masuk Gamifikasi <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
