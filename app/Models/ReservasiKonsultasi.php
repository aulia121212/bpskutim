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

    // ── Relasi ────────────────────────────────────────────────────

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
        return $this->hasMany(RiwayatKonsultasi::class, 'id_reservasi', 'id_reservasi');
    }

    public function riwayatTerbaru()
    {
        return $this->hasOne(RiwayatKonsultasi::class, 'id_reservasi', 'id_reservasi')
                    ->latest('updated_at');
    }

    // ── Accessor ─────────────────────────────────────────────────

    /**
     * Ambil status terbaru dari tabel riwayat.
     * Bisa diakses dengan $reservasi->status
     */
    public function getStatusAttribute(): string
    {
        return $this->riwayatTerbaru?->status_pengajuan ?? 'diajukan';
    }

    /**
     * Alias tanggal agar view bisa pakai $r->tanggal
     */
    public function getTanggalAttribute()
    {
        return $this->tanggal_konsultasi;
    }
}