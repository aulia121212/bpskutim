<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE statistics 
            MODIFY indikator_data VARCHAR(255)
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE statistics 
            MODIFY indikator_data 
            ENUM(
                'indikator_ekonomi',
                'indikator_ketenagakerjaan',
                'indikator_sosial',
                'indikator_pembangunan_manusia',
                'gender'
            )
        ");
    }
};