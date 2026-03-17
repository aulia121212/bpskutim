<?php
// ══════════════════════════════════════════════════════════════════════════
// 1. DAFTARKAN MIDDLEWARE di bootstrap/app.php (Laravel 12)
// ══════════════════════════════════════════════════════════════════════════
//
// Di file bootstrap/app.php, tambahkan:
//
// ->withMiddleware(function (Middleware $middleware) {
//     $middleware->alias([
//         'role' => \App\Http\Middleware\RoleMiddleware::class,
//     ]);
// })
//
// ══════════════════════════════════════════════════════════════════════════
// 2. SEEDER — buat akun default semua role
// ══════════════════════════════════════════════════════════════════════════

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name'     => 'Super Admin',
                'email'    => 'superadmin@bpskutim.go.id',
                'password' => Hash::make('superadmin123'),
                'role'     => User::ROLE_SUPER_ADMIN,
            ],
            [
                'name'     => 'Admin Pelayanan',
                'email'    => 'pelayanan@bpskutim.go.id',
                'password' => Hash::make('pelayanan123'),
                'role'     => User::ROLE_ADMIN_PELAYANAN,
            ],
            [
                'name'     => 'Admin Data Statistik',
                'email'    => 'statistik@bpskutim.go.id',
                'password' => Hash::make('statistik123'),
                'role'     => User::ROLE_ADMIN_STATISTIK,
            ],
            [
                'name'     => 'Pengguna Contoh',
                'email'    => 'user@example.com',
                'password' => Hash::make('user12345'),
                'role'     => User::ROLE_USER,
            ],
        ];

        foreach ($users as $data) {
            User::updateOrCreate(['email' => $data['email']], $data);
        }

        $this->command->info('✅ User seeder selesai — 4 akun dibuat.');
    }
}
