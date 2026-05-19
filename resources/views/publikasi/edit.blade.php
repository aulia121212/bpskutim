@extends('layouts.app')

@section('content')
<div class="p-6 max-w-2xl mx-auto">

    <div class="mb-8">
        <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">Manajemen Publikasi</p>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Publikasi</h1>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm p-8">
        <form method="POST" action="{{ route('superadmin.publikasi.update', $publikasi->id) }}">
            @csrf @method('PUT')

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-[#035f9c] mb-1.5">
                        Link Publikasi <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                            <i class="ti ti-link"></i>
                        </span>
                        <input type="url" name="link"
                            value="{{ old('link', $publikasi->link) }}"
                            placeholder="https://bps.go.id/publikasi/..."
                            class="w-full border border-gray-200 rounded-xl pl-9 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#035f9c] dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                            required>
                    </div>
                    @error('link')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                <a href="{{ route('superadmin.publikasi.index') }}"
                    class="px-6 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit"
                    class="px-8 py-2.5 rounded-xl bg-[#035f9c] hover:bg-[#035f9c] text-white text-sm font-semibold transition shadow-sm">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection