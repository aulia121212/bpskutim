<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    protected $fillable = [
        'indikator_data',
        'judul_data',
        //'interpretasi_data',
        'wilayah_data',
        'file_data',
        'interpretasi_lebih_kecil',  
        'interpretasi_lebih_besar', 
        'status',
    ];

    public function values()
    {
        return $this->hasMany(StatisticValue::class);
    }
}