<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $stat->judul_data }} - BPS Kabupaten Kutai Timur</title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400;1,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Nunito+Sans:ital,wght@1,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>tailwind.config = { corePlugins: { preflight: false } }</script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/show_data.css') }}?v={{ filemtime(public_path('css/show_data.css')) }}">
</head>
<body>

@include('partials.navbar')

<main class="pt-10">
<div class="show-page">

    {{-- Breadcrumb --}}
    <nav class="show-breadcrumb">
        <a href="{{ route('data-statistik.index') }}"><i class="ti ti-database"></i> Data Statistik</a>
        <i class="ti ti-chevron-right"></i>
        <a href="{{ route('data-statistik.indikator', $slug) }}">
            {{ $indikatorMap[$slug] ?? \Illuminate\Support\Str::title(str_replace('_', ' ', $slug)) }}
        </a>
        <i class="ti ti-chevron-right"></i>
        <span>{{ $stat->judul_data }}</span>
    </nav>

    {{-- Tab bar — identik grafik_blade --}}
    <div class="flex gap-2 mb-6">
        <button id="tab-grafik" onclick="switchTab('grafik')"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition bg-[#035f9c] text-white">
            <i class="ti ti-chart-line"></i> Grafik
        </button>
        <button id="tab-tabel" onclick="switchTab('tabel')"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition border border-gray-200 text-gray-600 hover:bg-gray-50">
            <i class="ti ti-table"></i> Tabel
        </button>
    </div>

    <div class="flex gap-6">

        {{-- Kiri --}}
        <div class="flex-1 space-y-4">

            {{-- Card Chart/Table — identik grafik_blade --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm p-6">

                {{-- Grafik --}}
                <div id="view-grafik">
                    <div id="chart-header" class="mb-1">
                        <h2 id="chart-title" class="text-sm font-bold text-gray-800 dark:text-white">-</h2>
                        <p id="chart-subtitle" class="text-xs text-gray-400">-</p>
                    </div>
                    <div class="relative mt-4" style="height:320px">
                        <canvas id="mainChart"></canvas>
                    </div>
                </div>

                {{-- Tabel --}}
                <div id="view-tabel" class="hidden">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-sm font-semibold text-gray-700">Data Tabel</h3>
                        <button onclick="downloadTable()"
                            class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-semibold text-[#035f9c] bg-blue-50 hover:bg-blue-100 rounded-lg transition">
                            <i class="ti ti-download"></i> Download CSV
                        </button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm" id="data-table">
                            <thead id="table-head"></thead>
                            <tbody id="table-body">
                                <tr><td colspan="5" class="text-center py-8 text-gray-400">Pilih data untuk ditampilkan</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Interpretasi — identik grafik_blade --}}
            <div id="interpretasi-section" class="hidden space-y-4">

                <div id="tren-card" class="hidden flex items-center justify-between gap-4 p-5 rounded-2xl border">
                    <div class="text-center">
                        <p class="text-xs text-gray-400 mb-0.5" id="tren-tahun-awal">-</p>
                        <p class="text-2xl font-black text-gray-800 dark:text-white" id="tren-nilai-awal">-</p>
                    </div>
                    <div class="flex flex-col items-center gap-1">
                        <i id="tren-icon" class="text-3xl ti ti-minus text-gray-400"></i>
                        <span id="tren-label" class="text-xs font-bold uppercase tracking-widest text-gray-400">-</span>
                        <span id="tren-selisih" class="text-xs font-semibold text-gray-400">-</span>
                    </div>
                    <div class="text-center">
                        <p class="text-xs text-gray-400 mb-0.5" id="tren-tahun-akhir">-</p>
                        <p class="text-2xl font-black text-gray-800 dark:text-white" id="tren-nilai-akhir">-</p>
                    </div>
                </div>

                <div id="interpretasi-card" class="rounded-2xl border p-5">
                    <div class="flex items-start gap-3">
                        <div id="interpretasi-icon-wrap" class="mt-0.5 shrink-0 w-8 h-8 rounded-xl flex items-center justify-center">
                            <i id="interpretasi-icon" class="ti ti-equal text-gray-400 text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <p id="interpretasi-label" class="text-xs font-bold uppercase tracking-widest mb-2 text-gray-400">Interpretasi</p>
                            <p id="interpretasi-teks" class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">-</p>
                        </div>
                    </div>
                </div>

                <div id="interpretasi-pairs" class="space-y-3"></div>
                <div id="interpretasi-wilayah" class="rounded-2xl border p-5 hidden"></div>
                <div id="interpretasi-tabel-komponen" class="hidden space-y-3"></div>

            </div>
        </div>

        {{-- Kanan: Filter — IDENTIK grafik_blade (w-64, compact) --}}
        <div class="w-64 bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm p-5 h-fit space-y-5">

            <h3 class="text-sm font-bold text-gray-700 dark:text-white">Sesuaikan tampilan grafik</h3>

            {{-- Wilayah --}}
            <div>
                <label class="block text-sm font-semibold text-[#035f9c] mb-2">Wilayah data</label>
                <div id="filter-wilayah" class="space-y-2">
                    <p class="text-xs text-gray-400">Memuat...</p>
                </div>
            </div>

            {{-- Komponen — hanya grafik --}}
            <div id="filter-kategori-wrap">
                <label class="block text-sm font-semibold text-[#035f9c] mb-2">Komponen / Kategori</label>
                <div id="filter-kategori" class="space-y-1.5">
                    <p class="text-xs text-gray-400">Memuat...</p>
                </div>
            </div>

            {{-- Tahun --}}
            <div>
                <label class="block text-sm font-semibold text-[#035f9c] mb-2">Tahun data</label>
                <div id="filter-tahun" class="space-y-1.5">
                    <p class="text-xs text-gray-400">Pilih kategori dulu</p>
                </div>
            </div>

        </div>

    </div>
</div>
</main>
@include('partials.footer')

<script>
window.DATA_CONFIG = {
    judul:       @json($judul),
    wilayahList: @json($allWilayahs),
    components:  @json($components),
    interp: {
        kecil: @json($stat->interpretasi_lebih_kecil ?? ''),
        besar: @json($stat->interpretasi_lebih_besar ?? ''),
        tetap: @json($stat->interpretasi_tetap ?? '')
    }
};
</script>

<script src="{{ asset('js/show_data.js') }}?v={{ filemtime(public_path('js/show_data.js')) }}"></script>

</body>
</html>