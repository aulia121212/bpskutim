@extends('layouts.app')

@section('title', 'Edit Pengguna - ' . $user->name)

@section('content')
<div class="max-w-4xl mx-auto space-y-8 pb-20">
    
    {{-- Header & Breadcrumb --}}
    <div class="flex items-center justify-between">
        <div class="space-y-1">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Edit Pengguna</h1>
            <nav class="flex items-center gap-2 text-xs font-medium text-gray-400">
                <a href="{{ route('laravel.users.index') }}" class="hover:text-indigo-600 transition-colors">Pengguna</a>
                <i class="ti ti-chevron-right"></i>
                <span class="text-gray-500 dark:text-gray-500">Edit Data</span>
            </nav>
        </div>
        <x-button variant="secondary" href="{{ route('laravel.users.index') }}" class="rounded-xl">
            <i class="ti ti-arrow-left mr-2"></i> Kembali
        </x-button>
    </div>

    {{-- Form Card --}}
    <x-card title="Pembaruan Informasi Personal">
        <form action="{{ route('laravel.users.update', $user->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Name Input --}}
                <div class="md:col-span-2">
                    <x-input 
                        label="Nama Lengkap" 
                        name="name" 
                        placeholder="Contoh: Aulia Azizah" 
                        value="{{ old('name', $user->name) }}"
                        required 
                    />
                </div>

                {{-- Email Input --}}
                <div class="md:col-span-2">
                    <x-input 
                        type="email"
                        label="Alamat Email" 
                        name="email" 
                        icon="mail"
                        placeholder="nama@perusahaan.com" 
                        value="{{ old('email', $user->email) }}"
                        required 
                    />
                    <p class="mt-2 text-[10px] text-gray-400 font-medium ml-1 italic">
                        Email unik digunakan sebagai identitas login pengguna.
                    </p>
                </div>

                <div class="md:col-span-2 pt-4 border-t border-gray-50 dark:border-gray-800">
                    <h4 class="text-sm font-bold text-gray-900 dark:text-white mb-1">Ganti Kata Sandi</h4>
                    <p class="text-xs text-gray-400">Biarkan kosong jika tidak ingin mengubah kata sandi.</p>
                </div>

                {{-- Password Input --}}
                <div class="space-y-4">
                    <x-input 
                        type="password"
                        label="Kata Sandi Baru" 
                        name="password" 
                        icon="lock"
                        placeholder="••••••••" 
                    />
                </div>

                {{-- Confirm Password Input --}}
                <div class="space-y-4">
                    <x-input 
                        type="password"
                        label="Konfirmasi Kata Sandi" 
                        name="password_confirmation" 
                        icon="lock-check"
                        placeholder="••••••••" 
                    />
                </div>
            </div>

            {{-- Info Alert --}}
            <div class="p-4 rounded-2xl bg-amber-50 dark:bg-amber-500/5 border border-amber-100 dark:border-amber-500/20 flex gap-3">
                <i class="ti ti-shield-lock text-amber-600 text-xl mt-0.5"></i>
                <div class="text-xs leading-relaxed text-amber-800/70 dark:text-amber-400/70 font-medium">
                    Sistem akan tetap menggunakan kata sandi lama jika field kata sandi baru tidak diisi. Jika diisi, pastikan minimal 8 karakter.
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50 dark:border-gray-800">
                <x-button variant="secondary" href="{{ route('laravel.users.index') }}" class="rounded-xl">
                    Batal
                </x-button>
                <x-button type="submit" variant="primary" class="rounded-xl shadow-lg shadow-indigo-500/20">
                    Update Pengguna
                </x-button>
            </div>
        </form>
    </x-card>

    {{-- User Meta Info --}}
    <x-card>
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 text-xs font-medium text-gray-400">
            <div class="flex items-center gap-2">
                <i class="ti ti-clock"></i>
                Terdaftar pada: <span class="text-gray-600 dark:text-gray-300">{{ $user->created_at->format('d M Y, H:i') }}</span>
            </div>
            <div class="flex items-center gap-2">
                <i class="ti ti-refresh"></i>
                Update terakhir: <span class="text-gray-600 dark:text-gray-300">{{ $user->updated_at->diffForHumans() }}</span>
            </div>
        </div>
    </x-card>
</div>
@endsection