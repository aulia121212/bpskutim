<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('statistic_values', function (Blueprint $table) {
            $table->string('x_label')->nullable()->after('statistic_id');
            $table->string('y_label')->nullable()->after('x_label');
        });

        // Isi data lama: x_label = judul statistik, y_label = year
        // Data lama hanya punya kolom 'year' dan 'value', belum ada x_label/y_label
        DB::statement("
            UPDATE statistic_values sv
            JOIN statistics s ON s.id = sv.statistic_id
            SET sv.x_label = s.judul_data,
                sv.y_label = CAST(sv.year AS CHAR)
            WHERE sv.x_label IS NULL
              AND sv.year IS NOT NULL
        ");
    }

    public function down(): void
    {
        Schema::table('statistic_values', function (Blueprint $table) {
            $table->dropColumn(['x_label', 'y_label']);
        });
    }
};