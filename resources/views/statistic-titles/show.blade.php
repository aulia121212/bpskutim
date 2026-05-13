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
        <!-- <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm p-6">
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
        </div> -->

       {{-- ── Card: Komponen / Kategori ── --}}
<div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm p-4 sm:p-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
        <div class="flex items-center gap-2">
            <span class="w-8 h-8 rounded-xl bg-indigo-50 dark:bg-indigo-900/20 flex items-center justify-center shrink-0">
                <i class="ti ti-list text-indigo-500 text-sm"></i>
            </span>

            <div>
                <h2 class="text-sm font-bold text-gray-700 dark:text-white">
                    Komponen / Kategori
                </h2>

                <p class="text-[11px] text-gray-400 mt-0.5">
                    Daftar komponen beserta definisi dan interpretasi perubahan data
                </p>
            </div>
        </div>

        <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-lg text-[10px] font-bold bg-gray-100 dark:bg-gray-800 text-gray-500 w-fit">
            {{ $statisticTitle->components->count() }} komponen
        </span>
    </div>

    @if($statisticTitle->components->count() > 0)

    <div class="space-y-4">
        @foreach($statisticTitle->components->sortBy('urutan') as $index => $comp)

        <div class="rounded-2xl overflow-hidden border
            {{ $comp->is_sub
                ? 'border-indigo-100 dark:border-indigo-800 bg-indigo-50/30 dark:bg-indigo-900/10'
                : 'border-gray-100 dark:border-gray-700 bg-white dark:bg-gray-900' }}">

            {{-- Header Komponen --}}
            <div class="flex flex-col sm:flex-row sm:items-center gap-3 px-4 py-4">

                {{-- Kiri --}}
                <div class="flex items-start gap-3 flex-1 min-w-0">

                    {{-- Nomor --}}
                    <div class="w-7 h-7 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center shrink-0">
                        <span class="text-[11px] font-bold text-gray-500">
                            {{ $loop->iteration }}
                        </span>
                    </div>

                    {{-- Nama --}}
                    <div class="min-w-0 flex-1">

                        <div class="flex flex-wrap items-center gap-2">

                            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200 break-words">
                                {{ $comp->nama }}
                            </h3>

                            @if($comp->is_sub)
                            <span class="px-2 py-0.5 rounded-md bg-indigo-100 dark:bg-indigo-900/30 text-[10px] font-semibold text-indigo-600 dark:text-indigo-300">
                                Sub
                            </span>
                            @endif

                            @if($comp->satuan)
                            <span class="px-2 py-0.5 rounded-md bg-gray-100 dark:bg-gray-800 text-[10px] font-semibold text-gray-500">
                                {{ $comp->satuan }}
                            </span>
                            @endif

                        </div>

                        @if(!$comp->is_sub)
{{-- Definisi --}}
<div class="mt-3 rounded-xl border border-blue-100 dark:border-blue-900/40 bg-blue-50/50 dark:bg-blue-900/10 p-3">
    <div class="flex items-center gap-1.5 mb-1.5">
        <i class="ti ti-book-2 text-blue-500 text-xs"></i>

        <p class="text-[10px] font-bold uppercase tracking-widest text-blue-600 dark:text-blue-300">
            Definisi
        </p>
    </div>

    <p class="text-xs leading-relaxed text-gray-600 dark:text-gray-300">
        {{ $comp->definisi ?: 'Definisi komponen belum tersedia.' }}
    </p>
</div>
@endif

                    </div>
                </div>

                {{-- Badge --}}
                @if(
                    $comp->interpretasi_lebih_besar ||
                    $comp->interpretasi_lebih_kecil ||
                    $comp->interpretasi_tetap
                )
                <div class="shrink-0">
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-purple-50 dark:bg-purple-900/20 text-[10px] font-semibold text-purple-600 dark:text-purple-300">
                        <i class="ti ti-message-2 text-[10px]"></i>
                        Ada Interpretasi
                    </span>
                </div>
                @endif

            </div>

            {{-- Interpretasi --}}
            @if(
                $comp->interpretasi_lebih_besar ||
                $comp->interpretasi_lebih_kecil ||
                $comp->interpretasi_tetap
            )

            <div class="border-t border-gray-100 dark:border-gray-800 px-4 py-4 bg-gray-50/50 dark:bg-gray-800/20">

                <div class="flex items-center gap-2 mb-4">
                    <div class="w-1.5 h-5 rounded-full bg-emerald-500"></div>

                    <div>
                        <h4 class="text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-widest">
                            Interpretasi Perubahan Data
                        </h4>

                        <p class="text-[11px] text-gray-400 mt-0.5">
                            Digunakan saat membandingkan perubahan nilai antar periode
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">

                    {{-- Naik --}}
                    <div class="rounded-xl border border-green-100 dark:border-green-900/30 bg-green-50/60 dark:bg-green-900/10 p-3">
                        <div class="flex items-center gap-1.5 mb-2">
                            <i class="ti ti-trending-up text-green-600 text-xs"></i>

                            <p class="text-[10px] font-bold uppercase tracking-widest text-green-600 dark:text-green-300">
                                Jika Nilai Naik
                            </p>
                        </div>

                        <p class="text-xs leading-relaxed text-gray-600 dark:text-gray-300">
                            {{ $comp->interpretasi_lebih_besar ?: 'Belum tersedia.' }}
                        </p>
                    </div>

                    {{-- Turun --}}
                    <div class="rounded-xl border border-red-100 dark:border-red-900/30 bg-red-50/60 dark:bg-red-900/10 p-3">
                        <div class="flex items-center gap-1.5 mb-2">
                            <i class="ti ti-trending-down text-red-500 text-xs"></i>

                            <p class="text-[10px] font-bold uppercase tracking-widest text-red-500 dark:text-red-300">
                                Jika Nilai Turun
                            </p>
                        </div>

                        <p class="text-xs leading-relaxed text-gray-600 dark:text-gray-300">
                            {{ $comp->interpretasi_lebih_kecil ?: 'Belum tersedia.' }}
                        </p>
                    </div>

                    {{-- Tetap --}}
                    <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/40 p-3">
                        <div class="flex items-center gap-1.5 mb-2">
                            <i class="ti ti-minus text-gray-500 text-xs"></i>

                            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-500 dark:text-gray-300">
                                Jika Nilai Tetap
                            </p>
                        </div>

                        <p class="text-xs leading-relaxed text-gray-600 dark:text-gray-300">
                            {{ $comp->interpretasi_tetap ?: 'Belum tersedia.' }}
                        </p>
                    </div>

                </div>

            </div>
            @endif

        </div>

        @endforeach
    </div>

    @else

    {{-- Empty State --}}
    <div class="text-center py-12 border-2 border-dashed border-gray-100 dark:border-gray-800 rounded-2xl">
        <div class="w-14 h-14 mx-auto rounded-2xl bg-gray-50 dark:bg-gray-800 flex items-center justify-center mb-3">
            <i class="ti ti-list-details text-2xl text-gray-300"></i>
        </div>

        <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-300">
            Belum Ada Komponen
        </h3>

        <p class="text-xs text-gray-400 mt-1">
            Tambahkan komponen untuk melengkapi detail statistik.
        </p>
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