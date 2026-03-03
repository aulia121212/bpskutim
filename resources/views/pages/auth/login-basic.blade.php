@extends('layouts.auth')

@section('title', 'Login - LaravaelUI Dashboard')

@section('content')
<div class="min-h-screen flex flex-col justify-center items-center p-6 bg-gray-50 dark:bg-gray-950 relative" x-data>
    
    <div class="absolute top-8 right-8">
        <button 
            @click="$store.theme.toggle()" 
            class="w-12 h-12 flex items-center justify-center rounded-2xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 text-gray-500 dark:text-gray-400 hover:text-indigo-600 transition-all shadow-sm active:scale-95"
        >
            <i class="ti text-xl" :class="$store.theme.theme === 'light' ? 'ti-moon' : 'ti-sun'"></i>
        </button>
    </div>

    <div class="mb-8 flex flex-col items-center gap-4">
        <a href="/">
             <x-logo :with-text="false" size="md" />
        </a>
        <h1 class="text-xl font-bold text-gray-900 dark:text-white ">
            LaravaelUI <span class="text-indigo-600">Dashboard</span>
        </h1>
    </div>

    <div class="w-full max-w-md">
        <x-card class="shadow-sm border-gray-200 dark:border-gray-800">
            <div class="space-y-6">
                
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Selamat Datang Kembali</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Silakan masuk untuk mengakses akun Anda.</p>
                </div>

                <form action="#" method="POST" class="space-y-6">
                    @csrf

                    <x-input 
                        label="Email" 
                        name="email" 
                        type="email" 
                        icon="mail"
                        placeholder="yourname@example.com" 
                        required 
                        autofocus
                    />

                    <div class="space-y-1">
                        <x-input 
                            label="Password" 
                            name="password" 
                            type="password" 
                            icon="lock"
                            placeholder="••••••••" 
                            required 
                        />
                        <div class="flex justify-end">
                            <a href="#" class="text-[11px] font-semibold text-indigo-600 hover:text-indigo-700 uppercase tracking-widest transition-colors">Lupa Password?</a>
                        </div>
                    </div>

                    <x-checkbox name="remember" label="Ingat Sesi Saya" />

                    <div class="space-y-4 pt-2">
                        <x-button type="submit" variant="primary" class="w-full shadow-indigo-500/20">
                            Log in
                        </x-button>

                        <div class="text-center">
                            <a href="#" class="text-sm text-gray-500 hover:text-indigo-600 font-medium transition-colors">
                                Belum punya akun? <span class="font-semibold underline underline-offset-4">Daftar Sekarang</span>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </x-card>

        <p class="text-center mt-8 text-xs text-gray-400 font-semibold uppercase tracking-widest opacity-60">
            &copy; {{ date('Y') }} LaravaelUI Team. All rights reserved.
        </p>
    </div>
</div>
@endsection