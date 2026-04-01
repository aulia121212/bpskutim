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
    Schema::table('statistic_titles', function (Blueprint $table) {
        $table->string('indikator_data')->after('id');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('statistic_titles', function (Blueprint $table) {
        $table->dropColumn('indikator_data');
    });
}
};
