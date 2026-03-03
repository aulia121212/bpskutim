@extends('layouts.app')

@section('title', 'Analytics Overview')

@section('content')
<div class="space-y-8 pb-12" x-data="{ range: '7days' }">
    
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Analytics Dashboard</h1>
            <p class="text-gray-500 dark:text-gray-400 font-medium text-sm sm:text-base">Pantau performa sistem dan trafik Laravael secara real-time.</p>
        </div>
        
        <div class="flex items-center gap-3">
            <x-select x-model="range" name="range" :placeholder="null" class="w-48">
                <option value="24h">24 Jam Terakhir</option>
                <option value="7days">7 Hari Terakhir</option>
                <option value="30days">30 Hari Terakhir</option>
            </x-select>
            
            <x-button variant="primary" icon="download">
                Export
            </x-button>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $stats = [
                ['label' => 'Total Pengunjung', 'value' => '48.2k', 'growth' => '+12%', 'icon' => 'ti-users', 'color' => 'indigo'],
                ['label' => 'Sesi Aktif', 'value' => '1.240', 'growth' => '+5%', 'icon' => 'ti-activity-heartbeat', 'color' => 'emerald'],
                ['label' => 'Bounce Rate', 'value' => '24.8%', 'growth' => '-2%', 'icon' => 'ti-chart-bubble', 'color' => 'rose'],
                ['label' => 'Durasi Rata-rata', 'value' => '4m 32s', 'growth' => '+18%', 'icon' => 'ti-clock-play', 'color' => 'amber'],
            ];
        @endphp

        @foreach($stats as $stat)
        <x-card class="group hover:border-indigo-500 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-{{ $stat['color'] }}-500/10 flex items-center justify-center text-{{ $stat['color'] }}-500 transition-transform group-hover:rotate-12">
                    <i class="ti {{ $stat['icon'] }} text-2xl"></i>
                </div>
                <span class="text-[10px] font-bold px-2.5 py-1 rounded-full bg-{{ str_contains($stat['growth'], '+') ? 'emerald' : 'rose' }}-500/10 text-{{ str_contains($stat['growth'], '+') ? 'emerald' : 'rose' }}-500 uppercase">
                    {{ $stat['growth'] }}
                </span>
            </div>
            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-widest">{{ $stat['label'] }}</p>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $stat['value'] }}</h3>
        </x-card>
        @endforeach
    </div>

    {{-- Main Charts Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Traffic Chart --}}
        <x-card class="lg:col-span-2 min-h-[450px] flex flex-col">
            <x-slot:header>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white leading-none">Trafik Kunjungan</h3>
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-indigo-500 shadow-[0_0_10px_rgba(79,70,229,0.5)]"></span>
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Unique Visitors</span>
                </div>
            </x-slot:header>
            <div class="relative flex-1 w-full min-h-[300px] mt-4">
                <canvas id="trafficChart"></canvas>
            </div>
        </x-card>

        {{-- Browser Chart --}}
        <x-card class="flex flex-col">
            <x-slot:header>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white leading-none">Top Browsers</h3>
            </x-slot:header>
            <div class="relative flex-1 flex items-center justify-center min-h-[220px] mt-4">
                <canvas id="browserChart"></canvas>
            </div>
            <div class="mt-8 space-y-2">
                @foreach([
                    ['label' => 'Google Chrome', 'pct' => '58%', 'color' => 'bg-indigo-600', 'icon' => 'brand-chrome'],
                    ['label' => 'Safari', 'pct' => '24%', 'color' => 'bg-indigo-400', 'icon' => 'brand-safari'],
                    ['label' => 'Firefox', 'pct' => '12%', 'color' => 'bg-indigo-200', 'icon' => 'brand-firefox'],
                ] as $browser)
                <div class="flex items-center justify-between p-3 rounded-2xl bg-gray-50/50 dark:bg-gray-900/50 transition-colors group">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-white dark:bg-gray-800 flex items-center justify-center shadow-sm">
                            <i class="ti ti-{{ $browser['icon'] }} text-gray-600 dark:text-gray-400"></i>
                        </div>
                        <span class="text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ $browser['label'] }}</span>
                    </div>
                    <span class="text-sm font-black dark:text-white">{{ $browser['pct'] }}</span>
                </div>
                @endforeach
            </div>
        </x-card>
    </div>

    {{-- Bottom Analytics Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Top Pages Table --}}
        <x-card title="Halaman Terpopuler">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-gray-50 dark:border-gray-800">
                            <th class="pb-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Halaman</th>
                            <th class="pb-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Kunjungan</th>
                            <th class="pb-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Bounce</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-800">
                        @foreach([
                            ['url' => '/dashboard', 'views' => '12,402', 'bounce' => '12%'],
                            ['url' => '/analytics/overview', 'views' => '8,290', 'bounce' => '18%'],
                            ['url' => '/products/v2/catalog', 'views' => '5,100', 'bounce' => '24%'],
                            ['url' => '/auth/login-cover', 'views' => '4,020', 'bounce' => '8%'],
                        ] as $page)
                        <tr class="group">
                            <td class="py-4">
                                <span class="text-sm font-bold text-gray-700 dark:text-gray-300 group-hover:text-indigo-600 transition-colors">{{ $page['url'] }}</span>
                            </td>
                            <td class="py-4 text-right">
                                <span class="text-sm font-black dark:text-white">{{ $page['views'] }}</span>
                            </td>
                            <td class="py-4 text-right">
                                <span class="text-xs font-bold text-emerald-500">{{ $page['bounce'] }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-card>

        {{-- Geolocation Bar Chart --}}
        <x-card title="Geografi Pengguna">
            <div class="space-y-6">
                @foreach([
                    ['country' => 'Indonesia', 'flag' => 'ID', 'count' => '45.2k', 'pct' => 85, 'color' => 'bg-indigo-600'],
                    ['country' => 'United States', 'flag' => 'US', 'count' => '5.1k', 'pct' => 45, 'color' => 'bg-indigo-400'],
                    ['country' => 'Singapore', 'flag' => 'SG', 'count' => '2.4k', 'pct' => 25, 'color' => 'bg-indigo-300'],
                    ['country' => 'Malaysia', 'flag' => 'MY', 'count' => '1.2k', 'pct' => 15, 'color' => 'bg-indigo-200'],
                ] as $geo)
                <div class="space-y-2">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $geo['country'] }}</span>
                        </div>
                        <span class="text-[11px] font-black dark:text-white">{{ $geo['count'] }}</span>
                    </div>
                    <div class="h-2 w-full bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
                        <div class="{{ $geo['color'] }} h-full rounded-full transition-all duration-1000" style="width: {{ $geo['pct'] }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </x-card>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modernTooltip = {
            enabled: true,
            backgroundColor: '#111827',
            padding: 16,
            cornerRadius: 16,
            titleFont: { family: 'Inter', size: 12 },
            bodyFont: { family: 'Inter', size: 14, weight: 'bold' }
        };

        // --- TRAFFIC CHART ---
        const ctxTraffic = document.getElementById('trafficChart').getContext('2d');
        const trafficGradient = ctxTraffic.createLinearGradient(0, 0, 0, 400);
        trafficGradient.addColorStop(0, 'rgba(79, 70, 229, 0.3)');
        trafficGradient.addColorStop(1, 'rgba(79, 70, 229, 0)');

        new Chart(ctxTraffic, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    data: [18500, 22000, 19500, 32000, 28000, 45000, 42000],
                    borderColor: '#4f46e5',
                    borderWidth: 4,
                    fill: true,
                    backgroundColor: trafficGradient,
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false }, tooltip: modernTooltip },
                scales: {
                    y: { grid: { color: 'rgba(0,0,0,0.03)' }, ticks: { callback: v => v/1000 + 'k' } },
                    x: { grid: { display: false } }
                }
            }
        });

        // --- BROWSER CHART ---
        new Chart(document.getElementById('browserChart'), {
            type: 'doughnut',
            data: {
                labels: ['Chrome', 'Safari', 'Firefox', 'Others'],
                datasets: [{
                    data: [58, 24, 12, 6],
                    backgroundColor: ['#4f46e5', '#818cf8', '#c7d2fe', '#e5e7eb'],
                    borderWidth: 0,
                    borderRadius: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '80%',
                plugins: { legend: { display: false }, tooltip: modernTooltip }
            }
        });
    });
</script>
@endpush