<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $stat->judul_data }} - BPS Kabupaten Kutai Timur</title>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400;1,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
        <span class="truncate max-w-[160px] sm:max-w-none">{{ $stat->judul_data }}</span>
    </nav>

    {{-- Tab bar --}}
    <div class="flex gap-2 mb-4">
        <button id="tab-grafik" onclick="switchTab('grafik')"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition bg-[#035f9c] text-white">
            <i class="ti ti-chart-line"></i> <span class="hidden sm:inline">Grafik</span>
        </button>
        <button id="tab-tabel" onclick="switchTab('tabel')"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition border border-gray-200 text-gray-600 hover:bg-gray-50">
            <i class="ti ti-table"></i> <span class="hidden sm:inline">Tabel</span>
        </button>
    </div>

    {{-- Layout: flex di desktop, stack di mobile --}}
    <div class="flex flex-col lg:flex-row gap-4 lg:gap-6">

        {{-- ── Konten Utama ── --}}
        <div class="flex-1 min-w-0 space-y-4">

            {{-- Card Chart/Table --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sm:p-6">

                {{-- Grafik --}}
                <div id="view-grafik">
                    <div id="chart-header" class="mb-1">
                        <h2 id="chart-title" class="text-sm font-bold text-gray-800">-</h2>
                        <p id="chart-subtitle" class="text-xs text-gray-400 mt-0.5">-</p>
                    </div>
                    {{-- Tinggi chart lebih kecil di mobile --}}
                    <div class="relative mt-4" style="height:240px" id="chart-wrapper">
                        <canvas id="mainChart"></canvas>
                    </div>
                </div>

                {{-- Tabel --}}
                <div id="view-tabel" class="hidden">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-sm font-semibold text-gray-700">Data Tabel</h3>
                        <button onclick="downloadTable()"
                            class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-semibold text-[#035f9c] bg-blue-50 hover:bg-blue-100 rounded-lg transition">
                            <i class="ti ti-download"></i> <span class="hidden sm:inline">Download CSV</span>
                        </button>
                    </div>
                    {{-- Scroll horizontal untuk tabel --}}
                    <div class="overflow-x-auto -mx-4 sm:mx-0">
                        <div class="min-w-[500px] px-4 sm:px-0">
                            <table class="w-full text-sm" id="data-table">
                                <thead id="table-head"></thead>
                                <tbody id="table-body">
                                    <tr><td colspan="5" class="text-center py-8 text-gray-400 text-sm">Pilih data untuk ditampilkan</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Interpretasi Section --}}
            <div id="interpretasi-section" class="hidden space-y-4">

                {{-- Definisi Komponen — selalu di atas --}}
                <div id="definisi-card" class="hidden"></div>

                <div id="tren-card" class="hidden flex items-center justify-between gap-3 p-4 sm:p-5 rounded-2xl border">
                    <div class="text-center">
                        <p class="text-xs text-gray-400 mb-0.5" id="tren-tahun-awal">-</p>
                        <p class="text-xl sm:text-2xl font-black text-gray-800" id="tren-nilai-awal">-</p>
                    </div>
                    <div class="flex flex-col items-center gap-1">
                        <i id="tren-icon" class="text-2xl sm:text-3xl ti ti-minus text-gray-400"></i>
                        <span id="tren-label" class="text-xs font-bold uppercase tracking-widest text-gray-400">-</span>
                        <span id="tren-selisih" class="text-xs font-semibold text-gray-400">-</span>
                    </div>
                    <div class="text-center">
                        <p class="text-xs text-gray-400 mb-0.5" id="tren-tahun-akhir">-</p>
                        <p class="text-xl sm:text-2xl font-black text-gray-800" id="tren-nilai-akhir">-</p>
                    </div>
                </div>

                <div id="interpretasi-card" class="rounded-2xl border p-4 sm:p-5">
                    <div class="flex items-start gap-3">
                        <div id="interpretasi-icon-wrap" class="mt-0.5 shrink-0 w-8 h-8 rounded-xl flex items-center justify-center">
                            <i id="interpretasi-icon" class="ti ti-equal text-gray-400 text-lg"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p id="interpretasi-label" class="text-xs font-bold uppercase tracking-widest mb-2 text-gray-400">Interpretasi</p>
                            <p id="interpretasi-teks" class="text-sm text-gray-700 leading-relaxed">-</p>
                        </div>
                    </div>
                </div>

                <div id="interpretasi-pairs" class="space-y-3"></div>
                <div id="interpretasi-wilayah" class="rounded-2xl border p-4 sm:p-5 hidden"></div>
                <div id="interpretasi-tabel-komponen" class="hidden space-y-3"></div>

            </div>
        </div>

        {{-- ── Filter Sidebar ── --}}
        {{-- Desktop: samping kanan | Mobile: di bawah konten tapi bisa toggle --}}
        <div class="w-full lg:w-64 shrink-0">

            {{-- Mobile toggle button --}}
            <button id="filter-toggle"
                class="lg:hidden w-full flex items-center justify-between px-4 py-3 mb-2 bg-white rounded-2xl border border-gray-100 shadow-sm text-sm font-semibold text-gray-700"
                onclick="document.getElementById('filter-panel').classList.toggle('hidden')">
                <span class="flex items-center gap-2"><i class="ti ti-adjustments-horizontal text-[#035f9c]"></i> Filter Data</span>
                <i class="ti ti-chevron-down text-gray-400"></i>
            </button>

            <div id="filter-panel" class="hidden lg:block bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sm:p-5 space-y-5">

                <h3 class="text-sm font-bold text-gray-700">Sesuaikan tampilan grafik</h3>

                {{-- Wilayah --}}
                <div>
                    <label class="block text-sm font-semibold text-[#035f9c] mb-2">Wilayah data</label>
                    <div id="filter-wilayah" class="space-y-2 max-h-48 overflow-y-auto pr-1">
                        <p class="text-xs text-gray-400">Memuat...</p>
                    </div>
                </div>

                {{-- Komponen --}}
                <div id="filter-kategori-wrap">
                    <label class="block text-sm font-semibold text-[#035f9c] mb-2">Komponen / Kategori</label>
                    <div id="filter-kategori" class="space-y-1.5 max-h-48 overflow-y-auto pr-1">
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

// Sesuaikan tinggi chart untuk layar besar
function adjustChartHeight() {
    const wrapper = document.getElementById('chart-wrapper');
    if (!wrapper) return;
    wrapper.style.height = window.innerWidth >= 768 ? '320px' : '220px';
}
window.addEventListener('resize', adjustChartHeight);
adjustChartHeight();
</script>

<script src="{{ asset('js/show_data.js') }}?v={{ filemtime(public_path('js/show_data.js')) }}"></script>

</body>
</html>