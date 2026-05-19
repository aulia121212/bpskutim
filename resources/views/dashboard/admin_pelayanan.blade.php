
@extends('layouts.app') {{-- sesuaikan dengan nama layout utama project kamu --}}

@section('title', 'Dashboard Pelayanan')

@section('content')

{{-- ── HEADER ─────────────────────────────────────────────────────── --}}
<div class="mb-6">
    <h1 class="text-xl font-bold text-gray-800 dark:text-white">Dashboard Pelayanan</h1>
    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
        Selamat datang, {{ auth()->user()->name }}.
        Berikut ringkasan aktivitas pelayanan hari ini.
    </p>
</div>

{{-- ── STAT CARDS ──────────────────────────────────────────────────── --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

    {{-- Total Petugas --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Petugas</span>
            <div class="w-9 h-9 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center">
                <i class="ti ti-users text-[#035f9c] text-lg"></i>
            </div>
        </div>
        <div class="text-3xl font-bold text-gray-800 dark:text-white">
            {{ $stats['total_petugas'] }}
        </div>
        <p class="text-xs text-gray-400 mt-1">Petugas konsultasi terdaftar</p>
    </div>

    {{-- Reservasi Masuk --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Reservasi Masuk</span>
            <div class="w-9 h-9 rounded-xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center">
                <i class="ti ti-clipboard-list text-amber-500 text-lg"></i>
            </div>
        </div>
        <div class="text-3xl font-bold text-gray-800 dark:text-white">
            {{ $stats['reservasi_masuk'] }}
        </div>
        <p class="text-xs text-gray-400 mt-1">Total semua reservasi</p>
    </div>

    {{-- Menunggu Tindak Lanjut --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Perlu Ditangani</span>
            <div class="w-9 h-9 rounded-xl bg-red-50 dark:bg-red-900/30 flex items-center justify-center">
                <i class="ti ti-alert-circle text-red-500 text-lg"></i>
            </div>
        </div>
        <div class="text-3xl font-bold text-gray-800 dark:text-white">
            {{ $stats['menunggu_tindak'] }}
        </div>
        <p class="text-xs text-red-400 mt-1 font-medium">Menunggu tindak lanjut</p>
    </div>

    {{-- Selesai Bulan Ini --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Selesai Bulan Ini</span>
            <div class="w-9 h-9 rounded-xl bg-green-50 dark:bg-green-900/30 flex items-center justify-center">
                <i class="ti ti-circle-check text-green-500 text-lg"></i>
            </div>
        </div>
        <div class="text-3xl font-bold text-gray-800 dark:text-white">
            {{ $stats['selesai_bulan_ini'] }}
        </div>
        <p class="text-xs text-green-500 mt-1 font-medium">Reservasi selesai</p>
    </div>

</div>

{{-- ── TABEL + JADWAL ───────────────────────────────────────────────── --}}
<div class="grid grid-cols-1 xl:grid-cols-2 gap-4">

    {{-- Reservasi Terbaru --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-5">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-bold text-gray-700 dark:text-white">Reservasi Terbaru</h2>
            <a href="{{ route('pelayanan.reservasi.index') }}"
               class="text-xs text-[#035f9c] hover:underline font-semibold">
                Lihat semua →
            </a>
        </div>

        @forelse ($reservasiTerbaru as $reservasi)
            <div class="flex items-center gap-3 py-3 border-b border-gray-50 dark:border-gray-800 last:border-0">
                {{-- Avatar inisial --}}
                <div class="w-9 h-9 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center
                            text-xs font-bold text-gray-500 flex-shrink-0">
                    {{ strtoupper(substr($reservasi->user->name ?? 'U', 0, 2)) }}
                </div>

                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-800 dark:text-white truncate">
                        {{ $reservasi->user->name ?? '-' }}
                    </p>
                    <p class="text-xs text-gray-400">
                        {{ \Carbon\Carbon::parse($reservasi->tanggal)->translatedFormat('D, d M Y') }}
                        · {{ $reservasi->jam ?? '-' }}
                    </p>
                </div>

                {{-- Badge status --}}
                @php
                    $statusClass = match($reservasi->status ?? '') {
                        'pending'  => 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400',
                        'diproses' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400',
                        'selesai'  => 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400',
                        default    => 'bg-gray-100 text-gray-500',
                    };
                    $statusLabel = match($reservasi->status ?? '') {
                        'pending'  => 'Menunggu',
                        'diproses' => 'Diproses',
                        'selesai'  => 'Selesai',
                        default    => ucfirst($reservasi->status ?? '-'),
                    };
                @endphp
                <span class="text-[11px] font-semibold px-2.5 py-1 rounded-full {{ $statusClass }} flex-shrink-0">
                    {{ $statusLabel }}
                </span>
            </div>
        @empty
            <div class="py-8 text-center">
                <i class="ti ti-clipboard-off text-3xl text-gray-300 dark:text-gray-700"></i>
                <p class="text-sm text-gray-400 mt-2">Belum ada reservasi</p>
            </div>
        @endforelse
    </div>

    {{-- Jadwal Petugas Hari Ini --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-5">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-bold text-gray-700 dark:text-white">Jadwal Petugas Hari Ini</h2>
            <a href="{{ route('pelayanan.jadwal.index') }}"
               class="text-xs text-[#035f9c] hover:underline font-semibold">
                Kelola jadwal →
            </a>
        </div>

        @forelse ($jadwalHariIni as $jadwal)
            <div class="flex items-center justify-between py-3 border-b border-gray-50 dark:border-gray-800 last:border-0">
                <div>
                    <p class="text-sm font-semibold text-gray-800 dark:text-white">
                        {{ $jadwal->petugas->name ?? $jadwal->nama_petugas ?? '-' }}
                    </p>
                    <p class="text-xs text-gray-400">
                        {{ $jadwal->jam_mulai ?? '-' }} – {{ $jadwal->jam_selesai ?? '-' }} WIB
                    </p>
                </div>

                @php
                    $aktif = now()->between(
                        \Carbon\Carbon::parse($jadwal->jam_mulai ?? '00:00'),
                        \Carbon\Carbon::parse($jadwal->jam_selesai ?? '00:00')
                    );
                @endphp
                <div class="flex items-center gap-1.5">
                    <div class="w-2 h-2 rounded-full {{ $aktif ? 'bg-green-500' : 'bg-amber-400' }}"></div>
                    <span class="text-xs font-semibold {{ $aktif ? 'text-green-600' : 'text-amber-600' }}">
                        {{ $aktif ? 'Aktif' : 'Menunggu' }}
                    </span>
                </div>
            </div>
        @empty
            <div class="py-8 text-center">
                <i class="ti ti-calendar-off text-3xl text-gray-300 dark:text-gray-700"></i>
                <p class="text-sm text-gray-400 mt-2">Tidak ada jadwal hari ini</p>
            </div>
        @endforelse
    </div>

</div>

@endsection