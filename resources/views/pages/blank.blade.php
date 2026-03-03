@extends('layouts.app')

@section('title', 'Blank Page')

@section('content')
<div class="min-h-[70vh] flex flex-col items-center justify-center space-y-6">
    
    {{-- Decorative Illustration Placeholder --}}
    <div class="relative">
        <div class="absolute inset-0 bg-indigo-500/20 blur-[80px] rounded-full"></div>
        <div class="relative w-24 h-24 bg-white dark:bg-gray-900 rounded-[2rem] border border-gray-100 dark:border-gray-800 flex items-center justify-center shadow-xl">
            <i class="ti ti-layout-board text-4xl text-indigo-600"></i>
        </div>
    </div>

    {{-- Content --}}
    <div class="text-center space-y-2 max-w-md mx-auto">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Mulai Sesuatu yang Baru</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
            Halaman ini kosong dan siap untuk diisi dengan ide-ide luar biasa Anda. Gunakan komponen UI Kit yang tersedia untuk mempercepat proses pengembangan.
        </p>
    </div>

    {{-- Action Buttons --}}
    <div class="flex items-center gap-3">
        <x-button variant="secondary" href="{{ route('dashboard.index') }}" class="rounded-xl">
            <i class="ti ti-arrow-left mr-2"></i> Dashboard
        </x-button>
        <x-button variant="primary" class="rounded-xl">
            <i class="ti ti-plus mr-2"></i> Tambah Widget
        </x-button>
    </div>

</div>
@endsection