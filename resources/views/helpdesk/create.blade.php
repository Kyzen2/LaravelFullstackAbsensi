<x-app-layout>
    <x-slot name="header">
        <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">
            Helpdesk / <span class="text-white">Buat Aduan Baru</span>
        </h2>
    </x-slot>

    <div class="py-10 pb-32">
        <div class="max-w-4xl mx-auto px-6">
            
            <div class="glass-card p-10 rounded-[40px] border-white/5">
                <div class="mb-8">
                    <h2 class="text-2xl font-black text-white">Form Kendala Teknis</h2>
                    <p class="text-sm text-slate-400 mt-2">Sistem akan mengecek apakah kendala serupa sudah pernah dilaporkan untuk mencegah duplikasi tiket.</p>
                </div>

                <form action="{{ route('helpdesk.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    @if(session('error'))
                    <div class="p-6 bg-rose-500/10 border border-rose-500/20 rounded-2xl animate-fade-in">
                        <h4 class="text-rose-400 text-xs font-black uppercase tracking-widest mb-1 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                            Sistem Pencegah Duplikasi
                        </h4>
                        <p class="text-sm text-rose-300">{{ session('error') }}</p>
                    </div>
                    @endif
                    
                    <!-- Alert Anti Duplikasi (Hidden by default) -->
                    <div id="duplicate-warning" class="hidden p-6 bg-rose-500/10 border border-rose-500/20 rounded-2xl animate-fade-in">
                        <h4 class="text-rose-400 text-xs font-black uppercase tracking-widest mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                            Peringatan Anti-Duplikasi (Full-Text Search)
                        </h4>
                        <p class="text-sm text-rose-300 mb-3">Sistem menemukan kendala serupa di database. Pastikan masalah Anda belum diselesaikan di tiket berikut:</p>
                        <ul id="similar-tickets-list" class="space-y-2">
                            <!-- Hasil AJAX akan masuk ke sini -->
                        </ul>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Prioritas Kendala</label>
                        <select name="priority" required class="w-full bg-slate-900/50 border-white/10 rounded-2xl text-white px-4 py-3 text-sm focus:border-indigo-500 transition-all">
                            <option value="medium">Menengah (Standar)</option>
                            <option value="high">Tinggi (Darurat / Mendesak)</option>
                            <option value="low">Rendah (Pertanyaan Umum)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Subjek / Judul Kendala</label>
                        <input type="text" name="subject" id="subject" required placeholder="Contoh: Kamera Gagal Scan QR" class="w-full bg-slate-900/50 border-white/10 rounded-2xl text-white px-4 py-3 text-sm focus:border-indigo-500 transition-all">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-2">Deskripsi Detail</label>
                        <textarea name="description" id="description" rows="5" required placeholder="Ceritakan detail masalahnya..." class="w-full bg-slate-900/50 border-white/10 rounded-2xl text-white px-4 py-3 text-sm focus:border-indigo-500 transition-all"></textarea>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white text-[10px] font-black uppercase tracking-widest rounded-2xl transition-all shadow-lg shadow-indigo-500/20">
                            Kirim Tiket Aduan
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- Skrip AJAX Anti-Duplikasi -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const subjectInput = document.getElementById('subject');
            const descInput = document.getElementById('description');
            const warningBox = document.getElementById('duplicate-warning');
            const listContainer = document.getElementById('similar-tickets-list');
            
            let timeout = null;

            function checkDuplicates() {
                // Gabungin teks dari subject dan description buat Full-Text Search
                const query = subjectInput.value + ' ' + descInput.value;
                
                if (query.trim().length < 5) {
                    warningBox.classList.add('hidden');
                    return;
                }

                // Call API (AJAX)
                fetch(`/helpdesk/search?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            listContainer.innerHTML = '';
                            data.forEach(ticket => {
                                listContainer.innerHTML += `
                                    <li class="bg-rose-950/30 p-3 rounded-xl border border-rose-500/20 text-xs text-rose-200">
                                        <span class="font-bold text-white">[Status: ${ticket.status.toUpperCase()}]</span> ${ticket.subject}
                                    </li>
                                `;
                            });
                            warningBox.classList.remove('hidden');
                        } else {
                            warningBox.classList.add('hidden');
                        }
                    });
            }

            // Debounce: Tunggu user selesai ngetik 1 detik sebelum hit API
            subjectInput.addEventListener('input', () => {
                clearTimeout(timeout);
                timeout = setTimeout(checkDuplicates, 1000);
            });
            descInput.addEventListener('input', () => {
                clearTimeout(timeout);
                timeout = setTimeout(checkDuplicates, 1000);
            });
        });
    </script>
</x-app-layout>
