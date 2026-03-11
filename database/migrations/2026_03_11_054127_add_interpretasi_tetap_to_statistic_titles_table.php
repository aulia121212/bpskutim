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
        $table->text('interpretasi_tetap')->nullable()->after('interpretasi_lebih_besar');
    });
}

public function down(): void
{
    Schema::table('statistic_titles', function (Blueprint $table) {
        $table->dropColumn('interpretasi_tetap');
    });
}
};
