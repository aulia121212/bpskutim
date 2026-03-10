<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalTidakTersedia extends Model
{
    protected $fillable = ['tanggal', 'judul', 'alasan', 'petugas'];

}
