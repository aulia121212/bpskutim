@extends('layouts.app')

@section('content')
<div class="p-6">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Admin Data Statistik</h1>
        <p class="text-sm text-gray-500">Perbarui data admin</p>
    </div>

    {{-- Error --}}
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 mb-4">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    {{-- Form --}}
    <form action="{{ route('superadmin.admin-data-statistik.update', $admin->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 space-y-4">

            {{-- Nama --}}
            <div>
                <label class="text-sm font-semibold text-gray-700">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $admin->name) }}"
                    class="w-full mt-1 px-4 py-2 border rounded-xl text-sm focus:ring focus:ring-blue-200">
            </div>

            {{-- Email --}}
            <div>
                <label class="text-sm font-semibold text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email', $admin->email) }}"
                    class="w-full mt-1 px-4 py-2 border rounded-xl text-sm focus:ring focus:ring-blue-200">
            </div>

            {{-- No WA --}}
            <div>
                <label class="text-sm font-semibold text-gray-700">No WhatsApp</label>
                <input type="text" name="no_whatsapp" value="{{ old('no_whatsapp', $admin->no_whatsapp) }}"
                    class="w-full mt-1 px-4 py-2 border rounded-xl text-sm focus:ring focus:ring-blue-200">
            </div>

            {{-- Instansi --}}
            <div>
                <label class="text-sm font-semibold text-gray-700">Instansi</label>
                <input type="text" name="instansi" value="{{ old('instansi', $admin->instansi) }}"
                    class="w-full mt-1 px-4 py-2 border rounded-xl text-sm focus:ring focus:ring-blue-200">
            </div>

            {{-- Jabatan --}}
            <div>
                <label class="text-sm font-semibold text-gray-700">Jabatan</label>
                <input type="text" name="jabatan" value="{{ old('jabatan', $admin->jabatan) }}"
                    class="w-full mt-1 px-4 py-2 border rounded-xl text-sm focus:ring focus:ring-blue-200">
            </div>

            {{-- Tim --}}
            <div>
                <label class="text-sm font-semibold text-gray-700">Tim</label>
                <input type="text" name="tim" value="{{ old('tim', $admin->tim) }}"
                    class="w-full mt-1 px-4 py-2 border rounded-xl text-sm focus:ring focus:ring-blue-200">
            </div>

            {{-- Alamat --}}
            <div>
                <label class="text-sm font-semibold text-gray-700">Alamat</label>
                <textarea name="alamat"
                    class="w-full mt-1 px-4 py-2 border rounded-xl text-sm focus:ring focus:ring-blue-200">{{ old('alamat', $admin->alamat) }}</textarea>
            </div>

            {{-- Password --}}
            <div>
                <label class="text-sm font-semibold text-gray-700">Password (opsional)</label>
                <input type="password" name="password"
                    class="w-full mt-1 px-4 py-2 border rounded-xl text-sm focus:ring focus:ring-blue-200">
            </div>

            {{-- Foto --}}
            <div>
                <label class="text-sm font-semibold text-gray-700">Foto</label>
                <input type="file" name="foto"
                    class="w-full mt-1 text-sm">
            </div>

            {{-- Button --}}
            <div class="flex justify-end gap-2 pt-4">
                <a href="{{ route('superadmin.admin-data-statistik.index') }}"
                    class="px-4 py-2 text-sm rounded-xl border">Batal</a>

                <button type="submit"
                    class="px-5 py-2 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700">
                    Simpan
                </button>
            </div>

        </div>
    </form>
</div>
@endsection