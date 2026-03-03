@extends('layouts.app')

@section('title', 'Widgets Component')

@section('content')
<div class="space-y-10 pb-20">
    {{-- Page Header --}}
    <div class="flex flex-col gap-1">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Widgets</h1>
        <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Kumpulan blok UI untuk menampilkan data statistik dan ringkasan informasi secara cepat.</p>
    </div>

    {{-- 1. Mini Stats Widgets --}}
    <section class="space-y-4">
        <h3 class="text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">Mini Statistics</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Stat 1 --}}
            <x-card>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-500/10 flex items-center justify-center text-indigo-600">
                        <i class="ti ti-currency-dollar text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase">Total Profit</p>
                        <h4 class="text-xl font-bold text-gray-900 dark:text-white">$12,840</h4>
                    </div>
                </div>
            </x-card>

            {{-- Stat 2 --}}
            <x-card>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center text-emerald-600">
                        <i class="ti ti-shopping-cart text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase">New Orders</p>
                        <h4 class="text-xl font-bold text-gray-900 dark:text-white">572</h4>
                    </div>
                </div>
            </x-card>

            {{-- Stat 3 --}}
            <x-card>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-rose-50 dark:bg-rose-500/10 flex items-center justify-center text-rose-600">
                        <i class="ti ti-users text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase">Active Users</p>
                        <h4 class="text-xl font-bold text-gray-900 dark:text-white">1,204</h4>
                    </div>
                </div>
            </x-card>

            {{-- Stat 4 --}}
            <x-card>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-500/10 flex items-center justify-center text-amber-600">
                        <i class="ti ti-star text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase">Avg. Rating</p>
                        <h4 class="text-xl font-bold text-gray-900 dark:text-white">4.9</h4>
                    </div>
                </div>
            </x-card>
        </div>
    </section>

    {{-- 2. Interactive & List Widgets --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- Progress Widget --}}
        <x-card title="Project Completion">
            <div class="space-y-6">
                @php
                    $projects = [
                        ['name' => 'UI Design System', 'progress' => 85, 'color' => 'bg-indigo-600'],
                        ['name' => 'API Integration', 'progress' => 42, 'color' => 'bg-rose-500'],
                        ['name' => 'Database Setup', 'progress' => 100, 'color' => 'bg-emerald-500'],
                    ];
                @endphp
                @foreach($projects as $project)
                <div class="space-y-2">
                    <div class="flex justify-between items-center text-xs font-bold">
                        <span class="text-gray-900 dark:text-white">{{ $project['name'] }}</span>
                        <span class="text-gray-400">{{ $project['progress'] }}%</span>
                    </div>
                    <div class="h-2 w-full bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
                        <div class="{{ $project['color'] }} h-full" style="width: {{ $project['progress'] }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </x-card>

        {{-- Activity Widget --}}
        <x-card title="Recent Activity">
            <div class="space-y-6 relative before:absolute before:left-[19px] before:top-2 before:bottom-2 before:w-px before:bg-gray-100 dark:before:bg-gray-800">
                <div class="relative flex gap-4">
                    <div class="z-10 w-10 h-10 rounded-full bg-white dark:bg-gray-900 border-2 border-indigo-600 flex items-center justify-center">
                        <i class="ti ti-plus text-indigo-600 text-sm"></i>
                    </div>
                    <div class="flex-1 pt-1">
                        <p class="text-sm font-bold text-gray-900 dark:text-white">New product added</p>
                        <p class="text-xs text-gray-400">2 minutes ago</p>
                    </div>
                </div>
                <div class="relative flex gap-4">
                    <div class="z-10 w-10 h-10 rounded-full bg-white dark:bg-gray-900 border-2 border-emerald-500 flex items-center justify-center">
                        <i class="ti ti-check text-emerald-500 text-sm"></i>
                    </div>
                    <div class="flex-1 pt-1">
                        <p class="text-sm font-bold text-gray-900 dark:text-white">Payout successful</p>
                        <p class="text-xs text-gray-400">1 hour ago</p>
                    </div>
                </div>
                <div class="relative flex gap-4">
                    <div class="z-10 w-10 h-10 rounded-full bg-white dark:bg-gray-900 border-2 border-amber-500 flex items-center justify-center">
                        <i class="ti ti-message text-amber-500 text-sm"></i>
                    </div>
                    <div class="flex-1 pt-1">
                        <p class="text-sm font-bold text-gray-900 dark:text-white">New review received</p>
                        <p class="text-xs text-gray-400">Yesterday</p>
                    </div>
                </div>
            </div>
        </x-card>

        {{-- Upgrade Card (Call to Action) --}}
        <x-card class="bg-indigo-600 border-none relative overflow-hidden">
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
            <div class="relative z-10 space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center text-white">
                    <i class="ti ti-rocket text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-white leading-tight">Buka Fitur <br> Premium Sekarang</h3>
                <p class="text-indigo-100 text-xs leading-relaxed">Dapatkan akses ke analytics yang lebih dalam dan laporan custom untuk bisnis Anda.</p>
                <x-button variant="secondary" class="w-full justify-center rounded-xl bg-white text-indigo-600 border-none hover:bg-indigo-50">
                    Upgrade Pro
                </x-button>
            </div>
        </x-card>

    </div>

    {{-- 3. Notification & Status Widgets --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <x-card title="System Health" :padding="false">
            <div class="divide-y divide-gray-50 dark:divide-gray-800">
                <div class="p-6 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <i class="ti ti-server text-indigo-500"></i>
                        <span class="text-sm font-bold dark:text-white">Main Server</span>
                    </div>
                    <x-badge variant="success" type="soft">Operational</x-badge>
                </div>
                <div class="p-6 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <i class="ti ti-database text-rose-500"></i>
                        <span class="text-sm font-bold dark:text-white">PostgreSQL DB</span>
                    </div>
                    <x-badge variant="danger" type="soft">High Load</x-badge>
                </div>
                <div class="p-6 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <i class="ti ti-cloud-lock text-emerald-500"></i>
                        <span class="text-sm font-bold dark:text-white">SSL Certificate</span>
                    </div>
                    <x-badge variant="success" type="soft">Valid</x-badge>
                </div>
            </div>
        </x-card>

        <x-card title="Quick Storage">
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-gray-800 flex items-center justify-center">
                            <i class="ti ti-folders text-indigo-600"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold dark:text-white">Google Drive</p>
                            <p class="text-[10px] text-gray-400">85GB of 100GB used</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-indigo-600">85%</span>
                </div>
                <div class="h-2 w-full bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
                    <div class="bg-indigo-600 h-full" style="width: 85%"></div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <x-button variant="secondary" size="sm" class="justify-center rounded-xl">Manage</x-button>
                    <x-button variant="primary" size="sm" class="justify-center rounded-xl">Upgrade</x-button>
                </div>
            </div>
        </x-card>
    </div>
</div>
@endsection