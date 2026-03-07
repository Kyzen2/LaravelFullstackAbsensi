<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-white uppercase tracking-widest text-sm">
            Presensi Tidak Tersedia
        </h2>
    </x-slot>

    <div class="min-h-screen bg-slate-900 py-12 px-6">
        <div class="max-w-md mx-auto text-center">
            
            <div class="bg-slate-800/80 rounded-[2.5rem] p-12 mb-8 border border-white/5 relative overflow-hidden">
                <div class="p-6 bg-slate-700/50 rounded-full w-24 h-24 mx-auto mb-8 flex items-center justify-center border border-white/10 shadow-inner">
                    <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>

                <h3 class="text-2xl font-black text-white tracking-tight mb-4">Belum Ada Kelas Aktif</h3>
                <p class="text-slate-400 text-sm leading-relaxed mb-8 px-4">
                    Maaf bro, sepertinya sekarang lagi gak ada jam mengajar kamu di sistem. Cek jadwal kamu lagi ya!
                </p>

                <a href="{{ route('teacher.dashboard') }}" 
                   class="block w-full py-4 bg-slate-700 hover:bg-indigo-600 text-white font-black rounded-2xl transition-all active:scale-95 uppercase tracking-widest text-xs">
                    Cek Jadwal
                </a>
            </div>

            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-[0.3em]">Status System: Normal</p>
        </div>
    </div>
</x-app-layout>
