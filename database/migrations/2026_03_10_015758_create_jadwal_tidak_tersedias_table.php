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
        Schema::create('jadwal_tidak_tersedias', function (Blueprint $table) {
            $table->id();
$table->date('tanggal')->unique();
$table->string('judul')->nullable();
$table->enum('alasan', ['Cuti Pribadi', 'Cuti Bersama', 'Libur Nasional']);
$table->string('petugas')->nullable(); // nama petugas atau 'Semua Petugas'
$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_tidak_tersedias');
    }
};
