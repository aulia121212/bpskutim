<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // ── Role constants ────────────────────────────────────────────────────
    const ROLE_SUPER_ADMIN      = 'super_admin';
    const ROLE_ADMIN_PELAYANAN  = 'admin_pelayanan';
    const ROLE_ADMIN_STATISTIK  = 'admin_statistik';
    const ROLE_USER             = 'user';

    // ── Role labels (untuk tampilan UI) ───────────────────────────────────
    const ROLE_LABELS = [
        'super_admin'     => 'Super Admin',
        'admin_pelayanan' => 'Admin Pelayanan',
        'admin_statistik' => 'Admin Data Statistik',
        'user'            => 'Pengguna',
    ];

    protected $fillable = [
        'name',
        'email',
        'no_whatsapp',
        'password',
        'role',
        'instansi',
        'jabatan',
        'tim',
        'alamat',
        'foto_profil',
        'google_id',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'google_id',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'is_active'         => 'boolean',
    ];

    // ── Role helpers ──────────────────────────────────────────────────────
    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    public function isAdminPelayanan(): bool
    {
        return $this->role === self::ROLE_ADMIN_PELAYANAN;
    }

    public function isAdminStatistik(): bool
    {
        return $this->role === self::ROLE_ADMIN_STATISTIK;
    }

    public function isUser(): bool
    {
        return $this->role === self::ROLE_USER;
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, [
            self::ROLE_SUPER_ADMIN,
            self::ROLE_ADMIN_PELAYANAN,
            self::ROLE_ADMIN_STATISTIK,
        ]);
    }

    public function hasRole(string|array $roles): bool
    {
        return in_array($this->role, (array) $roles);
    }

    public function getRoleLabelAttribute(): string
    {
        return self::ROLE_LABELS[$this->role] ?? $this->role;
    }

    public function reservasi()
    {
        return $this->hasMany(ReservasiKonsultasi::class, 'id_user');
    }
    // ── Redirect sesuai role ──────────────────────────────────────────────
    public function dashboardRoute(): string
    {
        return match ($this->role) {
    self::ROLE_SUPER_ADMIN     => route('superadmin.dashboard'),
    self::ROLE_ADMIN_PELAYANAN => route('dashboard.index'),
    self::ROLE_ADMIN_STATISTIK => route('dashboard.index'),
    default                    => route('home'),
};
    }
}
