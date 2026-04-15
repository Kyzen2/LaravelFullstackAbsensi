<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.master.data') }}" class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 border border-white/10 hover:bg-white/10 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">
                    Master Data / <span class="text-white">Jadwal Kelas</span>
                </h2>
            </div>
            <a href="{{ route('admin.jadwal.create') }}" class="px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-indigo-500/20">
                + Tambah Jadwal
            </a>
        </div>
    </x-slot>

    <div class="py-10 pb-32">
        <div class="max-w-7xl mx-auto px-6">
            @if(session('success'))
                <div class="mb-8 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl flex items-center gap-3 text-emerald-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <p class="font-bold text-sm">{{ session('success') }}</p>
                </div>
            @endif

            <div class="glass-card rounded-[32px] overflow-hidden border border-white/5">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white/5 border-b border-white/5">
                                <th class="p-6 text-xs font-black text-slate-400 uppercase tracking-widest whitespace-nowrap">Hari & Waktu</th>
                                <th class="p-6 text-xs font-black text-slate-400 uppercase tracking-widest whitespace-nowrap">Kelas</th>
                                <th class="p-6 text-xs font-black text-slate-400 uppercase tracking-widest whitespace-nowrap">Mata Pelajaran</th>
                                <th class="p-6 text-xs font-black text-slate-400 uppercase tracking-widest whitespace-nowrap">Guru Pengajar</th>
                                <th class="p-6 text-xs font-black text-slate-400 uppercase tracking-widest whitespace-nowrap text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($jadwals as $jadwal)
                            <tr class="hover:bg-white/[0.02] transition-colors">
                                <td class="p-6">
                                    <div class="flex flex-col gap-1">
                                        <span class="text-sm font-bold text-white uppercase">{{ $jadwal->hari }}</span>
                                        <span class="text-xs font-medium text-slate-400">
                                            {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}
                                        </span>
                                    </div>
                                </td>
                                <td class="p-6">
                                    <span class="px-3 py-1 bg-amber-500/10 text-amber-400 text-xs font-black rounded-lg border border-amber-500/20">
                                        {{ $jadwal->kelas->nama_kelas ?? 'Pilih Kelas' }}
                                    </span>
                                </td>
                                <td class="p-6">
                                    <div class="text-sm font-bold text-white">{{ $jadwal->mapel->nama_mapel ?? 'N/A' }}</div>
                                </td>
                                <td class="p-6">
                                    <div class="text-sm font-bold text-slate-300">{{ $jadwal->guru->nama_guru ?? 'N/A' }}</div>
                                </td>
                                <td class="p-6 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.jadwal.edit', $jadwal) }}" class="p-2 bg-indigo-500/10 text-indigo-400 hover:bg-indigo-500 hover:text-white rounded-lg transition-all border border-indigo-500/20">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </a>
                                        <form action="{{ route('admin.jadwal.destroy', $jadwal) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 bg-rose-500/10 text-rose-400 hover:bg-rose-500 hover:text-white rounded-lg transition-all border border-rose-500/20">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-10 text-center">
                                    <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4 border border-white/5">
                                        <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <h3 class="text-white font-bold mb-1">Belum ada Jadwal Kelas</h3>
                                    <p class="text-slate-500 text-sm">Tambahkan jadwal kelas baru untuk mulai mengatur jam absensi.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
