@extends('layouts.app')

@section('content')
<div class="p-6 max-w-2xl mx-auto">

    <div class="mb-8">
        <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">Manajemen / Publikasi</p>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Tambah Publikasi</h1>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm p-8">
        <form method="POST" action="{{ route('publikasi.store') }}">
            @csrf
            <div class="space-y-5">
                <!-- <div>
                    <label class="block text-sm font-semibold text-blue-500 mb-1.5">
                        Judul Publikasi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="judul" value="{{ old('judul') }}"
                        placeholder="Contoh: Statistik Daerah Kutai Timur 2024"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                        required>
                    @error('judul')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div> -->

                <div>
                    <label class="block text-sm font-semibold text-blue-500 mb-1.5">
                        Link Publikasi <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <i class="ti ti-link"></i>
                        </span>
                        <input type="url" name="link" value="{{ old('link') }}"
                            placeholder="https://bps.go.id/publikasi/..."
                            class="w-full border border-gray-200 rounded-xl pl-9 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                            required>
                    </div>
                    @error('link')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                <a href="{{ route('publikasi.index') }}"
                    class="px-6 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit"
                    class="px-8 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition shadow-sm">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection