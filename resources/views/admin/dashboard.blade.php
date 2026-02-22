<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Administrator Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen font-sans">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-2xl shadow-lg border-l-4 border-indigo-600 flex items-center">
                    <div class="p-3 bg-indigo-50 rounded-xl mr-4 text-indigo-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Total Guru</p>
                        <p class="text-2xl font-black text-gray-800">{{ $stats['guru'] }}</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-lg border-l-4 border-emerald-500 flex items-center">
                    <div class="p-3 bg-emerald-50 rounded-xl mr-4 text-emerald-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Total Siswa</p>
                        <p class="text-2xl font-black text-gray-800">{{ $stats['siswa'] }}</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-lg border-l-4 border-amber-500 flex items-center">
                    <div class="p-3 bg-amber-50 rounded-xl mr-4 text-amber-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Total Kelas</p>
                        <p class="text-2xl font-black text-gray-800">{{ $stats['kelas'] }}</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-lg border-l-4 border-blue-500 flex items-center">
                    <div class="p-3 bg-blue-50 rounded-xl mr-4 text-blue-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Absen Hari Ini</p>
                        <p class="text-2xl font-black text-gray-800">{{ $stats['absensi_today'] }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recent Activity -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                    <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                        <h3 class="text-lg font-black text-gray-800">Riwayat Absensi Terbaru</h3>
                        <a href="#" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">LIHAT SEMUA &rarr;</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Siswa</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Mapel</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-widest">Status</th>
                                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-widest">Waktu</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($recent_absences as $abs)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-gray-900">{{ $abs->siswa->nama_siswa }}</div>
                                            <div class="text-xs text-gray-500">{{ $abs->siswa->nisn }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-700">{{ $abs->sesi->jadwal->mapel->nama_mapel }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-[10px] font-black uppercase tracking-tighter">
                                                {{ $abs->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-mono text-gray-500">
                                            {{ \Carbon\Carbon::parse($abs->waktu_scan)->format('H:i:s') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-gray-400 italic">Belum ada data absensi masuk.</td>
                                    </tr>
                                @endforelse
                                
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="space-y-6">
                    <div class="bg-indigo-700 rounded-2xl shadow-xl p-6 text-white overflow-hidden relative">
                        <div class="relative z-10">
                            <h3 class="font-black text-xl mb-2 tracking-tight">Master Data</h3>
                            <p class="text-indigo-100 text-sm mb-6 opacity-80">Kelola data guru, siswa, kelas, dan mata pelajaran di sini.</p>
                            <a href="#" class="block w-full text-center bg-white text-indigo-700 font-black py-3 rounded-xl shadow-lg hover:bg-gray-100 transition-all uppercase tracking-widest text-xs">
                                Kelola Master Data
                            </a>
                        </div>
                        <div class="absolute -right-10 -bottom-10 opacity-10">
                            <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"></path></svg>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                        <h3 class="font-black text-gray-800 mb-4 tracking-tighter uppercase text-sm">System Health</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center bg-gray-50 p-3 rounded-xl">
                                <span class="text-xs font-bold text-gray-500 uppercase">Database</span>
                                <span class="bg-green-500 h-2.5 w-2.5 rounded-full animate-pulse shadow-sm shadow-green-200"></span>
                            </div>
                            <div class="flex justify-between items-center bg-gray-50 p-3 rounded-xl">
                                <span class="text-xs font-bold text-gray-500 uppercase">Sessions</span>
                                <span class="text-xs font-bold text-gray-800">{{ auth()->user()->count() }} Active</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
