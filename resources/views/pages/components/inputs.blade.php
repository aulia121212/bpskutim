@extends('layouts.app')

@section('title', 'Inputs')

@section('content')
    <div class="space-y-12 pb-20">

        <div class="flex flex-col gap-2">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Inputs</h1>
            <p class="text-gray-500 dark:text-gray-400 font-medium text-sm">Komponen input form yang mendukung ikon, label,
                dan validasi otomatis.</p>
        </div>

        <section class="space-y-6">
            <h3 class="text-xs font-bold uppercase text-indigo-600 dark:text-indigo-400 tracking-widest px-1">Basic Variants
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <div class="space-y-3">
                    <x-card class="relative">
                        <button @click="show = !show"
                            class="absolute top-6 right-8 text-gray-300 hover:text-indigo-600 transition-colors z-20">
                            <i class="ti" :class="show ? 'ti-code-off' : 'ti-code'"></i>
                        </button>
                        <x-input label="Nama Lengkap" name="fullname" placeholder="Masukkan nama sesuai KTP" />
                    </x-card>
                    <div x-show="show" x-collapse x-cloak
                        class="bg-gray-950 rounded-2xl p-4 font-mono text-[10px] text-indigo-300 overflow-x-auto shadow-inner">
                        <pre><code>&lt;x-input label="Nama Lengkap" name="fullname" placeholder="..." /&gt;</code></pre>
                    </div>
                </div>

                <div class="space-y-3">
                    <x-card class="relative">
                        <x-input type="password" label="Kata Sandi" name="password" icon="lock" placeholder="••••••••" />
                    </x-card>
                    <x-code>
                        <x-input type="password" label="Kata Sandi" name="password" icon="lock" placeholder="••••••••" />
                    </x-code>
                </div>

            </div>
        </section>

        <section class="space-y-6">
            <h3 class="text-xs font-bold uppercase text-indigo-600 dark:text-indigo-400 tracking-widest px-1">Icons & Styles
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="space-y-3">
                    <x-card class="relative">
                        <x-input name="search" icon="search" placeholder="Cari data..."
                            class="bg-indigo-50/30 dark:bg-indigo-500/5 border border-indigo-100 dark:border-indigo-500/20" />
                    </x-card>
                </div>

                <div class="space-y-3">
                    <x-card class="relative">
                        <x-input type="number" label="Harga Produk" name="price" icon="currency-dollar"
                            placeholder="0" />
                    </x-card>
                </div>

                <div class="space-y-3">
                    <x-card class="relative">
                        <x-input type="email" label="Email" name="email" icon="mail"
                            placeholder="admin@example.com" />
                    </x-card>
                </div>

            </div>
        </section>

        <section class="space-y-6">
            <h3 class="text-xs font-bold uppercase text-indigo-600 dark:text-indigo-400 tracking-widest px-1">Validation
                States</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <div class="space-y-3">
                    <x-card class="relative border-rose-100 dark:border-rose-900/30">
                        {{-- Simulasi Error Laravel secara manual untuk demo --}}
                        @php
                            $errors = new \Illuminate\Support\MessageBag([
                                'username' => ['Username ini sudah digunakan.'],
                            ]);
                        @endphp

                        <x-input label="Username" name="username" icon="at" value="aulia_azizah" />

                        {{-- Reset errors setelah demo --}}
                        @php $errors = session()->get('errors', new \Illuminate\Support\MessageBag); @endphp
                    </x-card>
                </div>

                <div class="space-y-3">
                    <x-card class="relative">
                        <x-input label="Subdomain" name="subdomain" icon="world" placeholder="my-store" />
                        <p class="text-[10px] text-gray-400 font-medium mt-2 ml-1">Domain Anda akan menjadi: <span
                                class="text-indigo-500 font-bold">my-store.laraui.com</span></p>
                    </x-card>
                </div>

            </div>
        </section>

        <section class="space-y-6 mt-12">
            <h3 class="text-xs font-bold uppercase text-indigo-600 dark:text-indigo-400 tracking-widest px-1">Checkboxes
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <x-card title="Simple Options">
                    <div class="space-y-4">
                        <x-checkbox name="remember" label="Ingat saya di perangkat ini" />
                        <x-checkbox name="newsletter" label="Langganan newsletter mingguan" checked />
                    </div>
                </x-card>

                <x-card title="With Descriptions">
                    <div class="space-y-6">
                        <x-checkbox name="privacy" label="Kebijakan Privasi"
                            description="Saya setuju dengan pengolahan data pribadi saya sesuai kebijakan yang berlaku." />

                        <x-checkbox name="updates" label="Update Keamanan"
                            description="Kirim notifikasi email jika ada aktivitas login yang mencurigakan." checked />
                    </div>
                </x-card>

            </div>
        </section>
        <section class="mt-12">
            <x-card title="Select">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    {{-- Kategori Produk --}}
                    <x-select label="Kategori Produk" name="category" icon="category">
                        <option value="">Semua Kategori</option>
                        <option value="electronics">Elektronik</option>
                        <option value="fashion">Fashion</option>
                        <option value="food">Makanan & Minuman</option>
                    </x-select>

                    {{-- Lokasi --}}
                    <x-select label="Pilih Lokasi" name="location" icon="map-pin">
                        <option value="">Semua Lokasi</option>
                        <option value="jakarta">Jakarta</option>
                        <option value="bandung">Bandung</option>
                        <option value="surabaya">Surabaya</option>
                    </x-select>

                </div>

            </x-card>

            <x-card class="mt-10" title="Textarea">
                <x-textarea label="Deskripsi Proyek" name="description"
                    placeholder="Tuliskan detail proyek Anda di sini..." />
            </x-card>
        </section>
        {{-- Media Upload Section --}}
        <section class="space-y-6 mt-12">
            <h3 class="text-xs font-bold uppercase text-indigo-600 dark:text-indigo-400 tracking-widest px-1">Media Upload
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                {{-- Variant 1: Profile / Avatar Upload --}}
                <x-card title="Avatar Upload">
                    <div x-data="{ photoName: null, photoPreview: null }" class="flex flex-col items-center gap-4 py-4">
                        <input type="file" class="hidden" x-ref="photo"
                            @change="
                                photoName = $event.target.files[0].name;
                                const reader = new FileReader();
                                reader.onload = (e) => { photoPreview = e.target.result; };
                                reader.readAsDataURL($event.target.files[0]);
                            ">

                        <div class="relative group">
                            <div
                                class="w-32 h-32 rounded-2xl border-4 border-gray-50 dark:border-gray-900 overflow-hidden bg-gray-100 dark:bg-gray-800 shadow-xl">
                                {{-- Placeholder --}}
                                <template x-if="!photoPreview">
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <i class="ti ti-user text-5xl"></i>
                                    </div>
                                </template>
                                {{-- Preview --}}
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" class="w-full h-full object-cover">
                                </template>
                            </div>

                            <button @click.prevent="$refs.photo.click()"
                                class="absolute -bottom-2 -right-2 bg-indigo-600 text-white p-2 rounded-xl shadow-lg hover:bg-indigo-700 transition-all active:scale-90">
                                <i class="ti ti-camera text-lg"></i>
                            </button>
                        </div>
                        <p class="text-[10px] text-gray-400 font-medium">Format: JPG, PNG. Maks 2MB.</p>
                    </div>
                </x-card>

                {{-- Variant 2: Drag & Drop Area --}}
                <x-card title="Dropzone Style">
                    <div x-data="{ isDropping: false, fileName: '' }" @dragover.prevent="isDropping = true"
                        @dragleave.prevent="isDropping = false"
                        @drop.prevent="isDropping = false; fileName = $event.dataTransfer.files[0].name" class="relative">

                        <label
                            class="flex flex-col items-center justify-center w-full h-44 border-2 border-dashed rounded-2xl cursor-pointer transition-all duration-200"
                            :class="isDropping ? 'border-indigo-500 bg-indigo-50/50 dark:bg-indigo-500/10' :
                                'border-gray-200 dark:border-gray-800 hover:border-indigo-400 dark:hover:border-indigo-500/40'">

                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <i class="ti ti-cloud-upload text-4xl mb-3 text-indigo-500"
                                    :class="isDropping ? 'animate-bounce' : ''"></i>
                                <p class="text-sm text-gray-600 dark:text-gray-400 font-semibold"
                                    x-text="fileName ? fileName : 'Klik atau tarik gambar ke sini'"></p>
                                <p class="text-xs text-gray-400 mt-1">PNG, JPG up to 10MB</p>
                            </div>
                            <input type="file" class="hidden" @change="fileName = $event.target.files[0].name" />
                        </label>
                    </div>
                </x-card>

            </div>
        </section>

        {{-- File Upload Section --}}
        <section class="space-y-6 mt-12">
            <h3 class="text-xs font-bold uppercase text-indigo-600 dark:text-indigo-400 tracking-widest px-1">Document &
                File Upload</h3>

            <div class="grid grid-cols-1 gap-8">
                <x-card title="Advanced File Manager">
                    <div x-data="{
                        files: [],
                        isUploading: false,
                        progress: 0,
                        addFiles(e) {
                            const newFiles = [...e.target.files];
                            this.files = [...this.files, ...newFiles];
                    
                            // Simulasi Progress Bar
                            this.isUploading = true;
                            this.progress = 0;
                            let interval = setInterval(() => {
                                this.progress += 10;
                                if (this.progress >= 100) {
                                    clearInterval(interval);
                                    setTimeout(() => this.isUploading = false, 500);
                                }
                            }, 100);
                        },
                        removeFile(index) {
                            this.files = this.files.filter((_, i) => i !== index);
                        },
                        formatSize(bytes) {
                            if (bytes === 0) return '0 Bytes';
                            const k = 1024;
                            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                            const i = Math.floor(Math.log(bytes) / Math.log(k));
                            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
                        }
                    }" class="space-y-6">

                        {{-- Drop Area --}}
                        <div class="relative">
                            <input type="file" multiple
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                @change="addFiles($event)">
                            <div
                                class="p-10 border-2 border-dashed border-gray-200 dark:border-gray-800 rounded-3xl bg-gray-50/50 dark:bg-gray-900/30 flex flex-col items-center justify-center transition-all hover:border-indigo-500 group">
                                <div
                                    class="w-16 h-16 bg-indigo-100 dark:bg-indigo-500/10 text-indigo-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                    <i class="ti ti-file-upload text-3xl"></i>
                                </div>
                                <h4 class="text-sm font-bold text-gray-900 dark:text-white">Pilih berkas atau tarik ke sini
                                </h4>
                                <p class="text-xs text-gray-400 mt-2 font-medium">Mendukung PDF, DOCX, ZIP (Maks. 50MB per
                                    file)</p>
                            </div>
                        </div>

                        {{-- Progress Bar --}}
                        <div x-show="isUploading" x-cloak class="space-y-2">
                            <div
                                class="flex justify-between text-[10px] font-bold uppercase tracking-widest text-indigo-600">
                                <span>Uploading...</span>
                                <span x-text="progress + '%'"></span>
                            </div>
                            <div class="h-1.5 w-full bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
                                <div class="h-full bg-indigo-600 transition-all duration-200"
                                    :style="'width:' + progress + '%'"></div>
                            </div>
                        </div>

                        {{-- File List --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" x-show="files.length > 0" x-cloak>
                            <template x-for="(file, index) in files" :key="index">
                                <div
                                    class="flex items-center gap-4 p-4 rounded-2xl border border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900 shadow-sm group">
                                    <div
                                        class="w-12 h-12 rounded-xl bg-amber-100 dark:bg-amber-500/10 text-amber-600 flex items-center justify-center shrink-0">
                                        <i class="ti ti-file-description text-2xl"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-bold text-gray-900 dark:text-white truncate"
                                            x-text="file.name"></p>
                                        <p class="text-[10px] text-gray-400 font-medium" x-text="formatSize(file.size)">
                                        </p>
                                    </div>
                                    <button @click="removeFile(index)"
                                        class="p-2 text-gray-300 hover:text-rose-500 transition-colors">
                                        <i class="ti ti-trash text-lg"></i>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>
                </x-card>
            </div>
        </section>
    </div>
@endsection