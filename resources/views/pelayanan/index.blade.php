@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-8">Layanan Konsultasi</h1>

    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm p-10">
        <div class="text-center mb-10">
            <h2 class="text-xl font-bold text-gray-700 dark:text-white tracking-wide uppercase">Manajemen Layanan Konsultasi</h2>
            <p class="text-sm text-gray-400 mt-2">Kelola seluruh data dan pengaturan layanan konsultasi statistik.</p>
        </div>

        <div class="flex flex-wrap justify-center gap-5">

            <a href="{{ route('pelayanan.petugas.index') }}"
               class="flex flex-col items-center justify-center w-44 h-44 rounded-2xl border-2 border-blue-100 hover:border-blue-400 hover:shadow-md transition bg-blue-50 hover:bg-blue-100 group">
                <div class="w-14 h-14 rounded-xl bg-blue-100 group-hover:bg-blue-200 flex items-center justify-center mb-3 transition">
                    <i class="ti ti-users text-2xl text-blue-600"></i>
                </div>
                <span class="text-sm font-semibold text-blue-700 text-center leading-tight">Manajemen<br>Petugas</span>
            </a>

            <a href="{{ route('pelayanan.jadwal.index') }}"
               class="flex flex-col items-center justify-center w-44 h-44 rounded-2xl border-2 border-blue-100 hover:border-blue-400 hover:shadow-md transition bg-blue-50 hover:bg-blue-100 group">
                <div class="w-14 h-14 rounded-xl bg-blue-100 group-hover:bg-blue-200 flex items-center justify-center mb-3 transition">
                    <i class="ti ti-file-off text-2xl text-blue-600"></i>
                </div>
                <span class="text-sm font-semibold text-blue-700 text-center leading-tight">Jadwal Tidak<br>Tersedia</span>
            </a>

            <a href="{{ route('pelayanan.reservasi.index') }}"
               class="flex flex-col items-center justify-center w-44 h-44 rounded-2xl border-2 border-blue-100 hover:border-blue-400 hover:shadow-md transition bg-blue-50 hover:bg-blue-100 group">
                <div class="w-14 h-14 rounded-xl bg-blue-100 group-hover:bg-blue-200 flex items-center justify-center mb-3 transition">
                    <i class="ti ti-calendar-stats text-2xl text-blue-600"></i>
                </div>
                <span class="text-sm font-semibold text-blue-700 text-center leading-tight">Reservasi<br>Konsultasi</span>
            </a>

            <a href="{{ route('pelayanan.popup.index') }}"
               class="flex flex-col items-center justify-center w-44 h-44 rounded-2xl border-2 border-blue-100 hover:border-blue-400 hover:shadow-md transition bg-blue-50 hover:bg-blue-100 group">
                <div class="w-14 h-14 rounded-xl bg-blue-100 group-hover:bg-blue-200 flex items-center justify-center mb-3 transition">
                    <i class="ti ti-layers-difference text-2xl text-blue-600"></i>
                </div>
                <span class="text-sm font-semibold text-blue-700 text-center leading-tight">Pop Up<br>Overlay</span>
            </a>

            <a href="{{ route('pelayanan.user.index') }}"
               class="flex flex-col items-center justify-center w-44 h-44 rounded-2xl border-2 border-blue-100 hover:border-blue-400 hover:shadow-md transition bg-blue-50 hover:bg-blue-100 group">
                <div class="w-14 h-14 rounded-xl bg-blue-100 group-hover:bg-blue-200 flex items-center justify-center mb-3 transition">
                    <i class="ti ti-user-circle text-2xl text-blue-600"></i>
                </div>
                <span class="text-sm font-semibold text-blue-700 text-center leading-tight">Manajemen<br>User</span>
            </a>

        </div>
    </div>
</div>
@endsection