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
    Schema::create('statistics', function (Blueprint $table) {
        $table->id();
        $table->enum('indikator_data', ['indikator_ekonomi', 'indikator_ketenagakerjaan', 'indikator_sosial', 'indikator_pembangunan_manusia']);
        $table->string('judul_data');
        $table->string('wilayah_data');
        $table->string('file_data');   
        $table->string('interpretasi_lebih_kecil');
        $table->string('interpretasi_lebih_besar');
        $table->enum('status', ['draft', 'published'])->default('draft');
        $table->timestamps();         
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistics');
    }
};
