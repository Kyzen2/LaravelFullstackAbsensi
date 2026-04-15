<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.jadwal.index') }}" class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 border border-white/10 hover:bg-white/10 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">
                Master Data / Jadwal / <span class="text-white">{{ isset($jadwal) ? 'Edit Jadwal' : 'Tambah Jadwal' }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-10 pb-32">
        <div class="max-w-3xl mx-auto px-6">
            <div class="glass-card p-10 rounded-[48px] border-white/5">
                <div class="mb-8">
                    <h3 class="text-2xl font-black text-white tracking-tight">{{ isset($jadwal) ? 'Edit Data Jadwal' : 'Tambah Jadwal Baru' }}</h3>
                    <p class="text-slate-500 text-sm mt-1">Lengkapi informasi jadwal mata pelajaran, kelas, dan waktu mengajar.</p>
                </div>

                <form action="{{ isset($jadwal) ? route('admin.jadwal.update', $jadwal) : route('admin.jadwal.store') }}" method="POST" class="space-y-6">
                    @csrf
                    @if(isset($jadwal))
                        @method('PUT')
                    @endif

                    <!-- Guru & Mapel -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Guru Pengajar</label>
                            <select name="guru_id" class="w-full bg-slate-800/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500/50" required>
                                <option value="">Pilih Guru...</option>
                                @foreach($gurus as $guru)
                                    <option value="{{ $guru->id }}" {{ (old('guru_id', $jadwal->guru_id ?? '')) == $guru->id ? 'selected' : '' }}>
                                        {{ $guru->nama_guru }}
                                    </option>
                                @endforeach
                            </select>
                            @error('guru_id') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Mata Pelajaran</label>
                            <select name="mapel_id" class="w-full bg-slate-800/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500/50" required>
                                <option value="">Pilih Mata Pelajaran...</option>
                                @foreach($mapels as $mapel)
                                    <option value="{{ $mapel->id }}" {{ (old('mapel_id', $jadwal->mapel_id ?? '')) == $mapel->id ? 'selected' : '' }}>
                                        {{ $mapel->nama_mapel }}
                                    </option>
                                @endforeach
                            </select>
                            @error('mapel_id') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Kelas & Lokasi -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Pilih Kelas</label>
                            <select name="kelas_id" class="w-full bg-slate-800/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500/50" required>
                                <option value="">Pilih Kelas...</option>
                                @foreach($kelases as $kelas)
                                    <option value="{{ $kelas->id }}" {{ (old('kelas_id', $jadwal->kelas_id ?? '')) == $kelas->id ? 'selected' : '' }}>
                                        {{ $kelas->nama_kelas }} ({{ $kelas->tingkat_kelas }})
                                    </option>
                                @endforeach
                            </select>
                            @error('kelas_id') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Lokasi (Opsional)</label>
                            <select name="lokasi_id" class="w-full bg-slate-800/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500/50">
                                <option value="">Tidak ada batasan lokasi</option>
                                @foreach($lokasis as $lokasi)
                                    <option value="{{ $lokasi->id }}" {{ (old('lokasi_id', $jadwal->lokasi_id ?? '')) == $lokasi->id ? 'selected' : '' }}>
                                        {{ $lokasi->nama_lokasi }}
                                    </option>
                                @endforeach
                            </select>
                            @error('lokasi_id') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Hari & Waktu -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Hari</label>
                            <select name="hari" class="w-full bg-slate-800/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500/50" required>
                                <option value="">Pilih Hari...</option>
                                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $h)
                                    <option value="{{ $h }}" {{ (old('hari', $jadwal->hari ?? '')) == $h ? 'selected' : '' }}>
                                        {{ $h }}
                                    </option>
                                @endforeach
                            </select>
                            @error('hari') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Jam Mulai</label>
                            <input type="time" name="jam_mulai" value="{{ old('jam_mulai', $jadwal->jam_mulai ?? '') }}" class="w-full bg-slate-800/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500/50" required>
                            @error('jam_mulai') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Jam Selesai</label>
                            <input type="time" name="jam_selesai" value="{{ old('jam_selesai', $jadwal->jam_selesai ?? '') }}" class="w-full bg-slate-800/50 border border-white/10 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-indigo-500/50" required>
                            @error('jam_selesai') <span class="text-rose-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="pt-6 border-t border-white/5 flex gap-4">
                        <button type="submit" class="px-8 py-3 bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-indigo-500/20">
                            {{ isset($jadwal) ? 'Simpan Perubahan' : 'Tambahkan Jadwal' }}
                        </button>
                        <a href="{{ route('admin.jadwal.index') }}" class="px-8 py-3 bg-slate-800 hover:bg-slate-700 text-white text-sm font-bold rounded-xl transition-all border border-white/5">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
