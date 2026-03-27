<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reservasi_konsultasi', function (Blueprint $table) {
    $table->id('id_reservasi');
    $table->unsignedBigInteger('id_user');
    $table->unsignedBigInteger('id_petugas');
    $table->date('tanggal_konsultasi');
    $table->time('waktu_konsultasi');
    $table->text('topik_diskusi')->nullable();
    $table->enum('jenis_konsultasi', ['online', 'offline'])->default('online');
    $table->string('lokasi_konsultasi')->nullable();
    $table->timestamp('created_at')->useCurrent();

    $table->foreign('id_user')
          ->references('id')->on('users')
          ->onDelete('cascade');

    $table->foreign('id_petugas')
          ->references('id')->on('petugas')   // ← ganti dari petugas_konsultasi
          ->onDelete('cascade');
});
    }

    public function down(): void
    {
        Schema::dropIfExists('reservasi_konsultasi');
    }
};