<x-app-layout>
    <x-slot name="header">
        <h2 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">
            Laporan / <span class="text-white">Performa Saya</span>
        </h2>
    </x-slot>

    <div class="py-10 pb-32 uppercase tracking-tight">
        <div class="max-w-7xl mx-auto px-6">
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Left: Radar Chart -->
                <div class="glass-card rounded-[40px] border-white/5 p-10 flex flex-col items-center justify-center relative overflow-hidden">
                    <div class="absolute -right-16 -top-16 w-64 h-64 bg-indigo-500/10 blur-[100px] rounded-full"></div>
                    
                    <div class="text-center mb-10 relative z-10">
                        <h3 class="text-2xl font-black text-white mb-2">Grafik Radar Performa</h3>
                        <p class="text-xs text-slate-500 font-bold uppercase tracking-widest">Analisis kekuatan dan area pengembangan diri.</p>
                    </div>

                    <div class="w-full aspect-square max-w-md relative z-10 p-4">
                        @if($chartData)
                        <canvas id="radarChart"></canvas>
                        @else
                        <div class="flex flex-col items-center justify-center h-full text-slate-600 grayscale opacity-50">
                            <svg class="w-20 h-20 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                            <p class="text-[10px] font-black uppercase tracking-widest italic">Belum ada data penilaian periode ini.</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Right: Latest Feedback & Details -->
                <div class="space-y-8">
                    @if($latestAssessment)
                    <div class="glass-card rounded-[40px] border-indigo-500/20 bg-indigo-500/5 p-10 relative overflow-hidden">
                         <div class="flex items-start justify-between mb-8">
                            <div>
                                <span class="px-4 py-2 bg-indigo-500/20 rounded-full border border-indigo-500/20 text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-4 inline-block">Penilaian Terbaru</span>
                                <h2 class="text-4xl font-black text-white tracking-tighter uppercase">{{ $latestAssessment->period }}</h2>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest">Dinilai Oleh</p>
                                <p class="text-sm font-bold text-white uppercase">{{ $latestAssessment->evaluator->name }}</p>
                            </div>
                         </div>

                         <div class="space-y-6 mb-10">
                            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-white/5 pb-2">Catatan Guru:</h4>
                            <p class="text-sm text-slate-300 font-medium italic leading-relaxed">
                                "{{ $latestAssessment->general_notes ?? 'Tidak ada catatan tambahan.' }}"
                            </p>
                         </div>

                         <div class="grid grid-cols-2 gap-4">
                             @foreach($latestAssessment->details->take(4) as $detail)
                             <div class="bg-white/5 rounded-2xl p-4 border border-white/5">
                                 <p class="text-[9px] font-bold text-slate-600 uppercase mb-1">{{ $detail->category->name }}</p>
                                 <div class="flex items-center gap-2">
                                     <div class="flex gap-0.5 text-amber-400">
                                         @for($i=1; $i<=5; $i++)
                                         <svg class="w-3 h-3 {{ $i <= $detail->score ? 'fill-current' : 'text-slate-700' }}" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                                         @endfor
                                     </div>
                                 </div>
                             </div>
                             @endforeach
                         </div>
                    </div>
                    @else
                    <div class="glass-card rounded-[40px] border-white/5 p-10 text-center flex flex-col items-center justify-center min-h-[400px]">
                         <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center text-slate-700 mb-6 font-black italic text-4xl">!</div>
                         <h3 class="text-xl font-black text-white mb-2 uppercase tracking-tighter">Penilaian Belum Tersedia</h3>
                         <p class="text-xs text-slate-600 font-bold uppercase tracking-widest max-w-xs leading-relaxed">Saat ini guru belum memasukkan laporan penilaian performa kamu untuk periode ini.</p>
                    </div>
                    @endif

                    <!-- History Timeline -->
                    <div class="glass-card rounded-[40px] border-white/5 p-10 pb-6">
                        <h4 class="text-xs font-black text-white uppercase tracking-widest mb-8 flex items-center gap-3">
                            <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                            Riwayat Evaluasi
                        </h4>

                        <div class="space-y-8 relative before:absolute before:left-3 before:top-2 before:bottom-0 before:w-px before:bg-white/5">
                            @forelse($history as $item)
                            <div class="relative pl-10">
                                <div class="absolute left-[9px] top-1.5 w-1.5 h-1.5 rounded-full bg-slate-600 ring-4 ring-[#0f1118]"></div>
                                <div class="flex items-center justify-between gap-4 mb-2">
                                    <h5 class="text-sm font-black text-slate-200 uppercase tracking-tight">{{ $item->period }}</h5>
                                    <span class="text-[9px] font-bold text-slate-600 uppercase tracking-widest">{{ $item->assessment_date->translatedFormat('d M Y') }}</span>
                                </div>
                                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">Penilai: {{ $item->evaluator->name }}</p>
                            </div>
                            @empty
                            <p class="text-[10px] text-slate-600 font-bold italic pl-4 pb-4">"Belum ada riwayat penilaian."</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @if($chartData)
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('radarChart');
            
            new Chart(ctx, {
                type: 'radar',
                data: {
                    labels: {!! json_encode($chartData['labels']) !!},
                    datasets: [{
                        label: 'Skor Performa',
                        data: {!! json_encode($chartData['scores']) !!},
                        fill: true,
                        backgroundColor: 'rgba(79, 70, 229, 0.2)',
                        borderColor: '#6366f1',
                        borderWidth: 3,
                        pointBackgroundColor: '#6366f1',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: '#6366f1',
                        pointRadius: 4
                    }]
                },
                options: {
                    scales: {
                        r: {
                            angleLines: {
                                color: 'rgba(255, 255, 255, 0.05)'
                            },
                            grid: {
                                color: 'rgba(255, 255, 255, 0.05)'
                            },
                            pointLabels: {
                                color: '#475569',
                                font: {
                                    size: 10,
                                    weight: 'bold',
                                    family: "'Inter', sans-serif"
                                }
                            },
                            ticks: {
                                display: false,
                                stepSize: 1
                            },
                            suggestedMin: 0,
                            suggestedMax: 5
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        });
    </script>
    @endif
</x-app-layout>
