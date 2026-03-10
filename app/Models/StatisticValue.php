<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatisticValue extends Model
{
   // protected $fillable = ['statistic_id','year','value'];
protected $fillable = ['statistic_id', 'year', 'value', 'x_label', 'y_label'];
    public function statistic()
    {
        return $this->belongsTo(Statistic::class);
    }
}
