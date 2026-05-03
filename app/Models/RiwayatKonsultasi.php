<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatKonsultasi extends Model
{
    protected $table      = 'riwayat_konsultasi';
    protected $primaryKey = 'id_riwayat_konsultasi';
    public    $timestamps = false;

    protected $fillable = [
        'id_reservasi',
        'status_pengajuan',
        'catatan_petugas',
        'catatan_konsultasi',  // catatan dari admin untuk user
        'alasan_pembatalan',   // alasan batalkan dari admin atau user
    ];

    protected $casts = [
        'updated_at' => 'datetime',
    ];

    const CREATED_AT = null;
    const UPDATED_AT = 'updated_at';

    public function reservasi()
    {
        return $this->belongsTo(ReservasiKonsultasi::class, 'id_reservasi', 'id_reservasi');
    }
}