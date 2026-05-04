@extends('layouts.app')

@section('content')
<div class="p-6">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Detail Data Statistik</h1>
        <a href="{{ route('statistics.edit', $statistic->id) }}"
           class="inline-flex items-center gap-2 bg-[#035f9c] text-white hover:bg-blue-700 text-sm font-semibold px-4 py-2 rounded-xl transition">
            <i class="ti ti-pencil text-base"></i> Edit Data
        </a>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm p-6">

        {{-- Row 1: Indikator + Judul Data --}}
        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-semibold text-[#035f9c] mb-1">Indikator</label>
                <div class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-800 bg-gray-50">
                    {{ ucwords(str_replace('_', ' ', $statistic->indikator_data)) }}
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-[#035f9c] mb-1">Judul Data</label>
                <div class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-800 bg-gray-50">
                    {{ $statistic->judul_data }}
                </div>
            </div>
        </div>

        {{-- Row 2: Tahun Data + Wilayah Data --}}
        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-semibold text-[#035f9c] mb-1">Tahun Data</label>
                <div class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-800 bg-gray-50">
                    {{ $values->pluck('y_label')->filter()->unique()->sort()->implode(', ') ?: '-' }}
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-[#035f9c] mb-1">Wilayah Data</label>
                <div class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-800 bg-gray-50">
                    {{ $statistic->wilayah_data }}
                </div>
            </div>
        </div>

        {{-- Interpretasi Data --}}
        <div class="mb-6">
            <p class="text-center text-sm font-semibold text-[#035f9c] mb-4">Interpretasi Data</p>
            <div class="grid grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-green-500 mb-1">
                        <i class="ti ti-trending-down text-xs"></i> Lebih Kecil (Turun)
                    </label>
                    <div class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-800 bg-gray-50 min-h-[7rem]">
                        {{ $statistic->interpretasi_lebih_kecil ?: '-' }}
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-red-400 mb-1">
                        <i class="ti ti-trending-up text-xs"></i> Lebih Besar (Naik)
                    </label>
                    <div class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-800 bg-gray-50 min-h-[7rem]">
                        {{ $statistic->interpretasi_lebih_besar ?: '-' }}
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-500 mb-1">
                        <i class="ti ti-minus text-xs"></i> Tetap
                    </label>
                    <div class="w-full border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-sm text-gray-700 dark:text-gray-300 dark:bg-gray-800 bg-gray-50 min-h-[7rem]">
                        {{ $statistic->interpretasi_tetap ?? '-' }}
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================================ --}}
        {{-- TABEL NILAI ANGKA                                            --}}
        {{-- ============================================================ --}}
        @if($values->isNotEmpty())
        <div class="mb-6">
            <p class="text-sm font-semibold text-[#035f9c] mb-3">Nilai Data</p>

            @php
                $years      = $values->pluck('y_label')->filter()->unique()->sort()->values();
                $xLabels    = $values->pluck('x_label')->unique()->values();
                $is2D       = $years->isNotEmpty();

                // Buat pivot: x_label => [ y_label => value ]
                $pivot = [];
                foreach ($values as $v) {
                    $key   = $v->x_label;
                    $col   = $is2D ? ($v->y_label ?? '-') : 'Nilai';
                    $pivot[$key][$col] = $v->value;
                }

                $cols = $is2D ? $years->toArray() : ['Nilai'];
            @endphp

            <div class="overflow-x-auto rounded-xl border border-gray-100 dark:border-gray-700">
                <table class="w-full text-sm border-collapse">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-800">
                            <th class="text-left px-4 py-3 text-xs font-bold text-gray-400 uppercase tracking-widest border-b border-r border-gray-100 dark:border-gray-700 min-w-[220px]">
                                Kategori
                            </th>
                            @foreach($cols as $col)
                            <th class="px-4 py-3 text-center text-xs font-bold text-gray-400 uppercase tracking-widest border-b border-r border-gray-100 dark:border-gray-700 min-w-[100px]">
                                {{ $col }}
                            </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pivot as $xLabel => $colValues)
                        @php $isSub = str_starts_with($xLabel, '· '); @endphp
                        <tr class="border-b border-gray-50 dark:border-gray-800
                            {{ $isSub ? 'bg-indigo-50/40 dark:bg-indigo-900/10' : 'bg-white dark:bg-gray-900' }}">
                            <td class="px-4 py-2.5 border-r border-gray-100 dark:border-gray-700
                                {{ $isSub ? 'pl-8 text-gray-500 text-xs italic' : 'font-semibold text-gray-700 dark:text-white text-sm' }}">
                                {{ $isSub ? ltrim($xLabel, '· ') : $xLabel }}
                            </td>
                            @foreach($cols as $col)
                            <td class="px-4 py-2.5 text-center border-r border-gray-100 dark:border-gray-700 text-gray-700 dark:text-gray-300">
                                @php $val = $colValues[$col] ?? null; @endphp
                                @if(!is_null($val))
                                    {{ is_numeric($val) ? number_format((float)$val, 2, ',', '.') : $val }}
                                @else
                                    <span class="text-gray-300">—</span>
                                @endif
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="mb-6 rounded-xl border border-dashed border-gray-200 dark:border-gray-700 py-8 text-center">
            <i class="ti ti-table-off text-2xl text-gray-300 block mb-2"></i>
            <p class="text-sm text-gray-400">Belum ada nilai data</p>
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
                Kembali
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