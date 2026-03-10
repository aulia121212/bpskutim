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
    Schema::table('petugas', function (Blueprint $table) {
        $table->string('nomor_wa')->nullable()->after('nama_lengkap');
        $table->string('foto')->nullable()->after('bidang_keahlian');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('petugas', function (Blueprint $table) {
            //
        });
    }
};
