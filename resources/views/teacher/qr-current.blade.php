<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-white uppercase tracking-widest text-sm">
            Presensi Aktif: {{ $jadwal->mapel->nama_mapel }}
        </h2>
    </x-slot>

    <div class="min-h-screen bg-slate-900 py-12 px-6 pb-32">
        <div class="max-w-md mx-auto">
            
            <!-- Info Card -->
            <div class="bg-indigo-600 rounded-3xl p-6 mb-8 shadow-2xl shadow-indigo-500/20 text-white relative overflow-hidden">
                <div class="relative z-10">
                    <h3 class="text-2xl font-black tracking-tight mb-1">{{ $jadwal->kelas->nama_kelas }}</h3>
                    <p class="text-indigo-100 text-xs font-bold uppercase tracking-widest opacity-80">
                        {{ $jadwal->mapel->nama_mapel }} • {{ $jadwal->lokasi->nama_lokasi }}
                    </p>
                </div>
                <!-- Decoration -->
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
            </div>

            <!-- QR Container -->
            <div class="bg-white rounded-[2rem] p-10 shadow-3xl text-center relative">
                <div id="qr-container" class="flex justify-center mb-6 transition-opacity duration-300">
                    {!! QrCode::size(250)->generate($sesi->token_qr) !!}
                </div>
                
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 rounded-xl">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                        </span>
                        <p class="text-[10px] font-black uppercase text-slate-500 tracking-widest">Token Refresh dlm: <span id="timer" class="text-indigo-600">03:00</span></p>
                    </div>

                    <p class="text-xs text-slate-400 font-medium px-4 leading-relaxed">
                        Minta siswa untuk scan kode ini menggunakan aplikasi mereka.
                    </p>
                </div>
            </div>

            <!-- Back Action -->
            <div class="mt-12 text-center flex gap-4">
                <a href="{{ route('teacher.session.detail', $sesi) }}" class="flex-1 py-4 bg-indigo-500 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-indigo-500/20 flex items-center justify-center gap-2 hover:bg-indigo-600 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Input Manual
                </a>
                <a href="{{ route('teacher.dashboard') }}" class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-slate-800/50 hover:bg-slate-800 text-slate-400 hover:text-white rounded-2xl transition-all border border-white/5 group">
                    <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                    </svg>
                    <span class="text-[10px] font-black uppercase tracking-[0.2em]">Kembali ke Dashboard</span>
                </a>
            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        let timeLeft = 180; // 3 minutes
        const timerElement = document.getElementById('timer');
        const qrContainer = document.getElementById('qr-container');
        const sesiId = "{{ $sesi->id }}";

        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            
            if (timeLeft <= 0) {
                timeLeft = 180;
                refreshToken();
            } else {
                timeLeft--;
            }
        }

        async function refreshToken() {
            try {
                qrContainer.style.opacity = '0.3';
                const response = await fetch(`/teacher/qr-refresh/${sesiId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                
                if (response.ok) {
                    const data = await response.json();
                    // Since we can't easily re-render the SVG from SimpleQRCode via JS 
                    // without a library or another endpoint, we'll reload the page for now
                    // OR we could have a dedicated simple route that returns the raw QR image/svg.
                    window.location.reload(); 
                } else {
                    console.error('Failed to refresh token');
                    window.location.reload();
                }
            } catch (error) {
                console.error('Error refreshing token:', error);
                window.location.reload();
            }
        }

        setInterval(updateTimer, 1000);
    </script>
    @endpush
</x-app-layout>
