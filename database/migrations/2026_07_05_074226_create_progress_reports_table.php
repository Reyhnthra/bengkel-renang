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
        Schema::create('progress_reports', function (Blueprint $table) {
            $table->id();
            // Menghubungkan progress langsung ke sesi latihan hari itu
            $table->foreignId('id_sesi')->constrained('sessions')->onDelete('cascade');
            $table->integer('gaya_bebas'); 
            $table->integer('gaya_punggung');  
            $table->integer('gaya_dada');  
            $table->integer('gaya_kupu');
            $table->text('catatan')->nullable(); // Catatan harian dari pelatih
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress_reports');
    }
};
