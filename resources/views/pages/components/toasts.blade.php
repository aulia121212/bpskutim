@extends('layouts.app')

@section('title', 'Toasts UI Kit')

@section('content')
<div class="space-y-10 pb-20">
    
    <div class="flex flex-col gap-2">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Toasts</h1>
        <p class="text-gray-500 dark:text-gray-400 font-medium text-sm">Notifikasi ringan yang muncul di berbagai sudut layar dengan sistem.</p>
    </div>

    <section class="space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="text-xs font-bold uppercase text-indigo-600 dark:text-indigo-400">Toast Placement</h3>
            <span class="text-[10px] font-medium text-gray-400">Pilih posisi kemunculan notifikasi</span>
        </div>

        <div class="bg-white dark:bg-gray-900 p-8 rounded-3xl border border-gray-200 dark:border-gray-800">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <button @click="$dispatch('toast', { type: 'info', message: 'Notifikasi di Kiri Atas', position: 'top-left' })" 
                    class="px-5 py-3 bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-200 font-bold rounded-2xl hover:bg-indigo-50 dark:hover:bg-indigo-900/30 hover:text-indigo-600 transition-all border border-gray-100 dark:border-gray-700 active:scale-95 flex flex-col items-center gap-2">
                    <i class="ti ti-layout-align-left text-xl"></i>
                    <span class="text-xs">Top Left</span>
                </button>

                <button @click="$dispatch('toast', { type: 'info', message: 'Notifikasi di Tengah Atas', position: 'top-center' })" 
                    class="px-5 py-3 bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-200 font-bold rounded-2xl hover:bg-indigo-50 dark:hover:bg-indigo-900/30 hover:text-indigo-600 transition-all border border-gray-100 dark:border-gray-700 active:scale-95 flex flex-col items-center gap-2">
                    <i class="ti ti-layout-align-center text-xl"></i>
                    <span class="text-xs">Top Center</span>
                </button>

                <button @click="$dispatch('toast', { type: 'info', message: 'Notifikasi di Kanan Atas', position: 'top-right' })" 
                    class="px-5 py-3 bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-200 font-bold rounded-2xl hover:bg-indigo-50 dark:hover:bg-indigo-900/30 hover:text-indigo-600 transition-all border border-gray-100 dark:border-gray-700 active:scale-95 flex flex-col items-center gap-2">
                    <i class="ti ti-layout-align-right text-xl"></i>
                    <span class="text-xs">Top Right</span>
                </button>

                <button @click="$dispatch('toast', { type: 'success', message: 'Notifikasi di Kiri Bawah', position: 'bottom-left' })" 
                    class="px-5 py-3 bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-200 font-bold rounded-2xl hover:bg-indigo-50 dark:hover:bg-indigo-900/30 hover:text-indigo-600 transition-all border border-gray-100 dark:border-gray-700 active:scale-95 flex flex-col items-center gap-2">
                    <i class="ti ti-layout-align-left text-xl rotate-180"></i>
                    <span class="text-xs">Bottom Left</span>
                </button>

                <button @click="$dispatch('toast', { type: 'success', message: 'Notifikasi di Tengah Bawah', position: 'bottom-center' })" 
                    class="px-5 py-3 bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-200 font-bold rounded-2xl hover:bg-indigo-50 dark:hover:bg-indigo-900/30 hover:text-indigo-600 transition-all border border-gray-100 dark:border-gray-700 active:scale-95 flex flex-col items-center gap-2">
                    <i class="ti ti-layout-align-center text-xl rotate-180"></i>
                    <span class="text-xs">Bottom Center</span>
                </button>

                <button @click="$dispatch('toast', { type: 'success', message: 'Notifikasi di Kanan Bawah', position: 'bottom-right' })" 
                    class="px-5 py-2.5 bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-200 font-bold rounded-2xl hover:bg-indigo-50 dark:hover:bg-indigo-900/30 hover:text-indigo-600 transition-all border border-gray-100 dark:border-gray-700 active:scale-95 flex flex-col items-center gap-2">
                    <i class="ti ti-layout-align-right text-xl rotate-180"></i>
                    <span class="text-xs">Bottom Right</span>
                </button>
            </div>
        </div>
    </section>

    <section class="space-y-4" x-data="{}">
        <h3 class="text-xs font-bold uppercase text-indigo-600 dark:text-indigo-400">Interactive Types</h3>
        <div class="bg-white dark:bg-gray-900 p-8 rounded-3xl border border-gray-200 dark:border-gray-800 flex flex-wrap gap-4">
            
            <button @click="$dispatch('toast', { type: 'success', message: 'Data berhasil disimpan ke server!' })" 
                class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition-all  active:scale-95 flex items-center gap-2">
                <i class="ti ti-circle-check text-lg"></i> Success
            </button>

            <button @click="$dispatch('toast', { type: 'error', message: 'Maaf, terjadi kesalahan pada validasi data.' })" 
                class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all  active:scale-95 flex items-center gap-2">
                <i class="ti ti-alert-circle text-lg"></i> Error
            </button>

            <button @click="$dispatch('toast', { type: 'warning', message: 'Sesi Anda akan segera berakhir dalam 5 menit.' })" 
                class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl transition-all  active:scale-95 flex items-center gap-2">
                <i class="ti ti-alert-triangle text-lg"></i> Warning
            </button>

        </div>
    </section>

    <section class="space-y-4" x-data="{ showCode: false }">
        <div class="flex items-center justify-between">
            <h3 class="text-xs font-bold uppercase text-indigo-600 dark:text-indigo-400">Documentation</h3>
            <button @click="showCode = !showCode" class="text-[10px] font-bold uppercase text-gray-400 hover:text-indigo-600 transition-colors flex items-center gap-1">
                <i class="ti" :class="showCode ? 'ti-eye-off' : 'ti-code'"></i>
                <span x-text="showCode ? 'Hide Code' : 'Show Code'"></span>
            </button>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-200 dark:border-gray-800 overflow-hidden">
            <div class="p-8">
                <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Gunakan parameter <code class="text-indigo-600">position</code> untuk menentukan arah tumpukan notifikasi.</p>
            </div>

            <div x-show="showCode" x-collapse x-cloak>
                <div class="bg-gray-50 dark:bg-gray-950 border-t border-gray-100 dark:border-gray-800 p-6">
                    <pre class="text-[11px] text-gray-600 dark:text-gray-400 overflow-x-auto leading-relaxed"><code>&lt;!-- Memicu toast dengan posisi spesifik --&gt;
&lt;button @click="$dispatch('toast', { 
    type: 'success', 
    message: 'Data saved!', 
    position: 'top-right' 
})"&gt;
    Launch Top Right
&lt;/button&gt;

&lt;!-- Opsi Posisi: 
     'top-left', 'top-center', 'top-right', 
     'bottom-left', 'bottom-center', 'bottom-right' 
--&gt;</code></pre>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection