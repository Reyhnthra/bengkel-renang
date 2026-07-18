<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    // WAJIB DAFTARKAN SEMUA KOLOM BARU DI SINI
    protected $fillable = [
        'id_tracking',
        'nama',
        'tanggal_lahir',    // Pastikan ini ada
        'level',            // Pastikan ini ada
        'nama_orang_tua',
        'no_orang_tua',
        'alamat',           // Pastikan ini ada
        'status',
        'tanggal_bergabung'
    ];

    /**
     * Relasi ke tabel sessions
     */
    // app/Models/Student.php

    public function sessions()
    {
        // Hapus orderBy('tanggal') atau orderBy apapun, biarkan default
        return $this->hasMany(Session::class, 'id_siswa');
    }
    // app/Models/Student.php


    // app/Models/Student.php

    public function getUsiaAttribute() {
        return $this->tanggal_lahir ? \Carbon\Carbon::parse($this->tanggal_lahir)->age : '-';
    }

    // Fungsi ini sudah ada, pastikan tetap dipakai
    public function calculateOverallProgress() {
        $latestSession = $this->sessions()->latest('id')->first();
        $report = $latestSession ? $latestSession->progressReport : null;
        if (!$report) return 0;
        
        $avg = ($report->gaya_bebas + $report->gaya_punggung + $report->gaya_dada + $report->gaya_kupu) / 4;
        return round($avg);
    }

    public function getImprovementRate()
    {
        $sessions = $this->sessions()->has('progressReport')
                        ->with('progressReport')
                        ->orderBy('tanggal', 'desc')
                        ->take(2)->get();

        if ($sessions->count() < 2) return 0;

        $latest = $sessions[0]->progressReport;
        $prev = $sessions[1]->progressReport;

        $avgLatest = ($latest->gaya_bebas + $latest->gaya_punggung + $latest->gaya_dada + $latest->gaya_kupu) / 4;
        $avgPrev = ($prev->gaya_bebas + $prev->gaya_punggung + $prev->gaya_dada + $prev->gaya_kupu) / 4;

        return round($avgLatest - $avgPrev);
    }
}