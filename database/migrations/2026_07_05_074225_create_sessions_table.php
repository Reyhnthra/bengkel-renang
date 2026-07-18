<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_siswa')->constrained('students')->onDelete('cascade');
            $table->integer('meeting_number'); 
            $table->date('tanggal');
            $table->string('topik_sesi')->nullable(); 
            
            // TAMBAHKAN BARIS INI: Kolom untuk menampung status absensi (hadir/tidak hadir)
            $table->enum('attendance_status', ['hadir', 'tidak hadir'])->default('hadir');
            
            $table->integer('nilai_sesi')->nullable();
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
