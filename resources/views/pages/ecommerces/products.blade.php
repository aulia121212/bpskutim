@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')
<div class="space-y-10 pb-20" x-data="{ 
    viewMode: 'grid', 
    deleteModal: false, 
    selectedProduct: { name: '', id: null, url: '' } 
}">
    

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex flex-col gap-1">
            <h1 class="text-3xl font-semibold text-gray-900 dark:text-white tracking-tight">Katalog Produk</h1>
            <p class="text-gray-500 dark:text-gray-400 font-medium text-sm">Kelola stok, harga, dan visibilitas produk Anda dalam satu tempat.</p>
        </div>
        <div class="flex items-center gap-3 shrink-0">
            <div class="bg-gray-100 dark:bg-gray-800 p-1 rounded-xl flex items-center gap-1 mr-2 ">
                <button @click="viewMode = 'grid'" 
                        :class="viewMode === 'grid' ? 'bg-white dark:bg-gray-700 text-indigo-600 shadow-sm' : 'text-gray-400 hover:text-gray-600'"
                        class="p-2 rounded-lg transition-all">
                    <i class="ti ti-layout-grid text-lg"></i>
                </button>
                <button @click="viewMode = 'table'" 
                        :class="viewMode === 'table' ? 'bg-white dark:bg-gray-700 text-indigo-600 shadow-sm' : 'text-gray-400 hover:text-gray-600'"
                        class="p-2 rounded-lg transition-all">
                    <i class="ti ti-list text-lg"></i>
                </button>
            </div>

            <button class="flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 text-gray-700 dark:text-gray-300 font-semibold rounded-2xl hover:bg-gray-50 dark:hover:bg-gray-800 transition-all shadow-sm">
                <i class="ti ti-file-export text-lg"></i>
                <span class="text-sm hidden sm:inline">Ekspor</span>
            </button>
            <x-button href="{{ route('ecommerce.products.create') }}" class="flex items-center gap-2 px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-2xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/25 active:scale-95">
                <i class="ti ti-plus text-lg"></i>
                <span class="text-sm">Tambah Produk</span>
            </x-button>
        </div>
    </div>

    <div class="bg-gray-100 dark:bg-gray-900/50 backdrop-blur-xl p-4 rounded-2xl border border-gray-200/50 dark:border-gray-800/50 flex flex-col md:flex-row gap-4">
        <div class="relative flex-1 group">
            <i class="ti ti-search absolute left-5 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-indigo-500 transition-colors"></i>
            <input type="text" placeholder="Cari nama, SKU, atau kategori..." 
                class="w-full bg-white dark:bg-gray-950 border-none rounded-2xl pl-12 pr-5 py-3 text-sm font-medium outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all dark:text-white ">
        </div>
        <div class="flex items-center gap-3">
            <select class="bg-white dark:bg-gray-950 border-none rounded-2xl px-5 py-3 text-sm font-semibold dark:text-white outline-none focus:ring-2 focus:ring-indigo-500/20  appearance-none cursor-pointer min-w-[160px]">
                <option>Semua Kategori</option>
                <option>Electronics</option>
                <option>Audio</option>
                <option>Accessories</option>
            </select>
            <button class="p-3 bg-white dark:bg-gray-950 text-gray-500 dark:text-gray-400 rounded-2xl border border-gray-100 dark:border-gray-800 hover:text-indigo-600 transition-all ">
                <i class="ti ti-adjustments-horizontal text-xl"></i>
            </button>
        </div>
    </div>

    <div x-show="viewMode === 'grid'" x-transition 
         class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-8">
        @foreach($products as $product)
        <div class="group bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 overflow-hidden hover:border-indigo-500/50 transition-all duration-500 ">
            
            <div class="relative aspect-square overflow-hidden m-3 rounded-2xl bg-gray-50 dark:bg-gray-950">
                <img src="{{ $product['image'] }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                
                <div class="absolute top-4 left-4">
                    <span class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest backdrop-blur-md  text-white
                        {{ $product['status'] === 'Tersedia' ? 'bg-emerald-500/90' : ($product['status'] === 'Stok Menipis' ? 'bg-amber-500/90' : 'bg-rose-500/90') }}">
                        {{ $product['status'] }}
                    </span>
                </div>

                <div class="absolute bottom-4 left-4 bg-white/90 dark:bg-gray-900/90 backdrop-blur px-3 py-1.5 rounded-xl flex items-center gap-1.5 shadow-sm">
                    <i class="ti ti-star-filled text-amber-400 text-xs"></i>
                    <span class="text-xs font-bold dark:text-white">{{ $product['rating'] }}</span>
                </div>
            </div>

            <div class="p-6 pt-2 space-y-4">
                <div>
                    <span class="text-[10px] font-black text-indigo-500 uppercase tracking-widest">{{ $product['category'] }}</span>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white leading-tight mt-1 group-hover:text-indigo-600 transition-colors truncate">
                        {{ $product['name'] }}
                    </h3>
                </div>

                <div class="grid grid-cols-1 gap-3">
                        <p class="text-[10px] text-gray-400 font-bold uppercase mb-1">Harga</p>
                        <p class="text-sm font-bold text-gray-900 dark:text-white">
                            <span class="text-indigo-500 text-[10px]">Rp</span>{{ number_format($product['price'], 0, ',', '.') }}
                        </p>
              
                       <p class="text-[10px] text-gray-400 font-bold uppercase mb-1">Stok</p>
                        <p class="text-sm font-bold text-gray-900 dark:text-white">
                            {{ $product['stock'] }} <span class="text-[10px] text-gray-400 font-normal">unit</span>
                        </p>
                </div>

              <div class="flex items-center gap-2 pt-3">
    {{-- View / Buy --}}
    <a href="{{ route('ecommerce.products.show', $product['id']) }}"
       class="flex flex-1 items-center justify-center gap-2
              h-11
              rounded-xl
              bg-gray-900 dark:bg-white
              text-white dark:text-gray-900
              text-xs font-bold uppercase tracking-wider
              transition-all duration-200
              hover:bg-indigo-600 hover:text-white
              dark:hover:bg-indigo-600 dark:hover:text-white">
        <i class="ti ti-shopping-bag text-base"></i>
        <span class="hidden sm:inline">View</span>
    </a>

    {{-- Edit --}}
    <a href="{{ route('ecommerce.products.edit', $product['id']) }}"
       class="flex items-center justify-center
              h-11 w-11
              rounded-xl
              bg-gray-100 dark:bg-gray-800
              text-gray-500 dark:text-gray-400
              transition-all duration-200
              hover:bg-indigo-50 dark:hover:bg-gray-700
              hover:text-indigo-600">
        <i class="ti ti-edit text-base"></i>
    </a>

    {{-- Delete --}}
    <button
        @click="selectedProduct = { name: '{{ $product['name'] }}', id: {{ $product['id'] }}, url: '{{ route('ecommerce.products.destroy', $product['id']) }}' }; deleteModal = true"
        class="flex items-center justify-center
               h-11 w-11
               rounded-xl
               bg-gray-100 dark:bg-gray-800
               text-gray-500 dark:text-gray-400
               transition-all duration-200
               hover:bg-rose-50 dark:hover:bg-gray-700
               hover:text-rose-500">
        <i class="ti ti-trash text-base"></i>
    </button>
</div>

            </div>
        </div>
        @endforeach
    </div>

    <div x-show="viewMode === 'table'" x-transition 
         class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-200 dark:border-gray-800 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800">
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Produk</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Kategori</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">Harga</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Stok</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach($products as $product)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $product['image'] }}" class="w-12 h-12 rounded-xl object-cover border border-gray-100 dark:border-gray-800">
                                <div>
                                    <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $product['name'] }}</p>
                                    <p class="text-[10px] text-amber-500 font-bold flex items-center gap-1">
                                        <i class="ti ti-star-filled"></i>{{ $product['rating'] }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ $product['category'] }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-sm font-bold text-gray-900 dark:text-white">Rp{{ number_format($product['price'], 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-sm font-bold text-gray-600 dark:text-gray-400">{{ $product['stock'] }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider
                                {{ $product['status'] === 'Tersedia' ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600' : ($product['status'] === 'Stok Menipis' ? 'bg-amber-50 dark:bg-amber-500/10 text-amber-600' : 'bg-rose-50 dark:bg-rose-500/10 text-rose-600') }}">
                                {{ $product['status'] }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('ecommerce.products.show', $product['id']) }}" class="p-2 bg-gray-50 dark:bg-gray-800 text-gray-400 rounded-lg hover:text-indigo-600 transition-all"><i class="ti ti-eye"></i></a>
                                <a href="{{ route('ecommerce.products.edit', $product['id']) }}" class="p-2 bg-gray-50 dark:bg-gray-800 text-gray-400 rounded-lg hover:text-indigo-600 transition-all"><i class="ti ti-edit"></i></a>
                                <button @click="selectedProduct = {name: '{{ $product['name'] }}', id: {{ $product['id'] }}, url: '{{ route('ecommerce.products.destroy', $product['id']) }}' }; deleteModal = true" 
                                        class="p-2 bg-gray-50 dark:bg-gray-800 text-gray-400 rounded-lg hover:text-rose-600 transition-all"><i class="ti ti-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <template x-teleport="body">
        <div x-show="deleteModal" class="fixed inset-0 z-[10001] flex items-center justify-center p-4" x-cloak>
            <div x-show="deleteModal" x-transition.opacity @click="deleteModal = false" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm"></div>
            
            <div x-show="deleteModal" x-transition.scale.95 
                 class="relative w-full max-w-md bg-white dark:bg-gray-900 rounded-3xl p-8 text-center border border-gray-100 dark:border-gray-800 shadow-2xl">
                
                <div class="w-20 h-20 bg-rose-50 dark:bg-rose-500/10 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="ti ti-alert-triangle text-4xl"></i>
                </div>
                
                <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Hapus Produk?</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400 font-medium px-4">
                    Apakah Anda yakin ingin menghapus <span class="text-gray-900 dark:text-white font-bold" x-text="selectedProduct.name"></span>? Tindakan ini tidak dapat dibatalkan.
                </p>
                
                <form :action="selectedProduct.url" method="POST" class="mt-10 flex flex-col gap-3">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full py-4 bg-rose-600 text-white font-bold rounded-2xl hover:bg-rose-700 transition-all shadow-lg shadow-rose-500/25">
                        Ya, Hapus Sekarang
                    </button>
                    <button type="button" @click="deleteModal = false" class="w-full py-4 bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-400 font-bold rounded-2xl hover:bg-gray-100 dark:hover:bg-gray-700 transition-all">
                        Batalkan
                    </button>
                </form>
            </div>
        </div>
    </template>

</div>
@endsection