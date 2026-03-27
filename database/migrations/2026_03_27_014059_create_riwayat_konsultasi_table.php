<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('riwayat_konsultasi', function (Blueprint $table) {
            $table->id('id_riwayat_konsultasi');
            $table->unsignedBigInteger('id_reservasi');
            $table->enum('status_pengajuan', [
                'diajukan',
                'dijadwalkan',
                'selesai',
                'dibatalkan',
            ])->default('diajukan');
            $table->text('catatan_petugas')->nullable();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('id_reservasi')
                  ->references('id_reservasi')->on('reservasi_konsultasi')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('riwayat_konsultasi');
    }
};