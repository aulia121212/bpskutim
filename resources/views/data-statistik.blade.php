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
    <div class="hero-content">
        <div class="hero-tag"><i class="ti ti-chart-dots"></i> Portal Data Statistik Resmi</div>
        <h1 class="hero-title">Data Statistik<br><span>Kabupaten Kutai</span><span>Timur</span></h1>
        <p class="hero-desc">Akses berbagai data statistik resmi Kabupaten Kutai Timur yang akurat, terbaru, dan mudah dipahami untuk kebutuhan informasi, penelitian, dan perencanaan.</p>
        <div class="hero-btns">
            <a href="#data" class="btn-primary"><i class="ti ti-search"></i> Jelajahi Data</a>
            <a href="#info" class="btn-secondary">Pelajari Lebih Lanjut</a>
        </div>
    </div>
    <div class="hero-chart">
        @php
            $featured     = $statistics->first();
            $featuredData = $featured ? $featured->values->sortBy('year') : collect();
        @endphp
        <div class="hero-chart-title">
            {{ $featured->judul_data ?? 'Persentase Penduduk Miskin di Kab. Kutai Timur' }}
            {{ $featuredData->min('year') ?? '2018' }}–{{ $featuredData->max('year') ?? '2024' }}
        </div>
        <div class="hero-chart-sub">Update Terakhir: {{ $featured?->updated_at?->format('F Y') ?? 'Desember 2024' }}</div>
        <div style="height:300px"><canvas id="heroChart"></canvas></div>
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
 
{{-- ── SECTION DATA (chart cards carousel) ── --}}
<section class="data-section">
    <h2 class="section-title">Data Terbaru</h2>
    <div class="charts-wrapper">
        <div class="charts-track" id="chartsTrack">
            @forelse($statistics as $statTitle)
            @php
            
                $firstStat = $statTitle->statistics->first();
                $previewVals = $firstStat
                    ? $firstStat->values->sortBy('year')
                    : collect();
                $chartLabels = $previewVals->pluck('year')->toArray();
                $chartVals   = $previewVals->pluck('value')->toArray();
                $minYear = $previewVals->min('year');
                $maxYear = $previewVals->max('year');
            @endphp
            <a href="{{ route('data-statistik.show', $statTitle->id) }}"
               class="chart-card"
               style="text-decoration:none;color:inherit;display:block"
               data-judul="{{ strtolower($statTitle->judul_data) }}"
               data-indikator="{{ $statTitle->indikator_data }}">
                <div class="chart-card-title">{{ $statTitle->judul_data }} {{ $minYear }}–{{ $maxYear }}</div>
                <div class="chart-card-sub">
                    {{ $statTitle->statistics->count() }} wilayah
                    · Update: {{ $statTitle->updated_at?->format('M Y') }}
                </div>
                <div style="height:180px"><canvas id="chart-{{ $statTitle->id }}"></canvas></div>
                <div style="display:flex;justify-content:space-between;margin-top:16px;font-size:11px;color:var(--muted)">
                    <span>Min: {{ $previewVals->min('value') }}</span>
                    <span>Max: {{ $previewVals->max('value') }}</span>
                </div>
            </a>
            @empty
            {{-- Demo data jika belum ada data --}}
            @php
                $demoData = [
                    ['judul'=>'Persentase Penduduk Miskin','wilayah'=>'Kutai Timur','tahun'=>'2018-2024','values'=>[9.28,9.51,9.65,9.91,9.38,8.78,8.61],'labels'=>[2018,2019,2020,2021,2022,2023,2024]],
                    ['judul'=>'Tingkat Partisipasi Angkatan Kerja','wilayah'=>'Kutai Timur','tahun'=>'2019-2024','values'=>[67.2,68.1,68.5,69.2,70.1,70.8],'labels'=>[2019,2020,2021,2022,2023,2024]],
                    ['judul'=>'Indeks Pembangunan Manusia','wilayah'=>'Kutai Timur','tahun'=>'2019-2024','values'=>[71.2,71.8,72.3,72.9,73.4,74.1],'labels'=>[2019,2020,2021,2022,2023,2024]],
                    ['judul'=>'Rata-rata Lama Sekolah','wilayah'=>'Kutai Timur','tahun'=>'2019-2024','values'=>[8.2,8.4,8.5,8.7,8.9,9.1],'labels'=>[2019,2020,2021,2022,2023,2024]],
                ];
            @endphp
            @foreach($demoData as $i => $demo)
            <div class="chart-card" data-judul="{{ strtolower($demo['judul']) }}">
                <div class="chart-card-title">{{ $demo['judul'] }} {{ $demo['tahun'] }}</div>
                <div class="chart-card-sub">{{ $demo['wilayah'] }} · Update: {{ ['Des 2024','Nov 2024','Okt 2024','Sep 2024'][$i] }}</div>
                <div style="height:180px"><canvas id="demo-chart-{{ $i }}"></canvas></div>
                <div style="display:flex;justify-content:space-between;margin-top:16px;font-size:11px;color:var(--muted)">
                    <span>Min: {{ min($demo['values']) }}</span>
                    <span>Max: {{ max($demo['values']) }}</span>
                </div>
            </div>
            @endforeach
            @endforelse
        </div>
    </div>
    <div class="chart-nav">
        <button class="nav-btn" id="chartPrev"><i class="ti ti-chevron-left"></i></button>
        <div class="dots" id="chartDots"></div>
        <button class="nav-btn" id="chartNext"><i class="ti ti-chevron-right"></i></button>
    </div>
</section>

@include('partials.footer')
 
{{-- ── SCRIPT init chart cards ── --}}
{{-- Ganti juga bagian <script> initStatChart di bawah halaman --}}
<script>
@foreach($statistics as $statTitle)
@php
    $fs = $statTitle->statistics->first();
    $pv = $fs ? $fs->values->sortBy('year') : collect();
@endphp
initStatChart('chart-{{ $statTitle->id }}',
    @json($pv->pluck('year')->toArray()),
    @json($pv->pluck('value')->toArray())
);
@endforeach
 
@if($statistics->isEmpty())
@php
    $demoCharts = [
        ['labels'=>[2018,2019,2020,2021,2022,2023,2024],'values'=>[9.28,9.51,9.65,9.91,9.38,8.78,8.61]],
        ['labels'=>[2019,2020,2021,2022,2023,2024],'values'=>[67.2,68.1,68.5,69.2,70.1,70.8]],
        ['labels'=>[2019,2020,2021,2022,2023,2024],'values'=>[71.2,71.8,72.3,72.9,73.4,74.1]],
        ['labels'=>[2019,2020,2021,2022,2023,2024],'values'=>[8.2,8.4,8.5,8.7,8.9,9.1]],
    ];
@endphp
@foreach($demoCharts as $i => $d)
initStatChart('demo-chart-{{ $i }}', @json($d['labels']), @json($d['values']));
@endforeach
@endif
</script>

</body>
</html>