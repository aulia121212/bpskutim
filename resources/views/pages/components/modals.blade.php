@extends('layouts.app')

@section('title', 'Modals')

@section('content')
<div class="space-y-10 pb-20">
    
    <div class="flex flex-col gap-2">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Modals</h1>
        <p class="text-gray-500 dark:text-gray-400 font-medium text-sm">Dialog interaktif premium untuk alur kerja profesional.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <section class="space-y-4" x-data="{ open: false, size: 'max-w-lg', showCode: false }">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-bold uppercase text-indigo-600 dark:text-indigo-400">Standard Modal & Sizes</h3>
                <button @click="showCode = !showCode" class="text-[10px] font-bold uppercase text-gray-400 hover:text-indigo-600 transition-colors flex items-center gap-1">
                    <i class="ti" :class="showCode ? 'ti-eye-off' : 'ti-code'"></i>
                    <span x-text="showCode ? 'Hide Code' : 'Show Code'"></span>
                </button>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-200 dark:border-gray-800 p-8 flex flex-col items-center justify-center min-h-[200px] gap-4">
                <div class="flex flex-wrap justify-center gap-2">
                    <button @click="open = true; size = 'max-w-xs'" class="px-6 py-3 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-white font-bold rounded-xl hover:bg-gray-200 transition-all">Small</button>
                    <button @click="open = true; size = 'max-w-lg'" class="px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition-all">Default (MD)</button>
                    <button @click="open = true; size = 'max-w-4xl'" class="px-6 py-3 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-white font-bold rounded-xl hover:bg-gray-200 transition-all">Large</button>
                </div>

                <template x-teleport="body">
                    <div x-show="open" class="fixed inset-0 z-[10001] flex items-center justify-center p-4" x-cloak>
                        <div x-show="open" x-transition.opacity @click="open = false" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm"></div>
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-300" 
                             x-transition:enter-start="opacity-0 scale-95 translate-y-4" 
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             :class="size"
                             class="relative w-full bg-white dark:bg-gray-900 rounded-[2rem] p-8 border border-gray-100 dark:border-gray-800 shadow-2xl">
                            <div class="flex items-center justify-between mb-6">
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white">Modal <span x-text="size.split('-')[2].toUpperCase()"></span></h4>
                                <button @click="open = false" class="text-gray-400 hover:text-gray-600 transition-colors p-1 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800"><i class="ti ti-x text-2xl"></i></button>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400 font-medium leading-relaxed">Ukuran kontainer modal ini disesuaikan secara dinamis menggunakan class Tailwind.</p>
                            <div class="mt-8 flex justify-end gap-3">
                                <button @click="open = false" class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 transition-all">Understood</button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            <div x-show="showCode" x-collapse x-cloak>
                <div class="bg-gray-50 dark:bg-gray-950 border-t border-gray-100 dark:border-gray-800 p-6 font-mono text-[11px] text-gray-500">
                    <pre><code>&lt;!-- Modal with Dynamic Sizes --&gt;
&lt;div :class="size" class="relative w-full bg-white rounded-[2rem] p-8"&gt;
   &lt;!-- Content --&gt;
&lt;/div&gt;

&lt;!-- Sizes used: max-w-xs (SM), max-w-lg (MD), max-w-4xl (LG) --&gt;</code></pre>
                </div>
            </div>
        </section>

        <section class="space-y-4" x-data="{ open: false, showCode: false }">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-bold uppercase text-indigo-600 dark:text-indigo-400">Side Drawer</h3>
                <button @click="showCode = !showCode" class="text-[10px] font-bold uppercase text-gray-400 hover:text-indigo-600 transition-colors flex items-center gap-1">
                    <i class="ti" :class="showCode ? 'ti-eye-off' : 'ti-code'"></i>
                    <span x-text="showCode ? 'Hide Code' : 'Show Code'"></span>
                </button>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-200 dark:border-gray-800 p-8 flex flex-col items-center justify-center min-h-[200px]">
                <button @click="open = true" class="px-6 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-white font-bold rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-all active:scale-95">
                    Open Sidebar Panel
                </button>

                <template x-teleport="body">
                    <div x-show="open" class="fixed inset-0 z-[10001] flex justify-end" x-cloak>
                        <div x-show="open" x-transition.opacity @click="open = false" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm"></div>
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-500" 
                             x-transition:enter-start="translate-x-full" 
                             x-transition:enter-end="translate-x-0"
                             x-transition:leave="transition ease-in duration-300"
                             x-transition:leave-start="translate-x-0"
                             x-transition:leave-end="translate-x-full"
                             class="relative w-full max-w-sm bg-white dark:bg-gray-900 h-full border-l border-gray-100 dark:border-gray-800 p-8 flex flex-col">
                            <div class="flex items-center justify-between mb-10">
                                <h4 class="text-xl font-bold dark:text-white">Settings Panel</h4>
                                <button @click="open = false" class="p-2 bg-gray-50 dark:bg-gray-800 rounded-xl hover:text-indigo-600 transition-colors"><i class="ti ti-x text-xl"></i></button>
                            </div>
                            <div class="flex-1 space-y-6 text-sm text-gray-500 font-medium">
                                <p>Atur konfigurasi aplikasi secara langsung melalui panel samping ini.</p>
                            </div>
                            <button @click="open = false" class="w-full py-4 bg-indigo-600 text-white font-bold rounded-2xl shadow-lg shadow-indigo-500/25">Save Changes</button>
                        </div>
                    </div>
                </template>
            </div>
            <div x-show="showCode" x-collapse x-cloak>
                <div class="bg-gray-50 dark:bg-gray-950 border-t border-gray-100 dark:border-gray-800 p-6 font-mono text-[11px] text-gray-500">
                    <pre><code>&lt;!-- Side Drawer Transition --&gt;
x-transition:enter-start="translate-x-full" 
x-transition:enter-end="translate-x-0"</code></pre>
                </div>
            </div>
        </section>

        <section class="space-y-4" x-data="{ open: false, showCode: false }">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-bold uppercase text-indigo-600 dark:text-indigo-400">Action Sheet</h3>
                <button @click="showCode = !showCode" class="text-[10px] font-bold uppercase text-gray-400 hover:text-indigo-600 transition-colors flex items-center gap-1">
                    <i class="ti" :class="showCode ? 'ti-eye-off' : 'ti-code'"></i>
                    <span x-text="showCode ? 'Hide Code' : 'Show Code'"></span>
                </button>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-200 dark:border-gray-800 p-8 flex flex-col items-center justify-center min-h-[200px]">
                <button @click="open = true" class="px-6 py-3 bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-bold rounded-xl flex items-center gap-2 transition-all active:scale-95 shadow-lg shadow-gray-900/10">
                    <i class="ti ti-share"></i> Share Content
                </button>

                <template x-teleport="body">
                    <div x-show="open" class="fixed inset-0 z-[10001] flex items-end justify-center" x-cloak>
                        <div x-show="open" x-transition.opacity @click="open = false" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm"></div>
                        <div x-show="open" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0"
                             x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-y-0" x-transition:leave-end="translate-y-full"
                             class="relative w-full max-w-2xl bg-white dark:bg-gray-900 rounded-t-[2.5rem] p-8 pb-10 border-t border-gray-100 dark:border-gray-800 shadow-2xl">
                            <div class="w-12 h-1 bg-gray-200 dark:bg-gray-700 rounded-full mx-auto mb-8 cursor-pointer" @click="open = false"></div>
                            <h4 class="text-xl font-bold dark:text-white mb-8 text-center">Bagikan Konten</h4>
                            <div class="grid grid-cols-4 gap-4">
                                @foreach(['Whatsapp' => 'brand-whatsapp', 'Telegram' => 'brand-telegram', 'Link' => 'link', 'Mail' => 'mail'] as $label => $icon)
                                <button class="flex flex-col items-center gap-3 group">
                                    <div class="w-14 h-14 rounded-2xl bg-gray-50 dark:bg-gray-800 flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300 group-hover:-translate-y-1 shadow-sm">
                                        <i class="ti ti-{{ $icon }} text-2xl"></i>
                                    </div>
                                    <span class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-tighter">{{ $label }}</span>
                                </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            <div x-show="showCode" x-collapse x-cloak>
                <div class="bg-gray-50 dark:bg-gray-950 border-t border-gray-100 dark:border-gray-800 p-6 font-mono text-[11px] text-gray-500">
                    <pre><code>&lt;!-- BottomSheet Transition --&gt;
x-transition:enter-start="translate-y-full" 
x-transition:enter-end="translate-y-0"</code></pre>
                </div>
            </div>
        </section>

        <section class="space-y-4" x-data="{ open: false, showCode: false }">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-bold uppercase text-indigo-600 dark:text-indigo-400">OTP / Security</h3>
                <button @click="showCode = !showCode" class="text-[10px] font-bold uppercase text-gray-400 hover:text-indigo-600 transition-colors flex items-center gap-1">
                    <i class="ti" :class="showCode ? 'ti-eye-off' : 'ti-code'"></i>
                    <span x-text="showCode ? 'Hide Code' : 'Show Code'"></span>
                </button>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-200 dark:border-gray-800 p-8 flex flex-col items-center justify-center min-h-[200px]">
                <button @click="open = true" class="px-6 py-3 bg-amber-500 text-white font-bold rounded-xl hover:bg-amber-600 transition-all shadow-lg shadow-amber-500/20 active:scale-95">
                    Security Check
                </button>

                <template x-teleport="body">
                    <div x-show="open" class="fixed inset-0 z-[10001] flex items-center justify-center p-4" x-cloak>
                        <div x-show="open" x-transition.opacity @click="open = false" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm"></div>
                        <div x-show="open" x-transition.scale.95 class="relative w-full max-w-sm bg-white dark:bg-gray-900 rounded-[2rem] p-8 text-center border dark:border-gray-800 shadow-2xl">
                            <div class="w-16 h-16 bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="ti ti-shield-check text-3xl"></i>
                            </div>
                            <h4 class="text-xl font-bold dark:text-white mb-2">Security Verification</h4>
                            <p class="text-xs text-gray-500 font-medium mb-6 leading-relaxed">Enter the 4-digit code sent to your email.</p>
                            <div class="flex justify-center gap-3">
                                <template x-for="i in 4">
                                    <input type="text" maxlength="1" class="w-12 h-14 bg-gray-50 dark:bg-gray-800 border-none rounded-xl text-center font-bold text-lg focus:ring-2 focus:ring-indigo-500 outline-none dark:text-white">
                                </template>
                            </div>
                            <button @click="open = false" class="w-full mt-8 py-4 bg-indigo-600 text-white font-bold rounded-2xl active:scale-95 transition-all">Verify Now</button>
                        </div>
                    </div>
                </template>
            </div>
            <div x-show="showCode" x-collapse x-cloak>
                <div class="bg-gray-50 dark:bg-gray-950 border-t border-gray-100 dark:border-gray-800 p-6 font-mono text-[11px] text-gray-500">
                    <pre><code>&lt;!-- Input OTP Grid Inside Modal --&gt;
&lt;div class="flex justify-center gap-3"&gt;
    &lt;input type="text" maxlength="1" class="w-12 h-14 bg-gray-50 rounded-xl" /&gt;
&lt;/div&gt;</code></pre>
                </div>
            </div>
        </section>

        <section class="space-y-4" x-data="{ open: false, showCode: false }">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-bold uppercase text-indigo-600 dark:text-indigo-400">Search Overlay</h3>
                <button @click="showCode = !showCode" class="text-[10px] font-bold uppercase text-gray-400 hover:text-indigo-600 transition-colors flex items-center gap-1">
                    <i class="ti" :class="showCode ? 'ti-eye-off' : 'ti-code'"></i>
                    <span x-text="showCode ? 'Hide Code' : 'Show Code'"></span>
                </button>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-200 dark:border-gray-800 p-8 flex flex-col items-center justify-center min-h-[200px]">
                <button @click="open = true" class="px-6 py-3 bg-gray-100 dark:bg-gray-800 text-gray-500 font-bold rounded-xl flex items-center gap-3 w-full max-w-xs hover:bg-gray-200 dark:hover:bg-gray-700 transition-all border border-transparent hover:border-indigo-500/20">
                    <i class="ti ti-search text-lg"></i> Cari sesuatu...
                </button>

                <template x-teleport="body">
                    <div x-show="open" class="fixed inset-0 z-[10001] flex items-start justify-center p-4 md:p-12" x-cloak>
                        <div x-show="open" x-transition.opacity @click="open = false" class="fixed inset-0 bg-gray-900/60 backdrop-blur-md"></div>
                        <div x-show="open" 
                             x-transition:enter="transition duration-300 ease-out" 
                             x-transition:enter-start="opacity-0 -translate-y-8" 
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="relative w-full max-w-2xl bg-white dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800 shadow-2xl overflow-hidden mt-10">
                            <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex items-center gap-4">
                                <i class="ti ti-search text-2xl text-indigo-600"></i>
                                <input type="text" class="flex-1 bg-transparent border-none outline-none text-lg font-medium dark:text-white" placeholder="Mencari file, proyek, atau dokumen..." autofocus>
                                <span class="text-[10px] font-bold text-gray-400 px-2 py-1 bg-gray-50 dark:bg-gray-800 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700">ESC</span>
                            </div>
                            <div class="p-12 text-center">
                                <i class="ti ti-loader-2 text-4xl text-gray-200 dark:text-gray-700 animate-spin mb-4 mx-auto block"></i>
                                <p class="text-sm text-gray-400 font-medium">Mulailah mengetik untuk melihat hasil...</p>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            <div x-show="showCode" x-collapse x-cloak>
                <div class="bg-gray-50 dark:bg-gray-950 border-t border-gray-100 dark:border-gray-800 p-6 font-mono text-[11px] text-gray-500">
                    <pre><code>&lt;!-- Command Palette Search Overlay --&gt;
x-transition:enter-start="opacity-0 -translate-y-8" 
x-transition:enter-end="opacity-100 translate-y-0"</code></pre>
                </div>
            </div>
        </section>

        <section class="space-y-4" x-data="{ open: false, showCode: false }">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-bold uppercase text-indigo-600 dark:text-indigo-400">Full Screen Overlay</h3>
                <button @click="showCode = !showCode" class="text-[10px] font-bold uppercase text-gray-400 hover:text-indigo-600 transition-colors flex items-center gap-1">
                    <i class="ti" :class="showCode ? 'ti-eye-off' : 'ti-code'"></i>
                    <span x-text="showCode ? 'Hide Code' : 'Show Code'"></span>
                </button>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-200 dark:border-gray-800 p-8 flex flex-col items-center justify-center min-h-[200px]">
                <button @click="open = true" class="px-6 py-3 bg-rose-600 text-white font-bold rounded-xl active:scale-95 transition-all shadow-lg shadow-rose-500/20">
                    Open Fullscreen Detail
                </button>

                <template x-teleport="body">
                    <div x-show="open" class="fixed inset-0 z-[10001] bg-white dark:bg-gray-950 flex flex-col" x-cloak
                         x-transition:enter="transition duration-500 ease-out" 
                         x-transition:enter-start="opacity-0 scale-105" 
                         x-transition:enter-end="opacity-100 scale-100">
                        <div class="p-6 border-b border-gray-100 dark:border-gray-900 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-rose-100 dark:bg-rose-900/30 text-rose-600 flex items-center justify-center rounded-xl"><i class="ti ti-maximize"></i></div>
                                <h4 class="text-xl font-bold dark:text-white">Fullscreen Workspace</h4>
                            </div>
                            <button @click="open = false" class="px-5 py-2 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 rounded-xl text-xs font-bold uppercase hover:bg-rose-600 hover:text-white transition-all">Close ESC</button>
                        </div>
                        <div class="flex-1 p-12 overflow-y-auto">
                            <div class="max-w-4xl mx-auto">
                                <div class="h-[500px] bg-gray-50 dark:bg-gray-900/50 rounded-[3rem] border-2 border-dashed border-gray-200 dark:border-gray-800 flex items-center justify-center">
                                    <p class="text-gray-400 font-bold uppercase tracking-widest text-xs">Rich Editor / Workspace Area</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            <div x-show="showCode" x-collapse x-cloak>
                <div class="bg-gray-50 dark:bg-gray-950 border-t border-gray-100 dark:border-gray-800 p-6 font-mono text-[11px] text-gray-500">
                    <pre><code>&lt;!-- Fullscreen Modal Logic --&gt;
&lt;div class="fixed inset-0 bg-white h-screen w-screen"&gt;...&lt;/div&gt;</code></pre>
                </div>
            </div>
        </section>

    </div>
</div>
@endsection