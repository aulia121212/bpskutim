@extends('layouts.app')

@section('title', 'Badges Component')

@section('content')
<div class="space-y-10 pb-20">
    {{-- Page Header --}}
    <div class="flex flex-col gap-2">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Badges</h1>
        <p class="text-gray-500 dark:text-gray-400 font-medium text-sm">Indikator status kecil yang digunakan untuk menonjolkan informasi atau kategori produk.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        {{-- SECTION 1: SOFT STYLE --}}
        <x-card title="Soft">
            <div class="flex flex-wrap gap-3">
                <x-badge variant="primary">Primary</x-badge>
                <x-badge variant="success">Success</x-badge>
                <x-badge variant="danger">Danger</x-badge>
                <x-badge variant="warning">Warning</x-badge>
                <x-badge variant="info">Info</x-badge>
                <x-badge variant="gray">Gray</x-badge>
            </div>
        </x-card>

        {{-- SECTION 2: SOLID STYLE --}}
        <x-card title="Solid Style">
            <div class="flex flex-wrap gap-3">
                <x-badge variant="primary" type="solid">Primary</x-badge>
                <x-badge variant="success" type="solid">Success</x-badge>
                <x-badge variant="danger" type="solid">Danger</x-badge>
                <x-badge variant="warning" type="solid">Warning</x-badge>
                <x-badge variant="info" type="solid">Info</x-badge>
                <x-badge variant="gray" type="solid">Gray</x-badge>
            </div>
        </x-card>

        {{-- SECTION 3: OUTLINE STYLE --}}
        <x-card title="Outline Style">
            <div class="flex flex-wrap gap-3">
                <x-badge variant="primary" type="outline">Primary</x-badge>
                <x-badge variant="success" type="outline">Success</x-badge>
                <x-badge variant="danger" type="outline">Danger</x-badge>
                <x-badge variant="warning" type="outline">Warning</x-badge>
                <x-badge variant="info" type="outline">Info</x-badge>
                <x-badge variant="gray" type="outline">Gray</x-badge>
            </div>
        </x-card>

        {{-- SECTION 4: WITH ICONS --}}
        <x-card title="With Icons">
            <div class="flex flex-wrap gap-3">
                <x-badge variant="success" icon="circle-check">Verified</x-badge>
                <x-badge variant="danger" type="solid" icon="alert-triangle">Error</x-badge>
                <x-badge variant="warning" type="soft" icon="clock">Pending</x-badge>
                <x-badge variant="primary" type="outline" icon="star">Premium</x-badge>
            </div>
        </x-card>

        {{-- SECTION 5: SIZES --}}
        <x-card title="Badge Sizes" class="lg:col-span-2">
            <div class="flex items-center flex-wrap gap-10">
                <div class="flex flex-col items-center gap-3">
                    <x-badge size="sm" variant="primary">Small Badge</x-badge>
                    <span class="text-[10px] font-bold text-gray-400">Size: SM</span>
                </div>
                <div class="flex flex-col items-center gap-3">
                    <x-badge size="md" variant="primary">Medium Badge</x-badge>
                    <span class="text-[10px] font-bold text-gray-400">Size: MD</span>
                </div>
                <div class="flex flex-col items-center gap-3">
                    <x-badge size="lg" variant="primary">Large Badge</x-badge>
                    <span class="text-[10px] font-bold text-gray-400">Size: LG</span>
                </div>
            </div>
        </x-card>

        {{-- SECTION 6: E-COMMERCE USE CASES --}}
        <x-card title="Real World Use Cases" class="lg:col-span-2" :padding="false">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/50">
                            <th class="py-4 px-8 text-xs font-semibold text-gray-400">Order ID</th>
                            <th class="py-4 px-8 text-xs font-semibold text-gray-400">Status</th>
                            <th class="py-4 px-8 text-xs font-semibold text-gray-400">Inventory</th>
                            <th class="py-4 px-8 text-xs font-semibold text-gray-400">Payment</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="py-5 px-8 text-sm font-bold dark:text-white">#ORD-001</td>
                            <td class="py-5 px-8"><x-badge variant="info" icon="truck">Shipped</x-badge></td>
                            <td class="py-5 px-8"><x-badge variant="success" type="solid" size="sm">In Stock</x-badge></td>
                            <td class="py-5 px-8"><x-badge variant="success" type="outline">Paid</x-badge></td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="py-5 px-8 text-sm font-bold dark:text-white">#ORD-002</td>
                            <td class="py-5 px-8"><x-badge variant="warning" icon="rotate-2">Processing</x-badge></td>
                            <td class="py-5 px-8"><x-badge variant="warning" type="solid" size="sm">Low Stock</x-badge></td>
                            <td class="py-5 px-8"><x-badge variant="danger" type="outline">Unpaid</x-badge></td>
                        </tr>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="py-5 px-8 text-sm font-bold dark:text-white">#ORD-003</td>
                            <td class="py-5 px-8"><x-badge variant="danger" icon="x">Cancelled</x-badge></td>
                            <td class="py-5 px-8"><x-badge variant="danger" type="solid" size="sm">Out of Stock</x-badge></td>
                            <td class="py-5 px-8"><x-badge variant="gray" type="outline">Refunded</x-badge></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </x-card>

    </div>
</div>
@endsection