<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Scan QR Kehadiran') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-900 min-h-screen pb-32">
        <div class="max-w-md mx-auto px-6">
            <!-- Header -->
            <div class="flex items-center justify-between mb-10">
                <div class="flex items-center">
                    <a href="{{ route('student.dashboard') }}" class="p-4 bg-white/10 rounded-2xl text-white mr-4 active:scale-95 transition-all">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </a>
                    <div>
                        <h2 class="text-2xl font-black text-white tracking-tight">QR Scanner</h2>
                        <p class="text-gray-500 text-[10px] font-black uppercase tracking-[0.2em]">Mark Presence</p>
                    </div>
                </div>
                <!-- Camera Switch Button -->
                <button id="switch-camera" class="p-4 bg-white/10 rounded-2xl text-white active:scale-95 transition-all flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </button>
            </div>

            <!-- Scanner Box -->
            <div class="relative group">
                <div id="reader-container" class="relative overflow-hidden rounded-[2.5rem] border-4 border-gray-800 bg-black aspect-square shadow-2xl shadow-indigo-500/10">
                    <div id="reader" style="width: 100%"></div>
                    
                    <!-- Scanner Overlays -->
                    <div class="absolute inset-0 z-10 pointer-events-none">
                        <!-- Corner Accents -->
                        <div class="absolute top-10 left-10 w-10 h-10 border-t-4 border-l-4 border-indigo-500 rounded-tl-xl opacity-80"></div>
                        <div class="absolute top-10 right-10 w-10 h-10 border-t-4 border-r-4 border-indigo-500 rounded-tr-xl opacity-80"></div>
                        <div class="absolute bottom-10 left-10 w-10 h-10 border-b-4 border-l-4 border-indigo-500 rounded-bl-xl opacity-80"></div>
                        <div class="absolute bottom-10 right-10 w-10 h-10 border-b-4 border-r-4 border-indigo-500 rounded-br-xl opacity-80"></div>
                        
                        <!-- Scanning Laser Line -->
                        <div class="absolute top-0 left-0 right-0 h-1 bg-indigo-500 shadow-[0_0_15px_rgba(99,102,241,1)] animate-scan-line"></div>
                    </div>
                </div>

                <!-- Result Card -->
                <div id="result" class="mt-8 text-center p-8 bg-indigo-600 rounded-[2rem] shadow-2xl hidden transform animate-bounce-in">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-4 backdrop-blur-md">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <p class="text-xl font-black text-white tracking-tight uppercase">Processing...</p>
                </div>
            </div>

            <!-- Footer Info -->
            <div class="mt-12 p-6 bg-white/5 rounded-[2rem] border border-white/10 flex items-start space-x-4">
                <div class="p-3 bg-indigo-500/20 rounded-xl text-indigo-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h4 class="text-white font-black text-xs uppercase tracking-widest mb-1">How it works</h4>
                    <p class="text-gray-500 text-[11px] font-medium leading-relaxed">Align the QR code within the frame to automatically log your attendance.</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        #reader { border: none !important; }
        #reader video { object-fit: cover !important; border-radius: 2rem !important; }
        #reader__dashboard { display: none !important; }
        
        @keyframes scan {
            0% { top: 15% }
            50% { top: 85% }
            100% { top: 15% }
        }
        .animate-scan-line {
            animation: scan 3s ease-in-out infinite;
            width: 80%;
            left: 10%;
        }

        @keyframes bounceIn {
            from { opacity: 0; transform: scale(0.8); }
            to { opacity: 1; transform: scale(1); }
        }
        .animate-bounce-in {
            animation: bounceIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        }
    </style>

    @push('scripts')
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        let html5QrCode;
        let currentFacingMode = "environment"; // Default to back camera
        
        function playBeep() {
            const oscillator = audioCtx.createOscillator();
            const gainNode = audioCtx.createGain();
            oscillator.connect(gainNode);
            gainNode.connect(audioCtx.destination);
            oscillator.type = 'sine';
            oscillator.frequency.setValueAtTime(800, audioCtx.currentTime); 
            gainNode.gain.setValueAtTime(0, audioCtx.currentTime);
            gainNode.gain.linearRampToValueAtTime(1, audioCtx.currentTime + 0.01);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.3);
            oscillator.start(audioCtx.currentTime);
            oscillator.stop(audioCtx.currentTime + 0.3);
        }

        function onScanSuccess(decodedText, decodedResult) {
            playBeep();
            html5QrCode.stop().then(() => {
                document.getElementById('result').classList.remove('hidden');
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
                        alert('Absensi Berhasil!');
                        window.location.href = "{{ route('student.dashboard') }}";
                    } else {
                        alert('Gagal: ' + data.message);
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan sistem.');
                });
            });
        }

        const qrConfig = { fps: 10, qrbox: { width: 250, height: 250 } };

        function startScanner(facingMode) {
            html5QrCode = new Html5Qrcode("reader");
            html5QrCode.start(
                { facingMode: facingMode }, 
                qrConfig, 
                onScanSuccess
            ).catch(err => {
                console.error("Unable to start scanning", err);
            });
        }

        document.getElementById('switch-camera').addEventListener('click', function() {
            if (html5QrCode) {
                html5QrCode.stop().then(() => {
                    currentFacingMode = (currentFacingMode === "environment") ? "user" : "environment";
                    startScanner(currentFacingMode);
                }).catch(err => console.error("Error stopping scanner", err));
            }
        });

        // Initialize scanner on load
        document.addEventListener('DOMContentLoaded', () => {
            startScanner(currentFacingMode);
        });
    </script>
    @endpush
</x-app-layout>
