<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $stat->judul_data }} - BPS Kabupaten Kutai Timur</title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400;1,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Nunito+Sans:ital,wght@1,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- Tailwind — dibutuhkan agar komponen interpretasi sama persis dengan grafik_blade --}}
    <script>
        tailwind.config = { corePlugins: { preflight: false } }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('css/show_data.css') }}?v={{ filemtime(public_path('css/show_data.css')) }}">
</head>
<body>

@include('partials.navbar')

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

    {{-- Tab bar --}}
    <div class="show-tabbar">
        <div class="show-tabs">
            <button id="tab-grafik" onclick="switchTab('grafik')" class="show-tab active">
                <i class="ti ti-chart-line"></i> Grafik
            </button>
            <button id="tab-tabel" onclick="switchTab('tabel')" class="show-tab">
                <i class="ti ti-table"></i> Tabel
            </button>
        </div>
        <button onclick="scrollToInterpretasi()" class="show-interp-btn">
            <i class="ti ti-lightbulb"></i> Interpretasi
        </button>
    </div>

    <div style="display:flex;gap:24px">

        {{-- Kiri --}}
        <div style="flex:1;min-width:0;display:flex;flex-direction:column;gap:16px">

            {{-- Card grafik/tabel — struktur IDENTIK dengan grafik_blade --}}
            <div class="show-card" style="padding:24px">

                {{-- Grafik --}}
                <div id="view-grafik">
                    <div id="chart-header" style="margin-bottom:4px">
                        <h2 id="chart-title" style="font-size:14px;font-weight:700;color:#1e293b">-</h2>
                        <p id="chart-subtitle" style="font-size:12px;color:#64748b">-</p>
                    </div>
                    <div style="position:relative;margin-top:16px;height:320px">
                        <canvas id="mainChart"></canvas>
                    </div>
                </div>

                {{-- Tabel --}}
                <div id="view-tabel" class="hidden">
                    <div class="show-table-top">
                        <h3 class="table-title">Data Tabel</h3>
                        <div class="table-actions">
                            <button onclick="downloadTable()" class="dl-btn primary">
                                <i class="ti ti-download"></i> Download CSV
                            </button>
                        </div>
                    </div>
                    <div class="show-table-wrap">
                        <table id="data-table" class="data-table">
                            <thead id="table-head"></thead>
                            <tbody id="table-body">
                                <tr><td colspan="5" class="table-empty">Pilih data untuk ditampilkan</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Interpretasi — ID IDENTIK dengan grafik_blade --}}
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

        {{-- Kanan: Filter sidebar --}}
        <div class="show-sidebar">
            <div class="sidebar-header">
                <h3 class="sidebar-title">
                    <i class="ti ti-adjustments-horizontal"></i> Filter Data
                </h3>
            </div>

            <div class="filter-group">
                <label class="filter-label"><i class="ti ti-map-pin"></i> Wilayah data</label>
                <div id="filter-wilayah" class="filter-options">
                    <p class="filter-empty">Memuat...</p>
                </div>
            </div>

            <div id="filter-kategori-wrap" class="filter-group">
                <label class="filter-label"><i class="ti ti-list-details"></i> Komponen / Kategori</label>
                <div id="filter-kategori" class="filter-options">
                    <p class="filter-empty">Memuat...</p>
                </div>
            </div>

            <div class="filter-group">
                <label class="filter-label"><i class="ti ti-calendar"></i> Tahun data</label>
                <div id="filter-tahun" class="filter-options">
                    <p class="filter-empty">Pilih kategori dulu</p>
                </div>
            </div>

            <div class="sidebar-actions">
                <button onclick="resetFilters()" class="btn-reset">
                    <i class="ti ti-refresh"></i> Reset
                </button>
                <button onclick="applyFilters()" class="btn-apply">
                    <i class="ti ti-play"></i> Update Tampilan
                    <div class="btn-pulse"></div>
                </button>
            </div>
        </div>

    </div>
</div>

@include('partials.footer')

{{-- ── Inject data dari controller — TIDAK ada PHP logic di sini ── --}}
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