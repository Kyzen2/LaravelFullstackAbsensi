<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.master.data') }}" class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 border border-white/10 hover:bg-white/10 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">
                Master Hub / <span class="text-white">Direktori Siswa</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-10 pb-32">
        <div class="max-w-7xl mx-auto px-6">
            
            <!-- Notifikasi Success/Error -->
            @if(session('success'))
            <div class="mb-8 p-6 bg-emerald-500/10 border border-emerald-500/20 rounded-[32px] text-emerald-400 text-[10px] font-black uppercase tracking-widest">
                {{ session('success') }}
            </div>
            @endif

            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
                <div>
                    <h1 class="text-4xl font-black text-white tracking-tighter mb-2">Manajemen Siswa</h1>
                    <p class="text-slate-500 font-medium text-sm">Total Terdaftar: <span class="text-indigo-400 font-bold">{{ $students->total() }} Siswa</span></p>
                </div>
                
                <div class="flex items-center gap-4">
                    <form action="{{ route('admin.students.index') }}" method="GET" class="relative group">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari NISN atau Nama..." 
                            class="w-64 bg-white/5 border border-white/10 rounded-2xl py-3 pl-10 pr-4 text-xs font-bold text-white placeholder-slate-600 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500/50 transition-all">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-600 group-focus-within:text-indigo-400 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </form>
                    
                    <button onclick="document.getElementById('modal-tambah-siswa').classList.remove('hidden')" class="px-8 py-4 bg-indigo-500 hover:bg-indigo-600 text-white text-[10px] font-black uppercase tracking-widest rounded-2xl transition-all shadow-lg shadow-indigo-500/20 active:scale-95">
                        Tambah Siswa
                    </button>
                </div>
            </div>

            <!-- Table Card -->
            <div class="glass-card rounded-[40px] border-white/5 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-white/5 bg-white/[0.02]">
                                <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Siswa</th>
                                <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">NISN</th>
                                <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Kelas Saat Ini</th>
                                <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Poin Dompet</th>
                                <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($students as $siswa)
                            <tr class="group hover:bg-white/[0.02] transition-colors">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-400 border border-indigo-500/20 font-black text-xs uppercase">
                                            {{ substr($siswa->user->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-white group-hover:text-indigo-400 transition-colors">{{ $siswa->user->name }}</div>
                                            <div class="text-[10px] text-slate-500 font-medium">{{ $siswa->user->email ?? 'No Email' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="text-xs font-mono text-slate-400 bg-white/5 px-2 py-1 rounded-md border border-white/10">{{ $siswa->nisn }}</span>
                                </td>
                                <td class="px-8 py-6">
                                    @php
                                        $kelas = $siswa->anggotaKelas->first()?->kelas;
                                    @endphp
                                    @if($kelas)
                                        <span class="text-[10px] font-black text-emerald-400 bg-emerald-500/10 px-3 py-1 rounded-full border border-emerald-500/20 uppercase tracking-widest">
                                            {{ $kelas->nama_kelas }}
                                        </span>
                                    @else
                                        <span class="text-[10px] font-black text-rose-400 bg-rose-500/10 px-3 py-1 rounded-full border border-rose-500/20 uppercase tracking-widest">
                                            NON-KELAS
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-6">
                                    <span class="text-xs font-black text-amber-400">{{ $siswa->user->point_balance }} P</span>
                                </td>
                                 <td class="px-8 py-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <!-- Tombol Suntik Poin -->
                                        <button onclick="openPointModal('{{ $siswa->id }}', '{{ $siswa->user->name }}', '{{ $siswa->user->point_balance }}')" class="w-8 h-8 rounded-lg bg-amber-500/10 flex items-center justify-center text-amber-500 border border-amber-500/20 hover:bg-amber-500/20 transition-all" title="Suntik Poin">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </button>
                                        <button onclick="openEditModal('{{ $siswa->id }}', '{{ $siswa->user->name }}', '{{ $siswa->nisn }}', '{{ $siswa->user->email }}')" class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 border border-white/10 hover:bg-indigo-500/10 hover:text-indigo-400 transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </button>
                                        <form action="{{ route('admin.students.destroy', $siswa) }}" method="POST" onsubmit="return confirm('Hapus siswa dan akun loginnya?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 border border-white/10 hover:bg-rose-500/10 hover:text-rose-400 transition-all">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center">
                                    <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">Tidak ada data siswa</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($students->hasPages())
                <div class="px-8 py-6 border-t border-white/5 bg-white/[0.01]">
                    {{ $students->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Suntik Poin -->
    <div id="modal-point-siswa" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-sm">
        <div class="glass-card p-10 rounded-[40px] border-white/10 w-full max-w-md mx-6">
            <h3 class="text-2xl font-black text-white mb-2">Penyesuaian Poin</h3>
            <p id="point-student-name" class="text-amber-400 text-[10px] font-black uppercase tracking-widest mb-6"></p>
            
            <form id="form-point-siswa" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Poin Sekarang</label>
                    <input type="text" id="current-point-display" disabled class="w-full bg-white/5 border-white/10 rounded-2xl text-slate-500 px-4 py-3 text-sm font-bold">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Nominal Perubahan (+/-)</label>
                    <input type="number" name="amount" required placeholder="Contoh: 10 atau -5" class="w-full bg-white/5 border-white/10 rounded-2xl text-white px-4 py-3 text-sm focus:border-amber-500 transition-all">
                    <p class="text-[9px] text-slate-500 mt-2 font-bold uppercase tracking-wider italic">Gunakan minus (-) untuk mengurangi poin.</p>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Alasan Penyesuaian</label>
                    <input type="text" name="description" required placeholder="Cth: Koreksi kesalahan scan" class="w-full bg-white/5 border-white/10 rounded-2xl text-white px-4 py-3 text-sm focus:border-amber-500 transition-all">
                </div>
                <div class="flex gap-4 pt-4">
                    <button type="button" onclick="document.getElementById('modal-point-siswa').classList.add('hidden')" class="flex-1 px-6 py-4 bg-white/5 text-white text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-white/10 transition-all">Batal</button>
                    <button type="submit" class="flex-1 px-6 py-4 bg-amber-500 text-white text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-amber-600 transition-all">Update Poin</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Tambah Siswa -->
    <div id="modal-tambah-siswa" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-sm">
        <div class="glass-card p-10 rounded-[40px] border-white/10 w-full max-w-md mx-6">
            <h3 class="text-2xl font-black text-white mb-6">Tambah Siswa Baru</h3>
            <form action="{{ route('admin.students.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Nama Lengkap</label>
                    <input type="text" name="name" required class="w-full bg-white/5 border-white/10 rounded-2xl text-white px-4 py-3 text-sm focus:border-indigo-500 transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">NISN (Juga sebagai ID Login)</label>
                    <input type="text" name="nisn" required class="w-full bg-white/5 border-white/10 rounded-2xl text-white px-4 py-3 text-sm focus:border-indigo-500 transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Email (Opsional)</label>
                    <input type="email" name="email" class="w-full bg-white/5 border-white/10 rounded-2xl text-white px-4 py-3 text-sm focus:border-indigo-500 transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Password Awal</label>
                    <input type="password" name="password" required class="w-full bg-white/5 border-white/10 rounded-2xl text-white px-4 py-3 text-sm focus:border-indigo-500 transition-all" value="password123">
                </div>
                <div class="flex gap-4 pt-4">
                    <button type="button" onclick="document.getElementById('modal-tambah-siswa').classList.add('hidden')" class="flex-1 px-6 py-4 bg-white/5 text-white text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-white/10 transition-all">Batal</button>
                    <button type="submit" class="flex-1 px-6 py-4 bg-indigo-500 text-white text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-indigo-600 transition-all">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Siswa -->
    <div id="modal-edit-siswa" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 backdrop-blur-sm">
        <div class="glass-card p-10 rounded-[40px] border-white/10 w-full max-w-md mx-6">
            <h3 class="text-2xl font-black text-white mb-6">Edit Data Siswa</h3>
            <form id="form-edit-siswa" method="POST" class="space-y-6">
                @csrf @method('PUT')
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Nama Lengkap</label>
                    <input type="text" name="name" id="edit-name" required class="w-full bg-white/5 border-white/10 rounded-2xl text-white px-4 py-3 text-sm focus:border-indigo-500 transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">NISN</label>
                    <input type="text" name="nisn" id="edit-nisn" required class="w-full bg-white/5 border-white/10 rounded-2xl text-white px-4 py-3 text-sm focus:border-indigo-500 transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Email</label>
                    <input type="email" name="email" id="edit-email" class="w-full bg-white/5 border-white/10 rounded-2xl text-white px-4 py-3 text-sm focus:border-indigo-500 transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Password Baru (Kosongkan jika tidak ganti)</label>
                    <input type="password" name="password" class="w-full bg-white/5 border-white/10 rounded-2xl text-white px-4 py-3 text-sm focus:border-indigo-500 transition-all">
                </div>
                <div class="flex gap-4 pt-4">
                    <button type="button" onclick="document.getElementById('modal-edit-siswa').classList.add('hidden')" class="flex-1 px-6 py-4 bg-white/5 text-white text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-white/10 transition-all">Batal</button>
                    <button type="submit" class="flex-1 px-6 py-4 bg-indigo-500 text-white text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-indigo-600 transition-all">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, name, nisn, email) {
            const modal = document.getElementById('modal-edit-siswa');
            const form = document.getElementById('form-edit-siswa');
            form.action = `/admin/students/${id}`;
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-nisn').value = nisn;
            document.getElementById('edit-email').value = email;
            modal.classList.remove('hidden');
        }

        function openPointModal(id, name, currentPoints) {
            const modal = document.getElementById('modal-point-siswa');
            const form = document.getElementById('form-point-siswa');
            form.action = `/admin/students/${id}/adjust-points`;
            document.getElementById('point-student-name').innerText = `Murid: ${name}`;
            document.getElementById('current-point-display').value = `${currentPoints} Poin`;
            modal.classList.remove('hidden');
        }
    </script>
</x-app-layout>
