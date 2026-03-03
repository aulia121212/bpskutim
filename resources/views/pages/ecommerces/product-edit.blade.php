@extends('layouts.app')

@section('title', 'Edit Produk: ' . $product['name'])

@section('content')
<div class="space-y-10 pb-20">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex flex-col gap-1">
            <div class="flex items-center gap-2 text-gray-400 mb-2">
                <a href="{{ route('ecommerce.products.index') }}" class="hover:text-indigo-600 transition-colors text-xs font-bold uppercase tracking-widest">Katalog</a>
                <i class="ti ti-chevron-right text-xs"></i>
                <span class="text-xs font-bold uppercase tracking-widest text-indigo-600">Edit Produk</span>
            </div>
            <h1 class="text-3xl font-semibold text-gray-900 dark:text-white tracking-tight">Perbarui Produk</h1>
            <p class="text-gray-500 dark:text-gray-400 font-medium text-sm">Ubah detail produk <span class="text-indigo-600 font-bold">#{{ $product['id'] }}</span> dan simpan perubahan terbaru.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('ecommerce.products.index') }}" class="px-6 py-2.5 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 text-gray-700 dark:text-gray-300 font-semibold rounded-2xl hover:bg-gray-50 transition-all">
                Batalkan
            </a>
            <button type="submit" form="productEditForm" class="px-8 py-2.5 bg-indigo-600 text-white font-semibold rounded-2xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/25 active:scale-95">
                Simpan Perubahan
            </button>
        </div>
    </div>

    <form id="productEditForm" action="{{ route('ecommerce.products.update', $product['id']) }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @csrf
        @method('PUT')
        
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] border border-gray-100 dark:border-gray-800 p-8 shadow-sm space-y-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <i class="ti ti-edit text-indigo-600"></i> Detail Informasi
                </h3>
                
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-400 uppercase ml-1 tracking-wider">Nama Produk</label>
                    <input type="text" name="name" value="{{ $product['name'] }}" required 
                        class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-2xl px-5 py-4 text-sm font-bold dark:text-white outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all">
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-400 uppercase ml-1 tracking-wider">Deskripsi</label>
                    <textarea name="description" rows="8" 
                        class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-[2rem] px-6 py-5 text-sm font-medium dark:text-white outline-none focus:ring-2 focus:ring-indigo-500/20 resize-none">{{ $product['description'] }}</textarea>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] border border-gray-100 dark:border-gray-800 p-8 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <i class="ti ti-currency-dollar text-indigo-600"></i> Harga & Stok
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-400 uppercase ml-1 tracking-wider">Harga Jual</label>
                        <div class="relative group">
                            <span class="absolute left-5 top-1/2 -translate-y-1/2 text-gray-400 font-bold text-sm">Rp</span>
                            <input type="number" name="price" value="{{ $product['price'] }}" required 
                                class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-2xl pl-14 pr-5 py-4 text-sm font-bold dark:text-white outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-gray-400 uppercase ml-1 tracking-wider">Stok Tersedia</label>
                        <input type="number" name="stock" value="{{ $product['stock'] }}" required 
                            class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-2xl px-5 py-4 text-sm font-bold dark:text-white outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all">
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-8">
            <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] border border-gray-100 dark:border-gray-800 p-8 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <i class="ti ti-photo text-indigo-600"></i> Media Produk
                </h3>
                <div class="space-y-4" x-data="{ preview: '{{ $product['image'] }}' }">
                    <div class="aspect-[4/5] w-full bg-gray-50 dark:bg-gray-800 border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-[2rem] flex flex-col items-center justify-center p-2 text-center group hover:border-indigo-500 transition-all cursor-pointer relative overflow-hidden">
                        <img :src="preview" class="absolute inset-0 w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-sm">
                            <p class="text-white text-xs font-bold uppercase tracking-widest">Ganti Foto</p>
                        </div>
                        <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer" 
                               @change="let file = $event.target.files[0]; if(file) { let reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); }">
                    </div>
                    <p class="text-[10px] text-gray-400 text-center font-medium italic">Klik gambar untuk mengganti foto saat ini.</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-[2.5rem] border border-gray-100 dark:border-gray-800 p-8 shadow-sm space-y-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 flex items-center gap-2">
                    <i class="ti ti-settings text-indigo-600"></i> Pengaturan
                </h3>
                
                <div class="space-y-2">
                    <label class="text-xs font-bold text-gray-400 uppercase ml-1 tracking-wider">Kategori</label>
                    <div class="relative">
                        <select name="category" class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-2xl px-5 py-4 text-sm font-bold dark:text-white outline-none focus:ring-2 focus:ring-indigo-500/20 appearance-none cursor-pointer">
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ $product['category'] == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                        <i class="ti ti-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-50 dark:border-gray-800 space-y-4">
                    <div class="flex items-center justify-between p-2">
                        <div>
                            <p class="text-sm font-bold dark:text-white">Publikasikan</p>
                            <p class="text-[10px] text-gray-400 font-medium">Tersedia untuk pembeli</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" class="sr-only peer" {{ $product['status'] == 'Tersedia' ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-indigo-600 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all shadow-sm"></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection