<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Kehadiran') }}
        </h2>
    </x-slot>

    <div class="py-12 pb-32 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="mb-8">
                <h3 class="text-2xl font-black text-gray-800 tracking-tight">Semua Aktivitas</h3>
                <p class="text-sm text-gray-400 mt-1">Daftar lengkap kehadiran kamu di kelas.</p>
            </div>

            <div class="space-y-4">
                @forelse($attendanceHistory as $abs)
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-md transition-all">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600 font-black text-xs uppercase">
                                {{ substr($abs->sesi->jadwal->mapel->nama_mapel, 0, 2) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 tracking-tight text-sm">{{ $abs->sesi->jadwal->mapel->nama_mapel }}</h4>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">
                                    {{ \Carbon\Carbon::parse($abs->waktu_scan)->translatedFormat('d M Y • H:i') }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-black uppercase tracking-tighter shadow-sm border border-green-200">
                                {{ $abs->status }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-20 text-center">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-gray-400 font-bold text-sm">Belum ada riwayat absen.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $attendanceHistory->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
