<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('petugas', function (Blueprint $table) {
            if (!Schema::hasColumn('petugas', 'nomor_wa')) {
                $table->string('nomor_wa')->nullable()->after('nama_lengkap');
            }
            if (!Schema::hasColumn('petugas', 'foto')) {
                $table->string('foto')->nullable()->after('bidang_keahlian');
            }
        });
    }

    public function down(): void
    {
        Schema::table('petugas', function (Blueprint $table) {
            $table->dropColumn(['nomor_wa', 'foto']);
        });
    }
};