<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-white uppercase tracking-widest text-sm">
            Dashboard Guru
        </h2>
    </x-slot>

    <div class="min-h-screen bg-slate-900 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-extrabold text-white">
                        Halo, {{ Auth::user()->name }} 👋
                    </h1>
                    <p class="text-slate-400 mt-2 text-sm font-medium">
                        Siap ngegas ngajar hari ini?
                    </p>
                    
                    <!-- Real-time Clock -->
                    <div class="mt-6 inline-flex flex-col">
                        <div id="realtime-clock" class="text-5xl font-black text-white tracking-tighter tabular-nums drop-shadow-[0_0_15px_rgba(99,102,241,0.3)]">
                            00:00:00
                        </div>
                        <div id="realtime-date" class="text-[10px] font-black uppercase tracking-[0.3em] text-indigo-400 mt-1">
                            Loading date...
                        </div>
                    </div>
                </div>
                
                <a href="{{ route('teacher.qr.current') }}" 
                   class="flex items-center justify-center gap-3 px-8 py-4 bg-indigo-600 hover:bg-indigo-500 text-white font-black rounded-2xl shadow-2xl shadow-indigo-500/20 transition-all active:scale-95 uppercase tracking-widest text-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 17h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    Tampilkan QR Sekarang
                </a>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
                <div class="bg-slate-800/70 backdrop-blur p-6 rounded-3xl border border-slate-700 shadow-xl">
                    <p class="text-xs uppercase text-slate-400 tracking-wider mb-2 font-bold">Presensi Hari Ini</p>
                    <h3 class="text-4xl font-extrabold text-indigo-400">{{ $todayStats['total_absen'] }}</h3>
                </div>
                <div class="bg-slate-800/70 backdrop-blur p-6 rounded-3xl border border-slate-700 shadow-xl">
                    <p class="text-xs uppercase text-slate-400 tracking-wider mb-2 font-bold">Total Jadwal Anda</p>
                    <h3 class="text-4xl font-extrabold text-emerald-400">{{ $schedules->count() }}</h3>
                </div>
            </div>

            <!-- All Schedules -->
            <div class="mb-6 flex items-center justify-between">
                <h3 class="text-xl font-extrabold text-white tracking-tight">Semua Jadwal Mengajar</h3>
            </div>

            @if($schedules->isEmpty())
            <div class="bg-slate-800/70 border border-slate-700 p-10 rounded-3xl text-center">
                <p class="text-slate-400 font-semibold text-sm capitalize">Ops, belum ada jadwal yang terdaftar.</p>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($schedules as $j)
                <div class="bg-slate-800/70 backdrop-blur p-6 rounded-3xl border border-slate-700 shadow-xl hover:border-indigo-500 transition-all duration-300">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-slate-700 text-white rounded-xl flex items-center justify-center font-bold shadow-lg border border-slate-600">
                                {{ strtoupper(substr($j->mapel->nama_mapel, 0, 1)) }}
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-white leading-tight mb-1">{{ $j->mapel->nama_mapel }}</h4>
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-0.5 bg-indigo-500/10 text-indigo-400 text-[10px] font-black uppercase rounded-md border border-indigo-500/20">
                                        {{ $j->hari }}
                                    </span>
                                    <p class="text-xs text-slate-500 font-medium">
                                        {{ $j->kelas->nama_kelas }} • {{ $j->lokasi->nama_lokasi }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between items-center pt-4 border-t border-slate-700/50">
                        <div class="flex items-center text-slate-400">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="text-xs font-bold leading-none">
                                {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

        </div>
    </div>

    @push('scripts')
    <script>
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            
            const dayName = days[now.getDay()];
            const day = now.getDate();
            const monthName = months[now.getMonth()];
            const year = now.getFullYear();

            const timeEl = document.getElementById('realtime-clock');
            const dateEl = document.getElementById('realtime-date');
            
            if (timeEl) timeEl.textContent = `${hours}:${minutes}:${seconds}`;
            if (dateEl) dateEl.textContent = `${dayName}, ${day} ${monthName} ${year}`;
        }

        setInterval(updateClock, 1000);
        updateClock();
    </script>
    @endpush
</x-app-layout>