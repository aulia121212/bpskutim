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
    Schema::table('statistic_title_components', function (Blueprint $table) {
        $table->text('interpretasi_lebih_kecil')->nullable()->after('urutan');
        $table->text('interpretasi_lebih_besar')->nullable()->after('interpretasi_lebih_kecil');
    });
}

public function down(): void
{
    Schema::table('statistic_title_components', function (Blueprint $table) {
        $table->dropColumn(['interpretasi_lebih_kecil', 'interpretasi_lebih_besar']);
    });
}

};
