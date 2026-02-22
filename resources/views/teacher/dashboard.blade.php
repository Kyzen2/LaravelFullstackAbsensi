<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Guru') }}
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-50 min-h-screen pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-8">
                <h1 class="text-2xl font-black text-gray-800 tracking-tight">Halo, {{ Auth::user()->name }}</h1>
                <p class="text-gray-400 text-xs font-bold mt-1 uppercase tracking-widest">Selamat mengajar hari ini!</p>
            </div>

            <!-- Stats Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                <div class="bg-blue-600 p-6 rounded-[2rem] shadow-xl shadow-blue-100 relative overflow-hidden group">
                    <div class="relative z-10 flex items-center justify-between">
                        <div>
                            <p class="text-blue-100/80 text-[10px] font-black uppercase tracking-widest mb-1">Presensi Hari Ini</p>
                            <h3 class="text-4xl font-black text-white tracking-tighter">{{ $todayStats['total_absen'] }}</h3>
                        </div>
                        <div class="p-4 bg-white/20 rounded-2xl text-white">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 flex items-center justify-between group">
                    <div>
                        <p class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">Total Jadwal</p>
                        <h3 class="text-3xl font-black text-gray-800 tracking-tighter">{{ $schedules->count() }}</h3>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-2xl text-gray-300 group-hover:text-blue-600 transition-colors">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Schedule Header -->
            <div class="mb-8 flex items-center justify-between px-4">
                <h3 class="text-2xl font-black text-gray-900 tracking-tight">Today's Timeline</h3>
                <div class="h-1 w-20 bg-gray-100 rounded-full"></div>
            </div>
            
            @if($schedules->isEmpty())
                <div class="flex flex-col items-center justify-center py-24 bg-white rounded-[3.5rem] border-2 border-dashed border-gray-100 px-8 text-center">
                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-12 h-12 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-gray-400 text-lg font-bold">Relax! No classes scheduled for today.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($schedules as $j)
                        <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-gray-100 group hover:shadow-xl hover:shadow-indigo-500/10 transition-all duration-300">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center space-x-4">
                                    <div class="w-14 h-14 bg-blue-600 rounded-2xl flex items-center justify-center text-white font-black text-lg shadow-lg shadow-blue-100">
                                        {{ strtoupper(substr($j->mapel->nama_mapel, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h4 class="font-black text-gray-800 tracking-tight leading-none mb-1">{{ $j->mapel->nama_mapel }}</h4>
                                        <div class="flex items-center space-x-2">
                                            <span class="px-2 py-0.5 bg-blue-50 text-blue-600 rounded-md text-[9px] font-black uppercase tracking-widest border border-blue-100 leading-none">
                                                {{ $j->kelas->nama_kelas }}
                                            </span>
                                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter inline-flex items-center leading-none">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                {{ $j->lokasi->nama_lokasi }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-[10px] font-black text-gray-300 uppercase tracking-widest leading-none block mb-1">Waktu</span>
                                    <span class="text-sm font-black text-blue-600 tabular-nums">
                                        {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                                <div class="text-[11px] font-bold text-gray-400 tracking-tight">
                                    Selesai {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                                </div>
                                <a href="{{ route('teacher.qr', $j->id) }}" class="inline-flex items-center px-6 py-3 bg-gray-900 text-white font-black rounded-xl shadow-lg shadow-gray-200 hover:bg-blue-600 hover:shadow-blue-200 transition-all active:scale-95 uppercase tracking-widest text-[10px]">
                                    Buka Sesi
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
