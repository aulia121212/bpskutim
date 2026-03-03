@extends('layouts.app')

@section('title', 'Point of Sale')

@section('content')
    <div class="flex flex-col lg:flex-row gap-8 h-full" x-data="{
        search: '',
        cart: [],
        get total() {
            return this.cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
        },
        init() {
            if (window.innerWidth >= 1280) {
                $store.sidebar.isExpanded = false;
            }
        },
        addToCart(product) {
            let found = this.cart.find(i => i.id === product.id);
            if (found) {
                found.qty++;
            } else {
                this.cart.push({ ...product, qty: 1 });
            }
        },
        removeFromCart(id) {
            this.cart = this.cart.filter(i => i.id !== id);
        },
        formatPrice(n) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(n);
        }
    }">

        {{-- Sisi Kiri: Katalog Produk --}}
        <div class="flex-1 space-y-6">
            {{-- POS Header & Search --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Terminal Kasir</h1>
                    <p class="text-sm text-gray-500">Pilih produk untuk ditambahkan ke pesanan.</p>
                </div>
                <div class="relative w-full sm:w-72">
                    <i class="ti ti-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" x-model="search" placeholder="Cari nama atau SKU..."
                        class="w-full pl-11 pr-4 py-2.5 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all">
                </div>
            </div>

            {{-- Category Tabs --}}
            <div class="flex items-center gap-3 overflow-x-auto no-scrollbar pb-2">
                <x-button variant="primary" size="sm" class="rounded-xl whitespace-nowrap">Semua</x-button>
                <x-button variant="secondary" size="sm" class="rounded-xl whitespace-nowrap">Makanan</x-button>
                <x-button variant="secondary" size="sm" class="rounded-xl whitespace-nowrap">Minuman</x-button>
                <x-button variant="secondary" size="sm" class="rounded-xl whitespace-nowrap">Snack</x-button>
                <x-button variant="secondary" size="sm" class="rounded-xl whitespace-nowrap">Elektronik</x-button>
            </div>

            {{-- Product Grid --}}
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @php
                    $products = [
                        [
                            'id' => 1,
                            'name' => 'Kopi Susu Gula Aren',
                            'price' => 18000,
                            'img' => 'https://images.unsplash.com/photo-1541167760496-162955ed8a9f?w=200&q=80',
                            'cat' => 'Minuman',
                        ],
                        [
                            'id' => 2,
                            'name' => 'Croissant Almond',
                            'price' => 25000,
                            'img' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=200&q=80',
                            'cat' => 'Makanan',
                        ],
                        [
                            'id' => 3,
                            'name' => 'Earl Grey Tea',
                            'price' => 15000,
                            'img' => 'https://images.unsplash.com/photo-1594631252845-29fc458639a8?w=200&q=80',
                            'cat' => 'Minuman',
                        ],
                        [
                            'id' => 4,
                            'name' => 'Spaghetti Carbonara',
                            'price' => 45000,
                            'img' => 'https://images.unsplash.com/photo-1612459284970-e8f027596582?w=200&q=80',
                            'cat' => 'Makanan',
                        ],
                        [
                            'id' => 5,
                            'name' => 'French Fries',
                            'price' => 20000,
                            'img' => 'https://images.unsplash.com/photo-1630384066242-17a17833f347?w=200&q=80',
                            'cat' => 'Snack',
                        ],
                        [
                            'id' => 6,
                            'name' => 'Cheesecake Slice',
                            'price' => 32000,
                            'img' => 'https://images.unsplash.com/photo-1533134242443-d4fd215305ad?w=200&q=80',
                            'cat' => 'Makanan',
                        ],
                    ];
                @endphp

      @foreach ($products as $p)
        <x-card @click="addToCart({{ json_encode($p) }})"
            class="group bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 cursor-pointer hover:border-indigo-500/50 transition-all hover:shadow-xl hover:shadow-indigo-500/5 active:scale-95">
            
            {{-- Bagian Gambar: Diperbaiki --}}
            <div class="aspect-square w-full rounded-2xl overflow-hidden mb-3 bg-gray-50 dark:bg-gray-800">
                <img src="{{ $p['img'] }}" 
                     class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110" 
                     alt="{{ $p['name'] }}">
            </div>

            <div class="space-y-1">
                <p class="text-[10px] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">
                    {{ $p['cat'] }}
                </p>
                <h3 class="text-sm font-bold text-gray-900 dark:text-white truncate">
                    {{ $p['name'] }}
                </h3>
                <p class="text-sm font-bold text-gray-900 dark:text-white">
                    Rp{{ number_format($p['price'], 0, ',', '.') }}
                </p>
            </div>
        </x-card>
    @endforeach
            </div>
        </div>

        <div class="w-full lg:w-96 shrink-0">
            <div class="sticky top-24">
                <x-card :padding="false" class="flex flex-col h-[calc(100vh-140px)]  overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/30">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-gray-900 dark:text-white">Pesanan Saat Ini</h3>
                            <x-button variant="secondary" class="text-xs font-bold text-rose-500 "
                                @click="cart = []">Reset</x-button>
                        </div>
                        <div
                            class="flex items-center gap-3 p-2 bg-white dark:bg-gray-900 rounded-xl border border-gray-100 dark:border-gray-800">
                            <div
                                class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-500/10 flex items-center justify-center text-indigo-600">
                                <i class="ti ti-user"></i>
                            </div>
                            <span class="text-xs font-bold text-gray-400">Walk-in Customer</span>
                            <i class="ti ti-chevron-down ml-auto text-gray-300"></i>
                        </div>
                    </div>

                    {{-- Order List --}}
                    <div class="flex-1 overflow-y-auto p-6 custom-scrollbar space-y-4">
                        <template x-if="cart.length === 0">
                            <div class="h-full flex flex-col items-center justify-center text-center opacity-30 py-20">
                                <i class="ti ti-shopping-bag text-5xl mb-2"></i>
                                <p class="text-sm font-bold">Belum ada item</p>
                            </div>
                        </template>

                        <template x-for="item in cart" :key="item.id">
                            <div class="flex items-center gap-4 group">
                                <img :src="item.img" class="w-12 h-12 rounded-xl object-cover">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-gray-900 dark:text-white truncate" x-text="item.name">
                                    </p>
                                    <p class="text-[11px] font-bold text-gray-400" x-text="formatPrice(item.price)"></p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button @click="if(item.qty > 1) item.qty--; else removeFromCart(item.id)"
                                        class="w-6 h-6 flex items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-500">-</button>
                                    <span class="text-xs font-bold w-4 text-center" x-text="item.qty"></span>
                                    <button @click="item.qty++"
                                        class="w-6 h-6 flex items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-500">+</button>
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Summary & Checkout --}}
                    <div class="p-6 bg-gray-50 dark:bg-gray-800/30 border-t border-gray-100 dark:border-gray-800 space-y-4">
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 font-medium">Subtotal</span>
                                <span class="font-bold dark:text-white" x-text="formatPrice(total)"></span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500 font-medium">Pajak (10%)</span>
                                <span class="font-bold dark:text-white" x-text="formatPrice(total * 0.1)"></span>
                            </div>
                            <div
                                class="flex justify-between items-center pt-2 border-t border-gray-100 dark:border-gray-800">
                                <span class="font-bold text-gray-900 dark:text-white">Total</span>
                                <span class="text-xl font-black text-indigo-600" x-text="formatPrice(total * 1.1)"></span>
                            </div>
                        </div>

                        <x-button variant="primary" class="w-full " ::disabled="cart.length === 0">
                            Bayar Sekarang <i class="ti ti-arrow-right ml-2"></i>
                        </x-button>
                    </div>
                </x-card>
            </div>
        </div>
    </div>
@endsection