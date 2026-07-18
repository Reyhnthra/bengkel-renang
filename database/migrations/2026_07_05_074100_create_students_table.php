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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('id_tracking')->unique();
            $table->string('nama');
            $table->date('tanggal_lahir');
            $table->string('nama_orang_tua');
            $table->string('no_orang_tua');
            $table->string('alamat'); 
            $table->enum('level', ['Toddler Splash', 'Junior Swimmer', 'Competitive Edge'])->default('Toddler Splash');
            $table->timestamp('tanggal_bergabung')->nullable();
            
            // TAMBAHKAN BARIS INI: Untuk menyimpan status keaktifan murid
            $table->string('status')->default('aktif'); 
            
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
