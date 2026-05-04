<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $namaIndikator }} - BPS Kabupaten Kutai Timur</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #1a3a6b;
            --primary-light: #2a55a0;
            --accent: #0e7fd4;
            --accent-soft: #e8f4fd;
            --text: #1a1a2e;
            --muted: #6b7280;
            --border: #e5e9f0;
            --bg: #f8fafc;
            --white: #ffffff;
            --card-shadow: 0 2px 12px rgba(26,58,107,.08);
            --radius: 16px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            padding-top: 80px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        /* ── Breadcrumb ── */
        .breadcrumb {
            padding: 20px 40px;
            font-size: 13px;
            color: var(--muted);
        }
        .breadcrumb a { color: var(--accent); text-decoration: none; }
        .breadcrumb a:hover { text-decoration: underline; }
        .breadcrumb span { margin: 0 6px; }

        /* ── Page Header ── */
        .page-header {
            text-align: center;
            padding: 8px 40px 40px;
        }
        .page-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: clamp(26px, 4vw, 40px);
            color: var(--primary);
            margin-bottom: 10px;
        }
        .page-header p {
            color: var(--muted);
            font-size: 14px;
        }

        /* ── Filter Bar ── */
        .filter-bar {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 40px 32px;
            max-width: 1100px;
            margin: 0 auto;
        }

        .indikator-dropdown {
            position: relative;
        }
        .indikator-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
        }
        .indikator-btn i { font-size: 16px; }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,.12);
            min-width: 220px;
            z-index: 100;
            overflow: hidden;
        }
        .indikator-dropdown:hover .dropdown-menu { display: block; }

        .dropdown-menu a {
            display: block;
            padding: 12px 18px;
            font-size: 13px;
            color: var(--text);
            text-decoration: none;
            transition: background .15s;
        }
        .dropdown-menu a:hover,
        .dropdown-menu a.active { background: var(--accent-soft); color: var(--accent); font-weight: 600; }

        .search-wrap {
            flex: 1;
            position: relative;
        }
        .search-wrap i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 18px;
        }
        .search-wrap input {
            width: 100%;
            padding: 12px 16px 12px 44px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            background: var(--white);
            color: var(--text);
            outline: none;
            transition: border-color .2s;
        }
        .search-wrap input:focus { border-color: var(--accent); }
        .search-wrap input::placeholder { color: var(--muted); }

        /* ── Divider ── */
        .divider { height: 1px; background: var(--border); margin: 0 40px 24px; max-width: 1100px; margin-left: auto; margin-right: auto; }

        /* ── Data List ── */
        .data-list {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 40px;
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .data-row {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 0;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            margin-bottom: 20px;
            box-shadow: var(--card-shadow);
            transition: box-shadow .2s, transform .2s;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
        }
        .data-row:hover {
            box-shadow: 0 8px 32px rgba(26,58,107,.14);
            transform: translateY(-2px);
        }

        /* Left: mini chart panel */
        .row-chart {
            background: var(--white);
            padding: 20px;
            border-right: 1px solid var(--border);
        }
        .row-chart-title {
            font-size: 11px;
            color: var(--muted);
            margin-bottom: 8px;
            font-weight: 500;
        }
        .row-chart canvas { width: 100% !important; }

        /* Right: info panel */
        .row-info {
            padding: 28px 32px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 12px;
        }
        .row-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(16px, 2vw, 22px);
            font-weight: 700;
            color: var(--primary);
            line-height: 1.35;
        }
        .row-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--accent-soft);
            color: var(--accent);
            font-size: 12px;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 20px;
            width: fit-content;
            border: 1px solid rgba(14,127,212,.2);
        }
        .row-meta {
            font-size: 12px;
            color: var(--muted);
        }

        /* ── Empty state ── */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: var(--muted);
        }
        .empty-state i { font-size: 48px; margin-bottom: 16px; display: block; }
        .empty-state h3 { font-size: 18px; margin-bottom: 8px; color: var(--text); }

        /* ── Pagination ── */
        .pagination-wrap {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            padding: 40px 40px 60px;
        }
        .page-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1.5px solid var(--border);
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 600;
            color: var(--text);
            text-decoration: none;
            transition: all .2s;
        }
        .page-btn:hover,
        .page-btn.active {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }
        .page-btn.arrow { font-size: 18px; color: var(--muted); }
        .page-btn.arrow:hover { color: white; }

        @media (max-width: 768px) {
            .breadcrumb, .filter-bar, .data-list, .divider { padding-left: 20px; padding-right: 20px; }
            .data-row { grid-template-columns: 1fr; }
            .row-chart { border-right: none; border-bottom: 1px solid var(--border); }
        }
    </style>
</head>
<body>

@include('partials.navbar')

<!-- // <div class="max-w-7xl mx-auto px-6 py-10"> -->

{{-- Breadcrumb --}}
<div class="breadcrumb">
    <a href="/data-statistik">Data Statistik</a>
    <span>›</span>
    <strong>{{ $namaIndikator }}</strong>
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