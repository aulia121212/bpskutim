@extends('layouts.auth')

@section('title', 'Login - Laravael Dashboard')

@section('content')
    {{-- Container Utama: Menggunakan min-h-screen agar bisa scroll di mobile --}}
    <div class="relative flex flex-col min-h-screen bg-white dark:bg-gray-950 md:flex-row" x-data>

        {{-- Floating Theme Switcher --}}
        <div class="absolute top-4 right-4 z-[60] md:top-6 md:right-6">
            <button @click="$store.theme.toggle()"
                class="w-10 h-10 md:w-11 md:h-11 flex items-center justify-center rounded-xl md:rounded-2xl bg-white/70 dark:bg-gray-900/60 backdrop-blur border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:text-indigo-600 transition-all active:scale-95">
                <i class="ti text-xl transition-transform duration-200"
                    :class="$store.theme.theme === 'light' ? 'ti-moon' : 'ti-sun rotate-180'"></i>
            </button>
        </div>

        {{-- LEFT SIDE: BRANDING AREA --}}
        {{-- Diubah: Muncul hanya di md (tablet ke atas) --}}
        <div class="hidden md:flex md:w-1/2 lg:w-3/5 relative overflow-hidden bg-indigo-50 dark:bg-indigo-600 sticky top-0 h-screen">
            {{-- Background Decorations --}}
            <div class="absolute inset-0 z-0">
                <div class="absolute -top-[15%] -left-[15%] w-[70%] h-[70%] rounded-full blur-[140px] bg-indigo-300/40 dark:bg-purple-500/50"></div>
                <div class="absolute -bottom-[15%] -right-[15%] w-[60%] h-[60%] rounded-full blur-[120px] bg-sky-300/40 dark:bg-indigo-400/40"></div>
                
                {{-- Dot Pattern --}}
                <div class="absolute inset-0 opacity-20 dark:hidden" style="background-image: radial-gradient(circle, rgba(0,0,0,.15) 1px, transparent 1px); background-size: 40px 40px;"></div>
                <div class="absolute inset-0 hidden dark:block opacity-20" style="background-image: radial-gradient(circle, rgba(255,255,255,.25) 1px, transparent 1px); background-size: 40px 40px;"></div>
                
                {{-- Glass Strip --}}
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[120%] h-[40%] rotate-12 backdrop-blur-md bg-white/40 dark:bg-white/5 border-y border-black/5 dark:border-white/10"></div>
            </div>

            {{-- Content --}}
            <div class="relative z-10 w-full h-full p-12 lg:p-16 flex flex-col justify-between text-gray-900 dark:text-white">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center text-indigo-600 shadow-sm">
                        <i class="ti ti-brand-laravel text-3xl font-black"></i>
                    </div>
                    <span class="text-2xl font-bold tracking-tight">Laravael UI</span>
                </div>

                <div class="max-w-xl space-y-6 lg:space-y-8">
                    <div class="space-y-4">
                        <span class="inline-block px-4 py-2 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700 dark:bg-white/10 dark:text-white border border-indigo-200 dark:border-white/20">
                           Laravael Dashboard UI Kit
                        </span>
                        <h2 class="text-4xl lg:text-6xl font-bold leading-[1.1] tracking-tight">
                           Tailwind UI Kit for <br>
                            <span class="text-indigo-600 dark:text-indigo-200">Laravel Framework</span>
                        </h2>
                    </div>
                    <p class="text-lg lg:text-xl font-medium leading-relaxed text-gray-700 dark:text-indigo-50/80">
                        Elevate your development workflow with meticulously crafted UI components.
                    </p>

                    {{-- Avatars --}}
                    <div class="flex items-center gap-6 pt-4">
                        <div class="flex -space-x-3">
                            @foreach ([1,2,3,4] as $i)
                                <div class="w-10 h-10 rounded-full border-2 border-indigo-50 dark:border-indigo-600 overflow-hidden">
                                    <img src="https://i.pravatar.cc/150?u={{ $i + 20 }}" alt="user">
                                </div>
                            @endforeach
                        </div>
                        <p class="text-sm font-bold text-gray-700 dark:text-white/80">
                            Join <span class="underline decoration-indigo-400">10k+ developers</span>.
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-6 text-sm font-medium text-gray-600 dark:text-white/60">
                    <span>© 2026 LaravaelUI</span>
                </div>
            </div>
        </div>

        {{-- RIGHT SIDE: LOGIN FORM --}}
        <div class="w-full md:w-1/2 lg:w-2/5 flex flex-col justify-center items-center p-6 sm:p-12 lg:p-20 bg-white dark:bg-gray-950">
            
            {{-- Mobile Logo: Muncul hanya di layar kecil --}}
            <div class="w-full mb-12 md:hidden">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-600/20">
                        <i class="ti ti-brand-laravel text-2xl"></i>
                    </div>
                    <span class="text-xl font-bold dark:text-white tracking-tighter">LaravaelUI</span>
                </div>
            </div>

            <div class="w-full max-w-md space-y-8">
                <div class="space-y-2">
                    <h3 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white tracking-tight">Welcome back</h3>
                    <p class="text-gray-500 dark:text-gray-400 font-medium">Please enter your details to sign in.</p>
                </div>

                <form action="#" method="POST" class="space-y-6">
                    @csrf
                    <div class="space-y-5">
                        <x-input label="Email address" name="email" type="email" icon="mail" placeholder="hello@example.com" required />

                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <label class="text-sm font-bold text-gray-700 dark:text-gray-300">Password</label>
                                <a href="#" class="text-xs text-indigo-600 font-bold hover:text-indigo-500 transition-colors">Forgot password?</a>
                            </div>
                            <x-input name="password" type="password" icon="lock" placeholder="••••••••" required />
                        </div>
                    </div>

                    <div class="flex items-center">
                        <x-checkbox name="remember" label="Keep me signed in" />
                    </div>

                    <x-button type="submit" icon="login" variant="primary" class="w-full">
                        Sign In
                    </x-button>

                    <div class="relative flex items-center py-2">
                        <div class="flex-grow border-t border-gray-100 dark:border-gray-800"></div>
                        <span class="flex-shrink mx-4 text-gray-400 text-[10px] font-bold uppercase tracking-widest">Or continue with</span>
                        <div class="flex-grow border-t border-gray-100 dark:border-gray-800"></div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <x-button variant="secondary" icon="brand-google" class="w-full rounded-2xl text-xs font-bold border-gray-200 dark:border-gray-800">Google</x-button>
                        <x-button variant="secondary" icon="brand-github" class="w-full rounded-2xl text-xs font-bold border-gray-200 dark:border-gray-800">Github</x-button>
                    </div>
                </form>

                <p class="text-center text-sm text-gray-500 font-medium">
                    Don't have an account?
                    <a href="#" class="text-indigo-600 font-bold hover:underline underline-offset-4 decoration-2">Create Account</a>
                </p>
            </div>
        </div>
    </div>
@endsection