@extends('layouts.app')

@section('content')
<div class="p-6">

    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Detail Data Statistik</h1>

    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm p-6">

        {{-- Row 1: Indikator + Judul Data --}}
        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-semibold text-blue-500 mb-1">Indikator</label>
                <div class="relative">
                    <div class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-800 bg-gray-50">
                        {{ ucwords(str_replace('_', ' ', $statistic->indikator_data)) }}
                    </div>
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-blue-500 mb-1">Judul Data</label>
                <div class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-800 bg-gray-50">
                    {{ $statistic->judul_data }}
                </div>
            </div>
        </div>

        {{-- Row 2: Tahun Data + File Data --}}
        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-semibold text-blue-500 mb-1">Tahun Data</label>
                <div class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-800 bg-gray-50">
                    {{ $values->pluck('year')->implode(', ') ?: '-' }}
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-blue-500 mb-1">File Data</label>
                <div class="flex items-center gap-2">
                    <div class="flex-1 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-800 bg-gray-50 truncate">
                        {{ basename($statistic->file_data) }}
                    </div>
                    <a href="{{ Storage::url($statistic->file_data) }}" target="_blank"
                        class="inline-flex items-center gap-1 bg-blue-50 hover:bg-blue-100 text-blue-600 text-xs font-semibold px-3 py-2 rounded-lg transition whitespace-nowrap">
                        Preview Saja <i class="ti ti-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Row 3: Wilayah Data --}}
        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-semibold text-blue-500 mb-1">Wilayah Data</label>
                <div class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-800 bg-gray-50">
                    {{ $statistic->wilayah_data }}
                </div>
            </div>
        </div>

        {{-- Interpretasi Data --}}
        <div class="mb-6">
            <p class="text-center text-sm font-semibold text-blue-500 mb-4">Interpretasi Data</p>
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-blue-400 mb-1">Lebih Kecil</label>
                    <div class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-800 bg-gray-50 min-h-[7rem]">
                        {{ $statistic->interpretasi_lebih_kecil }}
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-blue-400 mb-1">Lebih Besar</label>
                    <div class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-800 bg-gray-50 min-h-[7rem]">
                        {{ $statistic->interpretasi_lebih_besar }}
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- PREVIEW INTERPRETASI BERDASARKAN PERBANDINGAN DATA           --}}
        {{-- ============================================================ --}}
        @php
            $sortedValues = $values->sortBy('year')->values();
            $totalData    = $sortedValues->count();
            $tren         = null; // 'naik' | 'turun' | 'tetap'
            $selisih      = null;
            $nilaiAwal    = null;
            $nilaiAkhir   = null;
            $tahunAwal    = null;
            $tahunAkhir   = null;

            if ($totalData >= 2) {
                $first      = $sortedValues->first();
                $last       = $sortedValues->last();
                $nilaiAwal  = $first->value;
                $nilaiAkhir = $last->value;
                $tahunAwal  = $first->year;
                $tahunAkhir = $last->year;
                $selisih    = $nilaiAkhir - $nilaiAwal;

                if ($selisih > 0)      $tren = 'naik';
                elseif ($selisih < 0)  $tren = 'turun';
                else                   $tren = 'tetap';
            }
        @endphp

        @if ($totalData >= 2)
        <div class="mb-6">
            <p class="text-center text-sm font-semibold text-blue-500 mb-4">
                Preview Interpretasi — Perbandingan Data
            </p>

            {{-- Ringkasan Tren --}}
            <div class="flex items-center justify-between gap-4 mb-5 p-4 rounded-2xl
                @if($tren === 'naik')   bg-red-50  dark:bg-red-900/20  border border-red-100  dark:border-red-800
                @elseif($tren === 'turun') bg-green-50 dark:bg-green-900/20 border border-green-100 dark:border-green-800
                @else                  bg-gray-50  dark:bg-gray-800    border border-gray-200 dark:border-gray-700
                @endif">

                {{-- Nilai Awal --}}
                <div class="text-center">
                    <p class="text-xs text-gray-400 mb-0.5">Tahun {{ $tahunAwal }}</p>
                    <p class="text-2xl font-black text-gray-800 dark:text-white">{{ number_format($nilaiAwal, 2) }}</p>
                </div>

                {{-- Panah Tren --}}
                <div class="flex flex-col items-center gap-1">
                    @if($tren === 'naik')
                        <i class="ti ti-trending-up text-3xl text-red-500"></i>
                        <span class="text-xs font-bold text-red-500 uppercase tracking-widest">Naik</span>
                        <span class="text-xs font-semibold text-red-400">+{{ number_format(abs($selisih), 2) }}</span>
                    @elseif($tren === 'turun')
                        <i class="ti ti-trending-down text-3xl text-green-500"></i>
                        <span class="text-xs font-bold text-green-500 uppercase tracking-widest">Turun</span>
                        <span class="text-xs font-semibold text-green-400">-{{ number_format(abs($selisih), 2) }}</span>
                    @else
                        <i class="ti ti-minus text-3xl text-gray-400"></i>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Tetap</span>
                        <span class="text-xs font-semibold text-gray-400">0</span>
                    @endif
                </div>

                {{-- Nilai Akhir --}}
                <div class="text-center">
                    <p class="text-xs text-gray-400 mb-0.5">Tahun {{ $tahunAkhir }}</p>
                    <p class="text-2xl font-black text-gray-800 dark:text-white">{{ number_format($nilaiAkhir, 2) }}</p>
                </div>
            </div>

            {{-- Teks Interpretasi --}}
            <div class="rounded-2xl border p-5
                @if($tren === 'naik')   border-red-100   dark:border-red-800   bg-red-50/50   dark:bg-red-900/10
                @elseif($tren === 'turun') border-green-100 dark:border-green-800 bg-green-50/50 dark:bg-green-900/10
                @else                  border-gray-200  dark:border-gray-700   bg-gray-50     dark:bg-gray-800
                @endif">

                <div class="flex items-start gap-3">
                    <div class="mt-0.5 shrink-0 w-8 h-8 rounded-xl flex items-center justify-center
                        @if($tren === 'naik')   bg-red-100   dark:bg-red-900/30
                        @elseif($tren === 'turun') bg-green-100 dark:bg-green-900/30
                        @else                  bg-gray-100  dark:bg-gray-700
                        @endif">
                        @if($tren === 'naik')
                            <i class="ti ti-arrow-up text-red-500 text-lg"></i>
                        @elseif($tren === 'turun')
                            <i class="ti ti-arrow-down text-green-500 text-lg"></i>
                        @else
                            <i class="ti ti-equal text-gray-400 text-lg"></i>
                        @endif
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-bold uppercase tracking-widest mb-2
                            @if($tren === 'naik')   text-red-400
                            @elseif($tren === 'turun') text-green-500
                            @else                  text-gray-400
                            @endif">
                            Interpretasi — Data
                            @if($tren === 'naik') Lebih Besar (Naik)
                            @elseif($tren === 'turun') Lebih Kecil (Turun)
                            @else Tidak Berubah
                            @endif
                        </p>
                        <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                            @if($tren === 'naik')
                                {{ $statistic->interpretasi_lebih_besar ?: 'Tidak ada interpretasi yang tersedia.' }}
                            @elseif($tren === 'turun')
                                {{ $statistic->interpretasi_lebih_kecil ?: 'Tidak ada interpretasi yang tersedia.' }}
                            @else
                                Data tidak mengalami perubahan antara tahun {{ $tahunAwal }} dan {{ $tahunAkhir }}.
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endif
        {{-- ============================================================ --}}

        {{-- Timestamps --}}
        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-xs text-gray-400 mb-1">Created at</label>
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    {{ $statistic->created_at->format('d F Y') }}
                </div>
            </div>
            <div>
                <label class="block text-xs text-gray-400 mb-1">Updated at</label>
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    {{ $statistic->updated_at->format('d F Y H:i:s') }}
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex justify-end gap-3 mt-4">
            <a href="{{ route('statistics.index') }}"
                class="px-6 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                Batal
            </a>

            @if($statistic->status === 'draft')
            <form method="POST" action="{{ route('statistics.publish', $statistic->id) }}">
                @csrf
                <button type="submit"
                    class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition">
                    Publish
                </button>
            </form>
            @else
            <span class="px-6 py-2.5 rounded-xl bg-green-100 text-green-700 text-sm font-semibold">
                ✓ Published
            </span>
            @endif
        </div>

    </div>
</div>
@endsection