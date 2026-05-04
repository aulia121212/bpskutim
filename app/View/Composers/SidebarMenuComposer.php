<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\User;

class SidebarMenuComposer
{
    
    private function menuForRole(string $role): array
    {
        return match ($role) {
            User::ROLE_SUPER_ADMIN     => $this->menuSuperAdmin(),
            User::ROLE_ADMIN_PELAYANAN => $this->menuAdminPelayanan(),
            User::ROLE_ADMIN_STATISTIK => $this->menuAdminStatistik(),
            default                    => [],
        };
    }


    private function menuSuperAdmin(): array
    {
        return [
            [
                'title' => 'Utama',
                'items' => [
                    [
                        'name'          => 'Dashboard',
                        'icon'          => 'layout-dashboard',
                        'route'         => 'superadmin.dashboard',
                        'activePattern' => 'superadmin.dashboard',
                    ],
                ],
            ],
            [
                'title' => 'Manajemen Admin',
                'items' => [
                    [
                        'name'          => 'Admin Pelayanan',
                        'icon'          => 'users',
                        'route'         => 'superadmin.admin-pelayanan.index',
                        'activePattern' => 'superadmin.admin-pelayanan.*',
                    ],
                    [
                        'name'          => 'Admin Statistik',
                        'icon'          => 'user-check',
                        'route'         => 'superadmin.admin-data-statistik.index',
                        'activePattern' => 'superadmin.admin-data-statistik.*',
                    ],
                    // [
                    //     'name'          => 'Semua Admin',
                    //     'icon'          => 'shield-check',
                    //     'route'         => 'superadmin.admins.index',
                    //     'activePattern' => 'superadmin.admins.*',
                    // ],
                ],
            ],
            [
                'title' => 'Pelayanan',
                'items' => [
                    [
                        'name'          => 'Petugas Konsultasi',
                        'icon'          => 'users-group',
                        'route'         => 'pelayanan.petugas.index',
                        'activePattern' => 'pelayanan.petugas.*',
                    ],
                    [
                        'name'          => 'Jadwal Konsultasi',
                        'icon'          => 'calendar-event',
                        'route'         => 'pelayanan.jadwal.index',
                        'activePattern' => 'pelayanan.jadwal.*',
                    ],
                    [
                        'name'          => 'Reservasi',
                        'icon'          => 'clipboard-list',
                        'route'         => 'pelayanan.reservasi.index',
                        'activePattern' => 'pelayanan.reservasi.*',
                    ],
                    [
                        'name'          => 'Popup Info',
                        'icon'          => 'speakerphone',
                        'route'         => 'pelayanan.popup.index',
                        'activePattern' => 'pelayanan.popup.*',
                    ],
                    [
                        'name'          => 'Data Pengguna',
                        'icon'          => 'user',
                        'route'         => 'pelayanan.user.index',
                        'activePattern' => 'pelayanan.user.*',
                    ],
                ],
            ],
            [
                'title' => 'Data Statistik',
                'items' => [
                    [
                        'name'          => 'Data Statistik',
                        'icon'          => 'chart-bar',
                        'route'         => 'statistics.index',
                        'activePattern' => 'statistics.*',
                    ],
                    [
                        'name'          => 'Judul Statistik',
                        'icon'          => 'list',
                        'route'         => 'statistic-titles.index',
                        'activePattern' => 'statistic-titles.*',
                    ],
                ],
            ],
            [
                'title' => 'Konten',
                'items' => [
                    [
                        'name'          => 'Publikasi',
                        'icon'          => 'file-text',
                        'route'         => 'superadmin.publikasi.index',
                        'activePattern' => 'superadmin.publikasi.*',
                    ],
                ],
            ],
        ];
    }

  
    private function menuAdminPelayanan(): array
    {
        return [
            [
                'title' => 'Utama',
                'items' => [
                    [
                        'name'          => 'Dashboard',
                        'icon'          => 'layout-dashboard',
                        'route'         => 'dashboard.index',
                        'activePattern' => 'dashboard.index',
                    ],
                ],
            ],
            [
                'title' => 'Manajemen Pelayanan',
                'items' => [
                    [
                        'name'          => 'Petugas Konsultasi',
                        'icon'          => 'users-group',
                        'route'         => 'pelayanan.petugas.index',
                        'activePattern' => 'pelayanan.petugas.*',
                    ],
                    [
                        'name'          => 'Jadwal Konsultasi',
                        'icon'          => 'calendar-event',
                        'route'         => 'pelayanan.jadwal.index',
                        'activePattern' => 'pelayanan.jadwal.*',
                    ],
                    [
                        'name'          => 'Reservasi',
                        'icon'          => 'clipboard-list',
                        'route'         => 'pelayanan.reservasi.index',
                        'activePattern' => 'pelayanan.reservasi.*',
                    ],
                    [
                        'name'          => 'Popup Info',
                        'icon'          => 'speakerphone',
                        'route'         => 'pelayanan.popup.index',
                        'activePattern' => 'pelayanan.popup.*',
                    ],
                    [
                        'name'          => 'Data Pengguna',
                        'icon'          => 'user',
                        'route'         => 'pelayanan.user.index',
                        'activePattern' => 'pelayanan.user.*',
                    ],
                ],
            ],
        ];
    }

   
    private function menuAdminStatistik(): array
    {
        return [
            [
                'title' => 'Utama',
                'items' => [
                    [
                        'name'          => 'Dashboard',
                        'icon'          => 'layout-dashboard',
                        'route'         => 'dashboard.index',
                        'activePattern' => 'dashboard.index',
                    ],
                ],
            ],
            [
                'title' => 'Manajemen Data Statistik',
                'items' => [
                    [
                        'name'          => 'Data Statistik',
                        'icon'          => 'chart-bar',
                        'route'         => 'statistics.index',
                        'activePattern' => 'statistics.*',
                    ],
                    [
                        'name'          => 'Judul Statistik',
                        'icon'          => 'list',
                        'route'         => 'statistic-titles.index',
                        'activePattern' => 'statistic-titles.*',
                    ],
                ],
            ],
        ];
    }


    public function compose(View $view): void
    {
        $user = auth()->user();

        if (! $user) {
            $view->with('menuGroups', []);
            return;
        }

        $view->with('menuGroups', $this->menuForRole($user->role));
    }
}