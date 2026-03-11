<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatisticTitle extends Model
{
    protected $fillable = [
        'judul_data',
        'judul_kolom',
        'interpretasi_lebih_kecil',
        'interpretasi_lebih_besar',
        'interpretasi_tetap',
    ];

    public function values()
{
    return $this->hasMany(StatisticValue::class); // Sesuaikan nama model nilai Anda
}


    public function components()
    {
        return $this->hasMany(StatisticTitleComponent::class)
            ->orderBy('urutan');    }
}