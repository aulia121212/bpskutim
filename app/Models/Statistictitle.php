<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatisticTitle extends Model
{
    protected $fillable = [
        'judul_data',
        'interpretasi_lebih_kecil',
        'interpretasi_lebih_besar',
    ];

    public function statistics()
    {
        return $this->hasMany(Statistic::class, 'statistic_title_id');
    }
}