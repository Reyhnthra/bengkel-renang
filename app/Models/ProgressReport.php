<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgressReport extends Model
{
    use HasFactory;

    protected $table = 'progress_reports';

    // Izinkan semua input slider gaya renang masuk ke database
    protected $fillable = ['id_sesi', 'gaya_bebas', 'gaya_punggung', 'gaya_dada', 'gaya_kupu', 'catatan'];

    public function session()
    {
        return $this->belongsTo(Session::class, 'id_sesi');
    }
}