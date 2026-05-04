@extends('layouts.app')

@section('content')
<div class="p-6">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detail Admin Data Statistik</h1>
        <p class="text-sm text-gray-500">Informasi lengkap admin</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border p-6 max-w-xl">

        <div class="space-y-4">

            <div>
                <p class="text-sm text-gray-400">Nama</p>
                <p class="font-semibold text-gray-800">{{ $admin->name }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-400">Email</p>
                <p class="text-gray-700">{{ $admin->email }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-400">No WhatsApp</p>
                <p class="text-gray-700">{{ $admin->no_whatsapp ?? '-' }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-400">Instansi</p>
                <p class="text-gray-700">{{ $admin->instansi ?? 'BPS Kutai Timur' }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-400">Jabatan</p>
                <p class="text-gray-700">{{ $admin->jabatan ?? '-' }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-400">Tim</p>
                <p class="text-gray-700">{{ $admin->tim ?? '-' }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-400">Alamat</p>
                <p class="text-gray-700">{{ $admin->alamat ?? '-' }}</p>
            </div>

        </div>

        <div class="mt-6">
            <a href="{{ route('superadmin.admin-data-statistik.index') }}"
               class="inline-block bg-[#035f9c]  text-white px-4 py-2 rounded-lg text-sm hover:bg-white hover:text-[#035f9c] transition">
                Kembali
            </a>
        </div>

    </div>
</div>
@endsection