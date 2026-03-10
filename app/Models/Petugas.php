<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
protected $fillable = ['nama_lengkap', 'nomor_wa', 'jabatan', 'bidang_keahlian', 'foto'];

protected $casts = [
    'bidang_keahlian' => 'array', // ✅ auto convert array ↔ JSON
];

}
