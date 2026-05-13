<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
class StatisticTitle extends Model
{
    protected $fillable = [
        'indikator_data',
        'judul_data',
        'judul_kolom',
        'interpretasi_lebih_kecil',
        'interpretasi_lebih_besar',
        'interpretasi_tetap',
    ];  

    public function statistics(): HasMany
    {
        return $this->hasMany(Statistic::class, 'statistic_title_id');
    }
    public function values(): HasManyThrough
{
    return $this->hasManyThrough(
        StatisticValue::class, // Model tujuan akhir
        Statistic::class,      // Model perantara
        'statistic_title_id',  // Foreign key di model perantara (Statistic)
        'statistic_id',        // Foreign key di model tujuan (StatisticValue)
        'id',                  // Local key di StatisticTitle
        'id'                   // Local key di Statistic
    );
}

    public function components()
    {
        return $this->hasMany(StatisticTitleComponent::class)
            ->orderBy('urutan');    }


}