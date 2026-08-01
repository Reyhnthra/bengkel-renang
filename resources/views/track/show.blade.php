@php
    $logoPath = public_path('images/logo.jpeg');
    if (!file_exists($logoPath)) {
        $logoPath = base_path('public/images/logo.jpeg');
    }
    if (!file_exists($logoPath)) {
        $logoPath = '/home/beny1818/public_html/images/logo.jpeg';
    }
    if (!file_exists($logoPath)) {
        $logoPath = '/home/beny1818/repositories/bengkel-renang/public/images/logo.jpeg';
    }
    $logoBase64 = file_exists($logoPath) ? 'data:image/jpeg;base64,' . base64_encode(file_get_contents($logoPath)) : asset('images/logo.jpeg');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Tracking - {{ $student->nama }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html-to-image/1.11.11/html-to-image.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #032B53;
        }
        .modal-scroll::-webkit-scrollbar { width: 6px; }
        .modal-scroll::-webkit-scrollbar-track { background: transparent; }
        .modal-scroll::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 10px; }
    </style>
</head>
<body class="min-h-screen bg-[#032B53] py-8 px-4 flex justify-center items-center">

    <div class="w-full max-w-xl bg-white rounded-[32px] shadow-2xl overflow-y-auto max-h-[90vh] border border-slate-100 relative modal-scroll flex flex-col text-left animate-fade-in">
        
        <div class="bg-[#032B53] text-white p-6 rounded-t-[32px] relative shrink-0">
            <a href="{{ route('landing') }}" class="absolute top-6 right-6 w-8 h-8 flex items-center justify-center bg-white/10 hover:bg-white/20 text-white rounded-full text-sm font-bold transition cursor-pointer">✕</a>
            
            <div class="flex items-center space-x-4 mt-2">
                <div class="w-14 h-14 bg-amber-400 text-[#032B53] font-black rounded-2xl flex items-center justify-center text-base shadow-md shrink-0">
                    {{ strtoupper(substr($student->nama, 0, 2)) }}
                </div>
                <div>
                    <span class="text-[10px] uppercase tracking-widest text-slate-300 font-bold block">ID: {{ $student->id_tracking }}</span>
                    <h2 class="text-xl font-extrabold tracking-tight">{{ $student->nama }}</h2>
                    <div class="flex items-center space-x-2 mt-1">
                        <span class="bg-white/20 text-white text-[9px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider">{{ $student->level }}</span>
                        <span class="text-xs text-slate-300 font-medium">• {{ $usiaSiswa }} tahun</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3 mt-6 text-center">
                <div class="bg-white/10 p-2.5 rounded-xl flex flex-col items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-400 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="text-[9px] text-slate-300 font-bold uppercase tracking-wide">Total Sesi</span>
                    <span class="text-base font-black mt-0.5">{{ $sessionsCount }}</span>
                </div>
                <div class="bg-white/10 p-2.5 rounded-xl flex flex-col items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-400 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.966 7.966 0 01-2.343 5.657z" />
                    </svg>
                    <span class="text-[9px] text-slate-300 font-bold uppercase tracking-wide">Streak</span>
                    <span class="text-base font-black mt-0.5">{{ $streakCount }}x</span>
                </div>
                <div class="bg-white/10 p-2.5 rounded-xl flex flex-col items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-400 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    <span class="text-[9px] text-slate-300 font-bold uppercase tracking-wide">Progress</span>
                    <span class="text-base font-black mt-0.5 text-teal-300">{{ $progPercent }}%</span>
                </div>
            </div>
        </div>

        <div class="p-6 space-y-6 flex-1">
            
            <div class="grid grid-cols-3 bg-slate-100 p-1 rounded-xl text-center text-xs font-bold text-slate-500 shadow-inner">
                <button type="button" id="btn-tab-ringkasan" onclick="switchTab('ringkasan')" class="tab-btn cursor-pointer bg-white text-[#032B53] py-2.5 rounded-lg shadow-xs transition-all focus:outline-none">Ringkasan</button>
                <button type="button" id="btn-tab-riwayat" onclick="switchTab('riwayat')" class="tab-btn cursor-pointer text-slate-400 py-2.5 rounded-lg transition-all focus:outline-none">Riwayat Sesi</button>
                <button type="button" id="btn-tab-badge" onclick="switchTab('badge')" class="tab-btn cursor-pointer text-slate-400 py-2.5 rounded-lg transition-all focus:outline-none">Badge</button>
            </div>

            <div id="tab-ringkasan-content" class="tab-content space-y-6">
                <div class="space-y-1">
                    <div class="flex justify-between items-center text-xs font-bold uppercase tracking-wider text-slate-400">
                        <span>Progress Keseluruhan</span>
                        <span class="text-[#032B53]">{{ $progPercent }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                        <div class="bg-teal-500 h-full rounded-full transition-all duration-500" style="width: {{ $progPercent }}%"></div>
                    </div>
                    <div class="text-[10px] font-bold text-slate-400 pt-0.5 text-right">
                        <span>Bergabung: {{ $student->created_at ? $student->created_at->translatedFormat('d M Y') : '-' }}</span>
                    </div>
                </div>

                <div class="space-y-4">
                    <h4 class="text-xs font-black text-slate-800 uppercase tracking-wider">Kemampuan Per Gaya</h4>
                    
                    <div class="space-y-1.5">
                        <div class="flex justify-between text-xs font-extrabold text-slate-700 items-center">
                            <div class="flex items-center space-x-2.5">
                                <svg width="18" height="18" viewBox="0 0 36 36" class="transform -rotate-90 shrink-0">
                                    <circle cx="18" cy="18" r="16" fill="transparent" stroke="#E2E8F0" stroke-width="4.5"/>
                                    <circle cx="18" cy="18" r="16" fill="transparent" stroke="#00A79D" stroke-width="4.5" stroke-dasharray="100.5" stroke-dashoffset="{{ 100.5 - ($gBebas * 100.5 / 100) }}" stroke-linecap="round"/>
                                </svg>
                                <span>Gaya Bebas</span>
                            </div>
                            <span class="text-teal-600">{{ $gBebas }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden"><div class="bg-teal-500 h-full rounded-full" style="width: {{ $gBebas }}%"></div></div>
                    </div>

                    <div class="space-y-1.5">
                        <div class="flex justify-between text-xs font-extrabold text-slate-700 items-center">
                            <div class="flex items-center space-x-2.5">
                                <svg width="18" height="18" viewBox="0 0 36 36" class="transform -rotate-90 shrink-0">
                                    <circle cx="18" cy="18" r="16" fill="transparent" stroke="#E2E8F0" stroke-width="4.5"/>
                                    <circle cx="18" cy="18" r="16" fill="transparent" stroke="#032B53" stroke-width="4.5" stroke-dasharray="100.5" stroke-dashoffset="{{ 100.5 - ($gPunggung * 100.5 / 100) }}" stroke-linecap="round"/>
                                </svg>
                                <span>Gaya Punggung</span>
                            </div>
                            <span class="text-blue-600">{{ $gPunggung }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden"><div class="bg-blue-500 h-full rounded-full" style="width: {{ $gPunggung }}%"></div></div>
                    </div>

                    <div class="space-y-1.5">
                        <div class="flex justify-between text-xs font-extrabold text-slate-700 items-center">
                            <div class="flex items-center space-x-2.5">
                                <svg width="18" height="18" viewBox="0 0 36 36" class="transform -rotate-90 shrink-0">
                                    <circle cx="18" cy="18" r="16" fill="transparent" stroke="#E2E8F0" stroke-width="4.5"/>
                                    <circle cx="18" cy="18" r="16" fill="transparent" stroke="#FDB813" stroke-width="4.5" stroke-dasharray="100.5" stroke-dashoffset="{{ 100.5 - ($gDada * 100.5 / 100) }}" stroke-linecap="round"/>
                                </svg>
                                <span>Gaya Dada</span>
                            </div>
                            <span class="text-amber-500">{{ $gDada }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden"><div class="bg-amber-500 h-full rounded-full" style="width: {{ $gDada }}%"></div></div>
                    </div>

                    <div class="space-y-1.5">
                        <div class="flex justify-between text-xs font-extrabold text-slate-700 items-center">
                            <div class="flex items-center space-x-2.5">
                                <svg width="18" height="18" viewBox="0 0 36 36" class="transform -rotate-90 shrink-0">
                                    <circle cx="18" cy="18" r="16" fill="transparent" stroke="#E2E8F0" stroke-width="4.5"/>
                                    <circle cx="18" cy="18" r="16" fill="transparent" stroke="#EC4899" stroke-width="4.5" stroke-dasharray="100.5" stroke-dashoffset="{{ 100.5 - ($gKupu * 100.5 / 100) }}" stroke-linecap="round"/>
                                </svg>
                                <span>Gaya Kupu-kupu</span>
                            </div>
                            <span class="text-pink-500">{{ $gKupu }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden"><div class="bg-pink-500 h-full rounded-full" style="width: {{ $gKupu }}%"></div></div>
                    </div>
                </div>

                <div class="bg-teal-50/60 p-4 rounded-2xl border border-teal-100/50 space-y-2">
                    <div class="flex justify-between items-center text-[10px] font-black uppercase text-teal-600 tracking-wider">
                        <span>🕒 Sesi Terakhir</span>
                        <span>{{ $latestSession ? \Carbon\Carbon::parse($latestSession->tanggal)->translatedFormat('d M Y') : '-' }}</span>
                    </div>
                    <h4 class="font-extrabold text-xs text-[#032B53]">{{ $latestSession->topik_sesi ?? '-' }}</h4>
                    <p class="text-[11px] font-medium text-slate-500 italic leading-relaxed">"{{ $lastReport->catatan ?? 'Belum ada catatan.' }}"</p>
                </div>

                <div class="space-y-3 text-center border-t border-slate-100 pt-5">
                    <h4 class="text-xs font-black text-slate-800 uppercase tracking-wider text-left">Radar Keterampilan</h4>
                    <div class="flex justify-center items-center py-4">
                        <svg width="150" height="140" viewBox="0 0 100 100" class="transform -rotate-90">
                            <circle cx="50" cy="50" r="40" fill="transparent" stroke="#F1F5F9" stroke-width="5"/>
                            <circle cx="50" cy="50" r="40" fill="transparent" stroke="#00A79D" stroke-width="5" stroke-dasharray="251.3" stroke-dashoffset="{{ 251.3 - ($gBebas * 251.3 / 100) }}" stroke-linecap="round"/>
                            <circle cx="50" cy="50" r="32" fill="transparent" stroke="#F1F5F9" stroke-width="5"/>
                            <circle cx="50" cy="50" r="32" fill="transparent" stroke="#032B53" stroke-width="5" stroke-dasharray="201.1" stroke-dashoffset="{{ 201.1 - ($gPunggung * 201.1 / 100) }}" stroke-linecap="round"/>
                            <circle cx="50" cy="50" r="24" fill="transparent" stroke="#F1F5F9" stroke-width="5"/>
                            <circle cx="50" cy="50" r="24" fill="transparent" stroke="#FDB813" stroke-width="5" stroke-dasharray="150.8" stroke-dashoffset="{{ 150.8 - ($gDada * 150.8 / 100) }}" stroke-linecap="round"/>
                            <circle cx="50" cy="50" r="16" fill="transparent" stroke="#F1F5F9" stroke-width="5"/>
                            <circle cx="50" cy="50" r="16" fill="transparent" stroke="#EC4899" stroke-width="5" stroke-dasharray="100.5" stroke-dashoffset="{{ 100.5 - ($gKupu * 100.5 / 100) }}" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div class="flex flex-wrap justify-center gap-x-4 gap-y-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-wide">
                        <div class="flex items-center space-x-1.5"><span class="w-2.5 h-2.5 rounded-full bg-[#00A79D]"></span><span>Gaya Bebas</span></div>
                        <div class="flex items-center space-x-1.5"><span class="w-2.5 h-2.5 rounded-full bg-[#032B53]"></span><span>Gaya Punggung</span></div>
                        <div class="flex items-center space-x-1.5"><span class="w-2.5 h-2.5 rounded-full bg-[#FDB813]"></span><span>Gaya Dada</span></div>
                        <div class="flex items-center space-x-1.5"><span class="w-2.5 h-2.5 rounded-full bg-[#EC4899]"></span><span>Gaya Kupu</span></div>
                    </div>
                </div>
            </div>

            <div id="tab-riwayat-content" class="tab-content hidden space-y-4 max-h-[45vh] overflow-y-auto pr-1 modal-scroll">
                @forelse($historySessions as $sess)
                    @php
                        $isExcellent = $sess->nilai_sesi >= 85;
                        $badgeClr = $isExcellent ? "text-emerald-600 bg-emerald-50" : "text-amber-500 bg-amber-50";
                    @endphp
                    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-xs space-y-3 text-left">
                        <div class="flex justify-between items-start">
                            <div class="space-y-1">
                                <div class="flex items-center space-x-1.5 text-[10px] font-bold text-slate-400 uppercase">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Pertemuan #{{ $sess->meeting_number }} · {{ \Carbon\Carbon::parse($sess->tanggal)->translatedFormat('d M Y') }}</span>
                                </div>
                                <h4 class="font-extrabold text-sm text-[#032B53]">{{ $sess->topik_sesi ?? 'Latihan Umum' }}</h4>
                            </div>
                            <span class="text-xs font-black px-2.5 py-1 rounded-lg {{ $badgeClr }} shrink-0">{{ $sess->nilai_sesi }}/100</span>
                        </div>
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100/50">
                            <p class="text-xs text-slate-600 italic leading-relaxed">
                                "{{ $sess->progressReport ? ($sess->progressReport->catatan ?? '-') : 'Tidak ada catatan khusus pada sesi ini.' }}"
                            </p>
                        </div>
                        @php
                            $sessionData = json_encode([
                                'tanggal' => $sess->tanggal,
                                'pertemuan' => $sess->meeting_number,
                                'topik' => $sess->topik_sesi ?? 'Latihan Umum',
                                'score' => $sess->nilai_sesi,
                                'catatan' => $sess->progressReport->catatan ?? '',
                                'bebas' => $sess->progressReport->gaya_bebas ?? 0,
                                'punggung' => $sess->progressReport->gaya_punggung ?? 0,
                                'dada' => $sess->progressReport->gaya_dada ?? 0,
                                'kupu' => $sess->progressReport->gaya_kupu ?? 0,
                            ]);
                        @endphp
                        <button onclick="openStoryModal(this)" data-session="{{ $sessionData }}" class="w-full mt-3 inline-flex items-center justify-center space-x-2 text-pink-500 hover:text-pink-600 font-bold text-xs bg-pink-50 hover:bg-pink-100 py-2.5 px-4 rounded-xl transition border border-pink-100">
                            <span>Buat Story IG</span>
                        </button>
                    </div>
                @empty
                    <p class="text-center text-slate-400 text-xs py-8 font-semibold">Siswa belum memulai sesi latihan pertama.</p>
                @endforelse
            </div>
            
            <div id="tab-badge-content" class="tab-content hidden space-y-4">
                @php
                    $badgesList = [
                        'bebas' => ['nama' => 'Gaya Bebas', 'val' => $gBebas, 'color' => 'teal', 'icon' => '<path d="M2 16c2-1 4-1 6 0s4 1 6 0 4-1 6 0" /><path d="M15.5 10c-1-2.5-3.5-3.5-5.5-2.5s-2.5 3.5-1 5.5l2.5 3" /><circle cx="15.5" cy="5.5" r="1.5" fill="currentColor"/>'],
                        'punggung' => ['nama' => 'Gaya Punggung', 'val' => $gPunggung, 'color' => 'blue', 'icon' => '<path d="M2 11c2 1 4 1 6 0s4-1 6 0" /><path d="M8.5 11c0-2.5 1.5-4.5 4-4.5s4 2 4 4.5v1.5" /><circle cx="12.5" cy="4" r="1.5" fill="currentColor"/>'],
                        'dada' => ['nama' => 'Gaya Dada', 'val' => $gDada, 'color' => 'amber', 'icon' => '<circle cx="12" cy="5" r="1.5" fill="currentColor"/><path d="M4 11c2-2 5-2.5 8-1s6 1 8-1" /><path d="M2 17c3-1 6 1 10 0s7-1 10 0" />'],
                        'kupu' => ['nama' => 'Gaya Kupu-kupu', 'val' => $gKupu, 'color' => 'pink', 'icon' => '<circle cx="12" cy="6" r="1.5" fill="currentColor"/><path d="M3 10c2-3.5 5-2.5 9 .5 4-3 7-4 9-.5" /><path d="M2 17c4-2 6 2 10 0s6-2 10 0" />'],
                    ];
                    $earnedCount = 0;
                    foreach($badgesList as $b) {
                        if($b['val'] >= 100) $earnedCount++;
                    }
                @endphp
                
                <p class="text-xs font-bold text-slate-400 tracking-wide">{{ $earnedCount }} dari 4 badge diraih</p>

                <div class="grid grid-cols-2 gap-4 text-center">
                    @foreach($badgesList as $key => $b)
                        @php $isUnlocked = $b['val'] >= 100; @endphp
                        <div class="bg-white border p-5 rounded-2xl flex flex-col items-center justify-center transition-all {{ $isUnlocked ? 'border-teal-200 shadow-sm bg-teal-50/50' : 'opacity-40 grayscale border-slate-100' }}">
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center mb-2 {{ $isUnlocked ? 'bg-white shadow-xs' : 'bg-slate-100' }}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" class="h-6 w-6 text-slate-700">
                                    {!! $b['icon'] !!}
                                </svg>
                            </div>
                            <h5 class="font-extrabold text-xs text-slate-800">{{ $b['nama'] }}</h5>
                            <span class="text-[10px] font-bold block mt-1 {{ $isUnlocked ? 'text-teal-600' : 'text-slate-400' }}">
                                {{ $isUnlocked ? '✓ Diraih' : 'Belum' }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- IG Story Modal -->
    <div id="ig-story-modal" class="fixed inset-0 bg-black/95 z-[100] hidden flex flex-col items-center justify-center p-3 sm:p-6">
        <div class="relative w-full max-w-[360px] flex flex-col h-full max-h-[100vh] py-2">
            <!-- Header for actions -->
            <div class="flex justify-between items-center mb-2 px-2 shrink-0">
                <div class="flex items-center space-x-2 text-white/80">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                    <span class="text-sm font-semibold">Story Instagram</span>
                </div>
                <button onclick="closeStoryModal()" class="w-8 h-8 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center text-white transition">✕</button>
            </div>

            <!-- Template Toggle -->
            <div class="mb-2 flex bg-white/10 backdrop-blur-md rounded-xl p-1 shrink-0">
                <button id="btn-tpl-1" onclick="switchTemplate(1)" class="flex-1 py-1.5 text-xs font-bold rounded-lg bg-white text-[#032B53] shadow transition">Desain 1</button>
                <button id="btn-tpl-2" onclick="switchTemplate(2)" class="flex-1 py-1.5 text-xs font-bold rounded-lg text-white/70 hover:text-white transition">Desain 2</button>
            </div>

            <!-- Story Container (Scales to fit screen) -->
            <div id="story-container" class="flex-1 w-full flex items-center justify-center overflow-hidden min-h-0">
                <div id="story-scale-wrapper" class="origin-center transition-transform duration-300">
                    <!-- Template 1 -->
                    <div id="story-template" class="relative w-[324px] h-[576px] rounded-3xl overflow-hidden text-white flex flex-col justify-between shadow-2xl transition-all duration-300" style="background-color: #07364B; background-image: linear-gradient(180deg, #07364B 0%, #052635 100%);">
                        <!-- Background Image Layer -->
                        <div id="story-bg" class="absolute inset-0 bg-cover bg-center z-0 opacity-0 transition-opacity duration-300"></div>
                        <div class="absolute inset-0 z-0 pointer-events-none" style="background: linear-gradient(180deg, rgba(7, 54, 75, 0.95) 0%, rgba(7, 54, 75, 0.8) 50%, rgba(5, 38, 53, 0.98) 100%);"></div>

                        <!-- Content Layer -->
                        <div class="relative z-10 flex flex-col h-full p-5 justify-between">
                            <div>
                                <!-- Header -->
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center space-x-2 shrink-0">
                                        <div class="w-9 h-9 rounded-full shadow-lg border-2 border-white/20 bg-white shrink-0 bg-cover bg-center" style="background-image: url('{{ $logoBase64 }}');"></div>
                                        <div class="flex flex-col text-left">
                                            <h4 class="font-bold text-[13px] leading-snug text-white whitespace-nowrap m-0">Bengkel Renang</h4>
                                            <span class="text-[9px] text-teal-200 tracking-wider font-semibold uppercase whitespace-nowrap leading-none mt-0.5">Laporan Sesi</span>
                                        </div>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <span class="text-[9px] text-teal-200 tracking-widest uppercase font-semibold whitespace-nowrap block">SESI KE</span>
                                        <span id="story-meeting" class="font-extrabold text-[#FDB813] text-2xl leading-none">24</span>
                                    </div>
                                </div>

                                <!-- Score Circle -->
                                <div class="mt-2 flex justify-center">
                                    <div class="relative w-20 h-20 flex items-center justify-center">
                                        <svg width="80" height="80" viewBox="0 0 96 96" class="transform -rotate-90">
                                            <circle cx="48" cy="48" r="40" fill="transparent" stroke="rgba(20, 184, 166, 0.2)" stroke-width="6"/>
                                            <circle id="story-score-ring" cx="48" cy="48" r="40" fill="transparent" stroke="#2DD4BF" stroke-width="6" stroke-dasharray="251.32" stroke-dashoffset="251.32" stroke-linecap="round" class="transition-all duration-500"/>
                                        </svg>
                                        <div class="absolute inset-0 flex flex-col items-center justify-center rounded-full">
                                            <span id="story-score" class="text-3xl font-extrabold leading-none tracking-tight">90</span>
                                            <span class="text-[8.5px] text-teal-200 font-bold">/ 100</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Student Info -->
                                <div class="text-center mt-1.5">
                                    <h2 class="text-[18px] font-extrabold tracking-tight leading-tight text-white">{{ $student->nama }}</h2>
                                    <div class="flex items-center justify-center space-x-1.5 mt-1 whitespace-nowrap">
                                        <span class="bg-white/20 text-white px-2.5 py-0.5 rounded-full text-[9px] font-bold border border-white/20 inline-block">
                                            {{ ucfirst($student->level ?? 'Perenang Muda') }}
                                        </span>
                                        <span class="text-teal-200 text-[10px] font-semibold inline-block">• {{ $usiaSiswa ?? '-' }} thn</span>
                                    </div>
                                </div>

                                <!-- Date, Coach & Focus -->
                                <div class="text-center mt-1.5 space-y-1">
                                    <div class="text-[9.5px] text-teal-100 font-semibold flex items-center justify-center space-x-1 whitespace-nowrap">
                                        <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span id="story-date">30 Jun 2025</span>
                                        <span class="mx-0.5">•</span>
                                        <span>Mr. Iqbal</span>
                                    </div>
                                    <div class="inline-flex items-center justify-center space-x-1 bg-teal-500/20 border border-teal-500/30 rounded-full px-2.5 py-0.5 text-[9px] font-bold text-teal-50 max-w-full">
                                        <svg class="w-2.5 h-2.5 text-red-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>
                                        <span id="story-topic" class="truncate max-w-[200px]">Teknik pernapasan gaya bebas</span>
                                    </div>
                                </div>

                                <!-- Progress Bars -->
                                <div class="mt-2 space-y-1">
                                    <p class="text-[8.5px] font-extrabold text-teal-300 uppercase tracking-widest text-center mb-1">Progres Gaya Renang</p>
                                    
                                    <!-- Item 1 -->
                                    <div class="flex items-center space-x-2 text-[10px] font-bold">
                                        <span class="w-[95px] text-teal-50 text-left shrink-0 whitespace-nowrap">Gaya Bebas</span>
                                        <div class="flex-1 bg-white/10 h-2 rounded-full overflow-hidden">
                                            <div id="bar-bebas" class="bg-teal-400 h-full rounded-full" style="width: 88%"></div>
                                        </div>
                                        <span id="val-bebas" class="w-8 text-right text-teal-400 shrink-0">88%</span>
                                    </div>
                                    <!-- Item 2 -->
                                    <div class="flex items-center space-x-2 text-[10px] font-bold">
                                        <span class="w-[95px] text-teal-50 text-left shrink-0 whitespace-nowrap">Gaya Punggung</span>
                                        <div class="flex-1 bg-white/10 h-2 rounded-full overflow-hidden">
                                            <div id="bar-punggung" class="bg-blue-400 h-full rounded-full" style="width: 72%"></div>
                                        </div>
                                        <span id="val-punggung" class="w-8 text-right text-blue-400 shrink-0">72%</span>
                                    </div>
                                    <!-- Item 3 -->
                                    <div class="flex items-center space-x-2 text-[10px] font-bold">
                                        <span class="w-[95px] text-teal-50 text-left shrink-0 whitespace-nowrap">Gaya Dada</span>
                                        <div class="flex-1 bg-white/10 h-2 rounded-full overflow-hidden">
                                            <div id="bar-dada" class="bg-[#FDB813] h-full rounded-full" style="width: 65%"></div>
                                        </div>
                                        <span id="val-dada" class="w-8 text-right text-[#FDB813] shrink-0">65%</span>
                                    </div>
                                    <!-- Item 4 -->
                                    <div class="flex items-center space-x-2 text-[10px] font-bold">
                                        <span class="w-[95px] text-teal-50 text-left shrink-0 whitespace-nowrap">Gaya Kupu-kupu</span>
                                        <div class="flex-1 bg-white/10 h-2 rounded-full overflow-hidden">
                                            <div id="bar-kupu" class="bg-pink-400 h-full rounded-full" style="width: 55%"></div>
                                        </div>
                                        <span id="val-kupu" class="w-8 text-right text-pink-400 shrink-0">55%</span>
                                    </div>
                                </div>

                                <!-- Quote -->
                                <div class="mt-2 bg-white/10 border border-white/10 px-3 py-2 rounded-xl relative overflow-hidden shrink-0">
                                    <p id="story-quote" class="text-[10px] font-semibold text-teal-50 italic relative z-10 leading-snug text-center">
                                        "Sangat baik! Pernapasan sudah ritmis dan konsisten."
                                    </p>
                                    <p class="text-[8.5px] text-teal-200 mt-1 font-medium text-center">— Mr. Iqbal</p>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="flex justify-between items-center text-[9px] text-teal-200/80 font-medium pt-2 mt-2 border-t border-white/10">
                                <div class="flex items-center space-x-1.5">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                                    <span>@bengkelrenang</span>
                                </div>
                                <span>bengkelrenang.my.id</span>
                            </div>
                        </div>
                    </div>

                    <!-- Template 2 -->
                    <div id="story-template-2" class="relative w-[324px] h-[576px] rounded-3xl overflow-hidden text-white flex flex-col justify-between shadow-2xl transition-all duration-300 hidden" style="background-color: #07364B; background-image: linear-gradient(180deg, #07364B 0%, #052635 100%); -webkit-font-smoothing: antialiased;">
                        <!-- Background Layer -->
                        <div id="story-bg-2" class="absolute inset-0 bg-cover bg-center z-0 opacity-0 transition-opacity duration-300"></div>
                        <div class="absolute top-0 inset-x-0 h-40 z-0 pointer-events-none" style="background: linear-gradient(180deg, rgba(7, 54, 75, 0.8) 0%, transparent 100%);"></div>
                        <div class="absolute bottom-0 inset-x-0 h-[60%] z-0 pointer-events-none" style="background: linear-gradient(0deg, #052635 0%, rgba(7, 54, 75, 0.85) 60%, transparent 100%);"></div>

                        <!-- Content Layer -->
                        <div class="relative z-10 flex flex-col h-full p-5 justify-between">
                            <!-- Header Top-Left -->
                            <div class="flex items-center space-x-2.5">
                                <div class="w-9 h-9 rounded-full shadow-lg border-2 border-[#FDB813] bg-[#FDB813] shrink-0 bg-cover bg-center" style="background-image: url('{{ $logoBase64 }}');"></div>
                                <h4 class="font-extrabold text-[14px] leading-tight text-white whitespace-nowrap" style="text-shadow: 0 2px 4px rgba(0,0,0,0.7);">Bengkel Renang</h4>
                            </div>

                            <!-- Main Content (Bottom area) -->
                            <div class="mt-auto space-y-3">
                                <!-- Score and Session -->
                                <div class="flex justify-between items-end">
                                    <!-- Left: Score -->
                                    <div>
                                        <span class="text-[9.5px] text-white/90 font-bold uppercase tracking-widest block mb-0.5" style="text-shadow: 0 1px 3px rgba(0,0,0,0.7);">NILAI SESI</span>
                                        <div class="flex items-baseline space-x-1">
                                            <span id="story-score-2" class="text-6xl font-black leading-none" style="text-shadow: 0 3px 6px rgba(0,0,0,0.8);">90</span>
                                            <span class="text-lg font-bold text-white/80" style="text-shadow: 0 2px 4px rgba(0,0,0,0.7);">/100</span>
                                        </div>
                                        <div class="mt-1 flex items-center space-x-1.5 text-teal-300 font-bold" style="text-shadow: 0 1px 3px rgba(0,0,0,0.7);">
                                            <span id="story-praise-2" class="text-xs">Luar Biasa!</span>
                                            <span id="story-stars-2" class="text-xs">⭐⭐⭐⭐⭐</span>
                                        </div>
                                    </div>
                                    <!-- Right: Session -->
                                    <div class="text-right">
                                        <span class="text-[9px] text-white/90 tracking-widest uppercase font-bold whitespace-nowrap block" style="text-shadow: 0 1px 3px rgba(0,0,0,0.7);">SESI KE</span>
                                        <span id="story-meeting-2" class="font-extrabold text-[#FDB813] text-3xl leading-none" style="text-shadow: 0 2px 5px rgba(0,0,0,0.8);">24</span>
                                    </div>
                                </div>

                                <!-- Name and Student Info -->
                                <div>
                                    <h2 class="text-[22px] font-black tracking-tight leading-tight" style="text-shadow: 0 2px 5px rgba(0,0,0,0.8);">{{ $student->nama }}</h2>
                                    <div class="flex items-center space-x-2 mt-1.5 whitespace-nowrap shrink-0">
                                        <span class="bg-black/50 text-white px-2.5 py-0.5 rounded-full text-[10px] font-bold border border-white/20 shadow-sm shrink-0">
                                            {{ ucfirst($student->level ?? 'Perenang Muda') }}
                                        </span>
                                        <div class="text-[10px] text-white/90 font-semibold flex items-center space-x-1 shrink-0" style="text-shadow: 0 1px 3px rgba(0,0,0,0.7);">
                                            <svg class="w-3 h-3 text-teal-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <span id="story-date-2">30 Jun 2025</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Quote -->
                                <div class="bg-[#07364B]/85 border border-white/15 p-3 rounded-xl relative overflow-hidden">
                                    <p id="story-quote-2" class="text-[11px] font-medium text-white/95 italic leading-relaxed relative z-10">
                                        "Sangat baik! Pernapasan sudah ritmis dan konsisten."
                                    </p>
                                    <p class="text-[9px] text-teal-200 mt-1.5 font-medium">— Mr. Iqbal</p>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="flex justify-between items-center text-[9px] text-white/70 font-medium pt-2 mt-3 border-t border-white/10" style="text-shadow: 0 1px 2px rgba(0,0,0,0.6);">
                                <div class="flex items-center space-x-1.5">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                                    <span>@bengkelrenang</span>
                                </div>
                                <span>bengkelrenang.my.id</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-3 flex flex-col space-y-2.5 w-full shrink-0">
                <!-- Photo Upload -->
                <label class="cursor-pointer bg-white text-[#032B53] font-bold text-sm py-2.5 rounded-xl flex items-center justify-center shadow-lg transition hover:bg-slate-50 border border-slate-100">
                    <span id="photo-label-text" class="flex items-center">
                        <svg id="photo-icon" class="w-4 h-4 mr-2 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span id="photo-text-span">Tambah Latar Foto</span> 
                        <span class="text-slate-400 font-normal ml-1 hidden sm:inline">— opsional</span>
                    </span>
                    <input type="file" id="upload-photo" accept="image/*" class="hidden" onchange="handlePhotoUpload(event)">
                </label>

                <!-- Download Button -->
                <button onclick="downloadStoryImage()" id="btn-share" class="bg-gradient-to-r from-pink-500 via-purple-500 to-orange-500 hover:opacity-90 text-white font-bold text-sm py-2.5 rounded-xl shadow-lg transition flex items-center justify-center space-x-2 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    <span id="share-text">Unduh Gambar untuk IG Story</span>
                </button>
                <p class="text-center text-[10px] text-white/70 pt-0.5 font-medium">Unduh gambar lalu unggah ke Story Instagram Anda</p>
            </div>
        </div>
    </div>

    <script>
        let currentTemplate = 1;

        function switchTemplate(tplId) {
            currentTemplate = tplId;
            const tpl1 = document.getElementById('story-template');
            const tpl2 = document.getElementById('story-template-2');
            const btn1 = document.getElementById('btn-tpl-1');
            const btn2 = document.getElementById('btn-tpl-2');

            if (tplId === 1) {
                tpl1.classList.remove('hidden');
                tpl2.classList.add('hidden');
                btn1.className = 'flex-1 py-1.5 text-xs font-bold rounded-lg bg-white text-[#032B53] shadow transition';
                btn2.className = 'flex-1 py-1.5 text-xs font-bold rounded-lg text-white/70 hover:text-white transition';
            } else {
                tpl2.classList.remove('hidden');
                tpl1.classList.add('hidden');
                btn2.className = 'flex-1 py-1.5 text-xs font-bold rounded-lg bg-white text-[#032B53] shadow transition';
                btn1.className = 'flex-1 py-1.5 text-xs font-bold rounded-lg text-white/70 hover:text-white transition';
            }
        }

        function formatLocalDate(dateStr) {
            const date = new Date(dateStr);
            return date.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
        }
        
        function updateScale() {
            const container = document.getElementById('story-container');
            const wrapper = document.getElementById('story-scale-wrapper');
            if(container && wrapper) {
                const height = container.clientHeight;
                if(height > 0 && height < 576) {
                    const scale = height / 576;
                    wrapper.style.transform = `scale(${scale})`;
                } else {
                    wrapper.style.transform = 'scale(1)';
                }
            }
        }
        window.addEventListener('resize', updateScale);

        function openStoryModal(btn) {
            const rawData = btn.getAttribute('data-session');
            if(!rawData) return;
            const data = JSON.parse(rawData);

            const modal = document.getElementById('ig-story-modal');
            modal.classList.remove('hidden');
            
            setTimeout(updateScale, 10);
            
            // Reset to template 1 when opening
            switchTemplate(1);

            document.getElementById('story-meeting').innerText = parseInt(data.pertemuan) || 1;
            document.getElementById('story-meeting-2').innerText = parseInt(data.pertemuan) || 1;
            
            // Calc styles for Template 1
            const gBebas = parseInt(data.bebas) || 0;
            const gPunggung = parseInt(data.punggung) || 0;
            const gDada = parseInt(data.dada) || 0;
            const gKupu = parseInt(data.kupu) || 0;
            const average = parseInt(data.score) || 0;

            const scoreRing = document.getElementById('story-score-ring');
            if (scoreRing) {
                const clampedScore = Math.min(Math.max(average, 0), 100);
                const offset = 251.32 - (251.32 * clampedScore / 100);
                scoreRing.style.strokeDashoffset = offset;
            }

            document.getElementById('story-score').innerText = average;
            document.getElementById('story-date').innerText = formatLocalDate(data.tanggal);
            document.getElementById('story-topic').innerText = data.topik || '-';
            document.getElementById('story-quote').innerText = '"' + (data.catatan || 'Latihan berjalan dengan lancar.') + '"';

            document.getElementById('bar-bebas').style.width = gBebas + '%';
            document.getElementById('val-bebas').innerText = gBebas + '%';
            
            document.getElementById('bar-punggung').style.width = gPunggung + '%';
            document.getElementById('val-punggung').innerText = gPunggung + '%';
            
            document.getElementById('bar-dada').style.width = gDada + '%';
            document.getElementById('val-dada').innerText = gDada + '%';
            
            document.getElementById('bar-kupu').style.width = gKupu + '%';
            document.getElementById('val-kupu').innerText = gKupu + '%';

            // Populate Template 2
            document.getElementById('story-score-2').innerText = average;
            document.getElementById('story-date-2').innerText = formatLocalDate(data.tanggal);
            document.getElementById('story-quote-2').innerText = '"' + (data.catatan || 'Latihan berjalan dengan lancar.') + '"';
            
            let praise = "";
            let stars = "";
            if (average <= 20) {
                praise = "Ayo Semangat!";
                stars = "⭐";
            } else if (average <= 40) {
                praise = "Terus Berlatih!";
                stars = "⭐⭐";
            } else if (average <= 60) {
                praise = "Mulai Berkembang!";
                stars = "⭐⭐⭐";
            } else if (average <= 80) {
                praise = "Perkembangan Bagus!";
                stars = "⭐⭐⭐⭐";
            } else {
                praise = "Luar Biasa!";
                stars = "⭐⭐⭐⭐⭐";
            }
            
            document.getElementById('story-praise-2').innerText = praise;
            const starsEl = document.getElementById('story-stars-2');
            if (starsEl) starsEl.innerText = stars;

            // Clean up old photo if any
            document.getElementById('upload-photo').value = "";
            document.getElementById('photo-text-span').innerText = 'Tambah Latar Foto';
            document.getElementById('photo-icon').innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>';
            document.getElementById('photo-icon').classList.replace('text-blue-500', 'text-pink-500');
            document.getElementById('story-bg').style.opacity = '0';
            document.getElementById('story-bg-2').style.opacity = '0';
        }

        function closeStoryModal() {
            document.getElementById('ig-story-modal').classList.add('hidden');
        }

        function handlePhotoUpload(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('story-bg').style.backgroundImage = `url(${e.target.result})`;
                    document.getElementById('story-bg').style.opacity = '1';
                    document.getElementById('story-bg-2').style.backgroundImage = `url(${e.target.result})`;
                    document.getElementById('story-bg-2').style.opacity = '1';
                    
                    document.getElementById('photo-text-span').innerText = 'Ganti Latar Foto';
                    document.getElementById('photo-icon').innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>';
                    document.getElementById('photo-icon').classList.replace('text-pink-500', 'text-blue-500');
                }
               async function downloadStoryImage() {
            const btn = document.getElementById('btn-share');
            const text = document.getElementById('share-text');
            const originalText = text.innerText;
            text.innerText = "Mengunduh...";
            btn.disabled = true;

            const targetId = currentTemplate === 1 ? 'story-template' : 'story-template-2';
            const targetEl = document.getElementById(targetId);
            const scaleWrapper = document.getElementById('story-scale-wrapper');
            const storyContainer = document.getElementById('story-container');
            if (!targetEl || !scaleWrapper) {
                text.innerText = originalText;
                btn.disabled = false;
                return;
            }

            // Temporarily reset preview scale & overflow for crisp un-clipped 3x HD canvas rendering
            const savedTransform = scaleWrapper.style.transform;
            const savedOverflow = storyContainer ? storyContainer.style.overflow : '';
            scaleWrapper.style.transform = 'none';
            if (storyContainer) storyContainer.style.overflow = 'visible';

            try {
                if (document.fonts && document.fonts.ready) {
                    try { await document.fonts.ready; } catch(e){}
                }

                await new Promise(r => setTimeout(r, 60));

                let canvas;
                if (window.html2canvas) {
                    try {
                        canvas = await html2canvas(targetEl, {
                            scale: 3,
                            useCORS: true,
                            allowTaint: true,
                            backgroundColor: '#07364B',
                            scrollX: 0,
                            scrollY: 0,
                            logging: false,
                            onclone: (clonedDoc) => {
                                Array.from(clonedDoc.querySelectorAll('link[rel="stylesheet"]')).forEach(link => {
                                    try {
                                        let cssText = '';
                                        if (link.sheet && link.sheet.cssRules) {
                                            Array.from(link.sheet.cssRules).forEach(rule => {
                                                cssText += rule.cssText + '\n';
                                            });
                                        }
                                        if (cssText) {
                                            const cleanedText = cssText
                                                .replace(/oklab\([^)]+\)/gi, '#07364B')
                                                .replace(/oklch\([^)]+\)/gi, '#07364B');
                                            const styleEl = clonedDoc.createElement('style');
                                            styleEl.textContent = cleanedText;
                                            link.parentNode.insertBefore(styleEl, link);
                                            link.parentNode.removeChild(link);
                                        }
                                    } catch(e){}
                                });

                                clonedDoc.querySelectorAll('style').forEach(style => {
                                    try {
                                        style.innerHTML = style.innerHTML
                                            .replace(/oklab\([^)]+\)/gi, '#07364B')
                                            .replace(/oklch\([^)]+\)/gi, '#07364B');
                                    } catch(e){}
                                });
                            }
                        });
                    } catch (h2cErr) {
                        console.warn("html2canvas error, falling back to htmlToImage:", h2cErr);
                    }
                }

                if (!canvas && window.htmlToImage) {
                    try {
                        canvas = await htmlToImage.toCanvas(targetEl, {
                            pixelRatio: 3,
                            backgroundColor: '#07364B',
                            cacheBust: true
                        });
                    } catch(h2iErr) {
                        console.warn("htmlToImage error:", h2iErr);
                    }
                }

                // Restore preview scale and overflow after snapshot
                scaleWrapper.style.transform = savedTransform;
                if (storyContainer) storyContainer.style.overflow = savedOverflow;
                updateScale();

                if (!canvas) {
                    throw new Error("Gagal membuat gambar.");
                }

                canvas.toBlob((blob) => {
                    const timeStamp = new Date().getTime();
                    const fileName = `progress-renang-{{ Str::slug($student->nama) }}-${timeStamp}.png`;

                    if (!blob) {
                        showStoryToast("Gagal membuat data gambar.", "error");
                        text.innerText = originalText;
                        btn.disabled = false;
                        return;
                    }

                    fallbackDownloadBlob(blob, fileName);
                    text.innerText = originalText;
                    btn.disabled = false;
                }, 'image/png');

            } catch (err) {
                console.error("downloadStoryImage error:", err);
                if (scaleWrapper) scaleWrapper.style.transform = savedTransform;
                if (storyContainer) storyContainer.style.overflow = savedOverflow;
                updateScale();
                showStoryToast("Gagal mengunduh gambar: " + (err.message || 'Terjadi kesalahan'), "error");
                text.innerText = originalText;
                btn.disabled = false;
            }
        }
                btn.disabled = false;
            }
        }

        const shareStory = downloadStoryImage;

        function showStoryToast(message, type = 'info') {
            let toast = document.getElementById('story-toast');
            if (!toast) {
                toast = document.createElement('div');
                toast.id = 'story-toast';
                toast.className = 'fixed bottom-5 left-1/2 -translate-x-1/2 z-[110] max-w-xs sm:max-w-sm w-[90%] bg-slate-900/95 text-white text-xs font-semibold px-4 py-3 rounded-2xl shadow-2xl backdrop-blur-md flex items-center space-x-2.5 transition-all duration-300 transform opacity-0 translate-y-4 pointer-events-none border border-white/10';
                document.body.appendChild(toast);
            }
            const icon = type === 'success' ? '✅' : (type === 'error' ? '⚠️' : 'ℹ️');
            toast.innerHTML = `<span class="text-base">${icon}</span><span>${message}</span>`;
            toast.classList.remove('opacity-0', 'translate-y-4', 'pointer-events-none');
            toast.classList.add('opacity-100', 'translate-y-0');
            
            setTimeout(() => {
                toast.classList.remove('opacity-100', 'translate-y-0');
                toast.classList.add('opacity-0', 'translate-y-4', 'pointer-events-none');
            }, 4500);
        }

        function fallbackDownloadBlob(blob, filename) {
            try {
                const blobUrl = URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.href = blobUrl;
                link.download = filename;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                setTimeout(() => URL.revokeObjectURL(blobUrl), 10000);
                showStoryToast("Gambar Story berhasil diunduh!", "success");
            } catch (err) {
                console.error("Download fallback error:", err);
                showStoryToast("Gagal mengunduh gambar story.", "error");
            }
        }

        function switchTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.tab-btn').forEach(el => {
                el.classList.remove('bg-white', 'text-[#032B53]', 'shadow-xs');
                el.classList.add('text-slate-400');
            });
            document.getElementById('tab-' + tabName + '-content').classList.remove('hidden');
            document.getElementById('btn-tab-' + tabName).classList.add('bg-white', 'text-[#032B53]', 'shadow-xs');
            document.getElementById('btn-tab-' + tabName).classList.remove('text-slate-400');
        }
    </script>
</body>
</html>