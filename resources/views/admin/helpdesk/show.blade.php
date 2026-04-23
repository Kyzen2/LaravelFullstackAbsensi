<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.helpdesk.index') }}" class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 border border-white/10 hover:bg-white/10 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">
                Helpdesk / <span class="text-white">Tiket #HLP-{{ str_pad($ticket->id, 4, '0', STR_PAD_LEFT) }}</span>
            </h2>
        </div>
    </x-slot>

    <div class="py-10 pb-32">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Ruang Chat / Diskusi -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Info Aduan Awal -->
                <div class="glass-card p-8 rounded-[40px] border-white/5">
                    <div class="flex items-start gap-4 mb-6">
                        <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center font-black text-white text-lg">
                            {{ substr($ticket->user->name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-white">{{ $ticket->subject }}</h3>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Dilaporkan oleh: {{ $ticket->user->name }} • {{ $ticket->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    <div class="prose prose-invert max-w-none text-slate-300 text-sm leading-relaxed bg-slate-900/50 p-6 rounded-2xl border border-white/5">
                        {{ $ticket->description }}
                    </div>
                </div>

                <!-- Balasan Diskusi -->
                @foreach($ticket->responses as $resp)
                <div class="flex gap-4 {{ $resp->user_id == Auth::id() ? 'flex-row-reverse' : '' }}">
                    <div class="w-10 h-10 rounded-xl flex shrink-0 items-center justify-center font-black text-xs {{ $resp->user->role == 'admin' ? 'bg-indigo-500/20 text-indigo-400' : 'bg-white/10 text-white' }}">
                        {{ substr($resp->user->name, 0, 1) }}
                    </div>
                    <div class="glass-card p-5 rounded-2xl border-white/5 max-w-[80%] {{ $resp->user_id == Auth::id() ? 'bg-indigo-900/30 border-indigo-500/20' : '' }}">
                        <p class="text-xs font-bold {{ $resp->user->role == 'admin' ? 'text-indigo-400' : 'text-slate-400' }} mb-2">{{ $resp->user->name }}</p>
                        <p class="text-sm text-white leading-relaxed">{{ $resp->message }}</p>
                        <p class="text-[9px] text-slate-500 font-medium mt-3 text-right">{{ $resp->created_at->format('H:i') }}</p>
                    </div>
                </div>
                @endforeach

                <!-- Form Balasan (Operator) -->
                @if($ticket->status != 'closed')
                <div class="glass-card p-6 rounded-[32px] border-white/5 mt-8">
                    <!-- Auto Reply Suggestions -->
                    <div class="mb-4">
                        <p class="text-[10px] text-slate-500 font-black uppercase tracking-widest mb-3">⚡ Saran Balasan Cepat (Klik untuk mengisi otomatis)</p>
                        <div class="flex flex-wrap gap-2" id="suggestion-buttons">
                            <button type="button" onclick="fillReply(this)" data-reply="Terima kasih atas laporannya. Kami sedang meninjau kendala yang Anda alami dan akan segera memberikan solusi." class="px-3 py-2 bg-indigo-500/10 hover:bg-indigo-500/20 border border-indigo-500/20 text-indigo-400 text-[10px] font-bold rounded-xl transition-all cursor-pointer">
                                📋 Konfirmasi Penerimaan
                            </button>
                            <button type="button" onclick="fillReply(this)" data-reply="Kendala yang Anda laporkan sedang kami proses. Mohon bersabar, tim kami akan menghubungi Anda kembali setelah pengecekan selesai." class="px-3 py-2 bg-amber-500/10 hover:bg-amber-500/20 border border-amber-500/20 text-amber-400 text-[10px] font-bold rounded-xl transition-all cursor-pointer">
                                ⏳ Sedang Diproses
                            </button>
                            <button type="button" onclick="fillReply(this)" data-reply="Kendala yang Anda laporkan telah berhasil diperbaiki. Silakan cek kembali dan konfirmasi apakah masalah sudah teratasi. Jika masih ada kendala, silakan balas pesan ini." class="px-3 py-2 bg-emerald-500/10 hover:bg-emerald-500/20 border border-emerald-500/20 text-emerald-400 text-[10px] font-bold rounded-xl transition-all cursor-pointer">
                                ✅ Kendala Selesai
                            </button>
                            <button type="button" onclick="fillReply(this)" data-reply="Mohon maaf atas ketidaknyamanannya. Untuk mempercepat penanganan, bisakah Anda memberikan informasi tambahan seperti screenshot atau langkah-langkah yang dilakukan sebelum kendala terjadi?" class="px-3 py-2 bg-sky-500/10 hover:bg-sky-500/20 border border-sky-500/20 text-sky-400 text-[10px] font-bold rounded-xl transition-all cursor-pointer">
                                ❓ Minta Info Tambahan
                            </button>
                            <button type="button" onclick="fillReply(this)" data-reply="Kami telah melakukan restart/reset pada sistem terkait. Silakan coba login ulang atau refresh halaman Anda. Jika kendala masih berlanjut, kami akan melakukan pengecekan lebih lanjut." class="px-3 py-2 bg-violet-500/10 hover:bg-violet-500/20 border border-violet-500/20 text-violet-400 text-[10px] font-bold rounded-xl transition-all cursor-pointer">
                                🔄 Reset Sistem
                            </button>
                        </div>
                    </div>

                    <form action="{{ route('admin.helpdesk.reply', $ticket->id) }}" method="POST">
                        @csrf
                        <textarea id="replyMessage" name="message" rows="3" required placeholder="Tulis balasan atau solusi di sini..." class="w-full bg-slate-900/50 border-white/10 rounded-2xl text-white px-4 py-3 text-sm focus:border-indigo-500 transition-all mb-4"></textarea>
                        <div class="flex justify-end">
                            <button type="submit" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition-all shadow-lg shadow-indigo-500/20">
                                Kirim Balasan
                            </button>
                        </div>
                    </form>
                </div>

                <script>
                    function fillReply(btn) {
                        const textarea = document.getElementById('replyMessage');
                        textarea.value = btn.getAttribute('data-reply');
                        textarea.focus();
                        // Highlight effect
                        textarea.style.borderColor = '#6366f1';
                        setTimeout(() => { textarea.style.borderColor = ''; }, 1500);
                    }
                </script>
                @endif
            </div>

            <!-- Sidebar Info & Kontrol -->
            <div class="space-y-6">
                <!-- Info Status -->
                <div class="glass-card p-6 rounded-[32px] border-white/5">
                    <h4 class="text-xs font-black text-slate-500 uppercase tracking-widest mb-4">Informasi Tiket</h4>
                    <div class="space-y-4">
                        <div>
                            <p class="text-[10px] text-slate-500 uppercase tracking-widest mb-1">Status Saat Ini</p>
                            <span class="px-3 py-1 bg-white/10 text-white text-xs font-bold rounded-lg uppercase tracking-widest">{{ $ticket->status }}</span>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-500 uppercase tracking-widest mb-1">Prioritas</p>
                            <span class="px-3 py-1 {{ $ticket->priority == 'high' ? 'bg-rose-500/20 text-rose-400' : 'bg-white/10 text-white' }} text-xs font-bold rounded-lg uppercase tracking-widest">{{ $ticket->priority }}</span>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-500 uppercase tracking-widest mb-1">Operator Penanggung Jawab</p>
                            <p class="text-sm font-bold text-indigo-400">{{ $ticket->operator ? $ticket->operator->name : 'Belum Ditugaskan' }}</p>
                        </div>
                        @if($ticket->rating)
                        <div>
                            <p class="text-[10px] text-slate-500 uppercase tracking-widest mb-1">Rating Kepuasan</p>
                            <p class="text-2xl font-black text-rose-500 flex items-center gap-1">
                                {{ $ticket->rating }} <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            </p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Kontrol Status -->
                <div class="glass-card p-6 rounded-[32px] border-white/5">
                    <h4 class="text-xs font-black text-slate-500 uppercase tracking-widest mb-4">Ubah Status Tiket</h4>
                    <form action="{{ route('admin.helpdesk.status', $ticket->id) }}" method="POST">
                        @csrf @method('PUT')
                        <select name="status" class="w-full bg-slate-900/50 border-white/10 rounded-xl text-white text-sm mb-4">
                            <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>OPEN (Baru Masuk)</option>
                            <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>IN PROGRESS (Sedang Ditangani)</option>
                            <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>RESOLVED (Selesai/Terselesaikan)</option>
                            <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>CLOSED (Ditutup)</option>
                        </select>
                        <button type="submit" class="w-full py-3 bg-white/10 hover:bg-white/20 text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition-all">
                            Update Status
                        </button>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
