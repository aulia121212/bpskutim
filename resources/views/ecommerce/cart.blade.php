@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="space-y-8 pb-20" x-data="{ 
    cartItems: [
        { id: 1, name: 'Macbook Pro M3 Max', price: 52000000, qty: 1, image: 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=300&q=80', stock: 5 },
        { id: 2, name: 'Sony WH-1000XM5', price: 5999000, qty: 2, image: 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=300&q=80', stock: 12 }
    ],
    get subtotal() {
        return this.cartItems.reduce((total, item) => total + (item.price * item.qty), 0);
    },
    removeItem(id) {
        this.cartItems = this.cartItems.filter(item => item.id !== id);
    },
    formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
    }
}">
    
    {{-- Header --}}
    <div class="flex flex-col gap-1">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Keranjang Belanja</h1>
        <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Tinjau kembali daftar produk pilihan Anda sebelum menyelesaikan pesanan.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        {{-- Sisi Kiri: List Items --}}
        <div class="lg:col-span-8 space-y-4">
            <template x-if="cartItems.length > 0">
                <div class="space-y-4">
                    <template x-for="item in cartItems" :key="item.id">
                        <div class="group bg-white dark:bg-gray-900 p-5 rounded-3xl border border-gray-100 dark:border-gray-800 flex flex-col sm:flex-row items-center gap-6 transition-all hover:border-indigo-500/30 shadow-sm">
                            
                            {{-- Product Image --}}
                            <div class="relative w-full sm:w-28 aspect-square rounded-2xl overflow-hidden bg-gray-50 dark:bg-gray-950 shrink-0 border border-gray-100 dark:border-gray-800">
                                <img :src="item.image" class="w-full h-full object-cover transition-transform group-hover:scale-105 duration-500">
                            </div>

                            {{-- Details --}}
                            <div class="flex-1 min-w-0 text-center sm:text-left">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 transition-colors" x-text="item.name"></h3>
                                <p class="text-sm font-medium text-gray-400 mt-1" x-text="'Harga: ' + formatRupiah(item.price)"></p>
                                <div class="mt-2 flex items-center justify-center sm:justify-start gap-2">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                    <p class="text-xs font-semibold text-emerald-600 dark:text-emerald-400">Tersedia</p>
                                </div>
                            </div>

                            {{-- Quantity Controls --}}
                            <div class="flex items-center gap-4 bg-gray-50 dark:bg-gray-800 p-1.5 rounded-xl border border-gray-100 dark:border-gray-700">
                                <button @click="if(item.qty > 1) item.qty--" class="w-9 h-9 flex items-center justify-center rounded-lg bg-white dark:bg-gray-700 text-gray-500 hover:text-indigo-600 transition-all shadow-sm active:scale-90 border border-gray-100 dark:border-gray-600">
                                    <i class="ti ti-minus"></i>
                                </button>
                                <span class="text-sm font-bold dark:text-white w-8 text-center" x-text="item.qty"></span>
                                <button @click="if(item.qty < item.stock) item.qty++" class="w-9 h-9 flex items-center justify-center rounded-lg bg-white dark:bg-gray-700 text-gray-500 hover:text-indigo-600 transition-all shadow-sm active:scale-90 border border-gray-100 dark:border-gray-600">
                                    <i class="ti ti-plus"></i>
                                </button>
                            </div>

                            {{-- Total & Delete --}}
                            <div class="text-right hidden sm:block min-w-[140px]">
                                <p class="text-lg font-bold text-gray-900 dark:text-white" x-text="formatRupiah(item.price * item.qty)"></p>
                                <button @click="removeItem(item.id)" class="text-sm font-semibold text-rose-500 hover:text-rose-600 mt-1 transition-colors font-medium tracking-tight">Hapus</button>
                            </div>

                            {{-- Mobile Delete --}}
                            <button @click="removeItem(item.id)" class="sm:hidden w-full py-3 text-rose-500 font-bold text-sm border-t border-gray-50 dark:border-gray-800 flex items-center justify-center gap-2">
                                <i class="ti ti-trash"></i> Hapus Produk
                            </button>
                        </div>
                    </template>
                </div>
            </template>

            {{-- Empty State --}}
            <template x-if="cartItems.length === 0">
                <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] p-16 text-center border border-gray-100 dark:border-gray-800 shadow-sm">
                    <div class="w-20 h-20 bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 rounded-3xl flex items-center justify-center mx-auto mb-6">
                        <i class="ti ti-shopping-cart-x text-4xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold dark:text-white mb-2">Keranjang Anda Kosong</h2>
                    <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-xs mx-auto">Sepertinya Anda belum menambahkan produk apapun ke dalam keranjang.</p>
                    <x-button variant="primary" href="{{ route('ecommerce.products.index') }}" class="rounded-2xl px-8 py-3">
                        <i class="ti ti-arrow-left mr-2"></i> Kembali Belanja
                    </x-button>
                </div>
            </template>
        </div>

        {{-- Sisi Kanan: Summary --}}
        <div class="lg:col-span-4 space-y-6" x-show="cartItems.length > 0">
            <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] border border-gray-100 dark:border-gray-800 shadow-xl shadow-gray-200/50 dark:shadow-none overflow-hidden">
                <div class="p-8">
                    <h3 class="text-xl font-bold dark:text-white mb-6">Ringkasan Pesanan</h3>
                    
                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between items-center text-sm font-medium text-gray-500">
                            <span>Subtotal Produk</span>
                            <span class="text-gray-900 dark:text-white font-bold" x-text="formatRupiah(subtotal)"></span>
                        </div>
                        <div class="flex justify-between items-center text-sm font-medium text-gray-500">
                            <span>Biaya Pengiriman</span>
                            <span class="text-emerald-600 font-bold">Gratis Ongkir</span>
                        </div>
                        <div class="pt-4 border-t border-gray-100 dark:border-gray-800 flex justify-between items-center">
                            <span class="font-bold text-gray-900 dark:text-white">Total Bayar</span>
                            <span class="text-2xl font-bold text-indigo-600" x-text="formatRupiah(subtotal)"></span>
                        </div>
                    </div>

                    {{-- Voucher Code Section (Clean version without button) --}}
                    <div class="space-y-2 mb-8">
                        <label class="text-[11px] font-bold text-gray-400 uppercase tracking-wider ml-1">Punya Kode Promo?</label>
                        <div class="relative group">
                            <i class="ti ti-ticket absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-indigo-500 transition-colors"></i>
                            <input type="text" placeholder="Masukkan kode promo di sini..." 
                                class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl pl-11 pr-4 py-3.5 text-sm font-medium outline-none focus:ring-2 focus:ring-indigo-500/20 dark:text-white transition-all">
                        </div>
                    </div>

                    <x-button variant="primary" class="w-full rounded-2xl shadow-lg shadow-indigo-500/25 py-4 flex items-center justify-center gap-2">
                        Lanjut ke Pembayaran <i class="ti ti-arrow-right"></i>
                    </x-button>

                    <div class="mt-6 flex flex-col gap-3">
                        <div class="flex items-center gap-2 text-[11px] text-gray-400 font-medium justify-center bg-gray-50 dark:bg-gray-800/50 py-2 rounded-xl border border-gray-100 dark:border-gray-800">
                            <i class="ti ti-shield-check text-indigo-500 text-sm"></i> 
                            Transaksi Aman & Terenkripsi
                        </div>
                    </div>
                </div>
            </div>

            {{-- Support Card --}}
            <div class="p-6 rounded-3xl bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-800 flex items-center gap-4 transition-all hover:border-indigo-500/20 group">
                <div class="w-12 h-12 bg-white dark:bg-gray-900 rounded-2xl flex items-center justify-center text-indigo-600 shadow-sm shrink-0 border border-gray-100 dark:border-gray-700 group-hover:scale-110 transition-transform">
                    <i class="ti ti-headset text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm font-bold dark:text-white">Butuh bantuan?</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Hubungi Customer Service 24/7</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection