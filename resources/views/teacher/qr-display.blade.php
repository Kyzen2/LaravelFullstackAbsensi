<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-indigo-500/20 flex items-center justify-center text-indigo-400 border border-indigo-500/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 17h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
            </div>
            <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">
                QR Broadcast
            </h2>
        </div>
    </x-slot>

    <div class="py-10 space-y-10">
        <div class="max-w-md mx-auto px-6 space-y-10">
            <!-- Info Card -->
            <div class="glass-card p-8 rounded-[40px] text-center border-white/5 bg-indigo-500/5 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mr-12 -mt-12 w-32 h-32 bg-indigo-500/10 blur-3xl rounded-full"></div>
                <h3 class="text-2xl font-black text-white tracking-tight mb-2">{{ $jadwal->mapel->nama_mapel }}</h3>
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.3em] opacity-80">
                    {{ $jadwal->kelas->nama_kelas }} &bull; {{ now()->translatedFormat('d F Y') }}
                </p>
            </div>

            <!-- QR Container -->
            <div class="relative group">
                <div class="absolute -inset-1 bg-gradient-to-br from-indigo-500/30 to-emerald-500/30 rounded-[44px] blur-2xl opacity-50"></div>
                
                <div class="relative glass-card p-10 rounded-[40px] border-white/10 text-center bg-white shadow-2xl overflow-hidden">
                    <div class="flex justify-center mb-8 p-3 rounded-3xl bg-slate-50 shadow-inner inline-block">
                        {!! QrCode::size(250)->generate($sesi->token_qr) !!}
                    </div>
                    
                    <div class="space-y-3">
                        <p class="text-[9px] font-mono text-slate-400 bg-slate-100 py-1.5 px-4 rounded-full inline-block tracking-widest uppercase">
                            Token: {{ $sesi->token_qr }}
                        </p>
                        <p class="text-xs text-slate-500 font-medium leading-relaxed px-4 opacity-70">
                            Scan QR Code ini untuk melakukan presensi kehadiran siswa.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="text-center pt-4">
                <a href="{{ route('teacher.dashboard') }}" class="btn-premium w-full py-5 text-sm uppercase tracking-[0.2em] shadow-indigo-500/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Hub
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
