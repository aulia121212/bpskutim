@extends('layouts.app')

@section('title', 'Tambah Produk Baru')

@section('content')
<div class="space-y-10 pb-20">
    
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="flex flex-col gap-1">
            <nav class="flex items-center gap-2 text-gray-400 mb-2">
                <a href="{{ route('ecommerce.products.index') }}" class="hover:text-indigo-600 transition-colors text-xs font-bold uppercase tracking-widest">Katalog</a>
                <i class="ti ti-chevron-right text-[10px]"></i>
                <span class="text-xs font-bold uppercase tracking-widest text-indigo-600">Tambah Produk</span>
            </nav>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Buat Produk Baru</h1>
            <p class="text-gray-500 dark:text-gray-400 font-medium text-sm">Lengkapi detail produk Anda untuk mulai menjual ke pelanggan.</p>
        </div>
        <div class="flex items-center gap-3">
            <x-button variant="secondary" href="{{ route('ecommerce.products.index') }}" >
                Batalkan
            </x-button>
            <x-button type="submit" form="productForm" variant="primary" >
                Simpan Produk
            </x-button>
        </div>
    </div>

    <form id="productForm" action="{{ route('ecommerce.products.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @csrf
        
        <div class="lg:col-span-2 space-y-8">
            {{-- Informasi Umum --}}
            <x-card>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <i class="ti ti-info-circle text-indigo-600"></i> Informasi Umum
                </h3>
                
                <div class="space-y-6">
                    <x-input 
                        label="Nama Produk" 
                        name="name" 
                        placeholder="Contoh: Macbook Pro M3 14-inch 2024" 
                        value="{{ old('name') }}"
                        required 
                    />

                    <x-textarea 
                        label="Deskripsi Lengkap" 
                        name="description" 
                        rows="8" 
                        placeholder="Tuliskan spesifikasi lengkap, fitur unggulan, dan informasi lainnya..."
                    >{{ old('description') }}</x-textarea>
                </div>
            </x-card>

            {{-- Harga & Inventaris --}}
            <x-card>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <i class="ti ti-box text-indigo-600"></i> Harga & Inventaris
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-input 
                        type="number"
                        label="Harga Jual (Rp)" 
                        name="price" 
                        icon="currency-dollar"
                        placeholder="0"
                        value="{{ old('price') }}"
                        required 
                    />

                    <x-input 
                        type="number"
                        label="Stok Tersedia" 
                        name="stock" 
                        icon="database"
                        placeholder="0"
                        value="{{ old('stock') }}"
                        required 
                    />
                </div>
            </x-card>
        </div>

        {{-- Sisi Kanan: Media & Organisasi --}}
        <div class="space-y-8">
            {{-- Foto Produk --}}
            <x-card title="Foto Produk">
                <div class="space-y-4" x-data="{ preview: null }">
                    <div class="aspect-[4/5] w-full bg-gray-50 dark:bg-gray-800 border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-[2.5rem] flex flex-col items-center justify-center p-6 text-center group hover:border-indigo-500 transition-all cursor-pointer relative overflow-hidden">
                        <template x-if="!preview">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-white dark:bg-gray-900 rounded-2xl flex items-center justify-center shadow-sm mb-4 group-hover:scale-110 transition-transform">
                                    <i class="ti ti-upload text-2xl text-indigo-600"></i>
                                </div>
                                <p class="text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">Pilih Foto</p>
                                <p class="text-[10px] text-gray-400 mt-1">JPG, PNG (Max. 2MB)</p>
                            </div>
                        </template>
                        <template x-if="preview">
                            <img :src="preview" class="absolute inset-0 w-full h-full object-cover">
                        </template>
                        <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer" 
                               @change="let file = $event.target.files[0]; if(file) { let reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); }">
                    </div>
                    @error('image')
                        <p class="text-[10px] text-rose-500 font-bold ml-1">{{ $message }}</p>
                    @enderror
                </div>
            </x-card>

            {{-- Organisasi --}}
            <x-card>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <i class="ti ti-category text-indigo-600"></i> Organisasi
                </h3>
                
                <div class="space-y-6">
                    <x-select label="Kategori" name="category" icon="layout-grid">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                        @endforeach
                    </x-select>

                    <div class="pt-4 border-t border-gray-50 dark:border-gray-800">
                        <x-checkbox 
                            name="is_active" 
                            label="Status Publikasi" 
                            description="Tampilkan produk ini di toko online segera setelah disimpan." 
                            checked 
                        />
                    </div>
                </div>
            </x-card>
        </div>
    </form>
</div>
@endsection