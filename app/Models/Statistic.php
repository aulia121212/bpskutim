<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    protected $fillable = [
        'indikator_data',
        'statistic_title_id',        // ✅ tambah
        'judul_data',
        'wilayah_data',
        'file_data',
        'interpretasi_lebih_kecil',
        'interpretasi_lebih_besar',
        'interpretasi_tetap',        // ✅ tambah
        'status',
    ];

    public function values()
    {
        return $this->hasMany(StatisticValue::class);
    }

    public function title()
    {
        return $this->belongsTo(StatisticTitle::class, 'statistic_title_id');
    }

    // ✅ alias agar blade bisa pakai ->statisticTitle
    public function statisticTitle()
    {
        return $this->belongsTo(StatisticTitle::class, 'statistic_title_id');
    }
}