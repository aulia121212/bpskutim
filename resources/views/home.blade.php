<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BPS Kabupaten Kutai Timur</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400;1,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Nunito+Sans:ital,wght@1,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

@include('partials.navbar')

{{-- ══ HERO SLIDER (2 slides) ══════════════════════════════════ --}}
<section class="hero">
    <div class="slider-wrap">
        <div class="slider-track" id="heroTrack">

            {{-- ── Slide 1 — Data Statistik ── --}}
            <div class="slide">
                {{-- Background image blurred --}}
                
<div class="slide-img">
        <img src="{{ asset('images/bg_dataa.svg') }}" alt="Data Statistik">
    </div>

                {{-- Glass card --}}
                <div class="slide-card">
                    <span class="slide-tag">
                        <i class="ti ti-chart-dots"></i> Portal Data Resmi
                    </span>
                    <h1 class="slide-title">
                        Data<br><em>Statistik</em>
                    </h1>
                    <p class="slide-lead">Butuh data statistik untuk referensi atau analisis?</p>
                    <p class="slide-desc">
                        Jelajahi berbagai indikator dan tabel data yang dapat Anda gunakan sebagai dasar
                        informasi, penelitian, maupun perencanaan.
                    </p>
                    <a href="/data-statistik" class="btn-hero">
                        <span class="btn-icon"><i class="ti ti-search"></i></span>
                        Jelajahi Data
                    </a>
                </div>

                {{-- Image visible on right --}}
                {{-- <div class="slide-img">
                    <img src="{{ asset('images/bg_dataa.svg') }}" alt="Data Statistik">
                </div> --}}
            </div>

            {{-- ── Slide 2 — Konsultasi Statistik ── --}}
            <div class="slide">
                {{-- Background image blurred --}}
                {{-- <div class="slide-bg">
                    <img src="{{ asset('images/bg_dataa.svg') }}" alt="">
                </div> --}}

                {{-- <div class="slide-img">
                    <img src="{{ asset('images/bg_pelayanan.svg') }}" alt="Layanan Konsultasi">
                </div> --}}

                 <div class="slide-img">
        <img src="{{ asset('images/bg_pelayanan.svg') }}" alt="Layanan Konsultasi">
    </div>

                {{-- Glass card --}}
                <div class="slide-card">
                    <span class="slide-tag">
                        <i class="ti ti-headset"></i> Layanan BPS Kutai Timur
                    </span>
                    <h1 class="slide-title">
                        Layanan<br><em>Konsultasi</em> Statistik
                    </h1>
                    <p class="slide-lead">Butuh Bantuan Memahami Data Statistik?</p>
                    <p class="slide-desc">
                        Dapatkan pendampingan dari petugas untuk memahami data,
                        indikator, dan konsep statistik sesuai kebutuhan Anda.
                    </p>
                    <a href="/konsultasi" class="btn-hero">
                        <span class="btn-icon"><i class="ti ti-headset"></i></span>
                        Mulai Konsultasi
                    </a>
                </div>

                {{-- Image visible on right --}}
                {{-- <div class="slide-img">
                    <img src="{{ asset('images/bg_pelayanan.svg') }}" alt="Layanan Konsultasi">
                </div> --}}
            </div>

        </div>

        {{-- Nav arrows --}}
        <button class="slider-btn prev" id="heroPrev"><i class="ti ti-chevron-left"></i></button>
        <button class="slider-btn next" id="heroNext"><i class="ti ti-chevron-right"></i></button>
    </div>

    {{-- Dots bar --}}
    <div class="slider-dots">
        <button class="slider-prev-dot" id="dotPrev"><i class="ti ti-chevron-left"></i></button>
        <button class="dot active" data-idx="0"></button>
        <button class="dot"        data-idx="1"></button>
        <button class="slider-next-dot" id="dotNext"><i class="ti ti-chevron-right"></i></button>
    </div>
</section>

{{-- ══ PUBLIKASI ════════════════════════════════════════════════ --}}
<section class="publikasi">
    <div class="publikasi-container">
        {{-- Card di atas gambar --}}
        <div class="publikasi-card-wrapper">
            <div class="publikasi-card">
                <div class="publikasi-content">
                    <h2 class="publikasi-title">
                        <em>Publikasi</em>
                        BPS Kutai Timur
                    </h2>
                    <p class="publikasi-desc">
                        Temukan berbagai publikasi statistik resmi yang menyajikan data, analisis,
                        dan informasi terkini sebagai referensi terpercaya untuk memahami perkembangan daerah.
                    </p>
                    <a href="/publikasi" class="btn-outline">
                        <i class="ti ti-link"></i> Akses Publikasi
                    </a>
                </div>
            </div>
        </div>

        {{-- Gambar background full width --}}
        <div class="publikasi-img">
            <img src="{{ asset('images/bg_publikasi.png') }}" alt="Publikasi BPS">
        </div>
    </div>
</section>

{{-- ══ DATA TERBARU ═════════════════════════════════════════════ --}}
<section class="data-section">
    <div class="section-header">
        <h2 class="section-title">Data<br><em>Terbaru</em></h2>
        <a href="/data-statistik" class="btn-search">
            <i class="ti ti-search"></i> Jelajahi Data Sekarang
        </a>
    </div>

    <div class="charts-slider">
        <div class="charts-track" id="chartsTrack">
            @php $chartData = $statistics ?? collect(); @endphp

            @forelse($chartData as $stat)
            <div class="chart-card">
                <div class="chart-card-title">{{ $stat->judul_data }}</div>
                <div class="chart-card-sub">{{ $stat->wilayah_data }} · Update: {{ $stat->updated_at?->format('M Y') }}</div>
                <div style="height:180px"><canvas id="chart-{{ $stat->id }}"></canvas></div>
            </div>
            @empty
            @for($i = 0; $i < 3; $i++)
            <div class="chart-card">
                <div class="chart-card-title">Persentase Penduduk Miskin di Kab. Kutai Timur 2018–2024</div>
                <div class="chart-card-sub">Kutai Timur · Update: Des 2024</div>
                <div style="height:180px"><canvas id="demo-chart-{{ $i }}"></canvas></div>
            </div>
            @endfor
            @endforelse
        </div>
    </div>

    <div class="chart-nav">
        <button class="nav-btn" id="chartPrev"><i class="ti ti-chevron-left"></i></button>
        <div class="dots" id="chartDots"></div>
        <button class="nav-btn" id="chartNext"><i class="ti ti-chevron-right"></i></button>
    </div>
</section>

{{-- ══ POPUP BANNER ════════════════════════════════════════════ --}}
@php $activeBanner = isset($popups) ? $popups->first() : null; @endphp
<div class="popup-banner">
    <div class="popup-banner-content">
        <h2>Tidak menemukan<br><span>data yang dicari?</span></h2>
        <a href="/konsultasi" class="btn-konsultasi">
            <i class="ti ti-message-circle"></i> Hubungi Layanan Konsultasi
        </a>
    </div>
    <div class="popup-banner-img">
        @if($activeBanner)
            <img src="{{ asset($activeBanner->foto) }}" alt="Konsultasi">
        @else
            <div style="width:300px;height:220px;background:linear-gradient(135deg,#bfdbfe,#93c5fd);border-radius:20px;display:flex;align-items:center;justify-content:center">
                <i class="ti ti-users" style="font-size:80px;color:#1a56db;opacity:.5"></i>
            </div>
        @endif
    </div>
</div>

@include('partials.footer')

<script>
window.homeCharts = [
    @foreach($chartData ?? [] as $stat)
    {
        id:     'chart-{{ $stat->id }}',
        labels: {!! json_encode($stat->values->sortBy('year')->pluck('year')) !!},
        values: {!! json_encode($stat->values->sortBy('year')->pluck('value')) !!},
    },
    @endforeach
];
</script>
<script src="{{ asset('js/home.js') }}"></script>

</body>
</html>