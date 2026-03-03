@extends('layouts.app')

@section('title', 'Form Elements')


@section('content')
<div class="space-y-10 pb-20">
    <div class="flex flex-col gap-2">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Form Elements</h1>
        <p class="text-gray-500 dark:text-gray-400 font-medium text-sm">Kumpulan input kustom dengan gaya minimalis, modern, dan fungsional.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <section class="space-y-4" x-data="{ showCode: false }">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-bold uppercase text-indigo-600 dark:text-indigo-400">Text Inputs</h3>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-200 dark:border-gray-800 p-8 space-y-6 ">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2 ml-1">Default Input</label>
                    <input type="text" class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-2xl px-5 py-3.5 text-sm font-medium focus:ring-2 focus:ring-indigo-500 transition-all dark:text-white outline-none" placeholder="Enter your name...">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2 ml-1">Input with Icon</label>
                    <div class="relative group">
                        <i class="ti ti-mail absolute left-5 top-1/2 -translate-y-1/2 text-gray-400 text-lg group-focus-within:text-indigo-500 transition-colors"></i>
                        <input type="email" class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-2xl pl-12 pr-5 py-3.5 text-sm font-medium focus:ring-2 focus:ring-indigo-500 transition-all dark:text-white outline-none" placeholder="Email address">
                    </div>
                </div>
            </div>
        </section>

        <section class="space-y-4" x-data="{ showCode: false }">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-bold uppercase text-indigo-600 dark:text-indigo-400">Select & Switches</h3>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-200 dark:border-gray-800 p-8 space-y-6 ">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-2 ml-1">Custom Select</label>
                    <div class="relative">
                        <select class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-2xl px-5 py-3.5 text-sm font-medium focus:ring-2 focus:ring-indigo-500 transition-all dark:text-white outline-none appearance-none cursor-pointer">
                            <option>Indonesia</option>
                            <option>United States</option>
                            <option>Japan</option>
                        </select>
                        <i class="ti ti-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                    </div>
                </div>
                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 rounded-2xl border border-transparent focus-within:border-indigo-500/20 transition-all">
                    <div>
                        <span class="text-sm font-bold dark:text-white block">Email Notifications</span>
                        <span class="text-[10px] text-gray-400 font-medium">Receive weekly updates</span>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-indigo-600 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all "></div>
                    </label>
                </div>
            </div>
        </section>

        <section class="space-y-4" x-data="{ showCode: false }">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-bold uppercase text-indigo-600 dark:text-indigo-400">Choice Controls</h3>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-200 dark:border-gray-800 p-8 space-y-6 ">
                <div class="grid grid-cols-2 gap-4">
                    <label class="flex items-center gap-3 group cursor-pointer">
                        <div class="relative flex items-center justify-center">
                            <input type="checkbox" class="peer sr-only" checked>
                            <div class="w-6 h-6 bg-gray-50 dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-lg peer-checked:bg-indigo-600 peer-checked:border-indigo-600 transition-all duration-300 "></div>
                            <i class="ti ti-check absolute text-white text-xs scale-0 peer-checked:scale-100 transition-transform"></i>
                        </div>
                        <span class="text-sm font-bold text-gray-600 dark:text-gray-400 group-hover:text-indigo-600 transition-colors">Checkbox</span>
                    </label>
                    <label class="flex items-center gap-3 group cursor-pointer">
                        <div class="relative flex items-center justify-center">
                            <input type="radio" name="radio-demo" class="peer sr-only" checked>
                            <div class="w-6 h-6 bg-gray-50 dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-full peer-checked:border-indigo-600 transition-all duration-300 "></div>
                            <div class="absolute w-2.5 h-2.5 bg-indigo-600 rounded-full scale-0 peer-checked:scale-100 transition-transform"></div>
                        </div>
                        <span class="text-sm font-bold text-gray-600 dark:text-gray-400 group-hover:text-indigo-600 transition-colors">Radio</span>
                    </label>
                </div>
            </div>
        </section>

        <section class="space-y-4" x-data="{ showCode: false }">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-bold uppercase text-indigo-600 dark:text-indigo-400">Validation States</h3>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-200 dark:border-gray-800 p-8 space-y-6 ">
                <div>
                    <label class="block text-xs font-bold text-rose-500 uppercase mb-2 ml-1">Error State</label>
                    <div class="relative">
                        <input type="text" class="w-full bg-rose-50 dark:bg-rose-500/10 border-2 border-rose-200 dark:border-rose-500/20 rounded-2xl px-5 py-3.5 text-sm font-medium focus:ring-0 outline-none dark:text-rose-400" value="Invalid value">
                        <i class="ti ti-alert-circle absolute right-5 top-1/2 -translate-y-1/2 text-rose-500 text-lg"></i>
                    </div>
                    <p class="text-[10px] text-rose-500 font-bold mt-2 ml-1">This field is required.</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-emerald-500 uppercase mb-2 ml-1">Success State</label>
                    <div class="relative">
                        <input type="text" class="w-full bg-emerald-50 dark:bg-emerald-500/10 border-2 border-emerald-200 dark:border-emerald-500/20 rounded-2xl px-5 py-3.5 text-sm font-medium focus:ring-0 outline-none dark:text-emerald-400" value="aulia_azizah">
                        <i class="ti ti-circle-check absolute right-5 top-1/2 -translate-y-1/2 text-emerald-500 text-lg"></i>
                    </div>
                </div>
            </div>
        </section>

        <section class="space-y-4 lg:col-span-2" x-data="{ showCode: false }">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-bold uppercase text-indigo-600 dark:text-indigo-400">Textarea & Rich Text</h3>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-200 dark:border-gray-800 p-8 ">
                <label class="block text-xs font-bold text-gray-400 uppercase mb-2 ml-1">Description / Bio</label>
                <textarea rows="5" class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-3xl px-6 py-5 text-sm font-medium focus:ring-2 focus:ring-indigo-500 transition-all dark:text-white outline-none resize-none" placeholder="Tell us about yourself..."></textarea>
            </div>
        </section>
    </div>
</div>
@endsection