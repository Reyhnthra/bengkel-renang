<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Renang - {{ $student->nama }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</head>
<body class="bg-[#EBF3FC] min-h-screen py-8 px-4 flex justify-center items-center">

    <div class="w-full max-w-2xl bg-[#F4F9FD] rounded-[32px] shadow-2xl overflow-hidden border border-slate-100 relative">
        
        <div class="bg-[#032B53] text-white p-6 sm:p-8 relative">
            <a href="{{ route('landing') }}" class="absolute top-6 right-6 w-8 h-8 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center transition">
                <span class="text-sm font-bold text-white">✕</span>
            </a>

            <div class="flex items-center space-x-4 mb-8">
                <div class="w-16 h-16 bg-[#FDB813] rounded-2xl flex items-center justify-center font-extrabold text-[#032B53] text-2xl shadow-md shrink-0">
                    {{ strtoupper(substr($student->nama, 0, 2)) }}
                </div>
                <div>
                    <span class="text-xs text-slate-300 block font-medium tracking-wider">ID: {{ $student->id_tracking }}</span>
                    <h1 class="text-2xl font-extrabold tracking-tight mt-0.5">{{ $student->nama }}</h1>
                    <div class="flex items-center space-x-2 mt-1.5">
                        <span class="bg-blue-950/60 text-blue-300 font-bold text-[10px] px-2.5 py-1 rounded-full uppercase border border-blue-900">
                            {{ ucfirst($student->status) }}
                        </span>
                        <span class="text-xs text-slate-300 font-medium">• Orang Tua: {{ $student->nama_orang_tua }}</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3 sm:gap-4">
                <div class="bg-white/10 border border-white/5 p-3.5 rounded-2xl text-center backdrop-blur-sm">
                    <span class="text-lg block mb-1">📅</span>
                    <span class="text-xl font-extrabold block">{{ $student->sessions->count() }}</span>
                    <span class="text-[10px] text-slate-300 font-semibold uppercase tracking-wider">Total Sesi</span>
                </div>
                <div class="bg-white/10 border border-white/5 p-3.5 rounded-2xl text-center backdrop-blur-sm">
                    <span class="text-lg block mb-1">🔥</span>
                    <span class="text-xl font-extrabold block">
                        {{ $student->sessions->where('attendance_status', 'hadir')->count() }}x
                    </span>
                    <span class="text-[10px] text-slate-300 font-semibold uppercase tracking-wider">Hadir</span>
                </div>
                <div class="bg-white/10 border border-white/5 p-3.5 rounded-2xl text-center backdrop-blur-sm">
                    <span class="text-lg block mb-1">📈</span>
                    <span class="text-xl font-extrabold block text-[#FDB813]">
                        @php
                            // Menghitung rata-rata nilai dari seluruh sesi yang ada progress report-nya
                            $totalScore = 0;
                            $reportCount = 0;
                            foreach($student->sessions as $s) {
                                if($s->progressReport) {
                                    $avgSession = ($s->progressReport->nila_pernapasan + $s->progressReport->nilai_b + $s->progressReport->nilai_c) / 3;
                                    $totalScore += ($avgSession / 5) * 100;
                                    $reportCount++;
                                }
                            }
                            $overallProgress = $reportCount > 0 ? round($totalScore / $reportCount) : 0;
                        @endphp
                        {{ $overallProgress }}%
                    </span>
                    <span class="text-[10px] text-slate-300 font-semibold uppercase tracking-wider">Progress</span>
                </div>
            </div>
        </div>

        <div class="bg-white px-6 sm:px-8 py-5 border-b border-slate-100">
            <div class="flex justify-between items-center text-xs font-bold uppercase text-[#032B53] tracking-wide mb-2">
                <span>Progress Keseluruhan</span>
                <span class="text-sm font-extrabold text-teal-600">{{ $overallProgress }}%</span>
            </div>
            <div class="w-full bg-slate-100 h-3 rounded-full overflow-hidden">
                <div class="bg-gradient-to-r from-teal-500 to-cyan-600 h-full rounded-full transition-all duration-500" style="width: {{ $overallProgress }}%"></div>
            </div>
            <div class="flex justify-between items-center text-[11px] font-medium text-slate-400 mt-2.5">
                <span>Pelatih: Mr. Iqbal (Gajahdepa)</span>
                <span>Terdaftar: {{ $student->created_at->format('d M Y') }}</span>
            </div>
        </div>

        <div class="px-6 sm:px-8 py-5">
            <div class="bg-[#E6F0FA] p-1.5 rounded-2xl flex justify-between space-x-1 font-bold text-xs shadow-inner">
                <button onclick="switchTab('ringkasan')" id="btn-ringkasan" class="tab-btn w-full py-2.5 rounded-xl text-center transition duration-200 bg-white text-[#032B53] shadow-sm">
                    Ringkasan
                </button>
                <button onclick="switchTab('riwayat')" id="btn-riwayat" class="tab-btn w-full py-2.5 rounded-xl text-center transition duration-200 text-slate-500 hover:text-[#032B53]">
                    Riwayat Sesi
                </button>
                <button onclick="switchTab('badge')" id="btn-badge" class="tab-btn w-full py-2.5 rounded-xl text-center transition duration-200 text-slate-500 hover:text-[#032B53]">
                    Badge
                </button>
            </div>
        </div>

        <div class="px-6 sm:px-8 pb-8 min-h-[350px]">

            <div id="tab-content-ringkasan" class="tab-content space-y-6">
                @php
                    // Ambil nilai rata-rata tiap kolom dari DB (skala 1-5 diubah ke persen)
                    $bebPercent = 0; $pungPercent = 0; $dadPercent = 0;
                    if($reportCount > 0) {
                        $bebPercent = round(($student->sessions->avg(fn($s) => $s->progressReport->nila_pernapasan ?? 0) / 5) * 100);
                        $pungPercent = round(($student->sessions->avg(fn($s) => $s->progressReport->nilai_b ?? 0) / 5) * 100);
                        $dadPercent = round(($student->sessions->avg(fn($s) => $s->progressReport->nilai_c ?? 0) / 5) * 100);
                    }
                @endphp

                <div class="space-y-4">
                    <h3 class="text-sm font-extrabold text-[#032B53] uppercase tracking-wider">Kemampuan per Gaya</h3>
                    
                    <div class="space-y-1.5">
                        <div class="flex justify-between items-center text-xs font-bold">
                            <span class="text-slate-700">🏊‍♂️ Gaya Bebas</span>
                            <span class="text-teal-600">{{ $bebPercent }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden"><div class="bg-teal-500 h-full" style="width: {{ $bebPercent }}%"></div></div>
                    </div>

                    <div class="space-y-1.5">
                        <div class="flex justify-between items-center text-xs font-bold">
                            <span class="text-slate-700">🤿 Gaya Punggung</span>
                            <span class="text-blue-600">{{ $pungPercent }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden"><div class="bg-blue-500 h-full" style="width: {{ $pungPercent }}%"></div></div>
                    </div>

                    <div class="space-y-1.5">
                        <div class="flex justify-between items-center text-xs font-bold">
                            <span class="text-slate-700">🐬 Gaya Dada</span>
                            <span class="text-amber-600">{{ $dadPercent }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden"><div class="bg-amber-500 h-full" style="width: {{ $dadPercent }}%"></div></div>
                    </div>
                </div>

                @php 
                    // Tambahkan ->sortByDesc('id') agar yang diambil PASTI ID tertinggi (terbaru)
                    $latestSession = $student->sessions->sortByDesc('id')->first(); 
                @endphp
                @if($latestSession && $latestSession->progressReport)
                    <div class="bg-teal-50/60 border border-teal-100 p-5 rounded-2xl space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="bg-teal-600 text-white font-bold text-[9px] px-2 py-0.5 rounded uppercase tracking-wider">Sesi Terakhir</span>
                            <span class="text-[11px] text-slate-400 font-semibold">{{ \Carbon\Carbon::parse($latestSession->tanggal)->format('d M Y') }}</span>
                        </div>
                        <h4 class="font-extrabold text-slate-900 text-sm">Latihan Pertemuan Ke-{{ $latestSession->meeting_number }}</h4>
                        <p class="text-xs text-slate-600 italic">"{{ $latestSession->progressReport->catatan ?? 'Tidak ada catatan pelatih.' }}"</p>
                        <div class="pt-2 flex items-center space-x-2 text-xs font-bold text-teal-700">
                            <span class="w-2 h-2 bg-teal-500 rounded-full"></span>
                            <span>Nilai Pertemuan: {{ round((($latestSession->progressReport->nila_pernapasan + $latestSession->progressReport->nilai_b + $latestSession->progressReport->nilai_c)/3)/5 * 100) }}/100</span>
                        </div>
                    </div>
                @else
                    <div class="text-center py-6 text-xs text-slate-400 font-medium bg-slate-50 rounded-2xl border border-dashed">
                        Belum ada riwayat input latihan untuk murid ini.
                    </div>
                @endif
            </div>

            <div id="tab-content-riwayat" class="tab-content space-y-4 hidden">
                @forelse($student->sessions as $session)
                    @if($session->progressReport)
                        <div class="bg-white p-5 rounded-2xl border border-slate-100 hover:shadow-md transition">
                            <div class="flex justify-between items-start mb-4">
                                <div class="space-y-1.5 max-w-[80%]">
                                    <span class="text-[11px] text-slate-400 font-semibold block">{{ \Carbon\Carbon::parse($session->tanggal)->format('d M Y') }}</span>
                                    <h4 class="font-extrabold text-slate-800 text-sm">Pertemuan Ke-{{ $session->meeting_number }} (Status: {{ ucfirst($session->attendance_status) }})</h4>
                                    <p class="text-xs text-slate-500 leading-relaxed bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                                        "{{ $session->progressReport->catatan ?? 'Tidak ada catatan harian.' }}"
                                    </p>
                                </div>
                                @php 
                                    $sessionScore = round((($session->progressReport->nila_pernapasan + $session->progressReport->nilai_b + $session->progressReport->nilai_c) / 3) / 5 * 100);
                                @endphp
                                <div class="bg-teal-50 text-teal-600 font-extrabold px-3 py-1.5 rounded-xl text-center border border-teal-100 text-xs shrink-0">
                                    <span class="block text-base">{{ $sessionScore }}</span><span class="text-[9px] text-teal-500 font-bold uppercase -mt-1 block">/100</span>
                                </div>
                            </div>
                            @php
                                $gayaBebas = round((($session->progressReport->gaya_bebas ?? 0) / 5) * 100);
                                $gayaPunggung = round((($session->progressReport->gaya_punggung ?? 0) / 5) * 100);
                                $gayaDada = round((($session->progressReport->gaya_dada ?? 0) / 5) * 100);
                                $gayaKupu = round((($session->progressReport->gaya_kupu ?? 0) / 5) * 100);
                                $sessionData = json_encode([
                                    'date' => \Carbon\Carbon::parse($session->tanggal)->format('d M Y'),
                                    'meeting' => $session->meeting_number,
                                    'topic' => $session->topik_sesi ?? 'Latihan Renang',
                                    'score' => $sessionScore,
                                    'catatan' => $session->progressReport->catatan ?? '',
                                    'bebas' => $gayaBebas,
                                    'punggung' => $gayaPunggung,
                                    'dada' => $gayaDada,
                                    'kupu' => $gayaKupu,
                                ]);
                            @endphp
                             {{-- Tombol Story IG dihapus dari file legacy --}}
                        </div>
                    @endif
                @empty
                    <div class="text-center py-12 text-slate-400 text-xs font-medium">Belum ada riwayat pertemuan renang.</div>
                @endforelse
            </div>

            <div id="tab-content-badge" class="tab-content space-y-4 hidden">
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    <div class="bg-white p-5 rounded-2xl border border-slate-100 text-center space-y-3 flex flex-col items-center justify-between shadow-sm">
                        <div class="text-3xl bg-blue-50 w-14 h-14 rounded-xl flex items-center justify-center">🏊‍♂️</div>
                        <h4 class="font-extrabold text-slate-800 text-xs">Gaya Bebas</h4>
                        <span class="text-[10px] text-teal-600 font-bold">✓ Diraih</span>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-slate-100 text-center space-y-3 flex flex-col items-center justify-between shadow-sm">
                        <div class="text-3xl bg-teal-50 w-14 h-14 rounded-xl flex items-center justify-center">🌊</div>
                        <h4 class="font-extrabold text-slate-800 text-xs">Keselamatan Air</h4>
                        <span class="text-[10px] text-teal-600 font-bold">✓ Diraih</span>
                    </div>

                    <div class="p-5 rounded-2xl text-center space-y-3 flex flex-col items-center justify-between {{ $student->sessions->count() >= 5 ? 'bg-white border-slate-100' : 'bg-slate-50 opacity-50 grayscale' }}">
                        <div class="text-3xl w-14 h-14 rounded-xl flex items-center justify-center bg-amber-50">🏆</div>
                        <h4 class="font-extrabold text-xs {{ $student->sessions->count() >= 5 ? 'text-slate-800' : 'text-slate-400' }}">Kompetisi Siap</h4>
                        <span class="text-[10px] font-bold">{{ $student->sessions->count() >= 5 ? '✓ Diraih' : 'Belum' }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function switchTab(tabName) {
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('bg-white', 'text-[#032B53]', 'shadow-sm');
                btn.classList.add('text-slate-500');
            });
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            const activeBtn = document.getElementById(`btn-${tabName}`);
            if (activeBtn) {
                activeBtn.classList.remove('text-slate-500');
                activeBtn.classList.add('bg-white', 'text-[#032B53]', 'shadow-sm');
            }
            const contentEl = document.getElementById(`tab-content-${tabName}`);
            if (contentEl) {
                contentEl.classList.remove('hidden');
            }
        }
    </script>
</body>
</html>