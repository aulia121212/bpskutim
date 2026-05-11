@extends('layouts.app')

@section('content')
<div class="p-4 sm:p-6">

    {{-- Header --}}
    <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                Detail Admin Pelayanan
            </h1>

            <p class="text-sm text-gray-500 dark:text-gray-400">
                Informasi lengkap admin pelayanan
            </p>
        </div>

        <a href="{{ route('superadmin.admin-pelayanan.index') }}"
            class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">

            <i class="ti ti-arrow-left text-base"></i>
            Kembali
        </a>
    </div>

    {{-- Card --}}
    <div class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">

        {{-- Top Profile --}}
        <div class="border-b border-gray-100 px-6 py-6 dark:border-gray-800">

            <div class="flex flex-col items-center gap-4 sm:flex-row">

                {{-- Foto --}}
                <div class="relative h-24 w-24 overflow-hidden rounded-2xl border border-gray-200 bg-gray-100 dark:border-gray-700 dark:bg-gray-800">

                    @if ($admin->foto)
                        <img src="{{ asset($admin->foto) }}"
                            alt="{{ $admin->nama_lengkap }}"
                            class="h-full w-full object-cover">
                    @else
                        <div class="flex h-full w-full items-center justify-center text-gray-400">
                            <i class="ti ti-user text-5xl"></i>
                        </div>
                    @endif

                </div>

                {{-- Info --}}
                <div class="text-center sm:text-left">

                    <h2 class="text-xl font-bold text-gray-800 dark:text-white">
                        {{ $admin->nama_lengkap }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ $admin->email }}
                    </p>

                    <div class="mt-3 inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-[#035f9c] dark:bg-blue-900/20 dark:text-blue-300">
                        <i class="ti ti-shield"></i>
                        Admin Pelayanan
                    </div>

                </div>

            </div>

        </div>

        {{-- Detail --}}
        <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-2">

            {{-- WhatsApp --}}
            <div class="rounded-2xl border border-gray-100 bg-gray-50 p-5 dark:border-gray-800 dark:bg-gray-800/50">
                <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">
                    No WhatsApp
                </p>

                <p class="text-sm font-medium text-gray-800 dark:text-white">
                    {{ $admin->no_whatsapp ?? '-' }}
                </p>
            </div>

            {{-- Instansi --}}
            <div class="rounded-2xl border border-gray-100 bg-gray-50 p-5 dark:border-gray-800 dark:bg-gray-800/50">
                <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">
                    Instansi
                </p>

                <p class="text-sm font-medium text-gray-800 dark:text-white">
                    {{ $admin->instansi ?? 'BPS Kabupaten Kutai Timur' }}
                </p>
            </div>

            {{-- Jabatan --}}
            <div class="rounded-2xl border border-gray-100 bg-gray-50 p-5 dark:border-gray-800 dark:bg-gray-800/50">
                <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">
                    Jabatan
                </p>

                <p class="text-sm font-medium text-gray-800 dark:text-white">
                    {{ $admin->jabatan ?? '-' }}
                </p>
            </div>

            {{-- Tim --}}
            <div class="rounded-2xl border border-gray-100 bg-gray-50 p-5 dark:border-gray-800 dark:bg-gray-800/50">
                <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">
                    Tim
                </p>

                <p class="text-sm font-medium text-gray-800 dark:text-white">
                    {{ $admin->tim ?? '-' }}
                </p>
            </div>

            {{-- Alamat --}}
            <div class="md:col-span-2 rounded-2xl border border-gray-100 bg-gray-50 p-5 dark:border-gray-800 dark:bg-gray-800/50">

                <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-gray-400">
                    Alamat
                </p>

                <p class="text-sm leading-relaxed text-gray-700 dark:text-gray-300">
                    {{ $admin->alamat ?? '-' }}
                </p>

            </div>

        </div>

        {{-- Footer --}}
        <div class="flex justify-end border-t border-gray-100 px-6 py-5 dark:border-gray-800">

            <a href="{{ route('superadmin.admin-pelayanan.edit', $admin->id) }}"
                class="inline-flex items-center gap-2 rounded-2xl bg-[#035f9c] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#024b7c]">

                <i class="ti ti-edit"></i>
                Edit Admin
            </a>

        </div>

    </div>
</div>
@endsection