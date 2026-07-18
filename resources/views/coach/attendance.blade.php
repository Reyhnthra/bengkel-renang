@extends('layouts.coach')
@section('title', 'Absensi & Penilaian')

@section('content')
<!-- Kotak Alert Pengecek Eror Masukan Form -->
@if ($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl text-xs mb-4">
        <p class="font-bold uppercase tracking-wider mb-1">❌ Gagal Menyimpan Jurnal Latihan:</p>
        <ul class="list-disc pl-4 space-y-0.5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif



<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-extrabold text-[#032B53] tracking-tight">Absensi & Penilaian</h1>
        <p class="text-slate-500 text-xs font-semibold mt-1">Pilih siswa untuk mencatat kehadiran dan nilai performa sesinya</p>
    </div>

    <!-- ─── SEKARANG ADA BAR PENCARIAN SISWA (MENGGUNAKAN SVG OUTLINE) ─── -->
    <div class="flex space-x-3">
        <form action="{{ route('coach.attendance') }}" method="GET" class="w-full relative flex items-center">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <!-- Premium Search SVG Icon (Bukan Emoji) -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau ID siswa aktif..." class="w-full bg-white border border-slate-200 pl-11 pr-4 py-3 rounded-xl text-xs font-semibold shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </form>
    </div>

    <!-- Daftar List Box Kartu Siswa -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse($students as $std)
            @php
                $latestAttendanceSession = $std->sessions->where('attendance_status', 'hadir')->sortByDesc('tanggal')->first();
                $lastReport = $latestAttendanceSession ? $latestAttendanceSession->progressReport : null;
                
                $lastBebas = $lastReport ? $lastReport->gaya_bebas : 0;
                $lastPunggung = $lastReport ? $lastReport->gaya_punggung : 0;
                $lastDada = $lastReport ? $lastReport->gaya_dada : 0;
                $lastKupu = $lastReport ? $lastReport->gaya_kupu : 0;

                $lastSess = $std->sessions->sortByDesc('tanggal')->first();
            @endphp
            <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-[#032B53] text-white font-extrabold rounded-2xl flex items-center justify-center text-sm shadow-sm">{{ substr($std->nama,0,2) }}</div>
                    <div>
                        <div class="flex items-center space-x-2">
                            <h4 class="font-extrabold text-sm text-slate-900">{{ $std->nama }}</h4>
                            <span class="bg-[#E6F0FA] text-blue-700 font-extrabold text-[8px] px-2 py-0.5 rounded uppercase tracking-wider border border-blue-500">{{ $std->level }}</span>
                        </div>
                        <span class="text-[10px] text-slate-400 block font-semibold mt-0.5">Sesi Terakhir: {{ $lastSess ? \Carbon\Carbon::parse($lastSess->tanggal)->translatedFormat('d M Y') : 'Belum ada' }}</span>
                    </div>
                </div>
                
                <!-- UPGRADE: Tombol Absen Menggunakan SVG Note/Pencil Edit Outline Premium -->
                <button onclick="openEvaluationModal({{ $std->id }})" 
                        class="p-2 bg-slate-100 rounded-xl hover:bg-teal-50 transition-all !cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                </button>
            </div>
        @empty
            <div class="col-span-full bg-white p-12 rounded-3xl border border-dashed border-slate-200 text-center">
                <p class="text-slate-400 font-semibold text-xs">Siswa yang Anda cari tidak ditemukan atau tidak terdaftar.</p>
            </div>
        @endforelse
    </div>
</div>

<!-- ==================== POP-UP FORM INPUT NILAI HARIAN ==================== -->
<div id="evalModal" class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-[32px] w-full max-w-lg shadow-2xl overflow-y-auto max-h-[90vh] p-6 sm:p-8 border border-slate-100 relative">
        <button onclick="closeEvaluationModal()" class="absolute top-6 right-6 text-slate-400 hover:text-slate-600 font-bold text-sm !cursor-pointer">✕</button>
        
        <div class="flex items-center space-x-3 mb-6">
            <div class="w-12 h-12 bg-[#032B53] text-white font-extrabold rounded-2xl flex items-center justify-center text-sm" id="modal-avatar">AP</div>
            <div>
                <h3 class="font-extrabold text-base text-slate-900" id="modal-student-name">Arif Pratama</h3>
                <span class="text-[10px] text-slate-400 block font-bold uppercase tracking-wider" id="modal-student-level">Perenang Muda</span>
            </div>
        </div>

        <form action="{{ route('coach.attendance.store') }}" method="POST" class="space-y-5 text-xs font-bold text-slate-500 uppercase tracking-wider">
            @csrf
            <input type="hidden" name="id_siswa" id="modal-student-id">

            <div class="grid grid-cols-2 gap-3">
                <button type="button" id="btn-hadir" onclick="setStatus('hadir')" 
                    class="py-3 rounded-xl border-2 text-center transition font-black bg-[#032B53] border-[#032B53] text-white shadow-sm !cursor-pointer">
                    ✓ Hadir
                </button>
                <button type="button" id="btn-tidak-hadir" onclick="setStatus('tidak hadir')" class="py-3 rounded-xl border-2 text-center transition font-black border-slate-200 text-slate-400 hover:bg-slate-50 !cursor-pointer">✕ Tidak Hadir</button>
            </div>
            <input type="hidden" name="attendance_status" id="attendance_status" value="hadir">

            <div class="space-y-1.5">
                <label>Tanggal Sesi</label>
                <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full bg-[#E6F0FA] text-slate-800 rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-blue-500 font-bold" required>
            </div>

            <div id="form-scoring-section" class="space-y-5">
                <div class="space-y-1.5">
                    <label>Topik Sesi</label>
                    <input type="text" name="topik_sesi" placeholder="Contoh: Latihan gaya bebas, kick dasar..." class="w-full bg-[#E6F0FA] text-slate-800 rounded-xl px-4 py-3.5 focus:outline-none font-bold">
                </div>

                <div class="space-y-1.5 bg-slate-50/80 p-4 rounded-2xl border border-slate-100">
                    <div class="flex justify-between items-center mb-2">
                        <label>Nilai Sesi Keseluruhan</label>
                        <span class="bg-amber-100 text-amber-800 px-2.5 py-1 rounded-md text-xs font-black"><span id="val-display-sesi">0</span> /100</span>
                    </div>
                    <input type="range" name="nilai_sesi" min="0" max="100" value="0" oninput="updateVal('sesi', this.value)" class="w-full accent-teal-500 cursor-grab active:cursor-grabbing">
                    <div class="flex justify-between text-[9px] text-slate-400 font-bold pt-1"><span>Perlu Latihan</span><span>Cukup</span><span>Sangat Baik</span></div>
                </div>

                <div class="space-y-1.5">
                    <label>Catatan Pelatih</label>
                    <textarea name="catatan" rows="3" placeholder="Tulis perkembangan, saran, atau pujian yang akan dilihat orang tua..." class="w-full bg-[#E6F0FA] text-slate-800 rounded-xl p-4 focus:outline-none font-bold leading-relaxed"></textarea>
                </div>

                    <div class="border-t border-slate-100 pt-4 space-y-4">
                        <span class="text-[10px] text-center block text-slate-400 tracking-widest my-2 ">PENGUASAAN GAYA RENANG</span>
                        
                        <div class="space-y-1">
                            <div class="flex justify-between items-center text-slate-700 font-extrabold">
                                <span>⚪ Gaya Bebas</span>
                                <div class="flex items-center space-x-1.5">
                                    <span id="badge-diff-g1" class="text-[9px] font-black px-2 py-0.5 rounded-full hidden"></span>
                                    <span class="text-teal-600" id="val-display-g1">0%</span>
                                </div>
                            </div>
                            <input type="range" name="gaya_bebas" id="slider-bebas" min="0" max="100" value="0" 
                                oninput="calculateDiff('g1', this.value)" 
                                class="w-full accent-teal-500 cursor-grab active:cursor-grabbing">
                        </div>

                    <div class="space-y-1">
                        <div class="flex justify-between items-center text-slate-700 font-extrabold">
                            <span>⚪ Gaya Punggung</span>
                            <div class="flex items-center space-x-1.5">
                                <span id="badge-diff-g2" class="text-[9px] font-black px-2 py-0.5 rounded-full hidden"></span>
                                <span class="text-blue-600" id="val-display-g2">0%</span>
                            </div>
                        </div>
                        <input type="range" name="gaya_punggung" id="slider-punggung" min="0" max="100" value="0" 
                            oninput="calculateDiff('g2', this.value)" 
                            class="w-full accent-blue-500 cursor-grab active:cursor-grabbing">
                    </div>

                    <div class="space-y-1">
                        <div class="flex justify-between items-center text-slate-700 font-extrabold">
                            <span>⚪ Gaya Dada</span>
                            <div class="flex items-center space-x-1.5">
                                <span id="badge-diff-g3" class="text-[9px] font-black px-2 py-0.5 rounded-full hidden"></span>
                                <span class="text-amber-600" id="val-display-g3">0%</span>
                            </div>
                        </div>
                        <input type="range" name="gaya_dada" id="slider-dada" min="0" max="100" value="0" 
                            oninput="calculateDiff('g3', this.value)" 
                            class="w-full accent-amber-500 cursor-grab active:cursor-grabbing">
                    </div>

                    <div class="space-y-1">
                        <div class="flex justify-between items-center text-slate-700 font-extrabold">
                            <span>⚪ Gaya Kupu</span>
                            <div class="flex items-center space-x-1.5">
                                <span id="badge-diff-g4" class="text-[9px] font-black px-2 py-0.5 rounded-full hidden "></span>
                                <span class="text-pink-600" id="val-display-g4">0%</span>
                            </div>
                        </div>
                        <input type="range" name="gaya_kupu" id="slider-kupu" min="0" max="100" value="0" 
                            oninput="calculateDiff('g4', this.value)" 
                            class="w-full accent-pink-500 cursor-grab active:cursor-grabbing">
                    </div>
                </div>

            <button type="submit" class="w-full bg-[#032B53] text-white font-bold py-4 rounded-xl text-xs uppercase tracking-wider shadow-md mt-4 flex items-center justify-center space-x-2 !cursor-pointer">
                <span>Simpan Sesi</span>
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let databaseValues = { g1: 0, g2: 0, g3: 0, g4: 0 };
    window.lastSavedScores = { g1: 0, g2: 0, g3: 0, g4: 0 };

    async function openEvaluationModal(studentId) {
        // 1. Tampilkan Modal
        document.getElementById('evalModal').classList.remove('hidden');
        
        // 2. Reset / Bersihkan Form sebelum diisi data baru
        document.getElementById('modal-student-id').value = studentId; // Penting: supaya data masuk ke siswa yang benar
        document.querySelector('textarea[name="catatan"]').value = ''; // Reset catatan

        try {
            const response = await fetch(`/coach/student-data/${studentId}`);
            const data = await response.json();

            // 3. Update Header (Nama, Level, Avatar)
            document.getElementById('modal-student-name').innerText = data.nama;
            document.getElementById('modal-student-level').innerText = data.level;
            document.getElementById('modal-avatar').innerText = data.avatar_initials;

            // 4. Sinkronisasi Nilai Slider & Label
            // Kita simpan nilai awal database agar bisa hitung selisih nanti
            window.lastSavedScores = {
                g1: data.gaya_bebas || 0,
                g2: data.gaya_punggung || 0,
                g3: data.gaya_dada || 0,
                g4: data.gaya_kupu || 0
            };

            // Objek pemetaan untuk mempermudah akses input
            // Objek pemetaan untuk mempermudah akses input dan ID display
            const mapping = { 
                g1: { input: 'gaya_bebas', display: 'g1' }, 
                g2: { input: 'gaya_punggung', display: 'g2' }, 
                g3: { input: 'gaya_dada', display: 'g3' }, 
                g4: { input: 'gaya_kupu', display: 'g4' } 
            };

            Object.keys(window.lastSavedScores).forEach(key => {
                const val = window.lastSavedScores[key];
                const map = mapping[key]; // Ambil mapping untuk g1/g2/dst
                
                // 1. Set nilai input slider
                const input = document.querySelector(`input[name="${map.input}"]`);
                if(input) {
                    input.value = val; 
                }

                // 2. UPDATE DISPLAY (Gunakan kunci 'g1' penuh agar sesuai dengan id="val-display-g1")
                const displayEl = document.getElementById('val-display-' + map.display);
                if(displayEl) {
                    displayEl.innerText = val + "%";
                }

                // 3. Hitung Badge
                calculateDiff(key, val); 
            });

        } catch (err) { 
            console.error("Gagal memuat data:", err); 
        }
    }

    // Fungsi penutup modal
    function closeEvaluationModal() {
        document.getElementById('evalModal').classList.add('hidden');
    }
    
    function calculateDiff(id, currentVal) {
        // 1. Update angka persentase utama
        document.getElementById('val-display-' + id).innerText = currentVal + "%";

        // 2. Hitung selisih
        const lastVal = window.lastSavedScores[id] || 0;
        const diff = currentVal - lastVal;
        
        const badge = document.getElementById('badge-diff-' + id);
        
        // 3. Tampilkan badge hanya jika ada perubahan
        if (diff === 0) {
            badge.classList.add('hidden');
        } else {
            badge.classList.remove('hidden');
            badge.innerText = (diff > 0 ? "+" : "") + diff;
            
            // Ganti warna: Hijau kalau naik, Merah kalau turun
            if (diff > 0) {
                badge.className = "text-[9px] font-black px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700";
            } else {
                badge.className = "text-[9px] font-black px-2 py-0.5 rounded-full bg-red-100 text-red-700";
            }
        }
    }

    function populateSlider(data) {
        const styles = ['bebas', 'punggung', 'dada', 'kupu'];

        styles.forEach(style => {
            // Ambil nilai dari data database (contoh: data.gaya_bebas)
            const val = data['gaya_' + style] || 0;

            // 1. Update Slider (Range Input)
            const input = document.querySelector(`input[name="gaya_${style}"]`);
            if (input) input.value = val;

            // 2. Update Tampilan Angka (Label)
            const display = document.getElementById(`val-display-${style}`);
            if (display) display.innerText = val + "%";
        });
    }

    function setStatus(status) {
        document.getElementById('attendance_status').value = status;
        const btnHadir = document.getElementById('btn-hadir');
        const btnAbsen = document.getElementById('btn-tidak-hadir');
        const scoringSection = document.getElementById('form-scoring-section');
        
        if(status === 'hadir') {
            btnHadir.className = "py-3 rounded-xl border-2 text-center font-black bg-teal-500 border-teal-500 text-white shadow-sm";
            btnAbsen.className = "py-3 rounded-xl border-2 text-center font-black border-slate-200 text-slate-400 hover:bg-slate-50";
            scoringSection.classList.remove('hidden');
        } else {
            btnAbsen.className = "py-3 rounded-xl border-2 text-center font-black bg-red-500 border-red-500 text-white shadow-sm";
            btnHadir.className = "py-3 rounded-xl border-2 text-center font-black border-slate-200 text-slate-400 hover:bg-slate-50";
            scoringSection.classList.add('hidden');
        }
    }

    function updateVal(type, val) { document.getElementById(`val-display-${type}`).innerText = val + (type === 'sesi' ? '' : '%'); }
</script>

@endsection