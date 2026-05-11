@extends('layouts.app')

@section('content')
<div class="p-6 max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="flex items-start justify-between mb-6">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('statistic-titles.index') }}"
                    class="text-xs text-gray-400 hover:text-[#035f9c] transition">Judul & Interpretasi Data</a>
                <i class="ti ti-chevron-right text-xs text-gray-300"></i>
                <span class="text-xs text-gray-500">Detail</span>
            </div>
            <h1 class="text-xl font-bold text-gray-800 dark:text-white">{{ $statisticTitle->judul_data }}</h1>
            <span class="inline-flex items-center mt-1.5 px-2.5 py-1 rounded-lg text-[10px] font-semibold bg-blue-50 text-[#035f9c] dark:bg-blue-900/20">
                {{ Str::title(Str::replace('_', ' ', $statisticTitle->indikator_data)) }}
            </span>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <a href="{{ route('statistic-titles.edit', $statisticTitle->id) }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold bg-[#035f9c] text-white hover:bg-blue-700 transition shadow-sm">
                <i class="ti ti-pencil text-sm"></i> Edit
            </a>
            <a href="{{ route('statistic-titles.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold border border-gray-200 text-gray-600 hover:bg-gray-50 transition">
                <i class="ti ti-arrow-left text-sm"></i> Kembali
            </a>
        </div>
    </div>

    <div class="space-y-5">

        {{-- ── Card: Informasi Judul ── --}}
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm p-6">
            <h2 class="text-sm font-bold text-gray-700 dark:text-white flex items-center gap-2 mb-5">
                <span class="w-7 h-7 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center">
                    <i class="ti ti-file-description text-blue-500 text-sm"></i>
                </span>
                Informasi Judul
            </h2>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Indikator Data</p>
                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                        {{ Str::title(Str::replace('_', ' ', $statisticTitle->indikator_data)) }}
                    </p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Judul Kolom</p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        {{ $statisticTitle->judul_kolom ?: '—' }}
                    </p>
                </div>
                <div class="col-span-2">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Judul Data</p>
                    <p class="text-sm font-semibold text-gray-800 dark:text-white leading-relaxed">
                        {{ $statisticTitle->judul_data }}
                    </p>
                </div>
                <div class="col-span-2 flex items-center gap-4 pt-2 border-t border-gray-50 dark:border-gray-800 text-xs text-gray-400">
                    <span><i class="ti ti-calendar mr-1"></i>Dibuat: {{ $statisticTitle->created_at->format('d M Y, H:i') }}</span>
                    <span><i class="ti ti-refresh mr-1"></i>Diperbarui: {{ $statisticTitle->updated_at->format('d M Y, H:i') }}</span>
                </div>
            </div>
        </div>

        {{-- ── Card: Interpretasi Level Judul ── --}}
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm p-6">
            <h2 class="text-sm font-bold text-gray-700 dark:text-white flex items-center gap-2 mb-5">
                <span class="w-7 h-7 rounded-lg bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center">
                    <i class="ti ti-message-2-text text-purple-500 text-sm"></i>
                </span>
                Interpretasi Level Judul
                <span class="text-xs font-normal text-gray-400">(fallback jika komponen tidak punya interpretasi sendiri)</span>
            </h2>

            <div class="grid grid-cols-3 gap-4">
                {{-- Naik --}}
                <div class="rounded-xl border border-green-100 dark:border-green-900/30 bg-green-50/50 dark:bg-green-900/10 p-4">
                    <p class="text-[10px] font-bold text-green-600 uppercase tracking-widest mb-2 flex items-center gap-1">
                        <i class="ti ti-trending-up"></i> Jika Naik
                    </p>
                    @if($statisticTitle->interpretasi_lebih_besar)
                        <p class="text-xs text-gray-600 dark:text-gray-300 leading-relaxed">
                            {{ $statisticTitle->interpretasi_lebih_besar }}
                        </p>
                    @else
                        <p class="text-xs text-gray-300 italic">Belum diisi</p>
                    @endif
                </div>

                {{-- Turun --}}
                <div class="rounded-xl border border-rose-100 dark:border-rose-900/30 bg-rose-50/50 dark:bg-rose-900/10 p-4">
                    <p class="text-[10px] font-bold text-rose-500 uppercase tracking-widest mb-2 flex items-center gap-1">
                        <i class="ti ti-trending-down"></i> Jika Turun
                    </p>
                    @if($statisticTitle->interpretasi_lebih_kecil)
                        <p class="text-xs text-gray-600 dark:text-gray-300 leading-relaxed">
                            {{ $statisticTitle->interpretasi_lebih_kecil }}
                        </p>
                    @else
                        <p class="text-xs text-gray-300 italic">Belum diisi</p>
                    @endif
                </div>

                {{-- Tetap --}}
                <div class="rounded-xl border border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/30 p-4">
                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-2 flex items-center gap-1">
                        <i class="ti ti-minus"></i> Jika Tetap
                    </p>
                    @if($statisticTitle->interpretasi_tetap)
                        <p class="text-xs text-gray-600 dark:text-gray-300 leading-relaxed">
                            {{ $statisticTitle->interpretasi_tetap }}
                        </p>
                    @else
                        <p class="text-xs text-gray-300 italic">Belum diisi</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── Card: Komponen / Kategori ── --}}
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm p-6">
            <h2 class="text-sm font-bold text-gray-700 dark:text-white flex items-center gap-2 mb-5">
                <span class="w-7 h-7 rounded-lg bg-indigo-50 dark:bg-indigo-900/20 flex items-center justify-center">
                    <i class="ti ti-list text-indigo-500 text-sm"></i>
                </span>
                Komponen / Kategori
                <span class="ml-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-gray-100 dark:bg-gray-800 text-gray-500">
                    {{ $statisticTitle->components->count() }} komponen
                </span>
            </h2>

            @if($statisticTitle->components->count() > 0)
            <div class="space-y-2">
                @foreach($statisticTitle->components->sortBy('urutan') as $index => $comp)
                <div class="rounded-xl border overflow-hidden
                    {{ $comp->is_sub
                        ? 'border-indigo-100 dark:border-indigo-800 bg-indigo-50/40 dark:bg-indigo-900/10'
                        : 'border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/30' }}">

                    {{-- Header komponen --}}
                    <div class="flex items-center gap-3 px-4 py-3 {{ $comp->is_sub ? 'pl-8' : '' }}">
                        <span class="text-xs font-bold text-gray-300 w-5 shrink-0 tabular-nums">
                            {{ $loop->iteration }}
                        </span>

                        @if($comp->is_sub)
                            <span class="text-indigo-300 font-bold shrink-0">·</span>
                        @endif

                        <p class="flex-1 text-sm font-{{ $comp->is_sub ? 'normal text-gray-500 dark:text-gray-400 italic' : 'semibold text-gray-700 dark:text-gray-200' }}">
                            {{ $comp->nama }}
                        </p>

                        @if($comp->satuan && !$comp->is_sub)
                            <span class="shrink-0 px-2 py-0.5 rounded-md bg-gray-100 dark:bg-gray-700 text-[10px] font-semibold text-gray-400">
                                {{ $comp->satuan }}
                            </span>
                        @endif

                        @if($comp->is_sub)
                            <span class="shrink-0 px-2 py-0.5 rounded-md bg-indigo-100 dark:bg-indigo-900/30 text-[10px] font-semibold text-indigo-500">
                                Sub
                            </span>
                        @endif

                        {{-- Badge interpretasi tersedia --}}
                        @if(!$comp->is_sub && ($comp->interpretasi_lebih_besar || $comp->interpretasi_lebih_kecil || $comp->interpretasi_tetap))
                            <span class="shrink-0 px-2 py-0.5 rounded-md bg-purple-50 dark:bg-purple-900/20 text-[10px] font-semibold text-purple-500 flex items-center gap-0.5">
                                <i class="ti ti-message-2 text-[9px]"></i> Ada interpretasi
                            </span>
                        @endif
                    </div>

                    {{-- Interpretasi per komponen (jika ada) --}}
                    @if(!$comp->is_sub && ($comp->interpretasi_lebih_besar || $comp->interpretasi_lebih_kecil || $comp->interpretasi_tetap))
                    <div class="border-t border-gray-100 dark:border-gray-700 px-4 py-3 grid grid-cols-3 gap-3 bg-white/60 dark:bg-gray-900/40">
                        <div>
                            <p class="text-[9px] font-bold text-green-500 uppercase tracking-widest mb-1 flex items-center gap-0.5">
                                <i class="ti ti-trending-up text-[9px]"></i> Naik
                            </p>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 leading-relaxed">
                                {{ $comp->interpretasi_lebih_besar ?: '—' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-[9px] font-bold text-rose-500 uppercase tracking-widest mb-1 flex items-center gap-0.5">
                                <i class="ti ti-trending-down text-[9px]"></i> Turun
                            </p>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 leading-relaxed">
                                {{ $comp->interpretasi_lebih_kecil ?: '—' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-1 flex items-center gap-0.5">
                                <i class="ti ti-minus text-[9px]"></i> Tetap
                            </p>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 leading-relaxed">
                                {{ $comp->interpretasi_tetap ?: '—' }}
                            </p>
                        </div>
                    </div>
                    @endif

                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-10 border-2 border-dashed border-gray-100 dark:border-gray-800 rounded-xl">
                <i class="ti ti-list-details text-3xl text-gray-300 mb-2 block"></i>
                <p class="text-sm text-gray-400">Belum ada komponen yang ditambahkan</p>
            </div>
            @endif
        </div>

        {{-- ── Footer actions ── --}}
        <div class="flex items-center justify-between pt-1">
            <form method="POST" action="{{ route('statistic-titles.destroy', $statisticTitle->id) }}"
                onsubmit="return confirm('Yakin hapus judul ini? Semua komponen terkait akan ikut terhapus.')">
                @csrf @method('DELETE')
                <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-rose-500 border border-rose-100 dark:border-rose-900/30 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition">
                    <i class="ti ti-trash text-sm"></i> Hapus Data Ini
                </button>
            </form>
            <a href="{{ route('statistic-titles.edit', $statisticTitle->id) }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-bold bg-[#035f9c] text-white hover:bg-blue-700 transition shadow-sm">
                <i class="ti ti-pencil text-sm"></i> Edit Data Ini
            </a>
        </div>

    </div>
</div>
@endsection