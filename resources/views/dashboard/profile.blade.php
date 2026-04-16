@extends('layouts.app')

@section('title', 'Profil Akun')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-xl font-bold text-gray-800 dark:text-white">Profil Akun</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
            Kelola informasi akun dan keamanan login kamu.
        </p>
    </div>

    {{-- Alert sukses --}}
    @if(session('success'))
        <div class="mb-5 flex items-center gap-3 rounded-xl bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 px-4 py-3 text-sm font-semibold text-green-700 dark:text-green-400">
            <i class="ti ti-circle-check text-lg"></i>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-5 flex items-start gap-3 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 px-4 py-3 text-sm font-semibold text-red-700 dark:text-red-400">
            <i class="ti ti-alert-circle text-lg mt-0.5"></i>
            <ul class="space-y-1">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-[260px_1fr] gap-5">

        {{-- ── KOLOM KIRI: Foto & Info Role ── --}}
        <div class="space-y-4">

            {{-- Foto Profil --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-6 text-center">

                {{-- Avatar --}}
                <div class="relative inline-block mb-4">
                    <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-800 mx-auto border-4 border-white dark:border-gray-700 shadow-md">
                        @if($user->foto_profil)
                            <img src="{{ asset($user->foto_profil) }}"
                                 alt="Foto Profil"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-blue-50 dark:bg-blue-900/30 text-blue-500 text-3xl font-bold">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                        @endif
                    </div>

                    {{-- Tombol edit foto --}}
                    <form method="POST"
                          action="{{ route('admin.profile.photo') }}"
                          enctype="multipart/form-data"
                          id="photoForm">
                        @csrf @method('PATCH')
                        <input type="file"
                               name="foto_profil"
                               id="fotoInput"
                               accept="image/*"
                               class="hidden"
                               onchange="document.getElementById('photoForm').submit()">
                        <button type="button"
                                onclick="document.getElementById('fotoInput').click()"
                                class="absolute bottom-0 right-0 w-8 h-8 bg-blue-600 hover:bg-blue-700 text-white rounded-full flex items-center justify-center shadow-md transition-colors">
                            <i class="ti ti-pencil text-sm"></i>
                        </button>
                    </form>
                </div>

                <p class="font-bold text-gray-800 dark:text-white text-base leading-tight">
                    {{ $user->name }}
                </p>
                <p class="text-xs text-gray-400 mt-1">{{ $user->email }}</p>

                {{-- Badge role --}}
                <div class="mt-3 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full
                    @if($user->isSuperAdmin()) bg-purple-50 dark:bg-purple-900/20 text-purple-700 dark:text-purple-300
                    @elseif($user->isAdminPelayanan()) bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300
                    @else bg-teal-50 dark:bg-teal-900/20 text-teal-700 dark:text-teal-300
                    @endif">
                    <i class="ti ti-shield-check text-sm"></i>
                    <span class="text-xs font-bold">{{ $user->role_label }}</span>
                </div>
            </div>

            {{-- Info singkat --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-5 space-y-3">
                @if($user->instansi)
                    <div class="flex items-center gap-3 text-sm">
                        <i class="ti ti-building text-gray-400 text-base w-5"></i>
                        <span class="text-gray-600 dark:text-gray-300">{{ $user->instansi }}</span>
                    </div>
                @endif
                @if($user->jabatan)
                    <div class="flex items-center gap-3 text-sm">
                        <i class="ti ti-id-badge text-gray-400 text-base w-5"></i>
                        <span class="text-gray-600 dark:text-gray-300">{{ $user->jabatan }}</span>
                    </div>
                @endif
                @if($user->tim)
                    <div class="flex items-center gap-3 text-sm">
                        <i class="ti ti-users text-gray-400 text-base w-5"></i>
                        <span class="text-gray-600 dark:text-gray-300">{{ $user->tim }}</span>
                    </div>
                @endif
                @if($user->no_whatsapp)
                    <div class="flex items-center gap-3 text-sm">
                        <i class="ti ti-brand-whatsapp text-gray-400 text-base w-5"></i>
                        <span class="text-gray-600 dark:text-gray-300">{{ $user->no_whatsapp }}</span>
                    </div>
                @endif
                @if($user->alamat)
                    <div class="flex items-center gap-3 text-sm">
                        <i class="ti ti-map-pin text-gray-400 text-base w-5"></i>
                        <span class="text-gray-600 dark:text-gray-300">{{ $user->alamat }}</span>
                    </div>
                @endif
                @if(!$user->instansi && !$user->jabatan && !$user->tim && !$user->no_whatsapp && !$user->alamat)
                    <p class="text-xs text-gray-400 text-center py-2">Belum ada informasi tambahan.</p>
                @endif
            </div>

        </div>

        {{-- ── KOLOM KANAN: Form Edit ── --}}
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-6">

            <form method="POST" action="{{ route('admin.profile.update') }}">
                @csrf @method('PATCH')

                {{-- Section: Informasi Dasar --}}
                <h2 class="text-sm font-bold text-gray-700 dark:text-white mb-4 flex items-center gap-2">
                    <i class="ti ti-user text-blue-500"></i> Informasi Dasar
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1.5">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="name"
                               value="{{ old('name', $user->name) }}"
                               class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 px-3.5 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1.5">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email"
                               name="email"
                               value="{{ old('email', $user->email) }}"
                               class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 px-3.5 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1.5">
                            Nomor WhatsApp
                        </label>
                        <input type="text"
                               name="no_whatsapp"
                               value="{{ old('no_whatsapp', $user->no_whatsapp) }}"
                               placeholder="08xx-xxxx-xxxx"
                               class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 px-3.5 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1.5">
                            Asal Instansi
                        </label>
                        <input type="text"
                               name="instansi"
                               value="{{ old('instansi', $user->instansi) }}"
                               class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 px-3.5 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1.5">
                            Jabatan
                        </label>
                        <input type="text"
                               name="jabatan"
                               value="{{ old('jabatan', $user->jabatan) }}"
                               class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 px-3.5 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1.5">
                            Tim
                        </label>
                        <input type="text"
                               name="tim"
                               value="{{ old('tim', $user->tim) }}"
                               class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 px-3.5 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1.5">
                            Alamat
                        </label>
                        <input type="text"
                               name="alamat"
                               value="{{ old('alamat', $user->alamat) }}"
                               class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 px-3.5 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                    </div>
                </div>

                <hr class="border-gray-100 dark:border-gray-800 my-5">

                {{-- Section: Ubah Password --}}
                <h2 class="text-sm font-bold text-gray-700 dark:text-white mb-4 flex items-center gap-2">
                    <i class="ti ti-lock text-blue-500"></i> Ubah Kata Sandi
                    <span class="text-xs font-normal text-gray-400">(kosongkan jika tidak ingin mengubah)</span>
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1.5">
                            Kata Sandi Baru
                        </label>
                        <input type="password"
                               name="password"
                               placeholder="Min. 8 karakter"
                               class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 px-3.5 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1.5">
                            Konfirmasi Kata Sandi
                        </label>
                        <input type="password"
                               name="password_confirmation"
                               placeholder="Ulangi kata sandi baru"
                               class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 px-3.5 py-2.5 text-sm text-gray-800 dark:text-white outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                    </div>
                </div>

                {{-- Tombol aksi --}}
                <div class="flex items-center justify-end gap-3">
                    <a href="{{ auth()->user()->dashboardRoute() }}"
                       class="px-5 py-2.5 text-sm font-semibold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-5 py-2.5 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition shadow-sm shadow-blue-500/20">
                        <i class="ti ti-device-floppy mr-1.5"></i> Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>

@endsection