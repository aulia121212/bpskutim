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

<section class="categories">
    <p class="cat-hint">Silakan pilih salah satu dari empat kategori indikator berikut untuk mulai menjelajahi data</p>
    <div class="cat-grid">
        <a href="{{ route('data-statistik.indikator', 'indikator_ekonomi') }}" class="cat-card {{ request('indikator') === 'indikator_ekonomi' ? 'active' : '' }}">
            <div class="cat-icon" style="background:#fef3c7">💰</div>
            <div class="cat-name">Indikator Ekonomi</div>
        </a>
        <a href="{{ route('data-statistik.indikator', 'indikator_ketenagakerjaan') }}" class="cat-card {{ request('indikator') === 'indikator_ketenagakerjaan' ? 'active' : '' }}">
            <div class="cat-icon" style="background:#fce7f3">👷</div>
            <div class="cat-name">Indikator Ketenagakerjaan</div>
        </a>
        <a href="{{ route('data-statistik.indikator', 'indikator_sosial') }}" class="cat-card {{ request('indikator') === 'indikator_sosial' ? 'active' : '' }}">
            <div class="cat-icon" style="background:#d1fae5">👥</div>
            <div class="cat-name">Indikator Sosial</div>
        </a>
        <a href="{{ route('data-statistik.indikator', 'indikator_pembangunan_manusia') }}" class="cat-card {{ request('indikator') === 'indikator_pembangunan_manusia' ? 'active' : '' }}">
            <div class="cat-icon" style="background:#e0f2fe">📊</div>
            <div class="cat-name">Indikator Pembangunan Manusia</div>
        </a>
    </div>
</section>

<section class="data-section">
    <h2 class="section-title">Data Terbaru</h2>
    <div class="charts-wrapper">
        <div class="charts-track" id="chartsTrack">
            @forelse($statistics as $stat)
            <div class="chart-card" data-judul="{{ strtolower($stat->judul_data) }}" data-indikator="{{ $stat->indikator_data }}">
                <div class="chart-card-title">{{ $stat->judul_data }} {{ $stat->values->min('year') }}–{{ $stat->values->max('year') }}</div>
                <div class="chart-card-sub">{{ $stat->wilayah_data }} · Update: {{ $stat->updated_at?->format('M Y') }}</div>
                <div style="height:180px"><canvas id="chart-{{ $stat->id }}"></canvas></div>
                <div style="display:flex;justify-content:space-between;margin-top:16px;font-size:11px;color:var(--muted)">
                    <span>Min: {{ $stat->values->min('value') }}</span>
                    <span>Max: {{ $stat->values->max('value') }}</span>
                </div>
            </div>
            @empty
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

<section class="info-section" id="info">
    <h2 class="info-title">Informasi Layanan Data Statistik</h2>
    <p class="info-sub">Pelajari lebih lanjut tentang layanan data statistik BPS Kabupaten Kutai Timur,<br>mulai dari jenis data yang tersedia, sumber data, hingga cara menggunakannya.</p>
    <div class="info-grid">
        <div class="info-card"><div style="font-size:32px;margin-bottom:16px">📊</div><h3>Jenis Data</h3><p>Beragam data tersedia seperti indikator ekonomi, ketenagakerjaan, sosial, dan pembangunan manusia.</p></div>
        <div class="info-card"><div style="font-size:32px;margin-bottom:16px">📚</div><h3>Sumber Data</h3><p>Data berasal dari publikasi resmi, survei, dan kegiatan statistik BPS sehingga dapat digunakan sebagai rujukan terpercaya.</p></div>
        <div class="info-card"><div style="font-size:32px;margin-bottom:16px">📱</div><h3>Cara Menggunakan</h3><p>Cari data melalui fitur pencarian atau kategori, lihat dalam bentuk grafik atau tabel, lalu unduh sesuai kebutuhan.</p></div>
        <div class="info-card highlight">
            <div class="info-card-header">
                <div style="display:flex;align-items:center;gap:16px">
                    <div style="font-size:40px">💬</div>
                    <div><h3 style="margin-bottom:4px">Bantuan</h3><p style="margin-bottom:0">Bingung memahami data? Gunakan fitur Layanan Konsultasi untuk mendapatkan bantuan dari petugas.</p></div>
                </div>
                <a href="/konsultasi" class="btn-primary" style="font-size:14px;padding:12px 24px"><i class="ti ti-headset"></i> Mulai Konsultasi</a>
            </div>
        </div>
    </div>
</section>

@include('partials.footer')

{{-- JS --}}
<script src="{{ asset('js/data-statistik.js') }}?v={{ filemtime(public_path('js/data-statistik.js')) }}"></script><script>
@php
    $heroStat   = $statistics->first();
    $heroLabels = $heroStat ? $heroStat->values->sortBy('year')->pluck('year') : [2018,2019,2020,2021,2022,2023,2024];
    $heroValues = $heroStat ? $heroStat->values->sortBy('year')->pluck('value') : [9.28,9.51,9.65,9.91,9.38,8.78,8.61];
@endphp
initHeroChart(@json($heroLabels), @json($heroValues));

@foreach($statistics as $stat)
initStatChart('chart-{{ $stat->id }}', {!! json_encode($stat->values->sortBy('year')->pluck('year')) !!}, {!! json_encode($stat->values->sortBy('year')->pluck('value')) !!});
@endforeach

@if($statistics->isEmpty())
@php $demoCharts = [['labels'=>[2018,2019,2020,2021,2022,2023,2024],'values'=>[9.28,9.51,9.65,9.91,9.38,8.78,8.61]],['labels'=>[2019,2020,2021,2022,2023,2024],'values'=>[67.2,68.1,68.5,69.2,70.1,70.8]],['labels'=>[2019,2020,2021,2022,2023,2024],'values'=>[71.2,71.8,72.3,72.9,73.4,74.1]],['labels'=>[2019,2020,2021,2022,2023,2024],'values'=>[8.2,8.4,8.5,8.7,8.9,9.1]]]; @endphp
@foreach($demoCharts as $i => $d)
initStatChart('demo-chart-{{ $i }}', @json($d['labels']), @json($d['values']));
@endforeach
@endif
</script>

</body>
</html>