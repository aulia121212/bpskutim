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
    Schema::table('statistics', function (Blueprint $table) {
        $table->foreignId('statistic_title_id')
              ->nullable()
              ->after('id')
              ->constrained('statistic_titles')
              ->nullOnDelete();
    });
}

public function down(): void
{
    Schema::table('statistics', function (Blueprint $table) {
        $table->dropForeign(['statistic_title_id']);
        $table->dropColumn('statistic_title_id');
    });
}
};
