<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Session;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TrackingController extends Controller
{
    // 1. Halaman Landing Page Utama
    public function index()
    {
        return view('landing');
    }

    // 2. Proses saat orang tua submit form pencarian ID (SINKRONISASI POP-UP AJAX)
    public function search(Request $request)
    {
        $request->validate([
            'id_tracking' => 'required|string',
        ], [
            'id_tracking.required' => 'ID Tracking wajib diisi.'
        ]);

        $student = Student::where('id_tracking', strtoupper($request->id_tracking))->first();

        // JIKA ID TIDAK ADA DI DATABASE:
        if (!$student) {
            return redirect()->back()->withErrors([
                'id_tracking' => "ID tidak ditemukan \nSilakan periksa kembali atau hubungi Mr Iqbal"
            ])->withInput();
        }

        // Jika ada, langsung pindah ke halaman show
        return redirect()->route('track.show', $student->id_tracking);
    }

    // 3. Halaman Hasil Progress Tampilan Orang Tua (Menyuplai isi HTML Kotak Pop-up)
    // 3. Halaman Hasil Progress Tampilan Orang Tua
    public function show($code)
    {
        // Ambil data siswa dengan relasi session dan progressReport
        $student = Student::where('id_tracking', $code)->with(['sessions.progressReport'])->firstOrFail();

        // --- PERBAIKAN DI SINI: GUNAKAN ID BUKAN TANGGAL ---
        $sessionsCount = $student->sessions->count();
        
        // Ambil sesi terbaru berdasarkan ID (pasti paling baru)
        $latestSession = $student->sessions->sortByDesc('id')->first();
        
        // Ambil laporan progress harian dari sesi "hadir" terbaru
        $latestAttendanceSession = $student->sessions->where('attendance_status', 'hadir')->sortByDesc('id')->first();
        $lastReport = $latestAttendanceSession ? $latestAttendanceSession->progressReport : null;

        // Ambil nilai murni
        $gBebas = $lastReport ? $lastReport->gaya_bebas : 0;
        $gPunggung = $lastReport ? $lastReport->gaya_punggung : 0;
        $gDada = $lastReport ? $lastReport->gaya_dada : 0;
        $gKupu = $lastReport ? $lastReport->gaya_kupu : 0;

        // Hitung rata-rata kemajuan
        $progPercent = $lastReport ? round(($gBebas + $gPunggung + $gDada + $gKupu) / 4) : 0;
        
        // Hitung umur & total kehadiran aktif
        $usiaSiswa = Carbon::parse($student->tanggal_lahir)->age;
        $streakCount = $student->sessions->where('attendance_status', 'hadir')->count();

        // Urutkan riwayat sesi dari yang paling baru (ID terbesar)
        $historySessions = $student->sessions->sortByDesc('id');

        return view('track.show', compact(
            'student',
            'sessionsCount',
            'latestSession',
            'lastReport',
            'gBebas',
            'gPunggung',
            'gDada',
            'gKupu',
            'progPercent',
            'usiaSiswa',
            'streakCount',
            'historySessions'
        ));
    }
}