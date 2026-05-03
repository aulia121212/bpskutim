<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatKonsultasi extends Model
{
    protected $table      = 'riwayat_konsultasi';
    protected $primaryKey = 'id_riwayat_konsultasi';

    // Tidak pakai timestamps otomatis — set updated_at manual saat create
    public $timestamps = false;

    // updated_at diisi manual sebagai penanda waktu entry riwayat
    protected $casts = [
        'updated_at' => 'datetime',
    ];

    protected $fillable = [
        'id_reservasi',
        'status_pengajuan',
        'catatan_petugas',
        'catatan_konsultasi',
        'alasan_pembatalan',
    ];
}