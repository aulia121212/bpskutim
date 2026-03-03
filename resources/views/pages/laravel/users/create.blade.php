@extends('layouts.app')

@section('title', 'Tambah Pengguna Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 pb-20">
    
    {{-- Header & Breadcrumb --}}
    <div class="flex items-center justify-between">
        <div class="space-y-1">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Tambah Pengguna</h1>
            <nav class="flex items-center gap-2 text-xs font-medium text-gray-400">
                <a href="{{ route('laravel.users.index') }}" class="hover:text-indigo-600 transition-colors">Pengguna</a>
                <i class="ti ti-chevron-right"></i>
                <span class="text-gray-500 dark:text-gray-500">Buat Baru</span>
            </nav>
        </div>
        <x-button variant="secondary" href="{{ route('laravel.users.index') }}" class="rounded-xl">
            <i class="ti ti-arrow-left mr-2"></i> Kembali
        </x-button>
    </div>

    {{-- Form Card --}}
    <x-card title="Informasi Personal">
        <form action="{{ route('laravel.users.store') }}" method="POST" class="space-y-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Name Input --}}
                <div class="md:col-span-2">
                    <x-input 
                        label="Nama Lengkap" 
                        name="name" 
                        placeholder="Contoh: Aulia Azizah" 
                        value="{{ old('name') }}"
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
                        value="{{ old('email') }}"
                        required 
                    />
                    <p class="mt-2 text-[10px] text-gray-400 font-medium ml-1">Pastikan email aktif untuk proses verifikasi akun.</p>
                </div>

                {{-- Password Input --}}
                <div class="space-y-4">
                    <x-input 
                        type="password"
                        label="Kata Sandi" 
                        name="password" 
                        icon="lock"
                        placeholder="••••••••" 
                        required 
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
                        required 
                    />
                </div>
            </div>

            {{-- Info Alert --}}
            <div class="p-4 rounded-2xl bg-indigo-50 dark:bg-indigo-500/5 border border-indigo-100 dark:border-indigo-500/20 flex gap-3">
                <i class="ti ti-info-circle text-indigo-600 text-xl mt-0.5"></i>
                <div class="text-xs leading-relaxed text-indigo-800/70 dark:text-indigo-400/70 font-medium">
                    Kata sandi minimal harus terdiri dari 8 karakter dan mengandung kombinasi huruf dan angka untuk keamanan maksimal.
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50 dark:border-gray-800">
                <x-button type="reset" variant="secondary" class="rounded-xl">
                    Reset
                </x-button>
                <x-button type="submit" variant="primary" class="rounded-xl shadow-lg shadow-indigo-500/20">
                    Simpan Pengguna
                </x-button>
            </div>
        </form>
    </x-card>

    {{-- Footer Info --}}
    <p class="text-center text-xs text-gray-400 font-medium">
        Setiap pengguna baru akan didaftarkan sebagai member aktif secara default.
    </p>
</div>
@endsection