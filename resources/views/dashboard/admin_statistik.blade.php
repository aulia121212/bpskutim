@extends('layouts.app') {{-- sesuaikan dengan nama layout utama project kamu --}}

@section('title', 'Dashboard Data Statistik')

@section('content')

{{-- ── HEADER ─────────────────────────────────────────────────────── --}}
<div class="mb-6">
    <h1 class="text-xl font-bold text-gray-800 dark:text-white">Dashboard Data Statistik</h1>
    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
        Selamat datang, {{ auth()->user()->name }}.
        Berikut ringkasan pengelolaan data statistik.
    </p>
</div>

{{-- ── STAT CARDS ──────────────────────────────────────────────────── --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

    {{-- Total Data --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Data</span>
            <div class="w-9 h-9 rounded-xl bg-teal-50 dark:bg-teal-900/30 flex items-center justify-center">
                <i class="ti ti-chart-bar text-teal-500 text-lg"></i>
            </div>
        </div>
        <div class="text-3xl font-bold text-gray-800 dark:text-white">
            {{ $stats['total_data'] }}
        </div>
        <p class="text-xs text-gray-400 mt-1">Total entri data statistik</p>
    </div>

    {{-- Dipublikasikan --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Dipublikasikan</span>
            <div class="w-9 h-9 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center">
                <i class="ti ti-circle-check text-[#035f9c] text-lg"></i>
            </div>
        </div>
        <div class="text-3xl font-bold text-gray-800 dark:text-white">
            {{ $stats['dipublikasikan'] }}
        </div>
        <p class="text-xs text-[#035f9c]mt-1 font-medium">
            @if($stats['total_data'] > 0)
                {{ round(($stats['dipublikasikan'] / $stats['total_data']) * 100) }}% dari total
            @else
                —
            @endif
        </p>
    </div>

    {{-- Draft / Review --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Draft / Review</span>
            <div class="w-9 h-9 rounded-xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center">
                <i class="ti ti-edit text-amber-500 text-lg"></i>
            </div>
        </div>
        <div class="text-3xl font-bold text-gray-800 dark:text-white">
            {{ $stats['draft_review'] }}
        </div>
        <p class="text-xs text-amber-500 mt-1 font-medium">Perlu ditindaklanjuti</p>
    </div>

    {{-- Total Judul / Indikator --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Judul / Indikator</span>
            <div class="w-9 h-9 rounded-xl bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center">
                <i class="ti ti-list text-purple-500 text-lg"></i>
            </div>
        </div>
        <div class="text-3xl font-bold text-gray-800 dark:text-white">
            {{ $stats['total_judul'] }}
        </div>
        <p class="text-xs text-gray-400 mt-1">Judul statistik aktif</p>
    </div>

</div>

{{-- ── TABEL + BAR CHART ────────────────────────────────────────────── --}}
<div class="grid grid-cols-1 xl:grid-cols-2 gap-4">

    {{-- Data Statistik Terbaru --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-5">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-bold text-gray-700 dark:text-white">Data Statistik Terbaru</h2>
            <a href="{{ route('statistics.index') }}"
               class="text-xs text-teal-600 hover:underline font-semibold">
                Kelola data →
            </a>
        </div>

        @forelse ($dataTerbaru as $data)
            @php
                $badgeClass = $data->is_published
                    ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400'
                    : 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400';
                $badgeLabel = $data->is_published ? 'Publikasi' : 'Draft';
            @endphp

            <div class="flex items-center gap-3 py-3 border-b border-gray-50 dark:border-gray-800 last:border-0">
                {{-- Dot warna kategori --}}
                <div class="w-2 h-2 rounded-full bg-teal-400 flex-shrink-0 mt-1 self-start"></div>

                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-800 dark:text-white truncate">
                        {{ $data->judul ?? $data->title ?? '-' }}
                    </p>
                    <p class="text-xs text-gray-400">
                        {{ $data->statisticTitle->title ?? $data->kategori ?? '-' }}
                        · Diperbarui {{ \Carbon\Carbon::parse($data->updated_at)->diffForHumans() }}
                    </p>
                </div>

                <span class="text-[11px] font-semibold px-2.5 py-1 rounded-full {{ $badgeClass }} flex-shrink-0">
                    {{ $badgeLabel }}
                </span>
            </div>
        @empty
            <div class="py-8 text-center">
                <i class="ti ti-chart-off text-3xl text-gray-300 dark:text-gray-700"></i>
                <p class="text-sm text-gray-400 mt-2">Belum ada data statistik</p>
            </div>
        @endforelse
    </div>

    {{-- Data per Kategori --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-5">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-bold text-gray-700 dark:text-white">Data per Kategori</h2>
            <a href="{{ route('statistic-titles.index') }}"
               class="text-xs text-teal-600 hover:underline font-semibold">
                Lihat semua →
            </a>
        </div>

        @php
            // Warna bar per urutan kategori (berulang jika lebih dari 6)
            $barColors = [
                'bg-teal-400',
                'bg-blue-400',
                'bg-amber-400',
                'bg-purple-400',
                'bg-pink-400',
                'bg-gray-400',
            ];
            $maxCount = $dataPerKategori->max('statistics_count') ?: 1;
        @endphp

        @forelse ($dataPerKategori as $i => $kategori)
            @php
                $pct   = round(($kategori->statistics_count / $maxCount) * 100);
                $color = $barColors[$i % count($barColors)];
            @endphp
            <div class="flex items-center gap-3 mb-3 last:mb-0">
                <span class="text-xs text-gray-500 dark:text-gray-400 text-right w-28 flex-shrink-0 truncate">
                    {{ $kategori->title ?? $kategori->nama ?? '-' }}
                </span>
                <div class="flex-1 h-2 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
                    <div class="h-full rounded-full {{ $color }}"
                         style="width: {{ $pct }}%"></div>
                </div>
                <span class="text-xs text-gray-500 dark:text-gray-400 w-6 flex-shrink-0 text-right">
                    {{ $kategori->statistics_count }}
                </span>
            </div>
        @empty
            <div class="py-8 text-center">
                <i class="ti ti-category-off text-3xl text-gray-300 dark:text-gray-700"></i>
                <p class="text-sm text-gray-400 mt-2">Belum ada kategori</p>
            </div>
        @endforelse
    </div>

</div>

@endsection