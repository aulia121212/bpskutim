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
        $table->string('satuan')->nullable()->after('nama');
    });
}

public function down(): void
{
    Schema::table('statistic_title_components', function (Blueprint $table) {
        $table->dropColumn('satuan');
    });
}
};
