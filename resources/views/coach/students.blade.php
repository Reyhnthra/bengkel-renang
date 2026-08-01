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
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4 hover:shadow-md transition">
                <div class="flex flex-col lg:flex-row justify-between lg:items-center gap-4">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-[#032B53] text-white font-extrabold rounded-2xl flex items-center justify-center text-sm shadow-sm shrink-0 mt-1">
                            {{ strtoupper(substr($std->nama, 0, 2)) }}
                        </div>
                        <div class="space-y-2">
                            <div class="flex flex-wrap items-center gap-2">
                                <h3 class="font-extrabold text-base text-slate-900">{{ $std->nama }}</h3>
                                <span class="bg-[#E6F0FA] text-blue-700 font-extrabold text-[9px] px-2.5 py-0.5 rounded-full uppercase tracking-wider border border-blue-100">{{ $std->level }}</span>
                                @if(($std->status ?? 'aktif') === 'aktif')
                                    <span class="bg-emerald-50 text-emerald-600 border border-emerald-100 font-extrabold text-[9px] px-2.5 py-0.5 rounded-full uppercase tracking-wider">● Aktif</span>
                                @else
                                    <span class="bg-slate-100 text-slate-500 border border-slate-200 font-extrabold text-[9px] px-2.5 py-0.5 rounded-full uppercase tracking-wider">● Non-Aktif</span>
                                @endif
                            </div>

                            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">
                                ID Tracking: <span class="font-bold text-slate-700">{{ $std->id_tracking }}</span> • Usia: {{ $std->usia }} thn ({{ $std->tanggal_lahir ? \Carbon\Carbon::parse($std->tanggal_lahir)->format('d M Y') : '-' }})
                            </p>

                            <div class="flex flex-wrap gap-x-4 gap-y-1 text-xs text-slate-600 font-medium bg-slate-50 p-2.5 rounded-xl border border-slate-100/80">
                                <span>👤 <strong class="text-slate-700">Wali:</strong> {{ $std->nama_orang_tua }}</span>
                                <span>📞 <strong class="text-slate-700">WA:</strong> {{ $std->no_orang_tua }}</span>
                                <span>📍 <strong class="text-slate-700">Alamat:</strong> {{ $std->alamat }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap items-center justify-between lg:justify-end gap-3 pt-3 lg:pt-0 border-t lg:border-t-0 border-slate-100">
                        <div class="flex space-x-4 mr-2">
                            <div class="text-center">
                                <span class="text-xl font-extrabold text-slate-900 block">{{ $std->sessions->count() }}</span>
                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Sesi</span>
                            </div>

                            <div class="text-center">
                                <span class="text-xl font-extrabold text-teal-600 block">{{ $std->calculateOverallProgress() }}%</span>
                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Progress</span>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2">
                            <!-- Tombol Detail -->
                            <button onclick="openDetailModal({{ $std->id }})" 
                                    class="border border-slate-200 text-slate-700 hover:bg-slate-50 font-bold text-xs px-3.5 py-2.5 rounded-xl shadow-xs transition flex items-center space-x-1 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span>Detail</span>
                            </button>

                            <!-- Tombol Edit -->
                            <button onclick='openEditModal({id: {{ $std->id }}, nama: @json($std->nama), tanggal_lahir: @json($std->tanggal_lahir), level: @json($std->level), nama_orang_tua: @json($std->nama_orang_tua), no_orang_tua: @json($std->no_orang_tua), alamat: @json($std->alamat), status: @json($std->status ?? "aktif")})'
                                    class="bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-200 font-bold text-xs px-3.5 py-2.5 rounded-xl shadow-xs transition flex items-center space-x-1 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                <span>Edit</span>
                            </button>

                            <!-- Tombol Hapus -->
                            <button onclick="openDeleteModal({{ $std->id }}, @json($std->nama))" 
                                    class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 font-bold text-xs px-3.5 py-2.5 rounded-xl shadow-xs transition flex items-center space-x-1 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                <span>Hapus</span>
                            </button>
                        </div>
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
                    <div id="badge-card-bebas" class="bg-white border p-5 rounded-2xl flex flex-col items-center justify-center transition-all opacity-40 grayscale border-slate-100">
                        <div class="badge-icon-box w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-700 mb-2">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" class="h-6 w-6"><path d="M2 16c2-1 4-1 6 0s4 1 6 0 4-1 6 0" /><path d="M15.5 10c-1-2.5-3.5-3.5-5.5-2.5s-2.5 3.5-1 5.5l2.5 3" /><circle cx="15.5" cy="5.5" r="1.5" fill="currentColor"/></svg>
                        </div>
                        <h5 class="font-extrabold text-xs text-slate-800">Gaya Bebas</h5>
                        <span class="text-[10px] font-bold block mt-1 text-slate-400">Belum</span>
                    </div>

                    <div id="badge-card-punggung" class="bg-white border p-5 rounded-2xl flex flex-col items-center justify-center transition-all opacity-40 grayscale border-slate-100">
                        <div class="badge-icon-box w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-700 mb-2">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" class="h-6 w-6"><path d="M2 11c2 1 4 1 6 0s4-1 6 0" /><path d="M8.5 11c0-2.5 1.5-4.5 4-4.5s4 2 4 4.5v1.5" /><circle cx="12.5" cy="4" r="1.5" fill="currentColor"/></svg>
                        </div>
                        <h5 class="font-extrabold text-xs text-slate-800">Gaya Punggung</h5>
                        <span class="text-[10px] font-bold block mt-1 text-slate-400">Belum</span>
                    </div>

                    <div id="badge-card-dada" class="bg-white border p-5 rounded-2xl flex flex-col items-center justify-center transition-all opacity-40 grayscale border-slate-100">
                        <div class="badge-icon-box w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-700 mb-2">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" class="h-6 w-6"><circle cx="12" cy="5" r="1.5" fill="currentColor"/><path d="M4 11c2-2 5-2.5 8-1s6 1 8-1" /><path d="M2 17c3-1 6 1 10 0s7-1 10 0" /></svg>
                        </div>
                        <h5 class="font-extrabold text-xs text-slate-800">Gaya Dada</h5>
                        <span class="text-[10px] font-bold block mt-1 text-slate-400">Belum</span>
                    </div>

                    <div id="badge-card-kupu" class="bg-white border p-5 rounded-2xl flex flex-col items-center justify-center transition-all opacity-40 grayscale border-slate-100">
                        <div class="badge-icon-box w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-700 mb-2">
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

<!-- ==================== BOX DIALOG MODAL EDIT DATA SISWA ==================== -->
<div id="editModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-[32px] w-full max-w-lg shadow-2xl overflow-hidden p-6 sm:p-8 relative border border-slate-100">
        
        <button onclick="closeEditModal()" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 font-bold text-sm cursor-pointer focus:outline-none">✕</button>
        
        <h2 class="text-xl font-extrabold text-[#032B53] mb-6 flex items-center space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            <span>Edit Data Siswa</span>
        </h2>
        
        <form id="editForm" method="POST" class="space-y-4 text-xs font-bold text-slate-500 uppercase tracking-wider">
            @csrf
            @method('PUT')
            
            <div class="space-y-1.5">
                <label>Nama Lengkap Siswa</label>
                <input type="text" id="edit_nama" name="nama" class="w-full bg-[#E6F0FA] text-slate-800 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-blue-500 uppercase font-bold" required>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label>Tanggal Lahir</label>
                    <input type="date" id="edit_tanggal_lahir" name="tanggal_lahir" class="w-full bg-[#E6F0FA] text-slate-800 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-blue-500 font-bold cursor-pointer" required>
                </div>
                <div class="space-y-1.5">
                    <label>Level</label>
                    <select id="edit_level" name="level" class="w-full bg-[#E6F0FA] text-slate-800 rounded-xl px-4 py-3.5 focus:outline-none font-bold cursor-pointer">
                        <option value="Toddler Splash">Toddler Splash</option>
                        <option value="Junior Swimmer">Junior Swimmer</option>
                        <option value="Competitive Edge">Competitive Edge</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label>Status Siswa</label>
                    <select id="edit_status" name="status" class="w-full bg-[#E6F0FA] text-slate-800 rounded-xl px-4 py-3.5 focus:outline-none font-bold cursor-pointer">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Non-Aktif</option>
                    </select>
                </div>
                <div class="space-y-1.5">
                    <label>Nomor WhatsApp</label>
                    <input type="text" id="edit_no_orang_tua" name="no_orang_tua" class="w-full bg-[#E6F0FA] text-slate-800 rounded-xl px-4 py-3.5 focus:outline-none font-bold" required>
                </div>
            </div>

            <div class="border-t border-dashed border-slate-200 my-4 pt-4 text-center text-slate-400 tracking-normal normal-case font-semibold text-xs">Data Orang Tua & Alamat</div>
            
            <div class="space-y-1.5">
                <label>Nama Orang Tua / Wali</label>
                <input type="text" id="edit_nama_orang_tua" name="nama_orang_tua" class="w-full bg-[#E6F0FA] text-slate-800 rounded-xl px-4 py-3.5 focus:outline-none font-bold" required>
            </div>
            
            <div class="space-y-1.5">
                <label>Alamat</label>
                <input type="text" id="edit_alamat" name="alamat" class="w-full bg-[#E6F0FA] text-slate-800 rounded-xl px-4 py-3.5 focus:outline-none font-bold" required>
            </div>
            
            <div class="flex space-x-3 mt-6">
                <button type="button" onclick="closeEditModal()" class="w-1/3 bg-slate-100 text-slate-600 font-bold py-3.5 rounded-xl text-xs uppercase tracking-wider hover:bg-slate-200 transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="w-2/3 bg-amber-500 text-white font-bold py-3.5 rounded-xl text-xs uppercase tracking-wider shadow-md hover:bg-amber-600 transition cursor-pointer">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ==================== BOX DIALOG MODAL HAPUS SISWA ==================== -->
<div id="deleteModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-[32px] w-full max-w-md shadow-2xl overflow-hidden p-6 sm:p-8 relative border border-slate-100 text-center space-y-4">
        <button onclick="closeDeleteModal()" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 font-bold text-sm cursor-pointer focus:outline-none">✕</button>
        
        <div class="w-14 h-14 bg-red-100 text-red-600 rounded-2xl flex items-center justify-center mx-auto text-xl shadow-sm">
            🗑️
        </div>
        
        <div>
            <h3 class="text-lg font-extrabold text-slate-900">Hapus Data Siswa?</h3>
            <p class="text-xs text-slate-500 font-medium mt-1 leading-relaxed">
                Apakah Anda yakin ingin menghapus data <strong id="delete_student_name" class="text-slate-800"></strong>? Seluruh riwayat absensi dan perkembangan latihan siswa akan terhapus secara permanen.
            </p>
        </div>

        <form id="deleteForm" method="POST" class="pt-2">
            @csrf
            @method('DELETE')
            <div class="flex space-x-3">
                <button type="button" onclick="closeDeleteModal()" class="w-1/2 bg-slate-100 text-slate-600 font-bold py-3.5 rounded-xl text-xs uppercase tracking-wider hover:bg-slate-200 transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="w-1/2 bg-red-600 text-white font-bold py-3.5 rounded-xl text-xs uppercase tracking-wider shadow-md hover:bg-red-700 transition cursor-pointer">
                    Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ==================== BOX DIALOG MODAL EDIT SESI ==================== -->
<div id="editSessionModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-[32px] w-full max-w-lg shadow-2xl overflow-y-auto max-h-[90vh] p-6 sm:p-8 border border-slate-100 relative">
        <button onclick="closeEditSessionModal()" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 font-bold text-sm cursor-pointer focus:outline-none">✕</button>
        
        <div class="flex items-center space-x-3 mb-6">
            <div class="w-12 h-12 bg-amber-500 text-white font-extrabold rounded-2xl flex items-center justify-center text-lg shadow-sm">
                ✏️
            </div>
            <div>
                <h3 class="font-extrabold text-base text-slate-900">Edit Riwayat Sesi</h3>
                <span class="text-[10px] text-amber-600 font-bold uppercase tracking-wider block" id="edit_session_title">Pertemuan #1</span>
            </div>
        </div>

        <form id="editSessionForm" method="POST" class="space-y-5 text-xs font-bold text-slate-500 uppercase tracking-wider">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-3">
                <button type="button" id="btn-edit-hadir" onclick="setEditStatus('hadir')" 
                    class="py-3 rounded-xl border-2 text-center transition font-black bg-[#032B53] border-[#032B53] text-white shadow-sm cursor-pointer">
                    ✓ Hadir
                </button>
                <button type="button" id="btn-edit-tidak-hadir" onclick="setEditStatus('tidak hadir')" 
                    class="py-3 rounded-xl border-2 text-center transition font-black border-slate-200 text-slate-400 hover:bg-slate-50 cursor-pointer">
                    ✕ Tidak Hadir
                </button>
            </div>
            <input type="hidden" name="attendance_status" id="edit_attendance_status" value="hadir">

            <div class="space-y-1.5">
                <label class="text-slate-600 font-extrabold">Tanggal Sesi</label>
                <input type="date" name="tanggal" id="edit_sess_tanggal" class="w-full bg-[#E6F0FA] text-slate-800 rounded-xl px-4 py-3.5 focus:outline-none font-bold" required>
            </div>

            <div id="edit-form-scoring-section" class="space-y-5">
                <div class="space-y-1.5">
                    <label class="text-slate-600 font-extrabold">Topik Sesi</label>
                    <input type="text" name="topik_sesi" id="edit_sess_topik" placeholder="Contoh: Latihan gaya bebas, kick dasar..." class="w-full bg-[#E6F0FA] text-slate-800 rounded-xl px-4 py-3.5 focus:outline-none font-bold">
                </div>

                <div class="space-y-1.5 bg-slate-50/80 p-4 rounded-2xl border border-slate-100">
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-slate-600 font-extrabold">Nilai Sesi Keseluruhan</label>
                        <span class="bg-amber-100 text-amber-800 px-2.5 py-1 rounded-md text-xs font-black"><span id="val-display-edit-sesi">0</span> /100</span>
                    </div>
                    <input type="range" name="nilai_sesi" id="edit_sess_nilai" min="0" max="100" value="0" oninput="updateEditVal('sesi', this.value)" class="w-full accent-teal-500 cursor-grab active:cursor-grabbing">
                    <div class="flex justify-between text-[9px] text-slate-400 font-bold pt-1"><span>Perlu Latihan</span><span>Cukup</span><span>Sangat Baik</span></div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-slate-600 font-extrabold">Catatan Pelatih</label>
                    <textarea name="catatan" id="edit_sess_catatan" rows="3" placeholder="Tulis perkembangan, saran, atau pujian..." class="w-full bg-[#E6F0FA] text-slate-800 rounded-xl p-4 focus:outline-none font-bold leading-relaxed"></textarea>
                </div>

                <div class="border-t border-slate-100 pt-4 space-y-4">
                    <span class="text-[10px] text-center block text-slate-400 tracking-widest my-2">PENGUASAAN GAYA RENANG</span>
                    
                    <div class="space-y-1">
                        <div class="flex justify-between items-center text-slate-700 font-extrabold">
                            <span>⚪ Gaya Bebas</span>
                            <span class="text-teal-600" id="val-display-edit-bebas">0%</span>
                        </div>
                        <input type="range" name="gaya_bebas" id="edit_slider_bebas" min="0" max="100" value="0" 
                            oninput="updateEditVal('bebas', this.value)" 
                            class="w-full accent-teal-500 cursor-grab active:cursor-grabbing">
                    </div>

                    <div class="space-y-1">
                        <div class="flex justify-between items-center text-slate-700 font-extrabold">
                            <span>⚪ Gaya Punggung</span>
                            <span class="text-blue-600" id="val-display-edit-punggung">0%</span>
                        </div>
                        <input type="range" name="gaya_punggung" id="edit_slider_punggung" min="0" max="100" value="0" 
                            oninput="updateEditVal('punggung', this.value)" 
                            class="w-full accent-blue-500 cursor-grab active:cursor-grabbing">
                    </div>

                    <div class="space-y-1">
                        <div class="flex justify-between items-center text-slate-700 font-extrabold">
                            <span>⚪ Gaya Dada</span>
                            <span class="text-amber-600" id="val-display-edit-dada">0%</span>
                        </div>
                        <input type="range" name="gaya_dada" id="edit_slider_dada" min="0" max="100" value="0" 
                            oninput="updateEditVal('dada', this.value)" 
                            class="w-full accent-amber-500 cursor-grab active:cursor-grabbing">
                    </div>

                    <div class="space-y-1">
                        <div class="flex justify-between items-center text-slate-700 font-extrabold">
                            <span>⚪ Gaya Kupu</span>
                            <span class="text-pink-600" id="val-display-edit-kupu">0%</span>
                        </div>
                        <input type="range" name="gaya_kupu" id="edit_slider_kupu" min="0" max="100" value="0" 
                            oninput="updateEditVal('kupu', this.value)" 
                            class="w-full accent-pink-500 cursor-grab active:cursor-grabbing">
                    </div>
                </div>
            </div>

            <div class="flex space-x-3 mt-6">
                <button type="button" onclick="closeEditSessionModal()" class="w-1/3 bg-slate-100 text-slate-600 font-bold py-3.5 rounded-xl text-xs uppercase tracking-wider hover:bg-slate-200 transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="w-2/3 bg-amber-500 text-white font-bold py-3.5 rounded-xl text-xs uppercase tracking-wider shadow-md hover:bg-amber-600 transition cursor-pointer">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ==================== BOX DIALOG MODAL HAPUS SESI ==================== -->
<div id="deleteSessionModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-[32px] w-full max-w-md shadow-2xl overflow-hidden p-6 sm:p-8 relative border border-slate-100 text-center space-y-4">
        <button onclick="closeDeleteSessionModal()" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 font-bold text-sm cursor-pointer focus:outline-none">✕</button>
        
        <div class="w-14 h-14 bg-red-100 text-red-600 rounded-2xl flex items-center justify-center mx-auto text-xl shadow-sm">
            🗑️
        </div>
        
        <div>
            <h3 class="text-lg font-extrabold text-slate-900">Hapus Riwayat Sesi?</h3>
            <p class="text-xs text-slate-500 font-medium mt-1 leading-relaxed">
                Apakah Anda yakin ingin menghapus data <strong id="delete_session_info" class="text-slate-800"></strong>? Data nilai dan catatan pada sesi ini akan terhapus secara permanen.
            </p>
        </div>

        <form id="deleteSessionForm" method="POST" class="pt-2">
            @csrf
            @method('DELETE')
            <div class="flex space-x-3">
                <button type="button" onclick="closeDeleteSessionModal()" class="w-1/2 bg-slate-100 text-slate-600 font-bold py-3.5 rounded-xl text-xs uppercase tracking-wider hover:bg-slate-200 transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="w-1/2 bg-red-600 text-white font-bold py-3.5 rounded-xl text-xs uppercase tracking-wider shadow-md hover:bg-red-700 transition cursor-pointer">
                    Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openAddModal() { document.getElementById('addModal').classList.remove('hidden'); }
    function closeAddModal() { document.getElementById('addModal').classList.add('hidden'); }

    function openEditModal(student) {
        document.getElementById('editForm').action = `/coach/students/${student.id}`;
        document.getElementById('edit_nama').value = student.nama || '';
        document.getElementById('edit_tanggal_lahir').value = student.tanggal_lahir || '';
        document.getElementById('edit_level').value = student.level || 'Toddler Splash';
        document.getElementById('edit_status').value = student.status || 'aktif';
        document.getElementById('edit_nama_orang_tua').value = student.nama_orang_tua || '';
        document.getElementById('edit_no_orang_tua').value = student.no_orang_tua || '';
        document.getElementById('edit_alamat').value = student.alamat || '';
        document.getElementById('editModal').classList.remove('hidden');
    }
    function closeEditModal() { document.getElementById('editModal').classList.add('hidden'); }

    function openDeleteModal(id, name) {
        document.getElementById('deleteForm').action = `/coach/students/${id}`;
        document.getElementById('delete_student_name').innerText = name;
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    function closeDeleteModal() { document.getElementById('deleteModal').classList.add('hidden'); }

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
            
            // Update Progress Bar & Tanggal Bergabung
            if (document.getElementById('det-bar-text-progress')) document.getElementById('det-bar-text-progress').innerText = (data.progress ?? 0) + "%";
            if (document.getElementById('det-bar-progress')) document.getElementById('det-bar-progress').style.width = (data.progress ?? 0) + "%";
            if (document.getElementById('modal-tgl-gabung')) document.getElementById('modal-tgl-gabung').innerText = data.tgl_gabung || "-";
            
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
            window.currentStudentSessions = data.sessions || [];
            const riwayatList = document.getElementById('riwayat-list-container');
            riwayatList.innerHTML = '';
            
            if (data.sessions && data.sessions.length > 0) {
                data.sessions.forEach(sess => {
                    const nilai = parseInt(sess.nilai) || 0;
                    const isExcellent = nilai >= 85;
                    const badgeClr = isExcellent ? "text-emerald-600 bg-emerald-50 border-emerald-100" : "text-amber-600 bg-amber-50 border-amber-100";
                    const isHadir = sess.attendance_status === 'hadir';
                    const statusBadgeClr = isHadir ? "text-emerald-600 bg-emerald-50 border-emerald-100" : "text-red-600 bg-red-50 border-red-100";
                    const statusTxt = isHadir ? "Hadir" : "Tidak Hadir";
                    
                    riwayatList.innerHTML += `
                        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm space-y-3 text-left">
                            <div class="flex justify-between items-start">
                                <div>
                                    <div class="flex items-center space-x-2 flex-wrap gap-y-1">
                                        <span class="text-[10px] font-bold text-slate-400 uppercase">PERTEMUAN #${sess.meeting_number || '1'}</span>
                                        <span class="text-[10px] font-extrabold text-slate-400">• ${sess.tanggal || ''}</span>
                                        <span class="px-2 py-0.5 rounded-full text-[9px] font-bold ${statusBadgeClr} border">${statusTxt}</span>
                                    </div>
                                    <h4 class="font-extrabold text-sm text-[#032B53] mt-1">${sess.topik || 'Latihan'}</h4>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="px-3 py-1 rounded-full text-xs font-black ${badgeClr} border">${nilai}/100</div>
                                    <div class="flex items-center space-x-1">
                                        <button type="button" onclick="openEditSessionModal(${sess.id})" class="p-1.5 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition cursor-pointer" title="Edit Sesi">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </button>
                                        <button type="button" onclick="openDeleteSessionModal(${sess.id}, '${sess.meeting_number}', '${sess.tanggal}')" class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition cursor-pointer" title="Hapus Sesi">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
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
                const isUnlocked = badges[key] >= 100; 
                const el = document.getElementById('badge-card-' + key); 

                if (el) {
                    const iconBox = el.querySelector('.badge-icon-box');
                    const textSpan = el.querySelector('span');
                    if (isUnlocked) {
                        earned++;
                        el.className = 'bg-white border p-5 rounded-2xl flex flex-col items-center justify-center transition-all border-teal-200 shadow-sm bg-teal-50/50';
                        if (iconBox) iconBox.className = 'badge-icon-box w-12 h-12 bg-white shadow-xs rounded-2xl flex items-center justify-center text-slate-700 mb-2';
                        if (textSpan) {
                            textSpan.innerText = '✓ Diraih';
                            textSpan.className = 'text-[10px] font-bold block mt-1 text-teal-600';
                        }
                    } else {
                        el.className = 'bg-white border p-5 rounded-2xl flex flex-col items-center justify-center transition-all opacity-40 grayscale border-slate-100';
                        if (iconBox) iconBox.className = 'badge-icon-box w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-700 mb-2';
                        if (textSpan) {
                            textSpan.innerText = 'Belum';
                            textSpan.className = 'text-[10px] font-bold block mt-1 text-slate-400';
                        }
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

    // Logika Modal Edit Sesi
    function openEditSessionModal(sessionId) {
        const sess = (window.currentStudentSessions || []).find(s => s.id === sessionId);
        if (!sess) return;

        document.getElementById('editSessionForm').action = `/coach/sessions/${sess.id}`;
        document.getElementById('edit_session_title').innerText = `Pertemuan #${sess.meeting_number || '1'}`;
        document.getElementById('edit_sess_tanggal').value = sess.tanggal_raw || '';
        document.getElementById('edit_sess_topik').value = (sess.topik === 'Latihan Umum') ? '' : (sess.topik || '');
        document.getElementById('edit_sess_nilai').value = sess.nilai || 0;
        document.getElementById('val-display-edit-sesi').innerText = sess.nilai || 0;
        document.getElementById('edit_sess_catatan').value = (sess.catatan === '-') ? '' : (sess.catatan || '');

        const bebas = sess.gaya_bebas || 0;
        const punggung = sess.gaya_punggung || 0;
        const dada = sess.gaya_dada || 0;
        const kupu = sess.gaya_kupu || 0;

        document.getElementById('edit_slider_bebas').value = bebas;
        document.getElementById('val-display-edit-bebas').innerText = bebas + "%";
        document.getElementById('edit_slider_punggung').value = punggung;
        document.getElementById('val-display-edit-punggung').innerText = punggung + "%";
        document.getElementById('edit_slider_dada').value = dada;
        document.getElementById('val-display-edit-dada').innerText = dada + "%";
        document.getElementById('edit_slider_kupu').value = kupu;
        document.getElementById('val-display-edit-kupu').innerText = kupu + "%";

        setEditStatus(sess.attendance_status || 'hadir');

        document.getElementById('editSessionModal').classList.remove('hidden');
    }

    function closeEditSessionModal() {
        document.getElementById('editSessionModal').classList.add('hidden');
    }

    function setEditStatus(status) {
        document.getElementById('edit_attendance_status').value = status;
        const btnHadir = document.getElementById('btn-edit-hadir');
        const btnAbsen = document.getElementById('btn-edit-tidak-hadir');
        const scoringSection = document.getElementById('edit-form-scoring-section');

        if (status === 'hadir') {
            btnHadir.className = "py-3 rounded-xl border-2 text-center font-black bg-[#032B53] border-[#032B53] text-white shadow-sm cursor-pointer";
            btnAbsen.className = "py-3 rounded-xl border-2 text-center font-black border-slate-200 text-slate-400 hover:bg-slate-50 cursor-pointer";
            scoringSection.classList.remove('hidden');
        } else {
            btnAbsen.className = "py-3 rounded-xl border-2 text-center font-black bg-red-500 border-red-500 text-white shadow-sm cursor-pointer";
            btnHadir.className = "py-3 rounded-xl border-2 text-center font-black border-slate-200 text-slate-400 hover:bg-slate-50 cursor-pointer";
            scoringSection.classList.add('hidden');
        }
    }

    function updateEditVal(type, val) {
        const el = document.getElementById(`val-display-edit-${type}`);
        if (el) {
            el.innerText = val + (type === 'sesi' ? '' : '%');
        }
    }

    // Logika Modal Hapus Sesi
    function openDeleteSessionModal(sessionId, meetingNumber, dateStr) {
        document.getElementById('deleteSessionForm').action = `/coach/sessions/${sessionId}`;
        document.getElementById('delete_session_info').innerText = `Pertemuan #${meetingNumber} (${dateStr})`;
        document.getElementById('deleteSessionModal').classList.remove('hidden');
    }

    function closeDeleteSessionModal() {
        document.getElementById('deleteSessionModal').classList.add('hidden');
    }
</script>
@endsection