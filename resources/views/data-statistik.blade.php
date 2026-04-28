<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Statistik - BPS Kabupaten Kutai Timur</title>
    <meta name="description" content="Portal data statistik resmi Kabupaten Kutai Timur.">
   <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Nunito+Sans:ital,wght@1,800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<link rel="stylesheet" href="{{ asset('css/data-statistik.css') }}?v={{ filemtime(public_path('css/data-statistik.css')) }}">    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

@include('partials.navbar')

<section class="hero">

    <!-- <div class="flex gap-10 items-center"> -->

        <!-- LEFT: HERO TEXT -->
        <div class="hero-content">
            <div class="hero-tag">
                <i class="ti ti-chart-dots"></i> Portal Data Statistik Resmi
            </div>

            <h1 class="hero-title">
                Data Statistik<br>
                <span>Kabupaten Kutai Timur</span>
            </h1>

            <p class="hero-desc">
                Akses berbagai data statistik resmi Kabupaten Kutai Timur yang akurat, terbaru, dan mudah dipahami untuk kebutuhan informasi, penelitian, dan perencanaan.
            </p>

            <div class="hero-btns">
                <a href="#data" class="btn-primary">
                    <i class="ti ti-search"></i> Jelajahi Data
                </a>
                <a href="#info" class="btn-secondary">
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>

        <!-- RIGHT SIDE -->
    <div class="hero-chart">

            

            <!-- CARD -->
            @if($kutim)
            <!-- <div class="chart-card !min-w-full !scale-100 !opacity-100"> -->

                <div class="chart-card-header">
                    <div>
                        <div class="chart-card-title">
                            {{ $kutim['judul'] }}
                        </div>

                        <div class="chart-card-period-title">
                            {{ $kutim['periode'] ?? '' }}
                        </div>
                    </div>

                    <span class="chart-card-badge">
                        <i class="ti ti-chart-dots-3"></i>
                        {{ $kutim['komponen'] ?? '' }}
                    </span>
                </div>

                <div class="chart-canvas-wrap">
                    <canvas id="chart-kutim"></canvas>
                </div>

            <!-- </div> -->
            @endif

        </div>

    </div>

</section>

<section class="search-section" id="data">
    <div class="search-bar">
        <i class="ti ti-search"></i>
        <input type="text" id="searchInput" placeholder="Cari data disini..." oninput="filterData()">
        <i class="ti ti-filter" style="cursor:pointer" onclick="toggleFilter()"></i>
    </div>
</section>

{{-- ── SECTION CATEGORIES ── --}}
<section class="categories">
    <p class="cat-hint">Silakan pilih salah satu dari lima kategori indikator berikut untuk mulai menjelajahi data</p>
    <div class="cat-grid">
        <a href="{{ route('data-statistik.indikator', 'indikator_ekonomi') }}" class="cat-card {{ request()->routeIs('data-statistik.indikator') && request()->route('slug') === 'indikator_ekonomi' ? 'active' : '' }}">
            <div class="cat-icon" style="background:#fef3c7">💰</div>
            <div class="cat-name">Indikator Ekonomi</div>
        </a>
        <a href="{{ route('data-statistik.indikator', 'indikator_ketenagakerjaan') }}" class="cat-card">
            <div class="cat-icon" style="background:#fce7f3">👷</div>
            <div class="cat-name">Indikator Ketenagakerjaan</div>
        </a>
        <a href="{{ route('data-statistik.indikator', 'indikator_sosial') }}" class="cat-card">
            <div class="cat-icon" style="background:#d1fae5">👥</div>
            <div class="cat-name">Indikator Sosial</div>
        </a>
        <a href="{{ route('data-statistik.indikator', 'indikator_pembangunan_manusia') }}" class="cat-card">
            <div class="cat-icon" style="background:#e0f2fe">📊</div>
            <div class="cat-name">Indikator Pembangunan Manusia</div>
        </a>
        <a href="{{ route('data-statistik.indikator', 'gender') }}" class="cat-card">
            <div class="cat-icon" style="background:#f0f9ff">👩‍💼</div>
            <div class="cat-name">Gender</div>
        </a>

    </div>
</section>
 
<section class="data-section">

        <!-- <div class="pub-badge">Data</div> -->

    <div class="section-header">

    
        <h2>
            <span class="title-main">Data Statistik</span><br>
            <em class="title-accent">Terbaru</em>
        </h2>
        <a href="/data-statistik" class="btn-search">
            <i class="ti ti-search"></i> Jelajahi Data Sekarang
        </a>
    </div>
 
    <div class="charts-viewport">
        <div class="charts-slider">
            <div class="charts-track" id="chartsTrack">
 
                @forelse($statistics as $stat)
                <div class="chart-card" data-id="{{ $stat['id'] }}">
 
                    {{-- Judul indikator --}}
                    <div class="chart-card-title" title="{{ $stat['judul'] }}">
                        {{ $stat['judul'] }}
                    </div>

                     @if(!empty($stat['periode']))
    <div class="chart-card-period-title">
        {{ $stat['periode'] }}
    </div>
    @endif
 
                    {{-- Meta row: update + periode badge --}}
                    <div class="chart-card-meta">
                        <span class="chart-card-sub">
                            <i class="ti ti-clock"></i>
                            Update: {{ \Carbon\Carbon::parse($stat['updated'])->isoFormat('MMM Y') }}
                        </span>
                        @if(!empty($stat['periode']))
                        <span class="chart-card-badge">
                            <i class="ti ti-calendar-stats"></i>
    {{ $stat['komponen']  }}
                        </span>
                        @endif
                    </div>
 
                    {{-- Legend warna per wilayah (diisi JS) --}}
                    <div class="chart-legend" id="legend-{{ $stat['id'] }}"></div>
 
                    {{-- Canvas chart --}}
                    <div class="chart-canvas-wrap">
                        <canvas id="chart-{{ $stat['id'] }}"></canvas>
                    </div>
 
                </div>
                @empty
                <p style="padding:60px;color:#9ca3af;text-align:center">
                    Belum ada data statistik yang dipublikasikan.
                </p>
                @endforelse
 
            </div>{{-- /charts-track --}}
        </div>{{-- /charts-slider --}}
    </div>{{-- /charts-viewport --}}
 
    <div class="chart-nav">
        <button class="nav-btn" id="chartPrev"><i class="ti ti-chevron-left"></i></button>
        <div class="dots" id="chartDots"></div>
        <button class="nav-btn" id="chartNext"><i class="ti ti-chevron-right"></i></button>
    </div>
</section>

@include('partials.footer')
 


<script>
window.homeCharts = [
    @foreach ($statistics as $stat)
    {
        id       : "{{ $stat['id'] }}",
        judul    : @json($stat['judul']),
        wilayah  : @json($stat['wilayah']),
        periode  : @json($stat['periode']  ?? ''),
        komponen : @json($stat['komponen'] ?? ''),
        y_labels : @json($stat['labels']   ?? []),   {{-- labels = array tahun --}}
        labels   : @json($stat['labels']   ?? []),
        values   : @json($stat['values']   ?? []),
    },
    @endforeach
];
</script>
 
{{-- 3. Init hero chart kutim ────────────────────────────────── --}}
@if($kutim)
<script>
(function () {
    const labels = @json($kutim['labels'] ?? []);
    const values = @json($kutim['values'] ?? []);
 
    if (!labels.length || !values.length) return;
 
    // Tunggu DOM siap (data-statistik.js mungkin belum eksekusi DOMContentLoaded)
    function drawKutim() {
        const el = document.getElementById('chart-kutim');
        if (!el) return;
 
        // Destroy jika sudah ada instance sebelumnya
        const existing = Chart.getChart(el);
        if (existing) existing.destroy();
 
        new Chart(el.getContext('2d'), {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    data             : values,
                    borderColor      : '#1a56db',
                    backgroundColor  : 'rgba(26,86,219,0.07)',
                    borderWidth      : 2.5,
                    pointBackgroundColor: '#1a56db',
                    pointBorderColor : '#fff',
                    pointBorderWidth : 2,
                    pointRadius      : 5,
                    pointHoverRadius : 7,
                    fill             : true,
                    tension          : 0.35,
                }],
            },
            options: {
                responsive          : true,
                maintainAspectRatio : false,
                plugins: {
                    legend : { display: false },
                    tooltip: {
                        callbacks: {
                            label: (c) => ' ' + Number(c.parsed.y).toLocaleString('id-ID'),
                        },
                    },
                },
                scales: {
                    x: {
                        title: { display: true, text: 'Tahun', color: '#94a3b8', font: { size: 11 } },
                        ticks: { font: { size: 11 }, color: '#94a3b8', maxRotation: 0 },
                        grid : { display: false },
                    },
                    y: {
                        title: { display: true, text: 'Nilai', color: '#94a3b8', font: { size: 11 } },
                        ticks: {
                            font         : { size: 10 },
                            color        : '#94a3b8',
                            maxTicksLimit: 5,
                            callback     : (v) => Number(v).toLocaleString('id-ID'),
                        },
                        grid: { color: 'rgba(0,0,0,.04)' },
                    },
                },
            },
        });
    }
 
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', drawKutim);
    } else {
        drawKutim();
    }
})();
</script>
@endif
<script src="{{ asset('js/data-statistik.js') }}"></script>
<script src="{{ asset('js/home.js') }}"></script>


</body>
</html>