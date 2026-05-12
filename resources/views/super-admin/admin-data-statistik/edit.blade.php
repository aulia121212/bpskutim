@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/edit_admin.css') }}">

<div class="p-4 sm:p-6">

    {{-- Header --}}
    <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
                Edit Admin Data Statistik
            </h1>

            <p class="text-sm text-gray-500 dark:text-gray-400">
                Perbarui informasi admin data statistik
            </p>
        </div>

        <a href="{{ route('superadmin.admin-data-statistik.index') }}"
            class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">

            <i class="ti ti-arrow-left text-base"></i>
            Kembali
        </a>
    </div>

    {{-- Error --}}
    @if ($errors->any())
        <div class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-4 py-4 text-sm text-red-700 dark:border-red-900/40 dark:bg-red-900/20 dark:text-red-300">

            <div class="mb-2 flex items-center gap-2 font-semibold">
                <i class="ti ti-alert-circle text-lg"></i>
                Terjadi kesalahan
            </div>

            <ul class="list-disc space-y-1 pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif

    {{-- Form --}}
    <form action="{{ route('superadmin.admin-data-statistik.update', $admin->id) }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-sm dark:border-gray-800 dark:bg-gray-900">

            {{-- Top --}}
            <div class="border-b border-gray-100 px-6 py-5 dark:border-gray-800">

                <div class="flex items-center gap-4">

                    {{-- Foto --}}
                    <div class="relative h-20 w-20 overflow-hidden rounded-2xl border border-gray-200 bg-gray-100 dark:border-gray-700 dark:bg-gray-800">

                        @if ($admin->foto_profil)
                            <img src="{{ asset($admin->foto_profil) }}"
                                alt="{{ $admin->name }}"
                                class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full w-full items-center justify-center text-gray-400">
                                <i class="ti ti-user text-4xl"></i>
                            </div>
                        @endif

                    </div>

                    {{-- Info --}}
                    <div>
                        <h2 class="text-lg font-bold text-gray-800 dark:text-white">
                            {{ $admin->nama_lengkap }}
                        </h2>

                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $admin->email }}
                        </p>
                    </div>

                </div>

            </div>

            {{-- Body --}}
            <div class="grid grid-cols-1 gap-5 p-6 md:grid-cols-2">

                {{-- Nama --}}
                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Nama Lengkap
                    </label>

                    <input type="text"
                        name="nama_lengkap"
                        value="{{ old('nama_lengkap', $admin->nama_lengkap) }}"
                        placeholder="Masukkan nama lengkap"
                        class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                </div>

                {{-- Email --}}
                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Email
                    </label>

                    <input type="email"
                        name="email"
                        value="{{ old('email', $admin->email) }}"
                        placeholder="Masukkan email"
                        class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                </div>

                {{-- WA --}}
                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        No WhatsApp
                    </label>

                    <input type="text"
                        name="no_whatsapp"
                        value="{{ old('no_whatsapp', $admin->no_whatsapp) }}"
                        placeholder="Contoh: 08123456789"
                        class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                </div>

                {{-- Instansi --}}
                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Instansi
                    </label>

                    <input type="text"
                        name="instansi"
                        value="{{ old('instansi', $admin->instansi) }}"
                        placeholder="Masukkan instansi"
                        class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                </div>

                {{-- Jabatan --}}
                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Jabatan
                    </label>

                    <input type="text"
                        name="jabatan"
                        value="{{ old('jabatan', $admin->jabatan) }}"
                        placeholder="Masukkan jabatan"
                        class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                </div>

                {{-- Tim --}}
                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Tim
                    </label>

                    <input type="text"
                        name="tim"
                        value="{{ old('tim', $admin->tim) }}"
                        placeholder="Masukkan tim"
                        class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                </div>

                {{-- Password --}}
                <div class="md:col-span-2">

                    <label class="mb-3 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Password
                    </label>

                    {{-- Trigger --}}
                    <button type="button"
                        id="toggle-password-btn"
                        onclick="togglePasswordSection()"
                        class="mb-4 inline-flex items-center gap-2 rounded-xl bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-600 transition hover:bg-blue-100 dark:bg-blue-900/20 dark:text-blue-300">

                        <i class="ti ti-lock"></i>
                        Ubah Password
                    </button>

                    {{-- Hidden --}}
                    <div id="password-section" class="hidden">

                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                            {{-- Password Lama --}}
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    Password Saat Ini
                                </label>

                                <div class="relative">

                                    <input type="password"
                                        name="current_password"
                                        id="current_password"
                                        placeholder="Masukkan password saat ini"
                                        class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 pr-12 text-sm text-gray-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100 dark:border-gray-700 dark:bg-gray-800 dark:text-white">

                                    <button type="button"
                                        onclick="togglePw('current_password','eye-current')"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">

                                        <i class="ti ti-eye" id="eye-current"></i>
                                    </button>

                                </div>
                            </div>

                            {{-- Password Baru --}}
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    Password Baru
                                </label>

                                <div class="relative">

                                    <input type="password"
                                        name="new_password"
                                        id="new_password"
                                        placeholder="Masukkan password baru"
                                        class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 pr-12 text-sm text-gray-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100 dark:border-gray-700 dark:bg-gray-800 dark:text-white">

                                    <button type="button"
                                        onclick="togglePw('new_password','eye-new')"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400">

                                        <i class="ti ti-eye" id="eye-new"></i>
                                    </button>

                                </div>
                            </div>

                        </div>

                    </div>

                </div>

                {{-- Alamat --}}
                <div class="md:col-span-2">
                    <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Alamat
                    </label>

                    <textarea name="alamat"
                        rows="4"
                        placeholder="Masukkan alamat lengkap"
                        class="w-full rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-700 outline-none transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100 dark:border-gray-700 dark:bg-gray-800 dark:text-white">{{ old('alamat', $admin->alamat) }}</textarea>
                </div>

                {{-- Foto --}}
                <div class="md:col-span-2">

                    <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Foto Profil
                    </label>

                    <input type="file"
                        name="foto"
                        class="block w-full rounded-2xl border border-dashed border-gray-300 bg-gray-50 px-4 py-3 text-sm text-gray-600 file:mr-4 file:rounded-xl file:border-0 file:bg-blue-600 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-blue-700 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300">

                </div>

            </div>

            {{-- Footer --}}
            <div class="flex flex-col-reverse justify-end gap-3 border-t border-gray-100 px-6 py-5 sm:flex-row dark:border-gray-800">

                <a href="{{ route('superadmin.admin-data-statistik.index') }}"
                    class="inline-flex items-center justify-center rounded-2xl border border-gray-200 px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800">

                    Batal
                </a>

                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-2xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">

                    <i class="ti ti-device-floppy text-base"></i>
                    Simpan Perubahan
                </button>

            </div>

        </div>
    </form>
</div>

<script>
function togglePasswordSection() {

    const section = document.getElementById('password-section');
    const btn = document.getElementById('toggle-password-btn');

    const current = document.getElementById('current_password');
    const newer = document.getElementById('new_password');

    section.classList.toggle('hidden');

    if (!section.classList.contains('hidden')) {

        btn.innerHTML = `
            <i class="ti ti-x"></i>
            Batal Ganti Password
        `;

        current.required = true;
        newer.required = true;

    } else {

        btn.innerHTML = `
            <i class="ti ti-lock"></i>
            Ubah Password
        `;

        current.required = false;
        newer.required = false;

        current.value = '';
        newer.value = '';
    }
}

function togglePw(fieldId, eyeId) {

    const field = document.getElementById(fieldId);
    const eye = document.getElementById(eyeId);

    if (field.type === 'password') {
        field.type = 'text';
        eye.className = 'ti ti-eye-off';
    } else {
        field.type = 'password';
        eye.className = 'ti ti-eye';
    }
}
</script>

@endsection