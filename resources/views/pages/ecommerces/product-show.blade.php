@extends('layouts.app')

@section('title', $product['name'] . ' - Detail Produk')

@section('content')
<div class="space-y-8 pb-20" x-data="{ activeTab: 'description' }">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('ecommerce.products.index') }}" 
               class="h-11 w-11 flex items-center justify-center rounded-2xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 text-gray-500 hover:text-indigo-600 transition-all shadow-sm">
                <i class="ti ti-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Detail Produk</h1>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">ID: #PROD-{{ str_pad($product['id'], 5, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('ecommerce.products.edit', $product['id']) }}" 
               class="flex items-center gap-2 px-6 py-2.5 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 text-gray-700 dark:text-gray-300 font-bold rounded-2xl hover:bg-gray-50 dark:hover:bg-gray-800 transition-all text-sm shadow-sm">
                <i class="ti ti-edit text-lg"></i>
                Edit Produk
            </a>
            <x-button variant="primary" class="shadow-lg shadow-indigo-500/20">
                <i class="ti ti-external-link mr-2"></i> Preview Store
            </x-button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <div class="lg:col-span-7 space-y-8">
            <x-card class="overflow-hidden !p-0">
                <div class="aspect-[16/10] relative bg-gray-50 dark:bg-gray-950">
                    <img src="{{ $product['image'] }}" class="w-full h-full object-cover">
                    <div class="absolute top-6 left-6">
                        <span class="px-4 py-2 rounded-2xl text-xs font-black uppercase tracking-widest backdrop-blur-xl border border-white/20 text-white
                            {{ $product['status'] === 'Tersedia' ? 'bg-emerald-500/80' : ($product['status'] === 'Stok Menipis' ? 'bg-amber-500/80' : 'bg-rose-500/80') }}">
                            {{ $product['status'] }}
                        </span>
                    </div>
                </div>
            </x-card>

            <x-card>
                <div class="flex items-center gap-8 border-b border-gray-100 dark:border-gray-800 mb-6">
                    <button @click="activeTab = 'description'" 
                            :class="activeTab === 'description' ? 'text-indigo-600 border-b-2 border-indigo-600 pb-4' : 'text-gray-400 pb-4'"
                            class="text-sm font-bold uppercase tracking-widest transition-all">
                        Deskripsi
                    </button>
                    <button @click="activeTab = 'spec'" 
                            :class="activeTab === 'spec' ? 'text-indigo-600 border-b-2 border-indigo-600 pb-4' : 'text-gray-400 pb-4'"
                            class="text-sm font-bold uppercase tracking-widest transition-all">
                        Spesifikasi
                    </button>
                </div>

                <div x-show="activeTab === 'description'" x-transition>
                    <p class="text-gray-600 dark:text-gray-400 leading-relaxed font-medium">
                        {{ $product['description'] }}
                    </p>
                </div>

                <div x-show="activeTab === 'spec'" x-transition>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach([['label' => 'Berat', 'val' => '1.2 kg'], ['label' => 'Dimensi', 'val' => '30x20x2 cm'], ['label' => 'Warna', 'val' => 'Space Grey'], ['label' => 'Garansi', 'val' => '1 Tahun Resmi']] as $spec)
                        <div class="flex items-center justify-between p-4 rounded-2xl bg-gray-50 dark:bg-gray-900/50">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-tight">{{ $spec['label'] }}</span>
                            <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $spec['val'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </x-card>
        </div>

        <div class="lg:col-span-5 space-y-6">
            <x-card class="bg-gray-800 !border-none relative overflow-hidden group">
                <div class="absolute -right-10 -bottom-10 opacity-10 rotate-12 transition-transform group-hover:rotate-0 duration-700">
                    <i class="ti ti-shopping-bag text-[12rem] text-white"></i>
                </div>
                <div class="relative z-10">
                    <p class="text-xs font-bold text-indigo-100  mb-2">Harga Jual Produk</p>
                    <h2 class="text-4xl font-black text-white tracking-tighter">
                        <span class="text-lg font-bold opacity-70">Rp</span> {{ number_format($product['price'], 0, ',', '.') }}
                    </h2>
                    <div class="mt-6 flex items-center gap-2 px-3 py-1.5 bg-white/10 rounded-xl w-fit">
                        <i class="ti ti-trending-up text-emerald-300"></i>
                        <span class="text-[10px] font-bold text-indigo-50 ">+12% dari bulan lalu</span>
                    </div>
                </div>
            </x-card>

            <div class="grid grid-cols-2 gap-4">
                <x-card class="text-center">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Stok Tersedia</p>
                    <h4 class="text-3xl font-black text-gray-900 dark:text-white tracking-tighter">{{ $product['stock'] }}</h4>
                    <p class="text-[10px] font-bold text-indigo-500 mt-1 uppercase">Unit</p>
                </x-card>
                <x-card class="text-center">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Rating</p>
                    <div class="flex items-center justify-center gap-2">
                        <h4 class="text-3xl font-black text-gray-900 dark:text-white tracking-tighter">{{ $product['rating'] }}</h4>
                        <i class="ti ti-star-filled text-amber-400 text-xl"></i>
                    </div>
                    <p class="text-[10px] font-bold text-gray-400 mt-1 uppercase">Global Score</p>
                </x-card>
            </div>

            <x-card>
                <h4 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-widest mb-6">Inventory Health</h4>
                <div class="space-y-6">
                    <div>
                        <div class="flex justify-between mb-2">
                            <span class="text-xs font-bold text-gray-500 uppercase tracking-tight">Kapasitas Stok</span>
                            <span class="text-xs font-black dark:text-white">{{ $product['stock'] > 0 ? $product['stock'] : '0' }}%</span>
                        </div>
                        <div class="h-2 w-full bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
                            <div class="h-full {{ $product['stock'] > 10 ? 'bg-indigo-600' : 'bg-rose-500' }} rounded-full" style="width: {{ $product['stock'] }}%"></div>
                        </div>
                    </div>
                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-amber-50 dark:bg-amber-500/5 border border-amber-100 dark:border-amber-500/20">
                        <i class="ti ti-bulb text-amber-500 text-xl"></i>
                        <p class="text-xs font-semibold text-amber-700 dark:text-amber-400 leading-relaxed">
                            @if($product['stock'] == 0)
                                Stok produk ini habis. Segera lakukan pengadaan (Restock) untuk menjaga performa penjualan.
                            @elseif($product['stock'] <= 10)
                                Stok menipis. Sistem menyarankan pengadaan baru dalam 2 hari ke depan.
                            @else
                                Performa stok stabil. Belum diperlukan pengadaan tambahan dalam waktu dekat.
                            @endif
                        </p>
                    </div>
                </div>
            </x-card>
        </div>
    </div>
</div>
@endsection