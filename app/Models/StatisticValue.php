<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatisticValue extends Model
{
    protected $fillable = ['statistic_id','year','value'];

    public function statistic()
    {
        return $this->belongsTo(Statistic::class);
    }
}
