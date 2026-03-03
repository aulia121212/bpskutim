@extends('layouts.app')

@section('title', 'Modern Alerts UI Kit')

@section('content')
    <div class="space-y-10 pb-20">

        <div class="flex flex-col gap-2">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Modern Alerts</h1>
            <p class="text-gray-500 dark:text-gray-400 font-medium text-sm">Notifikasi kontekstual yang bersih dengan fokus
                pada border dan warna lembut.</p>
        </div>

        <section class="space-y-4" x-data="{ showCode: false }">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-bold uppercase text-emerald-600 dark:text-emerald-400">Success Variant</h3>
                <button @click="showCode = !showCode"
                    class="text-[10px] font-bold uppercase text-gray-400 hover:text-indigo-600 transition-colors flex items-center gap-1">
                    <i class="ti" :class="showCode ? 'ti-eye-off' : 'ti-code'"></i>
                    <span x-text="showCode ? 'Hide Code' : 'Show Code'"></span>
                </button>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-200 dark:border-gray-800 overflow-hidden">
                <div class="p-8">
                    <div x-data="{ open: true }" x-show="open" x-transition
                        class="flex items-start gap-4 p-5 bg-emerald-50 dark:bg-emerald-500/10 rounded-2xl border border-emerald-200 dark:border-emerald-500/20">
                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-500 text-white">
                            <i class="ti ti-check text-xl"></i>
                        </div>
                        <div class="flex-1 pt-1">
                            <h4 class="text-sm font-bold text-emerald-900 dark:text-emerald-400">Pembaruan Berhasil</h4>
                            <p class="text-sm text-emerald-700 dark:text-emerald-400/70 mt-0.5">Semua data perubahan telah
                                disimpan secara aman ke server kami.</p>
                        </div>
                        <button @click="open = false"
                            class="text-emerald-500 hover:bg-emerald-500/10 p-1 rounded-lg transition-colors">
                            <i class="ti ti-x text-lg"></i>
                        </button>
                    </div>
                </div>
                <div x-show="showCode" x-collapse x-cloak>
                    <div class="bg-gray-50 dark:bg-gray-950 border-t border-gray-100 dark:border-gray-800 p-6">
                        <pre class="text-[11px] text-gray-600 dark:text-gray-400 overflow-x-auto"><code>&lt;div class="flex items-start gap-4 p-5 bg-emerald-50 dark:bg-emerald-500/10 rounded-2xl border border-emerald-200 dark:border-emerald-500/20"&gt;
    &lt;div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500 text-white"&gt;
        &lt;i class="ti ti-check text-xl"&gt;&lt;/i&gt;
    &lt;/div&gt;
    &lt;div class="flex-1"&gt;
        &lt;h4 class="text-sm font-bold text-emerald-900 dark:text-emerald-400"&gt;Title&lt;/h4&gt;
        &lt;p class="text-sm text-emerald-700 dark:text-emerald-400/70"&gt;Message text...&lt;/p&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                    </div>
                </div>
            </div>
        </section>

        <section class="space-y-4" x-data="{ showCode: false }">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-bold uppercase text-red-600 dark:text-red-400">Error Variant</h3>
                <button @click="showCode = !showCode"
                    class="text-[10px] font-bold uppercase text-gray-400 hover:text-indigo-600 transition-colors flex items-center gap-1">
                    <i class="ti" :class="showCode ? 'ti-eye-off' : 'ti-code'"></i>
                    <span x-text="showCode ? 'Hide Code' : 'Show Code'"></span>
                </button>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-200 dark:border-gray-800 overflow-hidden">
                <div class="p-8">
                    <div x-data="{ open: true }" x-show="open" x-transition
                        class="flex items-start gap-4 p-5 bg-red-50 dark:bg-red-500/10 rounded-2xl border border-red-200 dark:border-red-500/20">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-500 text-white">
                            <i class="ti ti-bolt text-xl"></i>
                        </div>
                        <div class="flex-1 pt-1">
                            <h4 class="text-sm font-bold text-red-900 dark:text-red-400">Kesalahan Sistem</h4>
                            <p class="text-sm text-red-700 dark:text-red-400/70 mt-0.5">Maaf, sistem tidak dapat memproses
                                permintaan Anda saat ini.</p>
                        </div>
                        <button @click="open = false"
                            class="text-red-500 hover:bg-red-500/10 p-1 rounded-lg transition-colors">
                            <i class="ti ti-x text-lg"></i>
                        </button>
                    </div>
                </div>
                <div x-show="showCode" x-collapse x-cloak>
                    <div class="bg-gray-50 dark:bg-gray-950 border-t border-gray-100 dark:border-gray-800 p-6">
                        <pre class="text-[11px] text-gray-600 dark:text-gray-400 overflow-x-auto"><code>&lt;div class="flex items-start gap-4 p-5 bg-red-50 dark:bg-red-500/10 rounded-2xl border border-red-200 dark:border-red-500/20"&gt;
    &lt;div class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-500 text-white"&gt;
        &lt;i class="ti ti-bolt text-xl"&gt;&lt;/i&gt;
    &lt;/div&gt;
    &lt;div class="flex-1"&gt;
        &lt;h4 class="text-sm font-bold text-red-900 dark:text-red-400"&gt;Title&lt;/h4&gt;
        &lt;p class="text-sm text-red-700 dark:text-red-400/70"&gt;Error message...&lt;/p&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                    </div>
                </div>
            </div>
        </section>

        <section class="space-y-4" x-data="{ showCode: false }">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-bold uppercase text-amber-600 dark:text-amber-400">Warning Variant</h3>
                <button @click="showCode = !showCode"
                    class="text-[10px] font-bold uppercase text-gray-400 hover:text-indigo-600 transition-colors flex items-center gap-1">
                    <i class="ti" :class="showCode ? 'ti-eye-off' : 'ti-code'"></i>
                    <span x-text="showCode ? 'Hide Code' : 'Show Code'"></span>
                </button>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-200 dark:border-gray-800 overflow-hidden">
                <div class="p-8">
                    <div x-data="{ open: true }" x-show="open" x-transition
                        class="flex items-start gap-4 p-5 bg-amber-50 dark:bg-amber-500/10 rounded-2xl border border-amber-200 dark:border-amber-500/20">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-500 text-white">
                            <i class="ti ti-alert-triangle text-xl"></i>
                        </div>
                        <div class="flex-1 pt-1">
                            <h4 class="text-sm font-bold text-amber-900 dark:text-amber-400">Peringatan Kuota</h4>
                            <p class="text-sm text-amber-700 dark:text-amber-400/70 mt-0.5">Penyimpanan Anda hampir penuh
                                (92%).</p>
                        </div>
                        <button @click="open = false"
                            class="text-amber-500 hover:bg-amber-500/10 p-1 rounded-lg transition-colors">
                            <i class="ti ti-x text-lg"></i>
                        </button>
                    </div>
                </div>
                <div x-show="showCode" x-collapse x-cloak>
                    <div class="bg-gray-50 dark:bg-gray-950 border-t border-gray-100 dark:border-gray-800 p-6">
                        <pre class="text-[11px] text-gray-600 dark:text-gray-400 overflow-x-auto"><code>&lt;div class="flex items-start gap-4 p-5 bg-amber-50 dark:bg-amber-500/10 rounded-2xl border border-amber-200 dark:border-amber-500/20"&gt;
    &lt;div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500 text-white"&gt;
        &lt;i class="ti ti-alert-triangle text-xl"&gt;&lt;/i&gt;
    &lt;/div&gt;
    &lt;div class="flex-1"&gt;
        &lt;h4 class="text-sm font-bold text-amber-900 dark:text-amber-400"&gt;Title&lt;/h4&gt;
        &lt;p class="text-sm text-amber-700 dark:text-amber-400/70"&gt;Warning message...&lt;/p&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                    </div>
                </div>
            </div>
        </section>

        <section class="space-y-4" x-data="{ showCode: false }">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-bold uppercase text-indigo-600 dark:text-indigo-400">Info Variant</h3>
                <button @click="showCode = !showCode"
                    class="text-[10px] font-bold uppercase text-gray-400 hover:text-indigo-600 transition-colors flex items-center gap-1">
                    <i class="ti" :class="showCode ? 'ti-eye-off' : 'ti-code'"></i>
                    <span x-text="showCode ? 'Hide Code' : 'Show Code'"></span>
                </button>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-200 dark:border-gray-800 overflow-hidden">
                <div class="p-8">
                    <div x-data="{ open: true }" x-show="open" x-transition
                        class="flex items-start gap-4 p-5 bg-indigo-50 dark:bg-indigo-500/10 rounded-2xl border border-indigo-200 dark:border-indigo-500/20">
                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-indigo-500 text-white">
                            <i class="ti ti-info-circle text-xl"></i>
                        </div>
                        <div class="flex-1 pt-1">
                            <h4 class="text-sm font-bold text-indigo-900 dark:text-indigo-400">Informasi Sistem</h4>
                            <p class="text-sm text-indigo-700 dark:text-indigo-400/70 mt-0.5">Kami akan melakukan
                                pemeliharaan rutin pada hari Minggu.</p>
                        </div>
                        <button @click="open = false"
                            class="text-indigo-500 hover:bg-indigo-500/10 p-1 rounded-lg transition-colors">
                            <i class="ti ti-x text-lg"></i>
                        </button>
                    </div>
                </div>
                <div x-show="showCode" x-collapse x-cloak>
                    <div class="bg-gray-50 dark:bg-gray-950 border-t border-gray-100 dark:border-gray-800 p-6">
                        <pre class="text-[11px] text-gray-600 dark:text-gray-400 overflow-x-auto"><code>&lt;div class="flex items-start gap-4 p-5 bg-indigo-50 dark:bg-indigo-500/10 rounded-2xl border border-indigo-200 dark:border-indigo-500/20"&gt;
    &lt;div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-500 text-white"&gt;
        &lt;i class="ti ti-info-circle text-xl"&gt;&lt;/i&gt;
    &lt;/div&gt;
    &lt;div class="flex-1"&gt;
        &lt;h4 class="text-sm font-bold text-indigo-900 dark:text-indigo-400"&gt;Title&lt;/h4&gt;
        &lt;p class="text-sm text-indigo-700 dark:text-indigo-400/70"&gt;Information message...&lt;/p&gt;
    &lt;/div&gt;
&lt;/div&gt;</code></pre>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection