<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('riwayat_konsultasi', function (Blueprint $table) {
            // Tambah kolom jika belum ada
            if (!Schema::hasColumn('riwayat_konsultasi', 'catatan_konsultasi')) {
                $table->text('catatan_konsultasi')->nullable()->after('catatan_petugas');
            }
            if (!Schema::hasColumn('riwayat_konsultasi', 'alasan_pembatalan')) {
                $table->text('alasan_pembatalan')->nullable()->after('catatan_konsultasi');
            }
        });
    }

    public function down(): void
    {
        Schema::table('riwayat_konsultasi', function (Blueprint $table) {
            $table->dropColumn(['catatan_konsultasi', 'alasan_pembatalan']);
        });
    }
};