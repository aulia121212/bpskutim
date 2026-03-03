<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Collection;

class Header extends Component
{
    public object $user;
    public int $unreadCount;
    public Collection $latestNotifications;
    public array $searchItems;
    public Collection $cartItems;
    public int $cartTotal;   

    public function __construct()
    {
        // Simulasi Data User
        $this->user = (object) [
            'name' => 'Aulia Azizah',
            'email' => 'auliazizahr@dev.test',
            'avatar' => null, 
            'initials' => 'RN',
            'role' => 'Super Admin',
        ];

        $this->unreadCount = 3;

        // Simulasi Data Notifikasi
        $this->latestNotifications = collect([
            (object) [
                'read_at' => null,
                'created_at' => now()->subMinutes(5),
                'data' => [
                    'title' => 'Pesanan Baru',
                    'message' => 'Anda menerima pesanan baru dari Toko Cabang Jakarta.',
                    'icon' => 'ti-shopping-cart',
                    'url' => '#'
                ]
            ],
            (object) [
                'read_at' => null,
                'created_at' => now()->subHour(),
                'data' => [
                    'title' => 'Server Re-boot',
                    'message' => 'Sistem mendeteksi reboot otomatis pada server pusat.',
                    'icon' => 'ti-server',
                    'url' => '#'
                ]
            ],
            (object) [
                'read_at' => now(),
                'created_at' => now()->subDays(1),
                'data' => [
                    'title' => 'Update Aplikasi',
                    'message' => 'Versi v2.4.0 sekarang sudah tersedia untuk dideploy.',
                    'icon' => 'ti-refresh',
                    'url' => '#'
                ]
            ]
        ]);

        // Simulasi Data Search
        $this->searchItems = [
            ['title' => 'Analytics Dashboard', 'category' => 'Page', 'icon' => 'ti-chart-bar', 'url' => route('dashboard.analytics')],
            ['title' => 'E-commerce Overview', 'category' => 'Page', 'icon' => 'ti-shopping-cart', 'url' => route('dashboard.ecommerce')],
            ['title' => 'CRM Management', 'category' => 'Page', 'icon' => 'ti-users', 'url' => route('dashboard.crm')],
            ['title' => 'Macbook Pro M3 Max', 'category' => 'Product', 'icon' => 'ti-device-laptop', 'url' => '#'],
            ['title' => 'Sony WH-1000XM5', 'category' => 'Product', 'icon' => 'ti-headphones', 'url' => '#'],
            ['title' => 'Alex Rivera', 'category' => 'User', 'icon' => 'ti-user', 'url' => '#'],
            ['title' => 'System Settings', 'category' => 'Settings', 'icon' => 'ti-settings', 'url' => '#']
        ];

        // Simulasi Data Keranjang
        $this->cartItems = collect([
            (object) [
                'id' => 1,
                'name' => 'Macbook Pro M3 Max',
                'price' => 52000000,
                'qty' => 1,
                'image' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=100&q=80'
            ],
            (object) [
                'id' => 2,
                'name' => 'Sony WH-1000XM5',
                'price' => 5999000,
                'qty' => 2,
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=100&q=80'
            ]
        ]);

        $this->cartTotal = $this->cartItems->sum(fn($item) => $item->price * $item->qty);
    }

    public function render(): View|Closure|string
    {
        return view('layouts.header');
    }
}