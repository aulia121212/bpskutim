<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $namaIndikator }} - BPS Kabupaten Kutai Timur</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <link rel="stylesheet"
        href="{{ asset('css/indikator.css') }}?v={{ filemtime(public_path('css/indikator.css')) }}">
</head>
<body>

@include('partials.navbar')

<!-- // <div class="max-w-7xl mx-auto px-6 py-10"> -->

{{-- Breadcrumb --}}
<div class="breadcrumb">
    <a href="/data-statistik">                 <i class="ti ti-database"></i>
Data Statistik</a>
    <span>›  {{ $namaIndikator }}</span>
    <!-- <<span>{{ $namaIndikator }}</span> -->
</div>

{{-- Page Header --}}
<div class="page-header">
    <h1>{{ $namaIndikator }}</h1>
    <p>Gunakan fitur pencarian atau filter kategori untuk menemukan data yang Anda butuhkan.</p>
</div>

{{-- Filter Bar --}}
<div class="filter-bar">
    {{-- Dropdown indikator --}}
    <div class="indikator-dropdown">
        <button class="indikator-btn">
            @php
                $labelShort = [
                    'indikator_ekonomi'             => 'Ekonomi',
                    'indikator_ketenagakerjaan'     => 'Kependudukan & Ketenagakerjaan',
                    'indikator_sosial'              => 'Sosial',
                    'indikator_pembangunan_manusia' => 'Pemb. Manusia',
                ];
            @endphp
            {{ $labelShort[$slug] ?? 'Pilih Indikator' }}
            <i class="ti ti-chevron-down"></i>
        </button>
        <div class="dropdown-menu">
            @foreach($indikatorMap as $s => $nama)
            <a href="{{ route('data-statistik.indikator', $s) }}" class="{{ $s === $slug ? 'active' : '' }}">
                {{ $nama }}
            </a>
            @endforeach
        </div>
    </div>

    {{-- Search --}}
    <form class="search-wrap" method="GET" action="{{ route('data-statistik.indikator', $slug) }}">
        <i class="ti ti-search"></i>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari data statistik disini...">
    </form>
</div>

<div class="divider"></div>

{{-- Data List --}}
<div class="data-list">
    @forelse($statistics as $stat)
    @php
        // {{--
        //     Struktur: Statistictitle → statistics (per wilayah) → values
        //     Untuk mini chart, ambil values dari statistic pertama (wilayah pertama)
        // --}}
        $firstStatistic = $stat->statistics->first();
        $values = $firstStatistic ? $firstStatistic->values->sortBy('year') : collect();
        $labels = $values->pluck('year')->toArray();
        $vals   = $values->pluck('value')->toArray();
        $minY   = $values->min('year');
        $maxY   = $values->max('year');

        $labelShortMap = [
            'indikator_ekonomi'             => 'Indikator Ekonomi',
            'indikator_ketenagakerjaan'     => 'Indikator Kependudukan dan Ketenagakerjaan',
            'indikator_sosial'              => 'Indikator Sosial',
            'indikator_pembangunan_manusia' => 'Indikator Pembangunan Manusia',
            'gender'                         => 'Gender',
        ];
    @endphp
    <a href="{{ route('data-statistik.show', $stat->id) }}" class="data-row">
        {{-- Mini chart --}}
        <div class="row-chart">
            <div class="row-chart-title">{{ $stat->judul_data }} {{ $minY }}–{{ $maxY }}</div>
            <div style="height:160px">
                <canvas id="rc-{{ $stat->id }}"></canvas>
            </div>
        </div>

        {{-- Info --}}
        <div class="row-info">
            <div class="row-title">{{ $stat->judul_data }} {{ $minY }}–{{ $maxY }}</div>
            <div class="row-badge">
                <i class="ti ti-tag" style="font-size:12px"></i>
                {{ $labelShortMap[$stat->indikator_data] ?? $stat->indikator_data }}
            </div>
            <div class="row-meta">
                {{ $stat->statistics->count() }} wilayah
                · Update Terakhir: {{ $stat->updated_at?->translatedFormat('F Y') ?? '-' }}
            </div>
        </div>
    </a>

    {{-- Render chart via inline script --}}
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('rc-{{ $stat->id }}');
        if (!ctx) return;
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    data: @json($vals),
                    borderColor: '#1a3a6b',
                    backgroundColor: 'rgba(26,58,107,.06)',
                    borderWidth: 2,
                    pointRadius: 3,
                    pointBackgroundColor: '#1a3a6b',
                    fill: true,
                    tension: .35
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false }, tooltip: { mode: 'index' } },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 10 }, color: '#9ca3af' } },
                    y: { grid: { color: '#f0f4f8' }, ticks: { font: { size: 10 }, color: '#9ca3af' } }
                }
            }
        });
    });
    </script>

    @empty
    <div class="empty-state">
        <i class="ti ti-database-off"></i>
        <h3>Belum ada data</h3>
        <p>Data untuk indikator ini belum tersedia. Silakan coba kategori lain.</p>
    </div>
    @endforelse
</div>

{{-- Pagination --}}
@if($statistics->hasPages())
<div class="pagination-wrap">
    {{-- Prev --}}
    @if($statistics->onFirstPage())
        <span class="page-btn arrow" style="opacity:.4"><i class="ti ti-chevron-left"></i></span>
    @else
        <a href="{{ $statistics->previousPageUrl() }}" class="page-btn arrow"><i class="ti ti-chevron-left"></i></a>
    @endif

    {{-- Pages --}}
    @foreach($statistics->getUrlRange(1, $statistics->lastPage()) as $page => $url)
        <a href="{{ $url }}" class="page-btn {{ $page == $statistics->currentPage() ? 'active' : '' }}">{{ $page }}</a>
    @endforeach

    {{-- Next --}}
    @if($statistics->hasMorePages())
        <a href="{{ $statistics->nextPageUrl() }}" class="page-btn arrow"><i class="ti ti-chevron-right"></i></a>
    @else
        <span class="page-btn arrow" style="opacity:.4"><i class="ti ti-chevron-right"></i></span>
    @endif
</div>
@endif

@include('partials.footer')

</body>
</html>