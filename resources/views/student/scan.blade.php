<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-indigo-500/20 flex items-center justify-center text-indigo-400 border border-indigo-500/20">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
            </div>
            <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">
                Scan Kehadiran
            </h2>
        </div>
    </x-slot>

    <div class="py-10 min-h-[90vh] flex flex-col items-center justify-center bg-[#020617] relative overflow-hidden pb-40">
        <!-- Background Orbs -->
        <div class="absolute top-0 right-0 -mr-32 -mt-32 w-96 h-96 bg-indigo-500/10 blur-[120px] rounded-full"></div>
        <div class="absolute bottom-0 left-0 -ml-32 -mb-32 w-96 h-96 bg-emerald-500/10 blur-[120px] rounded-full"></div>

        <div class="max-w-md w-full px-6 space-y-10 relative z-10">
            <!-- Header Section -->
            <div class="flex items-center justify-between">
                <div class="space-y-1">
                    <h2 class="text-3xl font-black text-white tracking-tighter uppercase leading-none">Scan QR</h2>
                    <p class="text-slate-500 text-[10px] font-black uppercase tracking-[0.2em] italic">Catat Kehadiran Instan</p>
                </div>
                
                <div class="flex gap-3">
                    <button id="switch-camera" class="w-12 h-12 glass-card rounded-2xl flex items-center justify-center text-slate-400 border-white/10 hover:text-indigo-400 hover:bg-indigo-500/10 transition-all active:scale-95">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                    </button>
                    <a href="{{ route('student.dashboard') }}" class="hidden sm:flex w-12 h-12 glass-card rounded-2xl items-center justify-center text-slate-400 border-white/10 hover:text-rose-400 hover:bg-rose-500/10 transition-all active:scale-95">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </a>
                </div>
            </div>

            <!-- Scanner Container -->
            <div class="relative aspect-square group">
                <!-- Floating Decorative Border -->
                <div class="absolute -inset-4 bg-gradient-to-br from-indigo-500/20 to-emerald-500/20 rounded-[3rem] blur-2xl opacity-30 group-hover:opacity-50 transition duration-1000"></div>
                
                <div id="reader-container" class="relative w-full h-full rounded-[2.5rem] border border-white/10 bg-black/40 backdrop-blur-3xl overflow-hidden shadow-2xl">
                    <div id="reader" class="w-full h-full"></div>
                    
                    <!-- Premium Overlays -->
                    <div class="absolute inset-0 z-20 pointer-events-none flex flex-col items-center justify-center">
                        <div class="relative w-64 h-64">
                            <!-- Corners -->
                            <div class="absolute top-0 left-0 w-8 h-8 border-t-[3px] border-l-[3px] border-indigo-400 rounded-tl-2xl shadow-[0_0_15px_rgba(129,140,248,0.5)]"></div>
                            <div class="absolute top-0 right-0 w-8 h-8 border-t-[3px] border-r-[3px] border-indigo-400 rounded-tr-2xl shadow-[0_0_15px_rgba(129,140,248,0.5)]"></div>
                            <div class="absolute bottom-0 left-0 w-8 h-8 border-b-[3px] border-l-[3px] border-indigo-400 rounded-bl-2xl shadow-[0_0_15px_rgba(129,140,248,0.5)]"></div>
                            <div class="absolute bottom-0 right-0 w-8 h-8 border-b-[3px] border-r-[3px] border-indigo-400 rounded-br-2xl shadow-[0_0_15px_rgba(129,140,248,0.5)]"></div>
                            
                            <!-- Laser -->
                            <div class="absolute top-0 left-0 right-0 h-[2px] bg-gradient-to-r from-transparent via-indigo-400 to-transparent shadow-[0_0_20px_rgba(129,140,248,0.8)] animate-scan-slow"></div>
                        </div>

                        <!-- Status Label -->
                        <div id="status-label" class="absolute bottom-10 left-1/2 -translate-x-1/2 px-6 py-2 rounded-full glass-card border-white/10 text-[9px] font-black uppercase tracking-[0.3em] text-slate-400 shadow-xl">
                            Scanner Aktif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Context Info -->
            <div class="glass-card p-6 rounded-[2rem] border-white/5 flex items-center gap-5">
                <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 flex items-center justify-center text-indigo-400 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h4 class="text-white font-black text-xs uppercase tracking-widest mb-0.5">Butuh Fokus</h4>
                    <p class="text-slate-500 text-[10px] font-bold uppercase tracking-wider opacity-60">Pastikan Kode QR berada dalam kotak fokus.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Processing Overlay -->
    <div id="result-overlay" class="fixed inset-0 z-[100] flex items-center justify-center p-6 bg-[#020617]/90 backdrop-blur-xl hidden">
        <div class="glass-card p-12 rounded-[3.5rem] border-indigo-500/20 text-center max-w-xs w-full shadow-2xl">
            <div id="status-icon" class="w-20 h-20 bg-indigo-500/10 rounded-[2rem] flex items-center justify-center mx-auto mb-8 border border-indigo-500/20 transition-all duration-500">
                <svg class="w-10 h-10 text-indigo-400 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
            </div>
            <h3 id="result-title" class="text-2xl font-black text-white tracking-tight uppercase mb-2">Memproses</h3>
            <p id="result-subtitle" class="text-[10px] text-slate-500 font-black uppercase tracking-[0.2em]">Memverifikasi Data Kehadiran</p>
        </div>
    </div>

    <style>
        #reader { border: none !important; }
        #reader video { width: 100% !important; height: 100% !important; object-fit: cover !important; }
        #reader__dashboard { display: none !important; }
        
        @keyframes scan-slow {
            0% { top: 0%; opacity: 0; }
            5% { opacity: 1; }
            95% { opacity: 1; }
            100% { top: 100%; opacity: 0; }
        }
        .animate-scan-slow {
            animation: scan-slow 3s ease-in-out infinite;
        }

        #reader__scan_region {
            background: transparent !important;
        }

        #reader__camera_selection, #reader__dashboard_section_csr button {
            display: none !important;
        }
    </style>

    @push('scripts')
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        let html5QrCode;
        let currentFacingMode = "environment";
        
        function playBeep() {
            const oscillator = audioCtx.createOscillator();
            const gainNode = audioCtx.createGain();
            oscillator.connect(gainNode);
            gainNode.connect(audioCtx.destination);
            oscillator.type = 'sine';
            oscillator.frequency.setValueAtTime(800, audioCtx.currentTime); 
            gainNode.gain.setValueAtTime(0, audioCtx.currentTime);
            gainNode.gain.linearRampToValueAtTime(0.5, audioCtx.currentTime + 0.01);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.3);
            oscillator.start(audioCtx.currentTime);
            oscillator.stop(audioCtx.currentTime + 0.3);
        }

        function onScanSuccess(decodedText) {
            playBeep();
            if(html5QrCode) {
                html5QrCode.stop().then(() => {
                    showOverlay("Berhasil", "Kehadiran Tercatat!", "emerald");
                    
                    fetch("{{ route('attendance.process') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            token_qr: decodedText,
                            latitude: -6.175392, 
                            longitude: 106.827153
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            setTimeout(() => {
                                window.location.href = "{{ route('student.dashboard') }}";
                            }, 1000);
                        } else {
                            showOverlay("Gagal", data.message, "rose");
                            setTimeout(() => {
                                location.reload();
                            }, 2000);
                        }
                    })
                    .catch(error => {
                        showOverlay("Error", "Terjadi kesalahan sistem.", "rose");
                        setTimeout(() => location.reload(), 2000);
                    });
                });
            }
        }

        function showOverlay(title, subtitle, color) {
            const overlay = document.getElementById('result-overlay');
            const icon = document.getElementById('status-icon');
            const titleEl = document.getElementById('result-title');
            const subtitleEl = document.getElementById('result-subtitle');
            
            overlay.classList.remove('hidden');
            titleEl.textContent = title;
            subtitleEl.textContent = subtitle;
            
            if(color === "emerald") {
                icon.innerHTML = '<svg class="w-10 h-10 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>';
                icon.className = 'w-20 h-20 bg-emerald-500/10 rounded-[2rem] flex items-center justify-center mx-auto mb-8 border border-emerald-500/20 transition-all';
                titleEl.className = 'text-2xl font-black text-emerald-400 tracking-tight uppercase mb-2';
            } else if(color === "rose") {
                icon.innerHTML = '<svg class="w-10 h-10 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>';
                icon.className = 'w-20 h-20 bg-rose-500/10 rounded-[2rem] flex items-center justify-center mx-auto mb-8 border border-rose-500/20 transition-all';
                titleEl.className = 'text-2xl font-black text-rose-400 tracking-tight uppercase mb-2';
            }
        }

        const qrConfig = { fps: 30, qrbox: { width: 250, height: 250 } };

        function startScanner(facingMode) {
            html5QrCode = new Html5Qrcode("reader");
            html5QrCode.start(
                { facingMode: facingMode }, 
                qrConfig, 
                onScanSuccess
            ).catch(err => {
                console.error("Scanner failed", err);
            });
        }

        document.getElementById('switch-camera').addEventListener('click', function() {
            if (html5QrCode) {
                html5QrCode.stop().then(() => {
                    currentFacingMode = (currentFacingMode === "environment") ? "user" : "environment";
                    startScanner(currentFacingMode);
                });
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            startScanner(currentFacingMode);
        });
    </script>
    @endpush
</x-app-layout>
