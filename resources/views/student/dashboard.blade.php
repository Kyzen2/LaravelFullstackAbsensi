    <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Siswa') }}
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-50 min-h-screen pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-8">
                <h1 class="text-2xl font-black text-gray-800 tracking-tight">Halo, {{ Auth::user()->name }}</h1>
                <p class="text-gray-400 text-xs font-bold mt-1 uppercase tracking-widest leading-none">Siap belajar hari ini?</p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-2 gap-4 mb-8">
                <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-100 flex flex-col justify-between h-32">
                    <div class="flex items-center justify-between">
                        <div class="p-2 bg-blue-50 rounded-xl text-blue-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest leading-none">Total</span>
                    </div>
                    <div>
                        <h3 class="text-2xl font-black text-gray-800 tracking-tighter leading-none">{{ $stats['total_absen'] }}</h3>
                        <p class="text-gray-400 text-[10px] font-bold mt-1">Kehadiran</p>
                    </div>
                </div>
                <div class="bg-blue-600 p-5 rounded-3xl shadow-xl shadow-blue-100 flex flex-col justify-between h-32 relative overflow-hidden group">
                    <div class="flex items-center justify-between relative z-10">
                        <div class="p-2 bg-white/20 rounded-xl text-white backdrop-blur-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <span class="text-[9px] font-black text-blue-100 uppercase tracking-widest leading-none">Bulan Ini</span>
                    </div>
                    <div class="relative z-10">
                        <h3 class="text-3xl font-black text-white tracking-tighter leading-none mb-1">{{ $stats['absen_bulan_ini'] }}</h3>
                        <p class="text-blue-100/70 text-[10px] font-bold uppercase tracking-widest">Presensi</p>
                    </div>
                </div>
            </div>

            <!-- Scan Action Hero -->
            <div class="bg-gray-900 rounded-[2.5rem] p-8 mb-10 shadow-2xl shadow-gray-200 relative overflow-hidden flex flex-col items-center text-center group">
                <div class="w-20 h-20 bg-white/5 rounded-3xl flex items-center justify-center mb-6 backdrop-blur-xl ring-1 ring-white/10 group-hover:scale-110 transition-transform">
                    <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 17h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                </div>
                <h3 class="text-xl font-black text-white tracking-tight mb-2">Masuk Kelas Sekarang</h3>
                <p class="text-gray-500 text-xs font-medium mb-8 max-w-[240px] leading-relaxed">Scan QR Code yang ditampilkan oleh guru untuk mencatat kehadiranmu.</p>
                <a href="{{ route('student.scan') }}" class="w-full py-5 bg-blue-600 hover:bg-white hover:text-blue-900 active:scale-95 text-white font-black rounded-2xl shadow-lg shadow-blue-500/30 transition-all duration-300 uppercase tracking-widest text-xs flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                    Buka Kamera
                </a>
            </div>

            <!-- Recent Activity -->
            <div class="mb-6 flex items-center justify-between px-2">
                <h3 class="text-lg font-black text-gray-800 tracking-tight">Riwayat Terbaru</h3>
                <a href="{{ route('student.history') }}" class="text-[10px] font-black text-blue-600 uppercase tracking-widest">Semua</a>
            </div>

            @if($recentAttendance->isEmpty())
                <div class="flex flex-col items-center justify-center py-12 bg-white rounded-3xl border border-gray-100 text-center px-6">
                    <p class="text-gray-400 font-bold text-xs uppercase tracking-widest">Belum ada riwayat absen</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($recentAttendance as $abs)
                        <div class="bg-white p-5 rounded-3xl shadow-sm border border-gray-50 flex items-center justify-between group hover:border-blue-100 transition-all">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center text-gray-400 font-black text-sm uppercase group-hover:bg-blue-600 group-hover:text-white transition-all">
                                    {{ substr($abs->sesi->jadwal->mapel->nama_mapel, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="font-black text-gray-800 tracking-tight text-sm uppercase">{{ $abs->sesi->jadwal->mapel->nama_mapel }}</h4>
                                    <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest mt-1">
                                        {{ \Carbon\Carbon::parse($abs->waktu_scan)->format('M d, H:i') }}
                                    </p>
                                </div>
                            </div>
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-emerald-100">
                                {{ $abs->status }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
