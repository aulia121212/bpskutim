<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('statistic_title_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('statistic_title_id')->constrained()->cascadeOnDelete();
            $table->string('nama');         // misal: "Pertambangan dan Penggalian"
            $table->boolean('is_sub')->default(false); // sub-kategori atau tidak
            $table->integer('urutan')->default(0);     // urutan tampil
            $table->timestamps();
        });

        // Tambah kolom judul_kolom ke statistic_titles
        // (label header kolom pertama tabel, misal: "Lapangan Usaha")
        Schema::table('statistic_titles', function (Blueprint $table) {
            $table->string('judul_kolom')->nullable()->after('judul_data');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statistic_title_components');
        Schema::table('statistic_titles', function (Blueprint $table) {
            $table->dropColumn('judul_kolom');
        });
    }
};