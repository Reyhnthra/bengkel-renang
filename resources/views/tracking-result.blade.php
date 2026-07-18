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
                            <button onclick="openStoryModal(this)" data-session="{{ $sessionData }}" class="w-full inline-flex items-center justify-center space-x-2 text-pink-500 hover:text-pink-600 font-bold text-xs bg-pink-50 hover:bg-pink-100 py-2.5 px-4 rounded-xl transition border border-pink-100">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.46 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg>
                                <span>Buat Story IG</span>
                            </button>
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
            activeBtn.classList.remove('text-slate-500');
            activeBtn.classList.add('bg-white', 'text-[#032B53]', 'shadow-sm');
            document.getElementById(`tab-content-${tabName}`).classList.remove('hidden');
        }

        function openStoryModal(btn) {
            const data = JSON.parse(btn.getAttribute('data-session'));
            document.getElementById('story-meeting').innerText = data.meeting;
            document.getElementById('story-score').innerText = data.score;
            document.getElementById('story-date').innerText = data.date;
            document.getElementById('story-topic').innerText = data.topic;
            document.getElementById('story-quote').innerText = '"' + (data.catatan || 'Latihan berjalan dengan lancar.') + '"';

            document.getElementById('bar-bebas').style.width = data.bebas + '%';
            document.getElementById('val-bebas').innerText = data.bebas + '%';
            
            document.getElementById('bar-punggung').style.width = data.punggung + '%';
            document.getElementById('val-punggung').innerText = data.punggung + '%';
            
            document.getElementById('bar-dada').style.width = data.dada + '%';
            document.getElementById('val-dada').innerText = data.dada + '%';
            
            document.getElementById('bar-kupu').style.width = data.kupu + '%';
            document.getElementById('val-kupu').innerText = data.kupu + '%';

            document.getElementById('ig-story-modal').classList.remove('hidden');
        }

        function closeStoryModal() {
            document.getElementById('ig-story-modal').classList.add('hidden');
        }

        function handlePhotoUpload(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const bgEl = document.getElementById('story-bg');
                    bgEl.style.backgroundImage = `url(${e.target.result})`;
                    bgEl.classList.remove('opacity-40');
                    bgEl.classList.add('opacity-100');
                    document.getElementById('photo-label-text').innerHTML = '🔄 Ganti Foto Anak &nbsp;<span class="text-slate-400 font-normal">— opsional</span>';
                }
                reader.readAsDataURL(file);
            }
        }

        function downloadStory() {
            const storyEl = document.getElementById('story-template');
            
            // Temporary hide border radius to prevent white corners in some versions of html2canvas
            const originalBorderRadius = storyEl.style.borderRadius;
            storyEl.style.borderRadius = '0px';

            html2canvas(storyEl, {
                scale: 3, // High quality
                useCORS: true,
                backgroundColor: '#0a3143'
            }).then(canvas => {
                storyEl.style.borderRadius = originalBorderRadius;
                
                const image = canvas.toDataURL("image/png");
                const link = document.createElement('a');
                link.download = `progress-renang-{{ Str::slug($student->nama) }}.png`;
                link.href = image;
                link.click();
            });
        }
    </script>

    <!-- IG Story Modal -->
    <div id="ig-story-modal" class="fixed inset-0 bg-black/90 z-50 hidden flex flex-col items-center justify-center p-4">
        <div class="relative w-full max-w-[380px] flex flex-col h-[750px] max-h-[95vh]">
            <!-- Header for actions -->
            <div class="flex justify-between items-center mb-4 px-2">
                <div class="flex items-center space-x-2 text-white/80">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.46 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg>
                    <span class="text-sm font-semibold">Template Story Instagram</span>
                </div>
                <button onclick="closeStoryModal()" class="w-8 h-8 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center text-white transition">✕</button>
            </div>

            <!-- Story Template Canvas -->
            <div id="story-template" class="relative w-full flex-1 rounded-3xl overflow-hidden bg-[#07364B] text-white flex flex-col justify-between shadow-2xl transition-all duration-300">
                <!-- Background Image Layer -->
                <div id="story-bg" class="absolute inset-0 bg-cover bg-center z-0 opacity-0 transition-opacity duration-300"></div>
                <div class="absolute inset-0 bg-gradient-to-b from-[#07364B]/95 via-[#07364B]/80 to-[#07364B] z-0"></div>

                <!-- Content Layer -->
                <div class="relative z-10 flex flex-col h-full p-6">
                    <!-- Header -->
                    <div class="flex justify-between items-start">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-[#FDB813] rounded-full flex items-center justify-center text-[#032B53] font-bold text-lg shadow-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-[15px] leading-tight">Bengkel Renang</h4>
                                <span class="text-[10px] text-teal-200/80 tracking-wider font-semibold uppercase">Laporan Sesi</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-[9px] text-teal-200/80 tracking-widest uppercase font-semibold block">Sesi Ke-</span>
                            <span id="story-meeting" class="font-extrabold text-[#FDB813] text-2xl leading-none">24</span>
                        </div>
                    </div>

                    <!-- Score Circle -->
                    <div class="mt-8 flex justify-center">
                        <div class="relative w-32 h-32">
                            <div class="absolute inset-0 rounded-full border-[10px] border-teal-500/20"></div>
                            <div class="absolute inset-0 rounded-full border-[10px] border-transparent border-t-teal-400 border-r-teal-400 shadow-[0_0_20px_rgba(45,212,191,0.6)] transform -rotate-45 rounded-full"></div>
                            <div class="absolute inset-0 flex flex-col items-center justify-center bg-teal-900/40 rounded-full backdrop-blur-sm m-2">
                                <span id="story-score" class="text-5xl font-extrabold leading-none tracking-tight">90</span>
                                <span class="text-xs text-teal-200 font-bold mt-1">/ 100</span>
                            </div>
                        </div>
                    </div>

                    <!-- Student Info -->
                    <div class="text-center mt-6">
                        <h2 class="text-[26px] font-extrabold tracking-tight">{{ $student->nama }}</h2>
                        <div class="flex items-center justify-center space-x-2 mt-2">
                            <span class="bg-white/10 backdrop-blur-md text-white px-3.5 py-1.5 rounded-full text-[11px] font-bold border border-white/20 shadow-sm">
                                {{ ucfirst($student->level ?? 'Perenang Muda') }}
                            </span>
                            <span class="text-teal-200/90 text-[11px] font-semibold">{{ $student->usia ?? '-' }} thn</span>
                        </div>
                    </div>

                    <!-- Date, Coach & Focus -->
                    <div class="text-center mt-5 space-y-2.5">
                        <div class="text-[11px] text-teal-100/80 font-semibold flex items-center justify-center space-x-2">
                            <span>📅 <span id="story-date">30 Jun 2025</span></span>
                            <span>•</span>
                            <span>Kak Reza</span>
                        </div>
                        <div class="inline-block bg-teal-500/20 backdrop-blur-md border border-teal-500/30 rounded-full px-4 py-2 text-xs font-bold text-teal-50 shadow-inner">
                            🎯 <span id="story-topic">Teknik pernapasan gaya bebas</span>
                        </div>
                    </div>

                    <!-- Progress Bars -->
                    <div class="mt-6 space-y-2.5">
                        <p class="text-[9px] font-extrabold text-teal-300/80 uppercase tracking-widest text-center mb-3">Progres Gaya Renang</p>
                        
                        <!-- Item 1 -->
                        <div class="flex items-center justify-between text-[11px] font-bold">
                            <span class="w-[110px] text-teal-50/90 text-right pr-3">Gaya Bebas</span>
                            <div class="flex-1 bg-white/10 h-1.5 rounded-full overflow-hidden backdrop-blur-sm">
                                <div id="bar-bebas" class="bg-teal-400 h-full rounded-full shadow-[0_0_8px_rgba(45,212,191,0.8)]" style="width: 88%"></div>
                            </div>
                            <span id="val-bebas" class="w-10 text-right text-teal-400">88%</span>
                        </div>
                        <!-- Item 2 -->
                        <div class="flex items-center justify-between text-[11px] font-bold">
                            <span class="w-[110px] text-teal-50/90 text-right pr-3">Gaya Punggung</span>
                            <div class="flex-1 bg-white/10 h-1.5 rounded-full overflow-hidden backdrop-blur-sm">
                                <div id="bar-punggung" class="bg-blue-400 h-full rounded-full shadow-[0_0_8px_rgba(96,165,250,0.8)]" style="width: 72%"></div>
                            </div>
                            <span id="val-punggung" class="w-10 text-right text-blue-400">72%</span>
                        </div>
                        <!-- Item 3 -->
                        <div class="flex items-center justify-between text-[11px] font-bold">
                            <span class="w-[110px] text-teal-50/90 text-right pr-3">Gaya Dada</span>
                            <div class="flex-1 bg-white/10 h-1.5 rounded-full overflow-hidden backdrop-blur-sm">
                                <div id="bar-dada" class="bg-[#FDB813] h-full rounded-full shadow-[0_0_8px_rgba(253,184,19,0.8)]" style="width: 65%"></div>
                            </div>
                            <span id="val-dada" class="w-10 text-right text-[#FDB813]">65%</span>
                        </div>
                        <!-- Item 4 -->
                        <div class="flex items-center justify-between text-[11px] font-bold">
                            <span class="w-[110px] text-teal-50/90 text-right pr-3">Gaya Kupu-kupu</span>
                            <div class="flex-1 bg-white/10 h-1.5 rounded-full overflow-hidden backdrop-blur-sm">
                                <div id="bar-kupu" class="bg-pink-400 h-full rounded-full shadow-[0_0_8px_rgba(244,114,182,0.8)]" style="width: 55%"></div>
                            </div>
                            <span id="val-kupu" class="w-10 text-right text-pink-400">55%</span>
                        </div>
                    </div>

                    <!-- Quote -->
                    <div class="mt-6 bg-white/10 backdrop-blur-md border border-white/10 p-4 rounded-2xl relative overflow-hidden">
                        <div class="absolute -top-2 -left-2 text-6xl text-white/5 font-serif">"</div>
                        <p id="story-quote" class="text-sm font-semibold text-teal-50 italic relative z-10 leading-relaxed">
                            "Sangat baik! Pernapasan sudah ritmis dan konsisten."
                        </p>
                        <p class="text-[10px] text-teal-200/80 mt-3 font-medium">— Kak Reza, Pelatih</p>
                    </div>

                    <!-- Footer -->
                    <div class="mt-auto pt-5 pb-1 flex justify-between items-center text-[10px] font-semibold text-teal-200/70 tracking-wide">
                        <div class="flex items-center space-x-1.5">
                            <svg class="w-3.5 h-3.5 text-pink-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.46 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg>
                            <span>@bengkelrenang</span>
                        </div>
                        <span>bengkelrenang.id</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-4 flex flex-col space-y-3 w-full shrink-0">
                <!-- Photo Upload -->
                <label class="cursor-pointer bg-white text-[#032B53] font-bold text-sm py-3.5 rounded-2xl flex items-center justify-center shadow-lg transition hover:bg-slate-50 border border-slate-100">
                    <span id="photo-label-text">📷 Tambah Foto Anak &nbsp;<span class="text-slate-400 font-normal">— opsional</span></span>
                    <input type="file" id="upload-photo" accept="image/*" class="hidden" onchange="handlePhotoUpload(event)">
                </label>

                <!-- Download Button -->
                <button onclick="downloadStory()" class="bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 text-white font-bold text-sm py-3.5 rounded-2xl shadow-lg transition flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    <span>Download Kartu Sesi</span>
                </button>
                <p class="text-center text-[11px] text-white/50 pt-1">Screenshot atau Download kartu ini untuk dibagikan ke Story</p>
            </div>
        </div>
    </div>
</body>
</html>