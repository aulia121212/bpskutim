@extends('layouts.auth')

@section('title', 'Login - Laravael Dashboard')

@section('content')
<div class="fixed inset-0 flex overflow-hidden bg-gray-50 dark:bg-gray-950" x-data>
    
    {{-- Decorative Background Elements --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-indigo-500/10 rounded-full blur-[120px] dark:bg-indigo-500/5"></div>
        <div class="absolute -bottom-[10%] -right-[10%] w-[40%] h-[40%] bg-purple-500/10 rounded-full blur-[120px] dark:bg-purple-500/5"></div>
        {{-- Dot Pattern --}}
        <div class="absolute inset-0 opacity-[0.03] dark:opacity-[0.05]" style="background-image: radial-gradient(#4f46e5 1px, transparent 1px); background-size: 24px 24px;"></div>
    </div>

    {{-- Theme Switcher Floating --}}
    <div class="absolute top-6 right-6 z-[60]">
        <button @click="$store.theme.toggle()" 
            class="w-12 h-12 flex items-center justify-center rounded-2xl bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 text-gray-500 dark:text-gray-400 hover:text-indigo-600 transition-all shadow-sm active:scale-95">
            <i class="ti text-2xl" :class="$store.theme.theme === 'light' ? 'ti-moon' : 'ti-sun'"></i>
        </button>
    </div>

    <div class="relative w-full max-w-7xl mx-auto flex items-center justify-center p-6 md:p-12">
        
        {{-- Card Container --}}
        <div class="w-full max-w-5xl grid md:grid-cols-2 bg-white dark:bg-gray-900 rounded-[3rem] shadow-2xl shadow-indigo-500/10 border border-gray-100 dark:border-gray-800 overflow-hidden">
            
            {{-- Branding Section (Left) --}}
            <div class="hidden md:flex flex-col justify-between p-12 lg:p-16 bg-indigo-600 relative overflow-hidden">
                {{-- Abstract Shapes --}}
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-indigo-400/20 rounded-full -ml-32 -mb-32 blur-3xl"></div>
                
                <div class="relative z-10 flex items-center gap-3">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-indigo-600 shadow-lg">
                        <i class="ti ti-brand-laravel text-2xl font-black"></i>
                    </div>
                    <span class="text-xl font-bold text-white tracking-tight">LaravaelUI</span>
                </div>

                <div class="relative z-10 space-y-6">
                    <h2 class="text-4xl lg:text-5xl font-bold text-white leading-[1.1] tracking-tight">
                        Powering the <br> 
                        <span class="text-indigo-200">Next Generation</span> <br>
                        of Dashboards.
                    </h2>
                    <p class="text-indigo-100/80 font-medium leading-relaxed max-w-sm">
                        Sistem manajemen modern dengan performa tinggi dan desain yang memanjakan mata.
                    </p>
                </div>

                <div class="relative z-10 flex items-center gap-4">
                    <div class="flex -space-x-3">
                        @foreach([1,2,3] as $i)
                            <img src="https://i.pravatar.cc/150?u={{$i+10}}" class="w-8 h-8 rounded-full border-2 border-indigo-600 shadow-sm">
                        @endforeach
                    </div>
                    <span class="text-xs font-bold text-indigo-100 uppercase tracking-widest">Trusted by 2k+ Teams</span>
                </div>
            </div>

            {{-- Form Section (Right) --}}
            <div class="p-10 lg:p-16 flex flex-col justify-center bg-white dark:bg-gray-900">
                
                <div class="md:hidden flex items-center gap-3 mb-10">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-500/20">
                        <i class="ti ti-brand-laravel text-2xl"></i>
                    </div>
                    <span class="text-xl font-bold dark:text-white tracking-tight">LaravaelUI</span>
                </div>

                <div class="space-y-8">
                    <div>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Login</h3>
                        <p class="text-gray-500 dark:text-gray-400 mt-2 font-medium">Selamat datang kembali! Silakan masukkan detail Anda.</p>
                    </div>

                    <form action="#" method="POST" class="space-y-5">
                        @csrf
                        <div class="space-y-4">
                            <x-input 
                                label="Alamat Email" 
                                name="email" 
                                type="email" 
                                icon="mail" 
                                placeholder="name@company.com" 
                                required 
                            />

                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <label class="text-sm font-bold text-gray-700 dark:text-gray-300">Kata Sandi</label>
                                    <a href="#" class="text-xs font-bold text-indigo-600 hover:text-indigo-500 transition-colors">Lupa Password?</a>
                                </div>
                                <x-input 
                                    name="password" 
                                    type="password" 
                                    icon="lock" 
                                    placeholder="••••••••" 
                                    required 
                                />
                            </div>
                        </div>

                        <div class="flex items-center">
                            <x-checkbox name="remember" label="Biarkan saya tetap masuk" />
                        </div>

                        <x-button type="submit" variant="primary" class="w-full py-4 rounded-2xl shadow-lg shadow-indigo-600/20">
                            Masuk ke Dashboard
                        </x-button>

                        <div class="relative flex items-center py-2">
                            <div class="flex-grow border-t border-gray-100 dark:border-gray-800"></div>
                            <span class="flex-shrink mx-4 text-gray-400 text-[10px] font-bold uppercase tracking-widest">Atau</span>
                            <div class="flex-grow border-t border-gray-100 dark:border-gray-800"></div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <x-button variant="secondary" icon="brand-google" class="w-full rounded-xl text-xs font-bold">Google</x-button>
                            <x-button variant="secondary" icon="brand-github" class="w-full rounded-xl text-xs font-bold">Github</x-button>
                        </div>
                    </form>

                    <p class="text-center text-sm text-gray-500 dark:text-gray-400 font-medium">
                        Baru di sini? 
                        <a href="#" class="text-indigo-600 dark:text-indigo-400 font-bold hover:underline underline-offset-4 transition-all">Buat Akun Baru</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection