<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservasiKonsultasi extends Model
{
    protected $table      = 'reservasi_konsultasi';
    protected $primaryKey = 'id_reservasi';
    public    $timestamps = false;

    protected $fillable = [
        'id_user',
        'id_petugas',
        'tanggal_konsultasi',
        'waktu_konsultasi',
        'topik_diskusi',
        'jenis_konsultasi',
        'lokasi_konsultasi',
    ];

    protected $casts = [
        'tanggal_konsultasi' => 'date',
        'created_at'         => 'datetime',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function petugas()
    {
        return $this->belongsTo(\App\Models\Petugas::class, 'id_petugas', 'id');
    }

    public function riwayat()
    {
        return $this->hasMany(RiwayatKonsultasi::class, 'id_reservasi', 'id_reservasi')
                    ->orderBy('id_riwayat_konsultasi', 'asc'); // pakai PK yang benar
    }

    public function riwayatTerbaru()
    {
        return $this->hasOne(RiwayatKonsultasi::class, 'id_reservasi', 'id_reservasi')
                    ->orderByDesc('id_riwayat_konsultasi'); // paling baru = PK terbesar
    }

    /** Status terbaru dari riwayat */
    public function getStatusAttribute(): string
    {
        return $this->riwayatTerbaru?->status_pengajuan ?? 'diajukan';
    }

    /** Alias agar blade bisa pakai $r->tanggal */
    public function getTanggalAttribute()
    {
        return $this->tanggal_konsultasi;
    }
}