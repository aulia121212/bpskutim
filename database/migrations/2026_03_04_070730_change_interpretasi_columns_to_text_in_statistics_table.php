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
        $table->text('interpretasi_lebih_kecil')->change();
        $table->text('interpretasi_lebih_besar')->change();
    });
}

public function down(): void
{
    Schema::table('statistics', function (Blueprint $table) {
        $table->string('interpretasi_lebih_kecil')->change();
        $table->string('interpretasi_lebih_besar')->change();
    });
}
};
