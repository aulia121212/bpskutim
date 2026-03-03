@extends('layouts.app')

@section('title', 'Advanced Cards UI Kit')

@section('content')
    <div class="space-y-16 pb-20">

        <div class="flex flex-col gap-2">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Card</h1>
            <p class="text-gray-500 dark:text-gray-400 font-medium text-sm">Koleksi komponen kartu modular.</p>
        </div>

        <section class="space-y-6">
            <h3 class="text-xs font-bold uppercase text-indigo-600 dark:text-indigo-400 tracking-widest px-1">
                Analytics & Statistik
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch">

                {{-- CARD 1 --}}
                <x-card
                    class="flex flex-col justify-between
                   group hover:border-indigo-500 transition-all duration-300">

                    <div class="flex-1 flex items-start justify-between gap-6">

                        {{-- Left --}}
                        <div class="flex flex-col gap-6">

                            <div
                                class="w-16 h-16 rounded-3xl
                               bg-indigo-50 dark:bg-indigo-500/10
                               flex items-center justify-center
                               text-indigo-600
                               group-hover:bg-indigo-600
                               group-hover:text-white
                               transition-all duration-500 shadow-sm">
                                <i class="ti ti-wallet text-3xl"></i>
                            </div>

                            <div class="space-y-1">
                                <p class="text-xs font-bold text-gray-400">
                                    Keuntungan
                                </p>
                                <h4 class="text-2xl font-bold dark:text-white leading-tight">
                                    Rp 42.500.000
                                </h4>
                            </div>

                        </div>

                        <span
                            class="self-start text-xs font-bold
                           bg-emerald-50 dark:bg-emerald-500/10
                           text-emerald-600
                           px-2 py-1 rounded-lg">
                            +12%
                        </span>

                    </div>
                </x-card>

                {{-- CARD 2 --}}
                <x-card
                    class="bg-indigo-600 text-white
                   relative overflow-hidden
                   flex flex-col justify-between
                   border-none shadow-lg shadow-indigo-500/20">

                    <div class="relative z-10 flex-1 flex flex-col justify-between">

                        <div class="space-y-1">
                            <p class="text-xs font-bold opacity-60">
                                Proyek Aktif
                            </p>
                            <h4 class="text-2xl font-bold">
                                LaravelUI Dashboard
                            </h4>
                        </div>

                        <div class="flex -space-x-2 mt-3">
                            @foreach ([1, 2, 3] as $i)
                                <img src="https://i.pravatar.cc/150?u={{ $i }}"
                                    class="w-12 h-12 rounded-full
                                   border-2 border-indigo-600 shadow-sm">
                            @endforeach
                            <div
                                class="w-12 h-12 rounded-full
                               bg-indigo-400/30 backdrop-blur
                               border-2 border-indigo-600
                               flex items-center justify-center
                               text-sm font-bold">
                                +5
                            </div>
                        </div>

                    </div>

                    <i
                        class="ti ti-brand-laravel text-9xl absolute
                       -bottom-8 -right-8
                       text-white opacity-10
                       group-hover:scale-110
                       transition-transform duration-700
                       pointer-events-none"></i>
                </x-card>

                {{-- CARD 3 --}}
                <x-card
                    class="h-full flex flex-col justify-between
                   group hover:border-amber-500 transition-all">

                    {{-- Top --}}
                    <div class="flex-1 space-y-5">

                        <div class="flex justify-between items-center">
                            <div
                                class="w-10 h-10 bg-amber-50 dark:bg-amber-500/10
                               text-amber-600 rounded-xl
                               flex items-center justify-center">
                                <i class="ti ti-trending-up text-lg"></i>
                            </div>
                            <span class="text-sm font-bold text-amber-600 uppercase tracking-wider">
                                +24%
                            </span>
                        </div>

                        <h4 class="text-3xl font-black dark:text-white leading-none">
                            8,492
                        </h4>

                    </div>

                    {{-- Bottom chart (tinggi konsisten) --}}
                    <div class="flex items-end gap-1.5 h-12">
                        @foreach ([40, 70, 45, 90, 65, 80, 50] as $h)
                            <div class="flex-1 bg-indigo-100 dark:bg-indigo-900/30
                               rounded-t-md transition-all
                               hover:bg-indigo-500"
                                style="height: {{ $h }}%">
                            </div>
                        @endforeach
                    </div>

                </x-card>

            </div>
        </section>

        @php
            $verticalProducts = [
                [
                    'title' => 'Nike Air Max Red',
                    'price' => 'Rp 850.000',
                    'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=400',
                    'label' => 'Flash Sale',
                    'left' => 12,
                    'progress' => '66%',
                ],
                [
                    'title' => 'Adidas Ultraboost',
                    'price' => 'Rp 1.150.000',
                    'image' => 'https://images.unsplash.com/photo-1600180758890-6b94519a8ba6?q=80&w=400',
                    'label' => 'Hot Deal',
                    'left' => 8,
                    'progress' => '80%',
                ],
                [
                    'title' => 'Puma RS-X',
                    'price' => 'Rp 990.000',
                    'image' => 'https://images.unsplash.com/photo-1519744792095-2f2205e87b6f?q=80&w=400',
                    'label' => 'Limited',
                    'left' => 5,
                    'progress' => '90%',
                ],
            ];

            $horizontalProducts = [
                [
                    'title' => 'Minimalist Watch v2',
                    'price' => 'Rp 1.250.000',
                    'image' =>
                        'https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=600&auto=format&fit=crop',
                    'desc' => 'Jam tangan premium dengan desain minimalis, cocok untuk gaya profesional dan kasual.',
                ],
                [
                    'title' => 'Leather Backpack Pro',
                    'price' => 'Rp 1.750.000',
                    'image' =>
                        'https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?q=80&w=600&auto=format&fit=crop',
                    'desc' => 'Tas kulit premium dengan kompartemen luas, cocok untuk kerja dan traveling.',
                ],
            ];
        @endphp

        <section class="space-y-12">

            {{-- SECTION TITLE --}}
            <h3
                class="px-1 text-xs font-bold uppercase tracking-widest
               text-indigo-600 dark:text-indigo-400">
                E-Commerce Variants
            </h3>

            {{-- ===================== --}}
            {{-- VERTICAL PRODUCTS (3) --}}
            {{-- ===================== --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 auto-rows-fr">

                @foreach ($verticalProducts as $product)
                    <div class="flex">
                        <x-card
                            class="flex flex-col h-full relative overflow-hidden group
                           bg-rose-50/10 dark:bg-rose-500/5
                           border-rose-500/30">

                            <div class="flex flex-col flex-1">

                                {{-- IMAGE --}}
                                <div class="aspect-video rounded-2xl overflow-hidden">
                                    <img src="{{ $product['image'] }}" alt="{{ $product['title'] }}"
                                        class="w-full h-full object-cover
                                       transition-transform duration-500
                                       group-hover:rotate-3">
                                </div>

                                {{-- INFO --}}
                                <div class="mt-4 space-y-1">
                                    <span
                                        class="inline-block text-[10px]
                                         bg-rose-500 text-white
                                         px-2 py-0.5 rounded-md
                                         font-bold uppercase tracking-widest">
                                        {{ $product['label'] }}
                                    </span>

                                    <h4 class="text-lg font-bold text-gray-900 dark:text-white">
                                        {{ $product['title'] }}
                                    </h4>

                                    <p class="text-rose-500 font-black">
                                        {{ $product['price'] }}
                                    </p>
                                </div>

                                {{-- BOTTOM --}}
                                <div class="mt-auto pt-4 space-y-2">
                                    <div
                                        class="h-1.5 w-full rounded-full overflow-hidden
                                        bg-gray-200 dark:bg-gray-800">
                                        <div class="h-full bg-rose-500" style="width: {{ $product['progress'] }}"></div>
                                    </div>

                                    <p class="text-[10px] font-bold uppercase text-gray-400">
                                        Tersisa {{ $product['left'] }} item
                                    </p>
                                </div>

                            </div>
                        </x-card>
                    </div>
                @endforeach

            </div>

            {{-- ======================= --}}
            {{-- HORIZONTAL PRODUCTS (2) --}}
            {{-- ======================= --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                @foreach ($horizontalProducts as $product)
                    <div class="flex">
                        <x-card :padding="false"
                            class="flex flex-col h-full relative overflow-hidden group
                           bg-gradient-to-br from-indigo-50/60 to-white
                           dark:from-gray-900 dark:to-gray-900">

                            <div class="flex flex-col sm:flex-row flex-1">

                                {{-- IMAGE --}}
                                <div
                                    class="aspect-square sm:w-64 shrink-0
                                    overflow-hidden bg-gray-100 dark:bg-gray-800">
                                    <img src="{{ $product['image'] }}" alt="{{ $product['title'] }}"
                                        class="w-full h-full object-cover
                                       transition-transform duration-700
                                       group-hover:scale-110">
                                </div>

                                {{-- CONTENT --}}
                                <div class="flex flex-col flex-1 p-8">

                                    <div class="space-y-3">
                                        <h4
                                            class="text-xl font-extrabold tracking-tight
                                           text-gray-900 dark:text-white">
                                            {{ $product['title'] }}
                                        </h4>

                                        <p
                                            class="text-sm font-bold uppercase tracking-tight
                                          text-indigo-600">
                                            {{ $product['price'] }}
                                        </p>

                                        <p
                                            class="text-sm text-gray-500 dark:text-gray-400
                                          leading-relaxed line-clamp-2">
                                            {{ $product['desc'] }}
                                        </p>
                                    </div>

                                    {{-- ACTION --}}
                                    <div class="mt-auto pt-6 flex gap-3">
                                        <x-button icon="shopping-bag" variant="primary" class="flex-1">
                                            Beli Sekarang
                                        </x-button>

                                        <x-button variant="secondary" icon="heart" />
                                    </div>

                                </div>
                            </div>
                        </x-card>
                    </div>
                @endforeach

            </div>

        </section>

        <section class="space-y-6">
            <h3 class="text-xs font-bold uppercase text-indigo-600 dark:text-indigo-400 tracking-widest px-1">Aktivitas &
                Log</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div x-data="{ show: false }" class="md:col-span-2 flex flex-col">
                    <x-card title="Aktivitas Tim Terbaru">
                        <div
                            class="space-y-8 relative before:absolute before:inset-y-0 before:left-[1.3rem] before:w-0.5 before:bg-gray-100 dark:before:bg-gray-800">
                            @foreach ([['icon' => 'upload', 'color' => 'indigo', 'user' => 'Alex Moon', 'action' => 'mengunggah aset desain baru', 'time' => '10 mnt lalu'], ['icon' => 'message-dots', 'color' => 'emerald', 'user' => 'Sarah Cole', 'action' => 'mengomentari laporan mingguan', 'time' => '1 jam lalu'], ['icon' => 'circle-check', 'color' => 'amber', 'user' => 'System', 'action' => 'backup database berhasil', 'time' => '5 jam lalu']] as $act)
                                <div class="relative flex gap-6 items-start group">
                                    <div
                                        class="w-11 h-11 shrink-0 bg-white dark:bg-gray-950 border-4 border-gray-50 dark:border-gray-900 text-{{ $act['color'] }}-600 rounded-2xl flex items-center justify-center z-10 shadow-sm transition-transform group-hover:scale-110">
                                        <i class="ti ti-{{ $act['icon'] }} text-lg"></i>
                                    </div>
                                    <div class="flex-1 pt-1">
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <span
                                                class="font-bold text-gray-900 dark:text-white">{{ $act['user'] }}</span>
                                            {{ $act['action'] }}
                                        </p>
                                        <p class="text-[11px] text-gray-400 font-medium uppercase mt-1 tracking-wider">
                                            {{ $act['time'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </x-card>
                </div>

                <div x-data="{ show: false }" class="flex flex-col">
                    <x-card title="Tugas Hari Ini">
                        <div class="space-y-4">
                            @foreach (['Meeting Client', 'Fixing Bug Navbar', 'Update Dokumentasi', 'Deploy ke Staging'] as $index => $task)
                                <label
                                    class="flex items-center gap-4 p-4 rounded-2xl bg-gray-50 dark:bg-gray-800/50 cursor-pointer group hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-all">
                                    <input type="checkbox"
                                        class="w-5 h-5 rounded-lg border-gray-300 dark:border-gray-700 text-indigo-600 focus:ring-indigo-500"
                                        {{ $index == 0 ? 'checked' : '' }}>
                                    <span
                                        class="text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-indigo-600 transition-colors">{{ $task }}</span>
                                </label>
                            @endforeach
                        </div>
                        <x-slot:footer>
                            <button
                                class="w-full text-xs font-bold text-gray-400 hover:text-indigo-600 transition-colors uppercase tracking-widest">+
                                Tambah Tugas Baru</button>
                        </x-slot:footer>
                    </x-card>
                </div>
            </div>
        </section>

        <section class="space-y-6">
            <h3 class="text-xs font-bold uppercase text-indigo-600 dark:text-indigo-400 tracking-widest px-1">Pilihan Paket
                (Pricing)</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <x-card class="hover:border-gray-300 transition-all">
                    <div class="text-center space-y-4">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Gratis</p>
                        <h4 class="text-4xl font-black dark:text-white">Rp 0</h4>
                        <p class="text-sm text-gray-500">Cocok untuk eksplorasi awal dan proyek personal.</p>
                    </div>
                    <div class="mt-8 space-y-4">
                        @foreach (['1 Proyek Aktif', 'Kapasitas 500MB', 'Dukungan Komunitas'] as $f)
                            <div class="flex items-center gap-3 text-sm font-medium text-gray-500">
                                <i class="ti ti-check text-indigo-600"></i> {{ $f }}
                            </div>
                        @endforeach
                    </div>
                    <x-button variant="secondary" class="w-full mt-10">Mulai Gratis</x-button>
                </x-card>

                <x-card
                    class="border-2 border-indigo-600 relative overflow-hidden shadow-xl shadow-indigo-500/10 scale-105 z-10">
                    <div
                        class="absolute top-0 right-0 bg-indigo-600 text-white px-6 py-2 rounded-bl-2xl text-[10px] font-black uppercase tracking-widest">
                        Populer</div>
                    <div class="text-center space-y-4">
                        <p class="text-xs font-bold text-indigo-600 uppercase tracking-widest">Paket Pro</p>
                        <h4 class="text-4xl font-black dark:text-white">Rp 299k<span
                                class="text-sm font-medium text-gray-400 lowercase tracking-normal">/bln</span></h4>
                        <p class="text-sm text-gray-500">Solusi lengkap untuk profesional dan tim kecil.</p>
                    </div>
                    <div class="mt-8 space-y-4">
                        @foreach (['Unlimited Proyek', 'Kapasitas 10GB', 'Dukungan Prioritas', 'Akses API'] as $f)
                            <div class="flex items-center gap-3 text-sm font-bold text-gray-700 dark:text-gray-300">
                                <i class="ti ti-circle-check text-indigo-600 text-lg"></i> {{ $f }}
                            </div>
                        @endforeach
                    </div>
                    <x-button variant="primary" class="w-full mt-10 py-4 shadow-lg">Pilih Paket Pro</x-button>
                </x-card>

                <x-card class="hover:border-gray-300 transition-all">
                    <div class="text-center space-y-4">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Enterprise</p>
                        <h4 class="text-4xl font-black dark:text-white">Custom</h4>
                        <p class="text-sm text-gray-500">Kapasitas tanpa batas untuk skala perusahaan besar.</p>
                    </div>
                    <div class="mt-8 space-y-4">
                        @foreach (['Server Dedicated', 'SLA 99.9%', 'Manager Akun Khusus'] as $f)
                            <div class="flex items-center gap-3 text-sm font-medium text-gray-500">
                                <i class="ti ti-check text-indigo-600"></i> {{ $f }}
                            </div>
                        @endforeach
                    </div>
                    <x-button variant="secondary" class="w-full mt-10">Hubungi Kami</x-button>
                </x-card>
            </div>
        </section>

    </div>
@endsection