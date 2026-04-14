<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;  
use App\View\Composers\SidebarMenuComposer; 
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
   public function boot(): void
    {
        // Daftarkan SidebarMenuComposer untuk semua view yang menyertakan
        // komponen sidebar. Ganti 'components.sidebar' dengan nama view-mu.
        //
        // Jika sidebar di-include via @include('components.sidebar')
        //   → pakai: View::composer('components.sidebar', SidebarMenuComposer::class);
        //
        // Jika sidebar ada di dalam layout utama, misalnya layouts.app
        //   → pakai: View::composer('layouts.app', SidebarMenuComposer::class);
        //
        // Atau pakai wildcard '*' agar berlaku di semua view (paling aman):
        //   → View::composer('*', SidebarMenuComposer::class);
 
        View::composer('layouts.sidebar', SidebarMenuComposer::class);
 
        // Tambahkan view lain jika sidebar di-include di beberapa tempat berbeda:
        // View::composer(['layouts.admin', 'layouts.app'], SidebarMenuComposer::class);
    }

    
}
