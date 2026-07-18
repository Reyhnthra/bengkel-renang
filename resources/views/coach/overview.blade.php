@extends('layouts.coach')
@section('title', 'Overview')

@section('content')
<div class="space-y-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-extrabold text-[#032B53] tracking-tight">Selamat datang, Mr Iqbal!</h1>
            <p class="text-slate-500 text-xs font-semibold mt-1">Ringkasan aktivitas Bengkel Renang.</p>
        </div>
        <span class="text-xs font-bold text-slate-400 uppercase bg-slate-100 px-3 py-1.5 rounded-lg">{{ $totalStudents }} siswa aktif</span>
    </div>

    <!-- 4 Kotak Indikator Utama Beranda (Menggunakan SVG Modern Sesuai Elemen image_653f3f.png) -->
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        <!-- Total Siswa -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-[#E6F0FA] rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div><span class="text-2xl font-extrabold text-slate-900 block">{{ $totalStudents }}</span><span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Total Siswa</span></div>
        </div>

        <!-- Total Sesi -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-teal-50 rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div><span class="text-2xl font-extrabold text-slate-900 block">{{ $totalSessions }}</span><span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Total Sesi</span></div>
        </div>

        <!-- Avg Progress -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-amber-50 rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </div>
            <div><span class="text-2xl font-extrabold text-teal-600 block">{{ $avgProgress }}%</span><span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Avg Progress</span></div>
        </div>

        <!-- Streak Tertinggi -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-pink-50 rounded-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.966 7.966 0 01-2.343 5.657z" />
                </svg>
            </div>
            <div><span class="text-2xl font-extrabold text-slate-900 block">{{ $streakStudents->first()?->total_hadir ?? 0 }}</span><span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Streak Tertinggi</span></div>
        </div>
    </div>

    <!-- Grid Tengah: Grafik Distribusi Level & Daftar Ranking Streak -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-7 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
            <h3 class="font-extrabold text-slate-900 text-sm tracking-tight">Distribusi Level Siswa</h3>
            <div class="flex items-end justify-center space-x-12 h-44 pt-6 border-b border-slate-100">
                @foreach($levelCounts as $lvl => $count)
                    <div class="flex flex-col items-center space-y-2 w-16">
                        <span class="text-xs font-bold text-slate-600">{{ $count }}</span>
                        <div class="bg-teal-500 w-full rounded-t-lg transition-all" style="height: {{ $count * 40 }}px"></div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider pt-1 text-center leading-tight">{{ $lvl }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="lg:col-span-5 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
            <h3 class="font-extrabold text-slate-900 text-sm tracking-tight">Streak Tertinggi 🔥</h3>
            <div class="space-y-3">
                @foreach($streakStudents as $index => $std)
                    <div class="flex items-center justify-between p-3 bg-slate-50/60 rounded-2xl border border-slate-100">
                        <div class="flex items-center space-x-3">
                            <span class="w-6 h-6 bg-amber-400 text-[#032B53] font-black rounded-full flex items-center justify-center text-xs shadow-inner">{{ $index + 1 }}</span>
                            <div class="w-10 h-10 bg-[#032B53] text-white font-bold text-xs rounded-xl flex items-center justify-center uppercase shadow-sm">
                                {{ substr($std->nama, 0, 2) }}
                            </div>
                            <div>
                                <h4 class="font-extrabold text-xs text-slate-800">{{ $std->nama }}</h4>
                                <span class="text-[9px] text-slate-400 block font-bold uppercase tracking-wider mt-0.5">{{ $std->level }}</span>
                            </div>
                        </div>
                        <span class="text-xs font-bold text-amber-600">🔥 {{ $std->total_hadir }}x</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- ==================== BOX KARTU LIST SESI TERBARU (SINKRON DATABASE) ==================== -->
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
        <h3 class="font-extrabold text-base text-slate-900">Sesi Terbaru</h3>
        
        <div class="divide-y divide-slate-100">
            @forelse($latestSessions as $sess)
                @php
                    // Logika pewarnaan titik bulat & badge skor (Hijau jika >= 85, Kuning jika di bawahnya)
                    $isExcellent = $sess->nilai_sesi >= 85;
                    $dotColor = $isExcellent ? 'bg-emerald-500' : 'bg-amber-500';
                    $badgeColor = $isExcellent ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600';
                @endphp
                
                <div class="flex justify-between items-center py-3.5 first:pt-0 last:pb-0">
                    <div class="flex items-center space-x-3">
                        <!-- Indikator Dot Bulat Sesuai Desain Figma -->
                        <span class="w-2.5 h-2.5 rounded-full {{ $dotColor }}"></span>
                        <div>
                            <div class="flex items-center space-x-2">
                                <h4 class="font-extrabold text-sm text-slate-900">{{ $sess->student->nama ?? 'Siswa Terhapus' }}</h4>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wide">{{ $sess->student->id_tracking ?? '-' }}</span>
                            </div>
                            <p class="text-xs text-slate-500 font-medium mt-0.5">{{ $sess->topik_sesi ?? 'Latihan Umum' }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4 text-right">
                        <span class="text-xs font-bold text-slate-400">{{ \Carbon\Carbon::parse($sess->tanggal)->translatedFormat('d M Y') }}</span>
                        <span class="px-2.5 py-1 rounded-md text-xs font-black {{ $badgeColor }}">
                            {{ $sess->nilai_sesi }}
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-center text-slate-400 text-xs py-8 font-semibold">Belum ada riwayat catatan sesi latihan di database.</p>
            @endforelse
        </div>
    </div>

</div>
@endsection