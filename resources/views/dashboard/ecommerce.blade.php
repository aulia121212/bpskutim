@extends('layouts.app')

@section('title', 'E-commerce Overview')

@section('content')
    <div class="space-y-8 pb-12">

        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-semibold text-gray-900 dark:text-white tracking-tight">E-commerce Dashboard</h1>
                <p class="text-gray-500 dark:text-gray-400 font-medium text-sm">Ringkasan penjualan, inventaris, dan performa
                    toko Anda hari ini.</p>
            </div>

            <div class="flex items-center gap-3">
                <x-button variant="secondary" icon="calendar">Laporan Bulanan</x-button>
                <x-button variant="primary" icon="shopping-cart">Tambah Produk</x-button>
            </div>
        </div>

        {{-- Stats Grid: Enhanced with Custom Background & Layered Effects --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $ecomStats = [
                    [
                        'label' => 'Total Penjualan',
                        'value' => 'Rp 142.8M',
                        'growth' => '+15.4%',
                        'icon' => 'ti-shopping-bag',
                        'bg' => 'from-indigo-600/20 via-indigo-600/5 to-transparent',
                        'color' => 'indigo',
                    ],
                    [
                        'label' => 'Pesanan Baru',
                        'value' => '856',
                        'growth' => '+42',
                        'icon' => 'ti-package',
                        'bg' => 'from-sky-500/20 via-sky-500/5 to-transparent',
                        'color' => 'sky',
                    ],
                    [
                        'label' => 'Produk Terjual',
                        'value' => '2,410',
                        'growth' => '+12%',
                        'icon' => 'ti-box',
                        'bg' => 'from-emerald-500/20 via-emerald-500/5 to-transparent',
                        'color' => 'emerald',
                    ],
                    [
                        'label' => 'Rata-rata Keranjang',
                        'value' => 'Rp 165k',
                        'growth' => '-2.4%',
                        'icon' => 'ti-shopping-cart-discount',
                        'bg' => 'from-rose-500/20 via-rose-500/5 to-transparent',
                        'color' => 'rose',
                    ],
                ];
            @endphp

            @foreach ($ecomStats as $stat)
                <x-card
                    class="group relative overflow-hidden border-none shadow-none bg-white dark:bg-gray-900 hover:scale-[1.02] transition-all duration-500">
                    <div
                        class="absolute inset-0 bg-gradient-to-br {{ $stat['bg'] }} opacity-40 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div
                        class="absolute -right-6 -bottom-6 opacity-[0.03] dark:opacity-[0.07] group-hover:scale-150 group-hover:-rotate-12 transition-transform duration-700">
                        <i class="ti {{ $stat['icon'] }} text-[10rem]"></i>
                    </div>

                    <div class="relative z-10 flex flex-col gap-5">
                        <div class="flex items-center justify-between">
                            <div class="relative">
                                <div
                                    class="absolute inset-0 bg-{{ $stat['color'] }}-500/20 blur-xl rounded-full opacity-0 group-hover:opacity-100 transition-opacity">
                                </div>
                                <div
                                    class="w-14 h-14 rounded-2xl bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-center text-{{ $stat['color'] }}-500 transition-all duration-500 group-hover:rotate-[10deg] group-hover:shadow-{{ $stat['color'] }}-500/20 group-hover:shadow-lg relative z-10">
                                    <i class="ti {{ $stat['icon'] }} text-3xl"></i>
                                </div>
                            </div>

                            <span
                                class="flex items-center gap-1 text-xs font-bold px-2.5 py-1 rounded-full bg-white/80 dark:bg-gray-800/80 backdrop-blur-md shadow-sm text-{{ str_contains($stat['growth'], '+') ? 'emerald' : 'rose' }}-500 border border-gray-100 dark:border-gray-700">
                                <i class="ti ti-trending-{{ str_contains($stat['growth'], '+') ? 'up' : 'down' }}"></i>
                                {{ str_replace(['+', '-'], '', $stat['growth']) }}
                            </span>
                        </div>

                        <div class="space-y-1">
                            <p class="text-sm font-semibold text-gray-400 dark:text-gray-500  leading-none">
                                {{ $stat['label'] }}</p>
                            <h3 class="text-3xl font-bold text-gray-900 dark:text-white">
                                {{ $stat['value'] }}
                            </h3>
                        </div>
                    </div>
                </x-card>
            @endforeach
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Revenue Chart --}}
            <x-card class="lg:col-span-2" title="Grafik Pendapatan">
                <div class="relative h-[380px] mt-4">
                    <canvas id="revenueChart"></canvas>
                </div>
            </x-card>

            {{-- Top Selling Products --}}
            <x-card title="Produk Terlaris">
                <div class="space-y-5 mt-4">
                    @foreach ([['name' => 'Nike Air Max 270', 'sales' => '412', 'stock' => '12', 'price' => 'Rp 2.1M', 'img' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=200'], ['name' => 'Apple Watch Series 7', 'sales' => '325', 'stock' => '0', 'price' => 'Rp 5.4M', 'img' => 'https://images.unsplash.com/photo-1546868871-7041f2a55e12?q=80&w=200'], ['name' => 'Sony WH-1000XM4', 'sales' => '210', 'stock' => '45', 'price' => 'Rp 3.8M', 'img' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=200'], ['name' => 'Logitech G Pro X', 'sales' => '185', 'stock' => '28', 'price' => 'Rp 1.2M', 'img' => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?q=80&w=200']] as $product)
                        <div class="flex items-center gap-4 group cursor-pointer">
                            <div class="relative flex-shrink-0">
                                <img src="{{ $product['img'] }}"
                                    class="w-14 h-14 rounded-2xl object-cover ring-2 ring-transparent group-hover:ring-indigo-500/20 transition-all">
                                @if ($product['stock'] == 0)
                                    <div
                                        class="absolute inset-0 bg-rose-500/60 rounded-2xl flex items-center justify-center">
                                        <span
                                            class="text-[8px] font-bold text-white uppercase tracking-tighter">Habis</span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4
                                    class="text-sm font-semibold text-gray-900 dark:text-white truncate group-hover:text-indigo-600 transition-colors">
                                    {{ $product['name'] }}</h4>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-tight">
                                    {{ $product['sales'] }} Terjual • Stok: {{ $product['stock'] }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $product['price'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <x-slot:footer>
                    <x-button variant="secondary" class="w-full text-xs font-semibold py-3">Kelola Inventaris</x-button>
                </x-slot:footer>
            </x-card>
        </div>

        {{-- Transaction Table --}}
        <x-card title="Transaksi Terkini">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-800">
                            <th class="pb-4 text-sm font-semibold text-gray-400 px-4">ID Pesanan</th>
                            <th class="pb-4 text-sm font-semibold text-gray-400">Pelanggan</th>
                            <th class="pb-4 text-sm font-semibold text-gray-400 text-center">Status</th>
                            <th class="pb-4 text-sm font-semibold text-gray-400 text-right px-4">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-gray-800/50">
                        @foreach ([['id' => '#ORD-7721', 'user' => 'Rizky Pratama', 'status' => 'Selesai', 'color' => 'emerald', 'total' => 'Rp 2.450.000'], ['id' => '#ORD-7722', 'user' => 'Dewi Anggraini', 'status' => 'Dikirim', 'color' => 'indigo', 'total' => 'Rp 890.000'], ['id' => '#ORD-7723', 'user' => 'Budi Santoso', 'status' => 'Proses', 'color' => 'amber', 'total' => 'Rp 1.120.000'], ['id' => '#ORD-7724', 'user' => 'Siti Aminah', 'status' => 'Dibatalkan', 'color' => 'rose', 'total' => 'Rp 450.000']] as $order)
                            <tr class="group hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-all">
                                <td class="py-4 px-4 text-sm font-bold text-indigo-600 group-hover:underline">
                                    {{ $order['id'] }}</td>
                                <td class="py-4 text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    {{ $order['user'] }}</td>
                                <td class="py-4 text-center">
                                 @php
    $statusVariantMap = [
        'Selesai'    => 'success',
        'Dikirim'    => 'info',
        'Proses'     => 'warning',
        'Dibatalkan' => 'danger',
    ];
@endphp

                                 @php
    $variant = $statusVariantMap[$order['status']] ?? 'gray';
@endphp

<x-badge
    :variant="$variant"
    type="soft"
    rounded
>
    {{ $order['status'] }}
</x-badge>

                                </td>
                                <td class="py-4 px-4 text-right text-sm font-bold text-gray-900 dark:text-white">
                                    {{ $order['total'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-card>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctxRev = document.getElementById('revenueChart').getContext('2d');
            const revGradient = ctxRev.createLinearGradient(0, 0, 0, 400);
            revGradient.addColorStop(0, 'rgba(79, 70, 229, 0.4)');
            revGradient.addColorStop(1, 'rgba(79, 70, 229, 0)');

            new Chart(ctxRev, {
                type: 'line',
                data: {
                    labels: ['01 Jan', '02 Jan', '03 Jan', '04 Jan', '05 Jan', '06 Jan', '07 Jan'],
                    datasets: [{
                        label: 'Revenue',
                        data: [12000000, 15000000, 11000000, 19000000, 24000000, 21000000,
                            28000000],
                        borderColor: '#4f46e5',
                        borderWidth: 4,
                        tension: 0.4,
                        fill: true,
                        backgroundColor: revGradient,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: '#4f46e5',
                        pointHoverBorderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#111827',
                            padding: 12,
                            cornerRadius: 12,
                            titleFont: {
                                weight: 'bold'
                            }
                        }
                    },
                    scales: {
                        y: {
                            grid: {
                                color: 'rgba(156, 163, 175, 0.05)',
                                drawBorder: false
                            },
                            ticks: {
                                color: '#9ca3af',
                                callback: v => 'Rp' + v / 1000000 + 'jt'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#9ca3af'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush