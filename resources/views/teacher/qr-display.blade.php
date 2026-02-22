<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Scan Absensi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-center">
                    <h3 class="text-lg font-bold mb-2">{{ $jadwal->mapel->nama_mapel }}</h3>
                    <p class="text-sm text-gray-600 mb-6">{{ $jadwal->kelas->nama_kelas }} - {{ now()->format('d M Y') }}</p>
                    
                    <div class="flex justify-center mb-6 p-4 bg-white border rounded-lg shadow-inner">
                        {!! QrCode::size(250)->generate($sesi->token_qr) !!}
                    </div>

                    <p class="text-sm text-gray-500 mb-4 font-mono">{{ $sesi->token_qr }}</p>

                    <div class="mt-6">
                        <a href="{{ route('teacher.dashboard') }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
                            &larr; Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
