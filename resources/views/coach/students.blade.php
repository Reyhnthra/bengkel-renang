@extends('layouts.coach')
@section('title', 'Daftar Siswa')

@section('content')
<div class="space-y-6">
    <!-- Bagian Atas Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-extrabold text-[#032B53] tracking-tight">Daftar Siswa</h1>
            <p class="text-slate-500 text-xs font-semibold mt-1">{{ $students->count() }} siswa terdaftar</p>
        </div>
        
        <button onclick="openAddModal()" class="bg-[#00A79D] hover:bg-[#008f86] text-white font-bold text-xs uppercase tracking-wider px-5 py-3 rounded-xl shadow-md transition flex items-center space-x-2 cursor-pointer !cursor-pointer focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
            <span>Tambah Siswa</span>
        </button>
    </div>

    <!-- Filter Pencarian & Level -->
    <div class="flex space-x-3 w-full">
        <form action="{{ route('coach.students') }}" method="GET" class="w-full flex space-x-3">
            <!-- UPGRADE: Bar Pencarian Menggunakan SVG Outline Premium & Padding pl-11 Khas Aplikasi Pro -->
            <div class="relative flex-1 flex items-center">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau ID siswa..." class="w-full bg-white border border-slate-200 pl-11 pr-4 py-3 rounded-xl text-xs font-semibold shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <select name="level" 
                    onchange="this.form.submit()" 
                    class="bg-white border border-slate-200 px-4 py-3 rounded-xl text-xs font-bold text-slate-700 shadow-sm min-w-[150px] cursor-pointer !cursor-pointer focus:outline-none">
                
                <option value="">Semua Level</option>
                <option value="Toddler Splash" {{ request('level') == 'Toddler Splash' ? 'selected' : '' }}>Toddler Splash</option>
                <option value="Junior Swimmer" {{ request('level') == 'Junior Swimmer' ? 'selected' : '' }}>Junior Swimmer</option>
                <option value="Competitive Edge" {{ request('level') == 'Competitive Edge' ? 'selected' : '' }}>Competitive Edge</option>
            </select>
        </form>
    </div>

    <!-- Daftar List Box Kartu Siswa -->
    <div class="space-y-4">
        @foreach($students as $std)
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
                <div class="flex justify-between items-start">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-[#032B53] text-white font-extrabold rounded-2xl flex items-center justify-center text-sm shadow-sm">
                            {{ strtoupper(substr($std->nama, 0, 2)) }}
                        </div>
                        <div>
                            <div class="flex items-center space-x-2">
                                <h3 class="font-extrabold text-base text-slate-900">{{ $std->nama }}</h3>
                                <span class="bg-[#E6F0FA] text-blue-700 font-extrabold text-[9px] px-2.5 py-0.5 rounded-full uppercase tracking-wider border border-blue-100">{{ $std->level }}</span>
                            </div>
                            <p class="text-[11px] font-semibold text-slate-400 mt-1 uppercase tracking-wide">ID: {{ $std->id_tracking }} • {{ $std->usia }} thn</p>
                            <span class="text-[11px] font-bold text-slate-500 block mt-1">📞 {{ $std->nama_orang_tua }} · {{ $std->no_orang_tua }}</span>
                        </div>
                    </div>
                    
                    <div class="text-right flex items-center space-x-4">
                        <div class="text-center">
                            <span class="text-xl font-extrabold text-slate-900 block">{{ $std->sessions->count() }}</span>
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Sesi</span>
                        </div>

                        <div class="text-center">
                            <span class="text-xl font-extrabold text-teal-600 block">{{ $std->calculateOverallProgress() }}%</span>
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Progress</span>
                        </div>

                        <button onclick="openDetailModal({{ $std->id }})" 
                                class="border border-slate-200 text-slate-700 hover:bg-slate-50 font-bold text-xs px-4 py-2.5 rounded-xl shadow-sm transition flex items-center space-x-1.5 group cursor-pointer ml-4">
                            <span>Detail</span>
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
</div>
    <!-- Pagination -->
</div>

<!-- ==================== POP-UP MODAL DETAIL PROFILE ANAK ==================== -->
<div id="detailModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="w-full max-w-xl bg-white rounded-[32px] shadow-2xl overflow-y-auto max-h-[90vh] border border-slate-100 relative modal-scroll flex flex-col text-left animate-fade-in">
        
        <div class="bg-[#032B53] text-white p-6 rounded-t-[32px] relative shrink-0">
            <button onclick="closeDetailModal()" class="absolute top-6 right-6 w-8 h-8 flex items-center justify-center bg-white/10 hover:bg-white/20 text-white rounded-full text-sm font-bold transition cursor-pointer">✕</button>
            
            <div class="flex items-center space-x-4 mt-2">
                <div id="det-avatar" class="w-14 h-14 bg-amber-400 text-[#032B53] font-black rounded-2xl flex items-center justify-center text-base shadow-md shrink-0">
                    -
                </div>
                <div>
                    <span id="det-tracking" class="text-[10px] uppercase tracking-widest text-slate-300 font-bold block">ID: -</span>
                    <h2 id="det-nama" class="text-xl font-extrabold tracking-tight">-</h2>
                    <div class="flex items-center space-x-2 mt-1">
                        <span id="det-level" class="bg-white/20 text-white text-[9px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider">-</span>
                        <span id="det-usia" class="text-xs text-slate-300 font-medium">• - tahun</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-3 mt-6 text-center">
                <div class="bg-white/10 p-2.5 rounded-xl flex flex-col items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-400 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="text-[9px] text-slate-300 font-bold uppercase tracking-wide">Total Sesi</span>
                    <span id="det-card-sesi" class="text-base font-black mt-0.5">0</span>
                </div>
                <div class="bg-white/10 p-2.5 rounded-xl flex flex-col items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-400 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.966 7.966 0 01-2.343 5.657z" />
                    </svg>
                    <span class="text-[9px] text-slate-300 font-bold uppercase tracking-wide">Streak</span>
                    <span id="det-card-streak" class="text-base font-black mt-0.5">0x</span>
                </div>
                <div class="bg-white/10 p-2.5 rounded-xl flex flex-col items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-400 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    <span class="text-[9px] text-slate-300 font-bold uppercase tracking-wide">Progress</span>
                    <span id="det-card-progress" class="text-base font-black mt-0.5 text-teal-300">0%</span>
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
                        <span id="det-bar-text-progress" class="text-[#032B53]">0%</span>
                    </div>
                    <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                        <div id="det-bar-progress" class="bg-teal-500 h-full rounded-full transition-all duration-500" style="width: 0%"></div>
                    </div>
                    <div class="text-[10px] font-bold text-slate-400 pt-0.5 text-right">
                        <span class="text-xs text-slate-500">
                        Bergabung: <span id="modal-tgl-gabung">-</span>
                    </span>
                    </div>
                </div>

                <div class="space-y-4">
                    <h4 class="text-xs font-black text-slate-800 uppercase tracking-wider">Kemampuan Per Gaya</h4>
                    
                    <div class="space-y-1.5">
                        <div class="flex justify-between text-xs font-extrabold text-slate-700 items-center">
                            <div class="flex items-center space-x-2.5">
                                <svg width="18" height="18" viewBox="0 0 36 36" class="transform -rotate-90 shrink-0"><circle cx="18" cy="18" r="16" fill="transparent" stroke="#E2E8F0" stroke-width="4.5"/><circle cx="18" cy="18" r="16" fill="transparent" stroke="#00A79D" stroke-width="4.5" id="ring-svg-bebas"/></svg>
                                <span>Gaya Bebas</span>
                            </div>
                            <span id="txt-bebas" class="text-teal-600">0%</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden"><div id="bar-bebas" class="bg-teal-500 h-full rounded-full" style="width: 0%"></div></div>
                    </div>

                    <div class="space-y-1.5">
                        <div class="flex justify-between text-xs font-extrabold text-slate-700 items-center">
                            <div class="flex items-center space-x-2.5">
                                <svg width="18" height="18" viewBox="0 0 36 36" class="transform -rotate-90 shrink-0"><circle cx="18" cy="18" r="16" fill="transparent" stroke="#E2E8F0" stroke-width="4.5"/><circle cx="18" cy="18" r="16" fill="transparent" stroke="#032B53" stroke-width="4.5" id="ring-svg-punggung"/></svg>
                                <span>Gaya Punggung</span>
                            </div>
                            <span id="txt-punggung" class="text-blue-600">0%</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden"><div id="bar-punggung" class="bg-blue-500 h-full rounded-full" style="width: 0%"></div></div>
                    </div>

                    <div class="space-y-1.5">
                        <div class="flex justify-between text-xs font-extrabold text-slate-700 items-center">
                            <div class="flex items-center space-x-2.5">
                                <svg width="18" height="18" viewBox="0 0 36 36" class="transform -rotate-90 shrink-0"><circle cx="18" cy="18" r="16" fill="transparent" stroke="#E2E8F0" stroke-width="4.5"/><circle cx="18" cy="18" r="16" fill="transparent" stroke="#FDB813" stroke-width="4.5" id="ring-svg-dada"/></svg>
                                <span>Gaya Dada</span>
                            </div>
                            <span id="txt-dada" class="text-amber-500">0%</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden"><div id="bar-dada" class="bg-amber-500 h-full rounded-full" style="width: 0%"></div></div>
                    </div>

                    <div class="space-y-1.5">
                        <div class="flex justify-between text-xs font-extrabold text-slate-700 items-center">
                            <div class="flex items-center space-x-2.5">
                                <svg width="18" height="18" viewBox="0 0 36 36" class="transform -rotate-90 shrink-0"><circle cx="18" cy="18" r="16" fill="transparent" stroke="#E2E8F0" stroke-width="4.5"/><circle cx="18" cy="18" r="16" fill="transparent" stroke="#EC4899" stroke-width="4.5" id="ring-svg-kupu"/></svg>
                                <span>Gaya Kupu-kupu</span>
                            </div>
                            <span id="txt-kupu" class="text-pink-500">0%</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden"><div id="bar-kupu" class="bg-pink-500 h-full rounded-full" style="width: 0%"></div></div>
                    </div>
                </div>

                <div class="bg-teal-50/60 p-4 rounded-2xl border border-teal-100/50 space-y-2">
                    <div class="flex justify-between items-center text-[10px] font-black uppercase text-teal-600 tracking-wider">
                        <span>🕒 Sesi Terakhir</span>
                        <span id="det-last-tgl" class="text-slate-400">-</span>
                    </div>
                    <h4 id="det-last-topik" class="font-extrabold text-xs text-[#032B53]">-</h4>
                    <p id="det-last-catatan" class="text-[11px] font-medium text-slate-500 italic leading-relaxed">"-Belum ada catatan-"</p>
                </div>
                <div class="space-y-3 text-center border-t border-slate-100 pt-5">
                    <h4 class="text-xs font-black text-slate-800 uppercase tracking-wider text-left">Radar Keterampilan</h4>
                    <div class="flex justify-center items-center py-4">
                        <svg width="150" height="140" viewBox="0 0 100 100" class="transform -rotate-90">
                            <circle cx="50" cy="50" r="40" fill="transparent" stroke="#F1F5F9" stroke-width="5"/>
                            <circle id="ring-bebas" cx="50" cy="50" r="40" fill="transparent" stroke="#00A79D" stroke-width="5" stroke-dasharray="251.3" stroke-dashoffset="251.3" stroke-linecap="round"/>
                            <circle cx="50" cy="50" r="32" fill="transparent" stroke="#F1F5F9" stroke-width="5"/>
                            <circle id="ring-punggung" cx="50" cy="50" r="32" fill="transparent" stroke="#032B53" stroke-width="5" stroke-dasharray="201.1" stroke-dashoffset="201.1" stroke-linecap="round"/>
                            <circle cx="50" cy="50" r="24" fill="transparent" stroke="#F1F5F9" stroke-width="5"/>
                            <circle id="ring-dada" cx="50" cy="50" r="24" fill="transparent" stroke="#FDB813" stroke-width="5" stroke-dasharray="150.8" stroke-dashoffset="150.8" stroke-linecap="round"/>
                            <circle cx="50" cy="50" r="16" fill="transparent" stroke="#F1F5F9" stroke-width="5"/>
                            <circle id="ring-kupu" cx="50" cy="50" r="16" fill="transparent" stroke="#EC4899" stroke-width="5" stroke-dasharray="100.5" stroke-dashoffset="100.5" stroke-linecap="round"/>
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
                <div id="riwayat-list-container" class="space-y-4"></div>
            </div>

            <div id="tab-badge-content" class="tab-content hidden space-y-4">
                <p id="badge-earned-count" class="text-xs font-bold text-slate-400 tracking-wide">0 dari 4 badge diraih</p>
                
                <div class="grid grid-cols-2 gap-4 text-center">
                    <div id="badge-card-bebas" class="bg-white border p-5 rounded-2xl flex flex-col items-center justify-center transition-all opacity-35 grayscale border-slate-100">
                        <div class="w-12 h-12 bg-teal-50 rounded-2xl flex items-center justify-center text-teal-600 mb-2">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" class="h-6 w-6"><path d="M2 16c2-1 4-1 6 0s4 1 6 0 4-1 6 0" /><path d="M15.5 10c-1-2.5-3.5-3.5-5.5-2.5s-2.5 3.5-1 5.5l2.5 3" /><circle cx="15.5" cy="5.5" r="1.5" fill="currentColor"/></svg>
                        </div>
                        <h5 class="font-extrabold text-xs text-slate-800">Gaya Bebas</h5>
                        <span class="text-[10px] font-bold block mt-1 text-slate-400">Belum</span>
                    </div>

                    <div id="badge-card-punggung" class="bg-white border p-5 rounded-2xl flex flex-col items-center justify-center transition-all opacity-35 grayscale border-slate-100">
                        <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 mb-2">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" class="h-6 w-6"><path d="M2 11c2 1 4 1 6 0s4-1 6 0" /><path d="M8.5 11c0-2.5 1.5-4.5 4-4.5s4 2 4 4.5v1.5" /><circle cx="12.5" cy="4" r="1.5" fill="currentColor"/></svg>
                        </div>
                        <h5 class="font-extrabold text-xs text-slate-800">Gaya Punggung</h5>
                        <span class="text-[10px] font-bold block mt-1 text-slate-400">Belum</span>
                    </div>

                    <div id="badge-card-dada" class="bg-white border p-5 rounded-2xl flex flex-col items-center justify-center transition-all opacity-35 grayscale border-slate-100">
                        <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-500 mb-2">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" class="h-6 w-6"><circle cx="12" cy="5" r="1.5" fill="currentColor"/><path d="M4 11c2-2 5-2.5 8-1s6 1 8-1" /><path d="M2 17c3-1 6 1 10 0s7-1 10 0" /></svg>
                        </div>
                        <h5 class="font-extrabold text-xs text-slate-800">Gaya Dada</h5>
                        <span class="text-[10px] font-bold block mt-1 text-slate-400">Belum</span>
                    </div>

                    <div id="badge-card-kupu" class="bg-white border p-5 rounded-2xl flex flex-col items-center justify-center transition-all opacity-35 grayscale border-slate-100">
                        <div class="w-12 h-12 bg-pink-50 rounded-2xl flex items-center justify-center text-pink-500 mb-2">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" class="h-6 w-6"><circle cx="12" cy="6" r="1.5" fill="currentColor"/><path d="M3 10c2-3.5 5-2.5 9 .5 4-3 7-4 9-.5" /><path d="M2 17c4-2 6 2 10 0s6-2 10 0" /></svg>
                        </div>
                        <h5 class="font-extrabold text-xs text-slate-800">Gaya Kupu-kupu</h5>
                        <span class="text-[10px] font-bold block mt-1 text-slate-400">Belum</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ==================== BOX DIALOG MODAL TAMBAH SISWA BARU ==================== -->
<div id="addModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-[32px] w-full max-w-lg shadow-2xl overflow-hidden p-6 sm:p-8 relative border border-slate-100">
        
        <button onclick="closeAddModal()" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 font-bold text-sm cursor-pointer focus:outline-none">✕</button>
        
        <h2 class="text-xl font-extrabold text-[#032B53] mb-6 flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#00A79D]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
            <span>Tambah Siswa Baru</span>
        </h2>
        
        <form action="{{ route('coach.students.store') }}" method="POST" class="space-y-4 text-xs font-bold text-slate-500 uppercase tracking-wider">
            @csrf
            <div class="space-y-1.5">
                <label>Nama Lengkap Siswa</label>
                <input type="text" name="nama" placeholder="Contoh: Rizki Andrian" class="w-full bg-[#E6F0FA] text-slate-800 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-blue-500 uppercase font-bold" required>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label>Tanggal Lahir Siswa</label>
                    <input type="date" name="tanggal_lahir" class="w-full bg-[#E6F0FA] text-slate-800 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-blue-500 font-bold cursor-pointer" required>
                </div>
                <div class="space-y-1.5">
                    <label>Level</label>
                    <select name="level" class="w-full bg-[#E6F0FA] text-slate-800 rounded-xl px-4 py-3.5 focus:outline-none font-bold cursor-pointer">
                        <option>Toddler Splash</option>
                        <option>Junior Swimmer</option>
                        <option>Competitive Edge</option>
                    </select>
                </div>
            </div>

            <div class="border-t border-dashed border-slate-200 my-4 pt-4 text-center text-slate-400 tracking-normal normal-case font-semibold text-xs">Data Orang Tua</div>
            
            <div class="space-y-1.5">
                <label>Nama Orang Tua / Wali</label>
                <input type="text" name="nama_orang_tua" placeholder="Contoh: Budi Santoso" class="w-full bg-[#E6F0FA] text-slate-800 rounded-xl px-4 py-3.5 focus:outline-none font-bold" required>
            </div>
            
            <div class="space-y-1.5">
                <label>Nomor WhatsApp</label>
                <input type="text" name="no_orang_tua" placeholder="0812-3456-7890" class="w-full bg-[#E6F0FA] text-slate-800 rounded-xl px-4 py-3.5 focus:outline-none font-bold" required>
            </div>
            
            <div class="space-y-1.5">
                <label>Alamat</label>
                <input type="text" name="alamat" placeholder="Contoh: Jl. Merdeka No. 123" class="w-full bg-[#E6F0FA] text-slate-800 rounded-xl px-4 py-3.5 focus:outline-none font-bold" required>
            </div>
            
            <button type="submit" class="w-full bg-[#00A79D] text-white font-bold py-4 rounded-xl text-xs uppercase tracking-wider shadow-md mt-4 transition hover:bg-[#008f86] cursor-pointer focus:outline-none">
                Tambah Siswa
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openAddModal() { document.getElementById('addModal').classList.remove('hidden'); }
    function closeAddModal() { document.getElementById('addModal').classList.add('hidden'); }

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

    
    async function openDetailModal(studentId) {
        // 1. Tampilkan modal & loading state
        document.getElementById('detailModal').classList.remove('hidden');
        switchTab('ringkasan');

        try {
            // 2. Fetch data terbaru dari server
            // Tambahkan ?t=${new Date().getTime()} di akhir URL
            const response = await fetch(`/coach/student-data/${studentId}?t=${new Date().getTime()}`);
            const data = await response.json();
            console.log("Data yang diterima:", data);

            // 3. Fungsi pembantu untuk mengupdate teks & bar dengan aman
            const updateText = (id, val, prefix = "", suffix = "") => {
                const el = document.getElementById(id);
                if (el) el.innerText = prefix + (val ?? 0) + suffix;
            };

            const updateBar = (id, val) => {
                const el = document.getElementById(id);
                if (el) el.style.width = (val ?? 0) + "%";
            };

            // Update teks
            document.getElementById('det-avatar').innerText = data.avatar_initials || "NA";
            document.getElementById('det-tracking').innerText = "ID: " + (data.id_tracking || "-");
            document.getElementById('det-nama').innerText = data.nama || "Siswa";
            document.getElementById('det-level').innerText = data.level || "-";
            document.getElementById('det-usia').innerText = "• " + (data.usia ?? 0) + " tahun";
            
            // Update Card
            document.getElementById('det-card-sesi').innerText = data.total_sesi ?? 0;
            document.getElementById('det-card-streak').innerText = (data.streak ?? 0) + "x";
            document.getElementById('det-card-progress').innerText = (data.progress ?? 0) + "%";
            
            // Update Progress Bar
            document.getElementById('det-bar-text-progress').innerText = (data.progress ?? 0) + "%";
            document.getElementById('det-bar-progress').style.width = (data.progress ?? 0) + "%";
            
            // Update Gaya (Dengan Safety Guard || 0)
            const bebas = data.gaya_bebas ?? 0;
            const punggung = data.gaya_punggung ?? 0;
            const dada = data.gaya_dada ?? 0;
            const kupu = data.gaya_kupu ?? 0;

            updateText('txt-bebas', bebas, "", "%");
            updateBar('bar-bebas', bebas);
            updateText('txt-punggung', punggung, "", "%");
            updateBar('bar-punggung', punggung);
            updateText('txt-dada', dada, "", "%");
            updateBar('bar-dada', dada);
            updateText('txt-kupu', kupu, "", "%");
            updateBar('bar-kupu', kupu);

            // Sesi Terakhir
            document.getElementById('det-last-tgl').innerText = data.last_tgl || "-";
            document.getElementById('det-last-topik').innerText = data.last_topik || "-";
            document.getElementById('det-last-catatan').innerText = `"${data.last_catatan || "-"}"`;

            // 4. LOGIKA RADAR
            document.getElementById('ring-bebas').style.strokeDashoffset = 251.3 - (bebas * 251.3 / 100);
            document.getElementById('ring-punggung').style.strokeDashoffset = 201.1 - (punggung * 201.1 / 100);
            document.getElementById('ring-dada').style.strokeDashoffset = 150.8 - (dada * 150.8 / 100);
            document.getElementById('ring-kupu').style.strokeDashoffset = 100.5 - (kupu * 100.5 / 100);

            // 5. Render Riwayat Sesi
            const riwayatList = document.getElementById('riwayat-list-container');
            riwayatList.innerHTML = '';
            
            if (data.sessions && data.sessions.length > 0) {
                data.sessions.forEach(sess => {
                    const nilai = parseInt(sess.nilai) || 0;
                    const isExcellent = nilai >= 85;
                    const badgeClr = isExcellent ? "text-emerald-600 bg-emerald-50 border-emerald-100" : "text-amber-600 bg-amber-50 border-amber-100";
                    
                    riwayatList.innerHTML += `
                        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm space-y-3 text-left">
                            <div class="flex justify-between items-start">
                                <div>
                                    <div class="text-[10px] font-bold text-slate-400 uppercase">PERTEMUAN #${sess.meeting_number || '1'}</div>
                                    <h4 class="font-extrabold text-sm text-[#032B53]">${sess.topik || 'Latihan'}</h4>
                                </div>
                                <div class="px-3 py-1 rounded-full text-xs font-black ${badgeClr} border">${nilai}/100</div>
                            </div>
                            <div class="text-xs text-slate-500 italic">"${sess.catatan || '-'}"</div>
                        </div>
                    `;
                });
            } else {
                riwayatList.innerHTML = '<p class="text-center text-slate-400 text-xs">Belum ada riwayat.</p>';
            }
            // 6. LOGIKA BADGE (Update status badge berdasarkan data terbaru)
            const badges = {
                bebas: data.gaya_bebas,
                punggung: data.gaya_punggung,
                dada: data.gaya_dada,
                kupu: data.gaya_kupu
            };

            let earned = 0;
            Object.keys(badges).forEach(key => {
                // Gunakan >= 100 agar aman jika nilainya lebih dari 100
                const isUnlocked = badges[key] >= 100; 
                const el = document.getElementById('badge-card-' + key); 

                if (el) { // Cek apakah elemennya ada
                    if (isUnlocked) {
                        earned++;
                        el.classList.remove('opacity-35', 'grayscale', 'border-slate-100');
                        el.classList.add('border-teal-200', 'shadow-sm', 'bg-teal-50');
                        el.querySelector('span').innerText = '✓ Diraih';
                        el.querySelector('span').classList.replace('text-slate-400', 'text-teal-600');
                    } else {
                        el.classList.add('opacity-35', 'grayscale', 'border-slate-100');
                        el.classList.remove('border-teal-200', 'shadow-sm', 'bg-teal-50');
                        el.querySelector('span').innerText = 'Belum';
                        el.querySelector('span').classList.replace('text-teal-600', 'text-slate-400');
                    }
                }
            });

            // Update counter di atas (pastikan ID-nya sesuai dengan HTML kamu)
            const counterEl = document.getElementById('badge-earned-count');
            if (counterEl) {
                counterEl.innerText = `${earned} dari 4 badge diraih`;
            }

        } catch (err) { 
            console.error("Error fetching student data:", err); 
        }
    }
    
    function closeDetailModal() { document.getElementById('detailModal').classList.add('hidden'); }
</script>
@endsection