<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Session;
use App\Models\ProgressReport;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CoachDashboardController extends Controller
{
    // 1. HALAMAN UTAMA (OVERVIEW)
    public function overview()
    {
        $totalStudents = Student::count();
        $totalSessions = Session::count();
        
        // Hitung rata-rata progress seluruh siswa
        $allReports = ProgressReport::all();
        $avgProgress = 0;
        if ($allReports->count() > 0) {
            $sum = $allReports->avg(fn($r) => ($r->gaya_dada + $r->gaya_bebas + $r->gaya_punggung + $r->gaya_kupu) / 4);
            $avgProgress = round($sum);
        }

        // Hitung distribusi level untuk grafik bar kecil
        $levelCounts = [
            'Toddler Splash' => Student::where('level', 'Toddler Splash')->count(),
            'Junior Swimmer' => Student::where('level', 'Junior Swimmer')->count(),
            'Competitive Edge' => Student::where('level', 'Competitive Edge')->count(),
        ];

        // Daftar urutan siswa dengan performa/kehadiran tertinggi
        $streakStudents = Student::withCount(['sessions as total_hadir' => function($q){
            $q->where('attendance_status', 'hadir');
        }])->orderBy('total_hadir', 'desc')->take(3)->get();

        // 5 sesi terbaru harian yang diinput pelatih
        $latestSessions = Session::with('student')->orderBy('tanggal', 'desc')->take(5)->get();

        return view('coach.overview', compact('totalStudents', 'totalSessions', 'avgProgress', 'levelCounts', 'streakStudents', 'latestSessions'));
    }

    // 2. HALAMAN DAFTAR SISWA
    public function students(Request $request)
    {
        $query = Student::with(['sessions.progressReport']);

        if ($request->has('search') && $request->search != '') {
            $query->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('id_tracking', 'like', '%' . $request->search . '%');
        }

        if ($request->has('level') && $request->level != 'Semua Level' && $request->level != '') {
            $query->where('level', $request->level);
        }

        $students = $query->get();
        return view('coach.students', compact('students'));
    }

    // 3. PROSES SIMPAN SISWA BARU
    public function storeStudent(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'level' => 'required|string',
            'nama_orang_tua' => 'required|string',
            'no_orang_tua' => 'required|string',
            'alamat' => 'required|string',
        ]);

        // Generate ID Unik otomatis ex: SWIM-A92B
        $uniqueId = 'BR-' . strtoupper(substr(md5(uniqid()), 0, 3));

        Student::create([
            'id_tracking' => $uniqueId,
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'level' => $request->level,
            'nama_orang_tua' => $request->nama_orang_tua,
            'no_orang_tua' => $request->no_orang_tua,
            'alamat' => $request->alamat,
            'status' => 'aktif'
        ]);

        return redirect()->back()->with('success', 'Siswa baru berhasil ditambahkan! ID: ' . $uniqueId);
    }

    // 4. HALAMAN ABSENSI & NILAI
    public function attendance(Request $request)
    {
        $query = Student::with(['sessions' => function($q) {
            $q->orderBy('tanggal', 'desc');
        }]);

        if ($request->has('search') && $request->search != '') {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $students = $query->get();
        return view('coach.attendance', compact('students'));
    }

    // 5. PROSES SIMPAN JURNAL LATIHAN & NILAI GAYA
    public function storeSession(Request $request)
    {
        $request->validate([
            'id_siswa' => 'required|exists:students,id',
            'tanggal' => 'required|date',
            'attendance_status' => 'required|in:hadir,tidak hadir',
            'topik_sesi' => 'nullable|string',
            'nilai_sesi' => 'required|integer',
            'gaya_bebas' => 'required|integer',
            'gaya_punggung' => 'required|integer',
            'gaya_dada' => 'required|integer',
            'gaya_kupu' => 'required|integer',
            'catatan' => 'nullable|string'
        ]);

        // Hitung nomor pertemuan otomatis
        $meetingNumber = Session::where('id_siswa', $request->id_siswa)->count() + 1;

        $session = Session::create([
            'id_siswa' => $request->id_siswa,
            'meeting_number' => $meetingNumber,
            'tanggal' => $request->tanggal,
            'attendance_status' => $request->attendance_status,
            'topik_sesi' => $request->topik_sesi,
            'nilai_sesi' => $request->nilai_sesi,
        ]);

        if ($request->attendance_status === 'hadir') {
            ProgressReport::create([
                'id_sesi' => $session->id,
                'gaya_bebas' => $request->gaya_bebas, // dipetakan ke field eksis database kamu
                'gaya_punggung' => $request->gaya_punggung,
                'gaya_dada' => $request->gaya_dada,
                'gaya_kupu' => $request->gaya_kupu,
                'catatan' => $request->catatan
            ]);
        }

        return redirect()->route('coach.students')->with('success', 'Data absensi & penilaian berhasil disimpan!');
    }
    
    public function calculateOverallProgress()
    {
        // Ambil sesi terbaru dengan report-nya
        $latestSession = $this->sessions()->latest('id')->first();
        
        if (!$latestSession || !$latestSession->progressReport) {
            return 0; // Jika belum ada data, 0%
        }

        $report = $latestSession->progressReport;

        // Hitung total nilai (maksimal 4 gaya x 5 = 20)
        $totalNilai = $report->gaya_bebas + $report->gaya_punggung + $report->gaya_dada + $report->gaya_kupu;
        
        // Hitung persentase: (Total / 20) * 100
        // Menggunakan round agar rapi
        return round(($totalNilai / 20) * 100);
    }

    

   public function getStudentData($id)
    {
        // 1. Ambil siswa dengan relasi session dan progressReport
        $student = Student::with(['sessions.progressReport'])->findOrFail($id);

        // --- SINKRONISASI DENGAN TRACKING CONTROLLER ---
        
        // Ambil laporan progress harian dari sesi "hadir" terbaru (ID terbesar)
        $latestAttendanceSession = $student->sessions
            ->where('attendance_status', 'hadir')
            ->sortByDesc('id')
            ->first();

        $lastReport = $latestAttendanceSession ? $latestAttendanceSession->progressReport : null;

        // Ambil nilai murni (0 jika null)
        $gBebas = $lastReport ? $lastReport->gaya_bebas : 0;
        $gPunggung = $lastReport ? $lastReport->gaya_punggung : 0;
        $gDada = $lastReport ? $lastReport->gaya_dada : 0;
        $gKupu = $lastReport ? $lastReport->gaya_kupu : 0;

        // Hitung rata-rata kemajuan (LOGIKA SAMA PERSIS)
        $progPercent = $lastReport ? round(($gBebas + $gPunggung + $gDada + $gKupu) / 4) : 0;

        // 2. Kirim data ke modal (JavaScript)
        return response()->json([
            'nama'          => $student->nama,
            'id_tracking'   => $student->id_tracking,
            'tgl_gabung'    => $student->created_at->format('d M Y'),
            'progress'      => $progPercent, // Hasil dari rumus yang sama
            'gaya_bebas'    => $gBebas,
            'gaya_punggung' => $gPunggung,
            'gaya_dada'     => $gDada,
            'gaya_kupu'     => $gKupu,
            'total_sesi'    => $student->sessions->count(),
            'streak'        => $student->sessions->where('attendance_status', 'hadir')->count(), 
            'level'         => $student->level ?? 'Pemula',
            'usia'          => $student->tanggal_lahir ? \Carbon\Carbon::parse($student->tanggal_lahir)->age : 0,
            
            // Data pendukung lainnya
            'last_tgl'      => $latestAttendanceSession ? \Carbon\Carbon::parse($latestAttendanceSession->tanggal)->format('d M Y') : '-',
            'last_catatan'  => $lastReport ? $lastReport->catatan : 'Tidak ada catatan.',
            
            // Riwayat sesi (Urutkan dari yang terbaru)
            'sessions'      => $student->sessions->sortByDesc('id')->map(function($session) {
                return [
                    'meeting_number' => $session->meeting_number ?? '-',
                    'tanggal'        => \Carbon\Carbon::parse($session->tanggal)->format('d M Y'),
                    'topik'          => $session->topik_sesi ?? 'Latihan Umum',
                    'nilai'          => $session->nilai_sesi ?? 0,
                    'catatan'        => $session->progressReport ? $session->progressReport->catatan : '-',
                ];
            })->values()
        ]);
    }
    
}