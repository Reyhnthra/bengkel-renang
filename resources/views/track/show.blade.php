<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Tracking - {{ $student->nama }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
                <p class="text-xs font-bold text-slate-400 tracking-wide">Badge Progress</p>
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
                    <div id="story-template" class="relative w-[324px] h-[576px] rounded-3xl overflow-hidden bg-[#07364B] text-white flex flex-col justify-between shadow-2xl transition-all duration-300">
                <!-- Background Image Layer -->
                <div id="story-bg" class="absolute inset-0 bg-cover bg-center z-0 opacity-0 transition-opacity duration-300"></div>
                <div class="absolute inset-0 bg-gradient-to-b from-[#07364B]/95 via-[#07364B]/80 to-[#07364B] z-0"></div>

                <!-- Content Layer -->
                <div class="relative z-10 flex flex-col h-full p-6 justify-between">
                    <div>
                        <!-- Header -->
                        <div class="flex justify-between items-start">
                            <div class="flex items-center space-x-2">
                                <div class="w-9 h-9 rounded-full flex items-center justify-center shadow-lg overflow-hidden border-2 border-white/20 bg-white shrink-0">
                                    <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h4 class="font-bold text-[14px] leading-tight text-white">Bengkel Renang</h4>
                                    <span class="text-[9px] text-teal-200/80 tracking-wider font-semibold uppercase">Laporan Sesi</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-[9px] text-teal-200/80 tracking-widest uppercase font-semibold block">Sesi Ke-</span>
                                <span id="story-meeting" class="font-extrabold text-[#FDB813] text-2xl leading-none">24</span>
                            </div>
                        </div>

                        <!-- Score Circle -->
                        <div class="mt-2.5 flex justify-center">
                            <div class="relative w-24 h-24">
                                <div class="absolute inset-0 rounded-full border-[6px] border-teal-500/20"></div>
                                <div class="absolute inset-0 rounded-full border-[6px] border-transparent border-t-teal-400 border-r-teal-400 shadow-[0_0_15px_rgba(45,212,191,0.5)] transform -rotate-45"></div>
                                <div class="absolute inset-0 flex flex-col items-center justify-center bg-teal-900/40 rounded-full backdrop-blur-sm m-1.5">
                                    <span id="story-score" class="text-4xl font-extrabold leading-none tracking-tight">90</span>
                                    <span class="text-[9px] text-teal-200 font-bold">/ 100</span>
                                </div>
                            </div>
                        </div>

                        <!-- Student Info -->
                        <div class="text-center mt-2.5">
                            <h2 class="text-[20px] font-extrabold tracking-tight">{{ $student->nama }}</h2>
                            <div class="flex items-center justify-center space-x-2 mt-1">
                                <span class="bg-white/10 backdrop-blur-md text-white px-2.5 py-0.5 rounded-full text-[9px] font-bold border border-white/20 shadow-sm">
                                    {{ ucfirst($student->level ?? 'Perenang Muda') }}
                                </span>
                                <span class="text-teal-200/90 text-[10px] font-semibold">{{ $usiaSiswa ?? '-' }} thn</span>
                            </div>
                        </div>

                        <!-- Date, Coach & Focus -->
                        <div class="text-center mt-2.5 space-y-1.5">
                            <div class="text-[10px] text-teal-100/80 font-semibold flex items-center justify-center space-x-1.5">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span id="story-date">30 Jun 2025</span>
                                <span class="mx-0.5">•</span>
                                <span>Mr. Iqbal</span>
                            </div>
                            <div class="inline-flex items-center justify-center space-x-1.5 bg-teal-500/20 backdrop-blur-md border border-teal-500/30 rounded-full px-3 py-1 text-[10px] font-bold text-teal-50 shadow-inner">
                                <svg class="w-3 h-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>
                                <span id="story-topic">Teknik pernapasan gaya bebas</span>
                            </div>
                        </div>

                        <!-- Progress Bars -->
                        <div class="mt-2.5 space-y-1.5">
                            <p class="text-[9px] font-extrabold text-teal-300/80 uppercase tracking-widest text-center mb-2">Progres Gaya Renang</p>
                            
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
                        <div class="mt-2 bg-white/10 backdrop-blur-md border border-white/10 p-3 rounded-xl relative overflow-hidden shrink-0">
                            <div class="absolute -top-3 -left-1 text-6xl text-white/10 font-serif">"</div>
                            <p id="story-quote" class="text-[11px] font-semibold text-teal-50 italic relative z-10 leading-snug text-center">
                                "Sangat baik! Pernapasan sudah ritmis dan konsisten."
                            </p>
                            <p class="text-[9px] text-teal-200/80 mt-1.5 font-medium text-center">— Mr. Iqbal, Pelatih</p>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="flex justify-between items-center text-[9px] text-teal-200/60 font-medium pt-3 mt-3 border-t border-white/10">
                        <div class="flex items-center space-x-1.5">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                            <span>@bengkelrenang</span>
                        </div>
                        <span>bengkelrenang.id</span>
                    </div>
                </div>
            </div>

            <!-- Template 2 -->
            <div id="story-template-2" class="relative w-[324px] h-[576px] rounded-3xl overflow-hidden bg-[#07364B] text-white flex flex-col justify-between shadow-2xl transition-all duration-300 hidden">
                <!-- Background Layer -->
                <div id="story-bg-2" class="absolute inset-0 bg-cover bg-center z-0 opacity-0 transition-opacity duration-300"></div>
                <div class="absolute top-0 inset-x-0 h-40 bg-gradient-to-b from-[#07364B]/80 to-transparent z-0"></div>
                <div class="absolute bottom-0 inset-x-0 h-[60%] bg-gradient-to-t from-[#07364B] via-[#07364B]/80 to-transparent z-0"></div>

                <!-- Content Layer -->
                <div class="relative z-10 flex flex-col h-full p-6 justify-between">
                    <!-- Header Top-Left -->
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center shadow-lg overflow-hidden border-2 border-[#FDB813] bg-[#FDB813] shrink-0">
                            <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" class="w-full h-full object-cover">
                        </div>
                        <h4 class="font-extrabold text-[15px] leading-tight text-white drop-shadow-md">Bengkel Renang</h4>
                    </div>

                    <!-- Main Content (Bottom area) -->
                    <div class="mt-auto space-y-4">
                        <!-- Score and Session -->
                        <div class="flex justify-between items-end">
                            <!-- Left: Score -->
                            <div>
                                <span class="text-[10px] text-white/90 font-bold uppercase tracking-widest block mb-0.5 drop-shadow-md">NILAI SESI</span>
                                <div class="flex items-baseline space-x-1">
                                    <span id="story-score-2" class="text-7xl font-black leading-none drop-shadow-lg">90</span>
                                    <span class="text-xl font-bold text-white/80">/100</span>
                                </div>
                                <div class="mt-1 flex items-center space-x-1.5 text-teal-300 font-bold drop-shadow-md">
                                    <span id="story-praise-2" class="text-sm">Luar Biasa!</span>
                                    <span id="story-stars-2">⭐⭐⭐⭐⭐</span>
                                </div>
                            </div>
                            <!-- Right: Session -->
                            <div class="text-right">
                                <span class="text-[9px] text-white/80 tracking-widest uppercase font-bold block drop-shadow-md">SESI KE-</span>
                                <span id="story-meeting-2" class="font-extrabold text-[#FDB813] text-4xl leading-none drop-shadow-lg">24</span>
                            </div>
                        </div>

                        <!-- Name and Student Info -->
                        <div>
                            <h2 class="text-[26px] font-black tracking-tight drop-shadow-lg">{{ $student->nama }}</h2>
                            <div class="flex items-center space-x-2 mt-2">
                                <span class="bg-black/40 backdrop-blur-md text-white px-3 py-1 rounded-full text-[11px] font-bold border border-white/20 shadow-sm">
                                    {{ ucfirst($student->level ?? 'Perenang Muda') }}
                                </span>
                                <div class="text-[11px] text-white/90 font-semibold flex items-center space-x-1.5 drop-shadow-md">
                                    <svg class="w-3.5 h-3.5 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span id="story-date-2">30 Jun 2025</span>
                                </div>
                            </div>
                        </div>

                        <!-- Quote -->
                        <div class="bg-[#07364B]/60 backdrop-blur-md border border-white/10 p-4 rounded-2xl relative overflow-hidden">
                            <div class="absolute -top-3 -left-1 text-7xl text-white/10 font-serif">"</div>
                            <p id="story-quote-2" class="text-[13px] font-medium text-white/95 italic leading-relaxed relative z-10">
                                "Sangat baik! Pernapasan sudah ritmis dan konsisten."
                            </p>
                            <p class="text-[10px] text-teal-200 mt-2.5 font-medium">— Mr. Iqbal</p>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="flex justify-between items-center text-[9px] text-white/60 font-medium pt-3 mt-4 border-t border-white/10">
                        <div class="flex items-center space-x-1.5">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                            <span>@bengkelrenang</span>
                        </div>
                        <span>bengkelrenang.id</span>
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
                <button onclick="shareStory()" id="btn-share" class="bg-gradient-to-r from-pink-500 via-purple-500 to-orange-500 hover:opacity-90 text-white font-bold text-sm py-2.5 rounded-xl shadow-lg transition flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                    <span id="share-text">Bagikan ke IG Story</span>
                </button>
                <p class="text-center text-[9px] text-white/50 pt-0.5">Otomatis unduh jika tidak ada fitur IG Story</p>
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
                reader.readAsDataURL(file);
            }
        }

        async function shareStory() {
            const btn = document.getElementById('btn-share');
            const text = document.getElementById('share-text');
            const originalText = text.innerText;
            text.innerText = "Memproses...";
            btn.disabled = true;

            const storyEl = currentTemplate === 1 ? document.getElementById('story-template') : document.getElementById('story-template-2');
            const wrapper = document.getElementById('story-scale-wrapper');
            
            // Temporary hide border radius to prevent white corners in some versions of html2canvas
            const originalBorderRadius = storyEl.style.borderRadius;
            const originalTransform = wrapper.style.transform;
            storyEl.style.borderRadius = '0px';
            wrapper.style.transform = 'scale(1)';

            try {
                const canvas = await html2canvas(storyEl, {
                    scale: 3, // Output will be 324*3=972 x 576*3=1728 (Perfect 9:16 IG Ratio)
                    useCORS: true,
                    backgroundColor: '#0a3143'
                });
                
                storyEl.style.borderRadius = originalBorderRadius;
                wrapper.style.transform = originalTransform;
                
                canvas.toBlob(async (blob) => {
                    const file = new File([blob], `progress-renang-{{ Str::slug($student->nama) }}.png`, { type: 'image/png' });
                    
                    if (navigator.canShare && navigator.canShare({ files: [file] })) {
                        try {
                            await navigator.share({
                                files: [file],
                                title: 'Laporan Sesi Renang',
                                text: 'Lihat progres renangku hari ini!'
                            });
                        } catch (err) {
                            console.error(err);
                            if (err.name !== 'AbortError') {
                                fallbackDownload(canvas);
                            }
                        }
                    } else {
                        // Fallback
                        fallbackDownload(canvas);
                    }

                    text.innerText = originalText;
                    btn.disabled = false;
                }, 'image/png');

            } catch (err) {
                console.error(err);
                text.innerText = originalText;
                btn.disabled = false;
                storyEl.style.borderRadius = originalBorderRadius;
                wrapper.style.transform = originalTransform;
            }
        }

        function fallbackDownload(canvas) {
            const image = canvas.toDataURL("image/png");
            const link = document.createElement('a');
            link.download = `progress-renang-{{ Str::slug($student->nama) }}.png`;
            link.href = image;
            link.click();
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