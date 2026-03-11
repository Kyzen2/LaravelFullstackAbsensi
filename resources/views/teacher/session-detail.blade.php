<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('teacher.schedule') }}" class="w-8 h-8 rounded-lg bg-slate-500/10 flex items-center justify-center text-slate-400 border border-white/5 hover:bg-slate-500/20 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">Kelola Kehadiran</h2>
        </div>
    </x-slot>

    <div class="py-10 pb-32 min-h-screen bg-[#020617] relative overflow-hidden">
        <!-- Background Orbs -->
        <div class="absolute top-0 right-0 -mr-32 -mt-32 w-96 h-96 bg-indigo-500/10 blur-[120px] rounded-full"></div>
        <div class="absolute bottom-10 left-0 -ml-32 w-96 h-96 bg-emerald-500/10 blur-[120px] rounded-full"></div>

        <div class="max-w-md mx-auto px-6 relative z-10">
            <!-- Header Section -->
            <div class="mb-10 text-center">
                <h1 class="text-3xl font-black text-white tracking-tighter uppercase leading-tight mb-2">Input Manual</h1>
                <div class="flex flex-col items-center gap-1">
                    <span class="text-indigo-400 text-sm font-bold">{{ $jadwal->mapel->nama_mapel }}</span>
                    <span class="text-slate-500 text-[10px] font-black uppercase tracking-[0.2em]">{{ $jadwal->kelas->nama_kelas }} &bull; {{ \Carbon\Carbon::parse($sesi->tanggal)->format('d M Y') }}</span>
                </div>
            </div>

            <!-- Student List -->
            <div class="space-y-4">
                @foreach($students as $student)
                @php $status = $attendance->get($student->id)->status ?? 'alpa'; @endphp
                <div class="glass-card p-5 rounded-[2.5rem] border-white/5 group hover:border-indigo-500/30 transition-all duration-500" id="student-row-{{ $student->id }}">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-slate-500/10 flex items-center justify-center text-white font-black text-lg border border-white/5 group-hover:bg-indigo-500/20 transition-colors">
                                {{ strtoupper(substr($student->nama_siswa, 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="text-white font-black text-sm leading-tight mb-1 truncate max-w-[150px]">{{ $student->nama_siswa }}</h3>
                                <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest" id="status-label-{{ $student->id }}">
                                    Status: <span class="status-text uppercase {{ $status === 'hadir' ? 'text-emerald-400' : ($status === 'alpa' ? 'text-rose-500' : 'text-amber-400') }}">{{ $status }}</span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Grid -->
                    <div class="grid grid-cols-4 gap-2">
                        <button onclick="updateStatus({{ $student->id }}, 'hadir')" class="btn-status flex flex-col items-center justify-center aspect-square rounded-2xl border border-white/5 bg-white/5 text-slate-400 hover:text-emerald-400 hover:bg-emerald-500/10 hover:border-emerald-500/30 transition-all duration-300 {{ $status === 'hadir' ? 'active-status-hadir' : '' }}">
                            <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span class="text-[8px] font-black uppercase tracking-tighter">Hadir</span>
                        </button>
                        <button onclick="updateStatus({{ $student->id }}, 'sakit')" class="btn-status flex flex-col items-center justify-center aspect-square rounded-2xl border border-white/5 bg-white/5 text-slate-400 hover:text-amber-400 hover:bg-amber-500/10 hover:border-amber-500/30 transition-all duration-300 {{ $status === 'sakit' ? 'active-status-sakit' : '' }}">
                            <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                            <span class="text-[8px] font-black uppercase tracking-tighter">Sakit</span>
                        </button>
                        <button onclick="updateStatus({{ $student->id }}, 'izin')" class="btn-status flex flex-col items-center justify-center aspect-square rounded-2xl border border-white/5 bg-white/5 text-slate-400 hover:text-indigo-400 hover:bg-indigo-500/10 hover:border-indigo-500/30 transition-all duration-300 {{ $status === 'izin' ? 'active-status-izin' : '' }}">
                            <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span class="text-[8px] font-black uppercase tracking-tighter">Izin</span>
                        </button>
                        <button onclick="updateStatus({{ $student->id }}, 'alpa')" class="btn-status flex flex-col items-center justify-center aspect-square rounded-2xl border border-white/5 bg-white/5 text-slate-400 hover:text-rose-500 hover:bg-rose-500/10 hover:border-rose-500/30 transition-all duration-300 {{ $status === 'alpa' ? 'active-status-alpa' : '' }}">
                            <svg class="w-5 h-5 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            <span class="text-[8px] font-black uppercase tracking-tighter">Alpha</span>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <style>
        .active-status-hadir { background: rgba(16, 185, 129, 0.2) !important; color: #10b981 !important; border-color: rgba(16, 185, 129, 0.4) !important; }
        .active-status-sakit { background: rgba(245, 158, 11, 0.2) !important; color: #f59e0b !important; border-color: rgba(245, 158, 11, 0.4) !important; }
        .active-status-izin { background: rgba(99, 102, 241, 0.2) !important; color: #6366f1 !important; border-color: rgba(99, 102, 241, 0.4) !important; }
        .active-status-alpa { background: rgba(244, 63, 94, 0.2) !important; color: #f43f5e !important; border-color: rgba(244, 63, 94, 0.4) !important; }
    </style>

    <script>
        function updateStatus(siswaId, status) {
            fetch("{{ route('teacher.attendance.manual') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    sesi_id: {{ $sesi->id }},
                    siswa_id: siswaId,
                    status: status
                })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    const row = document.getElementById(`student-row-${siswaId}`);
                    const label = document.getElementById(`status-label-${siswaId}`);
                    const textSpan = label.querySelector('.status-text');
                    
                    // Update text and color
                    textSpan.textContent = status;
                    textSpan.className = "status-text uppercase " + 
                        (status === 'hadir' ? 'text-emerald-400' : (status === 'alpa' ? 'text-rose-500' : 'text-amber-400'));
                    
                    // Update active button styles
                    row.querySelectorAll('.btn-status').forEach(btn => {
                        // Remove all possible active classes
                        btn.classList.remove('active-status-hadir', 'active-status-sakit', 'active-status-izin', 'active-status-alpa');
                        
                        // Check if this button matches the NEW status
                        if(btn.onclick.toString().includes(`'${status}'`)) {
                            btn.classList.add(`active-status-${status}`);
                        }
                    });

                    // Subtle feedback
                    row.classList.add('scale-[1.02]', 'brightness-125');
                    setTimeout(() => row.classList.remove('scale-[1.02]', 'brightness-125'), 300);
                }
            });
        }
    </script>
</x-app-layout>
