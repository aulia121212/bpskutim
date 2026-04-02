<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name'         => 'Super Admin',
                'email'        => 'superadmin@bpskutim.go.id',
                'password'     => Hash::make('superadmin123'),
                'role'         => User::ROLE_SUPER_ADMIN,
                'no_whatsapp'  => '081111111111',
                'instansi'     => 'BPS Kutai Timur',
                'jabatan'      => 'Kepala Admin',
                'tim'          => 'IT',
                'alamat'       => 'Kutai Timur',
                'is_active'    => true,
            ],
            [
                'name'         => 'Admin Pelayanan',
                'email'        => 'pelayanan@bpskutim.go.id',
                'password'     => Hash::make('pelayanan123'),
                'role'         => User::ROLE_ADMIN_PELAYANAN,
                'no_whatsapp'  => '082222222222',
                'instansi'     => 'BPS Kutai Timur',
                'jabatan'      => 'Petugas Layanan',
                'tim'          => 'Pelayanan',
                'alamat'       => 'Sangatta',
                'is_active'    => true,
            ],
            [
                'name'         => 'Admin Data Statistik',
                'email'        => 'statistik@bpskutim.go.id',
                'password'     => Hash::make('statistik123'),
                'role'         => User::ROLE_ADMIN_STATISTIK,
                'no_whatsapp'  => '083333333333',
                'instansi'     => 'BPS Kutai Timur',
                'jabatan'      => 'Staff Statistik',
                'tim'          => 'Data',
                'alamat'       => 'Sangatta',
                'is_active'    => true,
            ],
            [
                'name'         => 'Pengguna Contoh',
                'email'        => 'user@example.com',
                'password'     => Hash::make('user12345'),
                'role'         => User::ROLE_USER,
                'no_whatsapp'  => '084444444444',
                'instansi'     => 'Umum',
                'jabatan'      => '-',
                'tim'          => '-',
                'alamat'       => '-',
                'is_active'    => true,
            ],
        ];

        foreach ($users as $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                $data
            );
        }

        $this->command->info('✅ User seeder selesai — 4 akun lengkap dibuat.');
    }
}