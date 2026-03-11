<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.teachers.index') }}" class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 border border-white/10 hover:bg-white/10 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">
                Guru & Staf / <span class="text-white">Edit Data</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-10 pb-32">
        <div class="max-w-3xl mx-auto px-6">
            <div class="mb-12">
                <h1 class="text-4xl font-black text-white tracking-tighter mb-2">Edit Guru</h1>
                <p class="text-slate-500 font-medium text-sm">Perbarui informasi tenaga pendidik: <span class="text-indigo-400 font-bold">{{ $teacher->nama_guru }}</span></p>
            </div>

            <form action="{{ route('admin.teachers.update', $teacher) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div class="glass-card rounded-[40px] border-white/5 p-8 md:p-12">
                    <div class="grid grid-cols-1 gap-8">
                        <!-- Nama Lengkap -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-4">Nama Lengkap & Gelar</label>
                            <input type="text" name="nama_guru" value="{{ old('nama_guru', $teacher->nama_guru) }}" placeholder="Contoh: Budi Sudarsono, M.Kom" required
                                class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-sm font-bold text-white placeholder-slate-600 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500/50 transition-all">
                            @error('nama_guru') <p class="text-rose-400 text-[10px] font-bold mt-1 ml-4 uppercase tracking-widest">{{ $message }}</p> @enderror
                        </div>

                        <!-- NIP -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-4">Nomor Induk Pegawai (NIP)</label>
                            <input type="text" name="nip" value="{{ old('nip', $teacher->nip) }}" placeholder="Masukkan NIP" required
                                class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-sm font-bold text-white placeholder-slate-600 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500/50 transition-all">
                            @error('nip') <p class="text-rose-400 text-[10px] font-bold mt-1 ml-4 uppercase tracking-widest">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-4">Alamat Email (Opsional)</label>
                            <input type="email" name="email" value="{{ old('email', $teacher->user->email) }}" placeholder="guru@sekolah.sch.id"
                                class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-sm font-bold text-white placeholder-slate-600 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500/50 transition-all">
                            @error('email') <p class="text-rose-400 text-[10px] font-bold mt-1 ml-4 uppercase tracking-widest">{{ $message }}</p> @enderror
                        </div>

                        <div class="pt-8 border-t border-white/5 mt-4">
                            <div class="mb-6">
                                <h3 class="text-xs font-black text-white uppercase tracking-widest mb-1">Ganti Password</h3>
                                <p class="text-[10px] text-slate-500 font-medium italic">Kosongkan jika tidak ingin mengubah password.</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Password -->
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-4">Password Baru</label>
                                    <input type="password" name="password" placeholder="••••••••"
                                        class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-sm font-bold text-white placeholder-slate-600 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500/50 transition-all">
                                    @error('password') <p class="text-rose-400 text-[10px] font-bold mt-1 ml-4 uppercase tracking-widest">{{ $message }}</p> @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div class="space-y-2">
                                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-4">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" placeholder="••••••••"
                                        class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 px-6 text-sm font-bold text-white placeholder-slate-600 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500/50 transition-all">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4">
                    <a href="{{ route('admin.teachers.index') }}" class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] hover:text-white transition-colors mr-4">
                        Batal
                    </a>
                    <button type="submit" class="btn-premium py-4 px-10 text-[10px] uppercase tracking-widest text-white shadow-[0_20px_50px_rgba(79,70,229,0.2)]">
                        Perbarui Data Guru
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
