<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.master.data') }}" class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 border border-white/10 hover:bg-white/10 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">
                Master Hub / <span class="text-white">Guru & Staf</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-10 pb-32">
        <div class="max-w-7xl mx-auto px-6">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-12">
                <div>
                    <h1 class="text-4xl font-black text-white tracking-tighter mb-2">Tenaga Pendidik</h1>
                    <p class="text-slate-500 font-medium text-sm">Total Terdaftar: <span class="text-indigo-400 font-bold">{{ $teachers->total() }} Guru</span></p>
                </div>
                
                <div class="flex items-center gap-4">
                    <form action="{{ route('admin.teachers.index') }}" method="GET" class="relative group">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari NIP atau Nama..." 
                            class="w-64 bg-white/5 border border-white/10 rounded-2xl py-3 pl-10 pr-4 text-xs font-bold text-white placeholder-slate-600 focus:outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500/50 transition-all">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-600 group-focus-within:text-indigo-400 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </form>
                    
                    <button class="btn-premium py-3 px-6 text-[10px] uppercase tracking-widest">
                        Tambah Guru
                    </button>
                </div>
            </div>

            <!-- Table Card -->
            <div class="glass-card rounded-[40px] border-white/5 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-white/5 bg-white/[0.02]">
                                <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Guru / Staff</th>
                                <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">NIP</th>
                                <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Peran</th>
                                <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Status Akun</th>
                                <th class="px-8 py-6 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($teachers as $guru)
                            <tr class="group hover:bg-white/[0.02] transition-colors">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-400 border border-indigo-500/20 font-black text-xs">
                                            {{ substr($guru->nama_guru, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-white group-hover:text-indigo-400 transition-colors">{{ $guru->nama_guru }}</div>
                                            <div class="text-[10px] text-slate-500 font-medium">{{ $guru->user->email ?? 'No Email' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="text-xs font-mono text-slate-400 bg-white/5 px-2 py-1 rounded-md border border-white/10">{{ $guru->nip }}</span>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="text-[10px] font-black text-indigo-400 bg-indigo-500/10 px-3 py-1 rounded-full border border-indigo-500/20 uppercase tracking-widest">
                                        {{ $guru->user->role ?? 'Staff' }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></div>
                                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Aktif</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 border border-white/10 hover:bg-indigo-500/10 hover:text-indigo-400 hover:border-indigo-500/20 transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </button>
                                        <button class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 border border-white/10 hover:bg-rose-500/10 hover:text-rose-400 hover:border-rose-500/20 transition-all">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-8 py-20 text-center">
                                    <div class="w-16 h-16 bg-white/[0.02] rounded-full flex items-center justify-center mx-auto mb-4 border border-white/5">
                                        <svg class="w-8 h-8 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.514 13H4"></path></svg>
                                    </div>
                                    <p class="text-slate-500 font-bold uppercase tracking-widest text-xs">Tidak ada data guru</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($teachers->hasPages())
                <div class="px-8 py-6 border-t border-white/5 bg-white/[0.01]">
                    {{ $teachers->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
