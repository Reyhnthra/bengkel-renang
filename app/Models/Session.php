<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $table = 'sessions';

    // 1. Izinkan kolom-kolom ini ditulis ke database
    protected $fillable = [
        'id_siswa',
        'meeting_number',
        'tanggal',
        'topik_sesi',
        'attendance_status',
        'nilai_sesi'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'id_siswa');
    }

    // 2. Hubungkan sesi latihan langsung dengan laporan penilaian gaya renang (PENTING UNTUK BLADE)
    public function progressReport()
    {
        return $this->hasOne(ProgressReport::class, 'id_sesi');
    }
}