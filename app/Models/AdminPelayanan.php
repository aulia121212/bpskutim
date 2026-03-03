<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminPelayanan extends Model
{
    protected $fillable = [
    'nama_lengkap',
    'no_whatsapp',
    'email',
    'password',
    'alamat',
    'jabatan',
    'tim',
    'foto',
];

protected $hidden = ['password'];
}
