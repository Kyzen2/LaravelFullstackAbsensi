<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-white">
            Dashboard Guru
        </h2>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 py-10 pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header -->
            <div class="mb-10">
                <h1 class="text-3xl font-extrabold text-white">
                    Halo, {{ Auth::user()->name }} 👋
                </h1>
                <p class="text-slate-400 mt-2 text-sm">
                    Siap ngegas ngajar hari ini?
                </p>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">

                <div class="bg-slate-800/70 backdrop-blur p-6 rounded-3xl border border-slate-700 shadow-xl">
                    <p class="text-xs uppercase text-slate-400 tracking-wider mb-2">
                        Presensi Hari Ini
                    </p>
                    <h3 class="text-4xl font-extrabold text-indigo-400">
                        {{ $todayStats['total_absen'] }}
                    </h3>
                </div>

                <div class="bg-slate-800/70 backdrop-blur p-6 rounded-3xl border border-slate-700 shadow-xl">
                    <p class="text-xs uppercase text-slate-400 tracking-wider mb-2">
                        Total Jadwal
                    </p>
                    <h3 class="text-4xl font-extrabold text-emerald-400">
                        {{ $schedules->count() }}
                    </h3>
                </div>

            </div>

            <!-- Schedule -->
            @if($schedules->isEmpty())
            <div class="bg-slate-800/70 border border-slate-700 p-10 rounded-3xl text-center">
                <p class="text-slate-400 font-semibold">
                    Tidak ada jadwal hari ini 😴
                </p>
            </div>
            @else
            <div class="space-y-6">
                @foreach($schedules as $j)
                <div class="bg-slate-800/70 backdrop-blur p-6 rounded-3xl border border-slate-700 shadow-xl hover:scale-[1.02] hover:border-indigo-500 transition duration-300">

                    <div class="flex justify-between items-start mb-4">

                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-indigo-600 text-white rounded-xl flex items-center justify-center font-bold shadow-lg">
                                {{ strtoupper(substr($j->mapel->nama_mapel, 0, 1)) }}
                            </div>

                            <div>
                                <h4 class="text-lg font-bold text-white">
                                    {{ $j->mapel->nama_mapel }}
                                </h4>

                                <p class="text-sm text-slate-400">
                                    {{ $j->kelas->nama_kelas }} • {{ $j->lokasi->nama_lokasi }}
                                </p>
                            </div>
                        </div>

                        <div class="text-right">
                            <p class="text-xs text-slate-500 uppercase tracking-wide">Mulai</p>
                            <p class="text-base font-bold text-indigo-400">
                                {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }}
                            </p>
                        </div>

                    </div>

                    <div class="flex justify-between items-center pt-4 border-t border-slate-700">

                        <span class="text-sm text-slate-400">
                            Selesai {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                        </span>

                        <a href="{{ route('teacher.qr', $j->id) }}"
                            class="px-5 py-2 bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-semibold rounded-xl transition active:scale-95 shadow-lg shadow-indigo-500/20">
                            Buka Sesi
                        </a>

                    </div>

                </div>
                @endforeach
            </div>
            @endif

        </div>
    </div>
</x-app-layout>