<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('statistic_titles', function (Blueprint $table) {
            $table->id();
            $table->string('judul_data');
            $table->text('interpretasi_lebih_kecil')->nullable();
            $table->text('interpretasi_lebih_besar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statistic_titles');
    }
};