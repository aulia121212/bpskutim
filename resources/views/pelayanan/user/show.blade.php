@extends('layouts.app')

@section('content')
<div class="p-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Detail User</h1>

        <a href="{{ route('pelayanan.user.index') }}" 
           class="text-sm text-blue-600 hover:underline">
            ← Kembali
        </a>
    </div>

    {{-- Card --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm p-6">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Nama --}}
            <div>
                <p class="text-xs text-gray-400">Nama Lengkap</p>
                <p class="font-semibold text-gray-800 dark:text-white">
                    {{ $user->name }}
                </p>
            </div>

            {{-- Email --}}
            <div>
                <p class="text-xs text-gray-400">Email</p>
                <p class="font-semibold text-gray-800 dark:text-white">
                    {{ $user->email }}
                </p>
            </div>

            {{-- WhatsApp --}}
            <div>
                <p class="text-xs text-gray-400">No. WhatsApp</p>
                <p class="font-semibold text-gray-800 dark:text-white">
                    {{ $user->no_whatsapp }}
                </p>
            </div>

            {{-- Role --}}
            <div>
                <p class="text-xs text-gray-400">Role</p>
                <p class="font-semibold text-gray-800 dark:text-white">
                    {{ ucfirst($user->role) }}
                </p>
            </div>

            {{-- Instansi --}}
            <div>
                <p class="text-xs text-gray-400">Instansi</p>
                <p class="font-semibold text-gray-800 dark:text-white">
                    {{ $user->instansi ?? '-' }}
                </p>
            </div>

            {{-- Alamat --}}
            <div>
                <p class="text-xs text-gray-400">Alamat</p>
                <p class="font-semibold text-gray-800 dark:text-white">
                    {{ $user->alamat ?? '-' }}
                </p>
            </div>

            {{-- Tanggal Daftar --}}
            <div>
                <p class="text-xs text-gray-400">Tanggal Daftar</p>
                <p class="font-semibold text-gray-800 dark:text-white">
                    {{ $user->created_at->format('d M Y') }}
                </p>
            </div>

        </div>
    </div>

</div>
@endsection