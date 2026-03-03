@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="space-y-8 pb-20" x-data="{ activeTab: 'personal' }">
    
    {{-- Header Section (Cover) --}}
    <div class="relative h-48 md:h-60 rounded-[2.5rem] overflow-hidden bg-indigo-600">
        <div class="absolute inset-0 opacity-10">
            <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white"></path>
            </svg>
        </div>
        <div class="absolute bottom-6 right-8">
            <x-button variant="secondary" class="rounded-2xl bg-white/10 border-white/20 text-white hover:bg-white/20">
                <i class="ti ti-camera mr-2"></i> Ganti Sampul
            </x-button>
        </div>
    </div>

    {{-- Profile Header Card --}}
    <div class="-mt-20 relative px-4 sm:px-8">
        <div class="flex flex-col md:flex-row items-end gap-6">
            <div class="relative group">
                <x-avatar 
                    src="https://ui-avatars.com/api/?name=Rafael+Nuansa&background=6366f1&color=fff" 
                    size="xl" 
                    shape="3xl" 
                />
                <button class="absolute bottom-2 right-2 p-2 bg-indigo-600 text-white rounded-xl opacity-0 group-hover:opacity-100 transition-all active:scale-95">
                    <i class="ti ti-pencil text-sm"></i>
                </button>
            </div>
            
            <div class="flex-1 mb-2">
                <div class="flex flex-wrap items-center gap-3">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Aulia Azizah</h1>
                    <x-badge variant="primary" type="soft" icon="discount-check">Verified</x-badge>
                </div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mt-1">
                    aulia.azizah@bpskutim.go.id
                </p>
            </div>

            <div class="flex items-center gap-3 mb-2">
                <x-button variant="secondary" icon="share" class="rounded-xl">
                    Bagikan
                </x-button>
                <x-button variant="primary" icon="edit" class="rounded-xl">
                    Edit 
                </x-button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mt-6">
        
        {{-- Sisi Kiri: Info Ringkas --}}
        <div class="lg:col-span-4 space-y-6">
            <x-card title="Informasi Akun">
                <div class="space-y-5">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-gray-800 flex items-center justify-center text-gray-400">
                            <i class="ti ti-briefcase"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-400">Jabatan</p>
                            <p class="text-sm font-bold text-gray-900 dark:text-white">Chief Technical Officer</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-gray-800 flex items-center justify-center text-gray-400">
                            <i class="ti ti-map-pin"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-400">Lokasi</p>
                            <p class="text-sm font-bold text-gray-900 dark:text-white">Jakarta, Indonesia</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-gray-800 flex items-center justify-center text-gray-400">
                            <i class="ti ti-calendar"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-400">Bergabung</p>
                            <p class="text-sm font-bold text-gray-900 dark:text-white">Januari 2024</p>
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card title="Statistik">
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-800 text-center">
                        <p class="text-xl font-bold text-indigo-600">128</p>
                        <p class="text-[10px] font-bold text-gray-400">Proyek</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-800 text-center">
                        <p class="text-xl font-bold text-emerald-600">4.9</p>
                        <p class="text-[10px] font-bold text-gray-400">Rating</p>
                    </div>
                </div>
            </x-card>
        </div>

        {{-- Sisi Kanan: Form Pengaturan --}}
        <div class="lg:col-span-8">
            <x-card :padding="false">
                {{-- Tab Navigation --}}
                <div class="flex items-center gap-6 px-8 border-b border-gray-100 dark:border-gray-800">
                    <button @click="activeTab = 'personal'" 
                        :class="activeTab === 'personal' ? 'text-indigo-600 border-b-2 border-indigo-600 py-5' : 'text-gray-400 py-5'"
                        class="text-sm font-bold transition-all">
                        Data Diri
                    </button>
                    <button @click="activeTab = 'security'" 
                        :class="activeTab === 'security' ? 'text-indigo-600 border-b-2 border-indigo-600 py-5' : 'text-gray-400 py-5'"
                        class="text-sm font-bold transition-all">
                        Keamanan
                    </button>
                </div>

                {{-- Tab Content: Personal Data --}}
                <div x-show="activeTab === 'personal'" class="p-8 " x-transition>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1.5">
                            <label class="text-sm font-bold text-gray-400 ml-1">Nama Lengkap</label>
                            <input type="text" value="Aulia Azizah" class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-xl px-4 py-3 text-sm font-medium outline-none focus:ring-2 focus:ring-indigo-500/10 dark:text-white transition-all">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-sm font-bold text-gray-400 ml-1">Alamat Email</label>
                            <input type="email" value="aulia.azizah@bpskutim.go.id" class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-xl px-4 py-3 text-sm font-medium outline-none focus:ring-2 focus:ring-indigo-500/10 dark:text-white transition-all">
                        </div>
                        <div class="space-y-1.5 md:col-span-2">
                            <label class="text-sm font-bold text-gray-400 ml-1">Bio Singkat</label>
                            <textarea rows="3" class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-xl px-4 py-3 text-sm font-medium outline-none focus:ring-2 focus:ring-indigo-500/10 dark:text-white transition-all">Fullstack Developer based in Jakarta.</textarea>
                        </div>
                    </div>
                    <div class="flex justify-end pt-2">
                        <x-button variant="primary" icon="update">Simpan Perubahan</x-button>
                    </div>
                </div>

                {{-- Tab Content: Security --}}
                <div x-show="activeTab === 'security'" class="p-8 " x-transition x-cloak>
                    <div class="bg-gray-50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-800 p-5 rounded-2xl flex items-start gap-4">
                        <i class="ti ti-shield-check text-indigo-500 text-xl"></i>
                        <div>
                            <h4 class="text-sm font-bold text-gray-900 dark:text-white">Autentikasi Dua Faktor (2FA)</h4>
                            <p class="text-xs text-gray-500 mt-1 leading-relaxed">Tambahkan langkah keamanan ekstra pada akun Anda.</p>
                            <button class="mt-3 text-xs font-bold text-indigo-600 hover:underline">Aktifkan Sekarang</button>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <h4 class="text-sm font-bold text-gray-900 dark:text-white">Ganti Kata Sandi</h4>
                        <div class="grid grid-cols-1 gap-5">
                            <input type="password" placeholder="Kata Sandi Saat Ini" class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-xl px-4 py-3 text-sm font-medium outline-none focus:ring-2 focus:ring-indigo-500/10 dark:text-white transition-all">
                            <input type="password" placeholder="Kata Sandi Baru" class="w-full bg-gray-50 dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-xl px-4 py-3 text-sm font-medium outline-none focus:ring-2 focus:ring-indigo-500/10 dark:text-white transition-all">
                        </div>
                    </div>
                    <div class="flex justify-end pt-2">
                        <x-button variant="primary" class="rounded-xl px-8">Update Sandi</x-button>
                    </div>
                </div>
            </x-card>
        </div>
    </div>
</div>
@endsection