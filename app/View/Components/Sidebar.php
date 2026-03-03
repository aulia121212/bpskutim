<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    public array $menuGroups;

    public function __construct()
    {
        $this->menuGroups = [

            [
                'title' => 'Main',
                'items' => [
                    [
                        'name' => 'Dashboard',
                        'icon' => 'layout-dashboard',
                        'activePattern' => 'dashboard.*',
                        'route' => 'dashboard.index',
                    ],
                ]
            ],

            [
                'title' => 'Manajemen',
                'items' => [
                    [
    'name' => 'Kelola Admin',
    'icon' => 'users',
    'activePattern' => 'superadmin.*',
    'children' => [
        [
            'name' => 'Admin Data Statistik',
            'route' => 'superadmin.admin-data-statistik.index',
            'activePattern' => 'superadmin.admin-data-statistik.*'
        ],
        [
            'name' => 'Admin Pelayanan',
            'route' => 'superadmin.admin-pelayanan.index',
            'activePattern' => 'superadmin.admin-pelayanan.*'
        ],
    ]
],

                     [
                        'name' => 'Data Statistik',
                        'icon' => 'chart-line',
                        'activePattern' => 'statistik.*',
                        'route' => 'statistik.index',
                    ],
                    [
                        'name' => 'Pelayanan',
                        'icon' => 'calendar-event',
                        'activePattern' => 'pelayanan.*',
                        'route' => 'pelayanan.index',
                    ],
                ]
            ],

            [
                'title' => 'Pengaturan',
                'items' => [
                    [
                        'name' => 'Profil',
                        'icon' => 'user-circle',
                        'activePattern' => 'profile',
                        'route' => 'profile',
                    ],
                ]
            ],

            [
                'title' => 'Pengaturan',
                'items' => [
                    [
                        'name' => 'Profil',
                        'icon' => 'user-circle',
                        'activePattern' => 'profile',
                        'route' => 'profile',
                    ],
                ]
            ],
        ];
    }

    public function render(): View|Closure|string
    {
        return view('layouts.sidebar');
    }
}