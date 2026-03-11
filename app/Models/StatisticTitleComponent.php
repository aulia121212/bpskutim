<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatisticTitleComponent extends Model
{
    protected $fillable = [
        'statistic_title_id',
        'nama',
        'is_sub',
        'urutan',
        'interpretasi_lebih_kecil',  
        'interpretasi_lebih_besar', 
        'interpretasi_tetap', 
    ];

    protected $casts = [
        'is_sub' => 'boolean',
    ];

    public function statisticTitle()
    {
        return $this->belongsTo(StatisticTitle::class);
    }
}