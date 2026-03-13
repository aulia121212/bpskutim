<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Statistik - BPS Kabupaten Kutai Timur</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <!-- SEO Meta Tags (pindah ke head) -->
    <meta name="description" content="Portal data statistik resmi Kabupaten Kutai Timur. Akses data ekonomi, ketenagakerjaan, sosial, dan pembangunan manusia yang akurat dan terbaru.">
    <meta name="keywords" content="statistik, kutai timur, data ekonomi, data sosial, BPS, indikator pembangunan">
    <meta property="og:title" content="Data Statistik Kabupaten Kutai Timur">
    <meta property="og:description" content="Portal data statistik resmi Kabupaten Kutai Timur">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
    :root {
        --blue: #1a56db;
        --blue-dark: #1341b0;
        --blue-light: #e8f0fe;
        --blue-soft: #f0f5ff;
        --text: #1e293b;
        --muted: #64748b;
        --border: #e2e8f0;
        --bg: #f8fafc;
        --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        --hover-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }
    
    * { 
        margin: 0; 
        padding: 0; 
        box-sizing: border-box; 
    }
    
    body { 
        font-family: 'Plus Jakarta Sans', sans-serif; 
        color: var(--text); 
        background: #fff;
        line-height: 1.5;
    }
    
    /* Gunakan Playfair Display untuk heading */
    h1, h2, h3, h4, h5, h6,
    .hero-title,
    .section-title,
    .info-title,
    .chart-card-title,
    .cat-name {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
    }
    
    /* Khusus untuk hero title dengan efek */
    .hero-title {
        font-size: 64px; 
        font-weight: 800; 
        line-height: 1.1;
        margin-bottom: 20px; 
        letter-spacing: -2px;
    }
    
    .hero-title span { 
        color: var(--blue); 
        display: block; 
        font-size: 56px;
        font-weight: 700;
        font-style: italic; /* Memberi sentuhan italic pada span */
    }
    
    .section-title { 
        text-align: center; 
        font-size: 40px; 
        font-weight: 800; 
        margin-bottom: 40px; 
        letter-spacing: -1px;
    }
    
    .info-title { 
        text-align: center; 
        font-size: 36px; 
        font-weight: 800; 
        margin-bottom: 8px; 
        letter-spacing: -1px;
    }
    
    .chart-card-title { 
        font-size: 14px; 
        font-weight: 700; 
        color: var(--text); 
        margin-bottom: 4px; 
        font-family: 'Playfair Display', serif;
    }
    
    .cat-name { 
        font-size: 15px; 
        font-weight: 600; 
        color: var(--text); 
        font-family: 'Playfair Display', serif;
    }
    
    .info-card h3 { 
        font-size: 18px; 
        font-weight: 700; 
        color: var(--blue); 
        margin-bottom: 12px; 
        font-family: 'Playfair Display', serif;
    }
    
    .footer-col h4 { 
        font-size: 15px; 
        font-weight: 700; 
        margin-bottom: 20px; 
        font-family: 'Playfair Display', serif;
    }
    
    /* NAVBAR - tetap pakai Plus Jakarta Sans */
nav {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    z-index: 9999 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    padding: 0 48px !important;
    height: 72px !important;
    background-color: #FFFFFF !important; /* PUTIH SOLID */
    border-bottom: 1px solid #e2e8f0 !important;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05) !important;
    backdrop-filter: none !important; /* HAPUS efek blur */
    -webkit-backdrop-filter: none !important;
}

/* Pastikan semua elemen di dalam navbar tidak transparan */
nav * {
    background-color: transparent !important;
}

.nav-logo {
    display: flex !important;
    align-items: center !important;
    gap: 12px !important;
    text-decoration: none !important;
}

.nav-logo div:first-of-type {
    font-family: 'Playfair Display', serif !important;
    font-size: 14px !important;
    font-weight: 800 !important;
    color: #1e293b !important;
    line-height: 1.2 !important;
}

.nav-logo div:last-of-type {
    font-size: 11px !important;
    color: #64748b !important;
}

.nav-links {
    display: flex !important;
    align-items: center !important;
    gap: 40px !important;
}

.nav-links a {
    text-decoration: none !important;
    color: #64748b !important;
    font-size: 14px !important;
    font-weight: 600 !important;
    transition: color 0.2s !important;
    letter-spacing: 0.3px !important;
    font-family: 'Plus Jakarta Sans', sans-serif !important;
}

.nav-links a:hover {
    color: #1a56db !important;
}

.nav-links a.active {
    color: #1a56db !important;
}

.btn-nav {
    background: #1a56db !important;
    color: #ffffff !important;
    border: none !important;
    border-radius: 10px !important;
    padding: 10px 24px !important;
    font-size: 14px !important;
    font-weight: 600 !important;
    cursor: pointer !important;
    text-decoration: none !important;
    transition: background 0.2s !important;
}

.btn-nav:hover {
    background: #1341b0 !important;
    color: #ffffff !important;
}

    /* HERO */
    .hero {
        margin-top: 72px; 
        padding: 60px 80px 80px;
        background: linear-gradient(145deg, #d9e8ff 0%, #e8f0fe 40%, #f2f7ff 80%);
        display: flex; 
        align-items: center; 
        gap: 60px; 
        min-height: 580px;
        position: relative; 
        overflow: hidden;
    }
    
    .hero::before {
        content: ''; 
        position: absolute; 
        left: -200px; 
        top: -200px;
        width: 700px; 
        height: 700px; 
        border-radius: 50%;
        background: radial-gradient(circle, rgba(26,86,219,0.08) 0%, transparent 60%);
        pointer-events: none;
    }
    
    .hero::after {
        content: ''; 
        position: absolute; 
        right: 150px; 
        bottom: -150px;
        width: 500px; 
        height: 500px; 
        border-radius: 50%;
        background: radial-gradient(circle, rgba(26,86,219,0.06) 0%, transparent 70%);
        pointer-events: none;
    }
    
    .hero-content { 
        flex: 1; 
        z-index: 2; 
    }
    
    .hero-tag {
        display: inline-flex; 
        align-items: center; 
        gap: 8px;
        background: rgba(255,255,255,0.9); 
        border: 1px solid rgba(255,255,255,0.95);
        border-radius: 40px; 
        padding: 8px 20px;
        font-size: 13px; 
        font-weight: 600; 
        color: var(--blue);
        margin-bottom: 28px; 
        backdrop-filter: blur(8px);
        box-shadow: 0 2px 10px rgba(0,0,0,.03);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    
    .hero-desc { 
        font-size: 16px; 
        color: #475569; 
        line-height: 1.7; 
        max-width: 440px; 
        margin-bottom: 36px; 
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    
    .hero-btns { 
        display: flex; 
        gap: 16px; 
        align-items: center; 
    }
    
    .btn-primary {
        display: inline-flex; 
        align-items: center; 
        gap: 8px;
        background: var(--blue); 
        color: #fff; 
        text-decoration: none;
        padding: 14px 32px; 
        border-radius: 14px; 
        font-weight: 700; 
        font-size: 15px;
        transition: all .2s; 
        box-shadow: 0 8px 24px rgba(26,86,219,.3);
        border: none;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    
    .btn-primary:hover { 
        background: var(--blue-dark); 
        transform: translateY(-2px); 
        box-shadow: 0 12px 28px rgba(26,86,219,.4); 
    }
    
    .btn-secondary {
        display: inline-flex; 
        align-items: center; 
        gap: 8px;
        background: rgba(255,255,255,0.9); 
        color: var(--text); 
        text-decoration: none;
        padding: 14px 28px; 
        border-radius: 14px; 
        font-weight: 600; 
        font-size: 15px;
        border: 1px solid rgba(255,255,255,0.95); 
        transition: all .2s;
        backdrop-filter: blur(8px); 
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    
    .btn-secondary:hover { 
        border-color: var(--blue); 
        color: var(--blue); 
        background: #fff; 
        transform: translateY(-2px);
    }
    
    .hero-chart {
        width: 460px; 
        flex-shrink: 0; 
        background: #fff; 
        border-radius: 28px;
        border: 1px solid rgba(200,220,250,0.5); 
        padding: 28px;
        box-shadow: 0 20px 40px rgba(26,86,219,.12); 
        z-index: 2;
    }
    
    .hero-chart-title { 
        font-size: 15px; 
        font-weight: 700; 
        color: var(--text); 
        margin-bottom: 4px; 
        font-family: 'Playfair Display', serif;
    }
    
    .hero-chart-sub { 
        font-size: 12px; 
        color: var(--muted); 
        margin-bottom: 20px; 
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* SEARCH */
    .search-section { 
        padding: 32px 80px 0; 
    }
    
    .search-bar {
        display: flex; 
        align-items: center; 
        gap: 12px;
        background: #fff; 
        border: 1.5px solid var(--border); 
        border-radius: 20px;
        padding: 14px 24px; 
        box-shadow: 0 4px 16px rgba(0,0,0,.04); 
        transition: border-color .2s;
        max-width: 800px;
        margin: 0 auto;
    }
    
    .search-bar:focus-within { 
        border-color: var(--blue); 
        box-shadow: 0 4px 20px rgba(26,86,219,.1);
    }
    
    .search-bar input { 
        flex: 1; 
        border: none; 
        outline: none; 
        font-size: 15px; 
        font-family: 'Plus Jakarta Sans', sans-serif; 
        color: var(--text); 
        background: transparent;
    }
    
    .search-bar input::placeholder { 
        color: #94a3b8; 
    }
    
    .search-bar i { 
        font-size: 22px; 
        color: var(--muted); 
    }

    /* CATEGORIES */
    .categories { 
        padding: 40px 80px; 
    }
    
    .cat-hint { 
        text-align: center; 
        font-size: 15px; 
        color: var(--muted); 
        margin-bottom: 28px; 
        font-weight: 500;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    
    .cat-grid { 
        display: grid; 
        grid-template-columns: repeat(4, 1fr); 
        gap: 20px; 
        max-width: 1000px;
        margin: 0 auto;
    }
    
    .cat-card {
        background: #fff; 
        border: 1.5px solid var(--border); 
        border-radius: 24px;
        padding: 32px 20px; 
        text-align: center; 
        cursor: pointer;
        transition: all .2s; 
        text-decoration: none; 
        color: var(--text);
    }
    
    .cat-card:hover, 
    .cat-card.active { 
        border-color: var(--blue); 
        background: var(--blue-soft); 
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(26,86,219,.15);
    }
    
    .cat-icon {
        width: 72px; 
        height: 72px; 
        border-radius: 20px; 
        background: var(--bg);
        display: flex; 
        align-items: center; 
        justify-content: center;
        margin: 0 auto 16px; 
        font-size: 32px;
        transition: all .2s;
    }
    
    .cat-card:hover .cat-icon, 
    .cat-card.active .cat-icon { 
        background: #fff; 
        transform: scale(1.05);
    }

    /* DATA TERBARU */
    .data-section { 
        padding: 60px 80px; 
        background: var(--bg); 
    }
    
    .chart-card-sub { 
        font-size: 11px; 
        color: var(--muted); 
        margin-bottom: 16px; 
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    
    .chart-nav { 
        display: flex; 
        justify-content: center; 
        align-items: center; 
        gap: 20px; 
        margin-top: 36px; 
    }
    
    .nav-btn {
        width: 44px; 
        height: 44px; 
        border-radius: 50%; 
        background: #fff;
        border: 1.5px solid var(--border); 
        cursor: pointer; 
        display: flex; 
        align-items: center; 
        justify-content: center;
        transition: all .2s; 
        font-size: 18px;
    }
    
    .nav-btn:hover { 
        background: var(--blue); 
        color: #fff; 
        border-color: var(--blue); 
        transform: scale(1.05);
    }
    
    .dots { 
        display: flex; 
        gap: 8px; 
    }
    
    .dot { 
        width: 10px; 
        height: 10px; 
        border-radius: 50%; 
        background: var(--border); 
        border: none; 
        cursor: pointer; 
        transition: all .2s; 
        padding: 0;
    }
    
    .dot.active { 
        background: var(--blue); 
        width: 28px; 
        border-radius: 20px; 
    }

    /* INFO CARDS */
    .info-section { 
        padding: 60px 80px 80px; 
    }
    
    .info-sub { 
        text-align: center; 
        font-size: 15px; 
        color: var(--muted); 
        margin-bottom: 48px; 
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    
    .info-grid { 
        display: grid; 
        grid-template-columns: 1fr 1fr; 
        gap: 24px; 
        max-width: 1000px;
        margin: 0 auto;
    }
    
    .info-card {
        background: #fff; 
        border: 1.5px solid var(--border); 
        border-radius: 24px;
        padding: 32px; 
        transition: all .2s;
    }
    
    .info-card:hover { 
        border-color: var(--blue); 
        box-shadow: 0 8px 28px rgba(26,86,219,.12); 
        transform: translateY(-2px);
    }
    
    .info-card p { 
        font-size: 14px; 
        color: var(--muted); 
        line-height: 1.7; 
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    
    .info-card.highlight { 
        background: var(--blue-soft); 
        border-color: var(--blue); 
        grid-column: span 2;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .info-card-header { 
        display: flex; 
        justify-content: space-between; 
        align-items: center; 
        gap: 20px;
    }

    /* FOOTER */
    footer { 
        background: #fff; 
        border-top: 1px solid var(--border); 
        padding: 48px 80px 32px; 
    }
    
    .footer-grid { 
        display: grid; 
        grid-template-columns: 1.5fr 1fr 1.5fr; 
        gap: 48px; 
        margin-bottom: 40px; 
    }
    
    .footer-col a { 
        display: block; 
        font-size: 13px; 
        color: var(--muted); 
        text-decoration: none; 
        margin-bottom: 10px; 
        transition: color .2s; 
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    
    .footer-col a:hover { 
        color: var(--blue); 
    }
    
    .footer-info { 
        font-size: 13px; 
        color: var(--muted); 
        line-height: 1.8; 
        margin-top: 12px; 
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    
    .social-links { 
        display: flex; 
        gap: 12px; 
        margin-top: 20px; 
    }
    
    .social-link {
        width: 40px; 
        height: 40px; 
        border-radius: 50%; 
        background: var(--bg);
        border: 1px solid var(--border); 
        display: flex; 
        align-items: center; 
        justify-content: center;
        text-decoration: none; 
        color: var(--muted); 
        font-size: 18px; 
        transition: all .2s;
    }
    
    .social-link:hover { 
        background: var(--blue); 
        color: #fff; 
        border-color: var(--blue); 
        transform: translateY(-2px);
    }
    
    .footer-bottom { 
        border-top: 1px solid var(--border); 
        padding-top: 24px; 
        text-align: center; 
        font-size: 12px; 
        color: var(--muted); 
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Tooltip styles */
    .tooltip {
        position: absolute;
        background: #1e293b;
        color: white;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        z-index: 1000;
        pointer-events: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    
    .tooltip::after {
        content: '';
        position: absolute;
        bottom: -4px;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 0;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-top: 5px solid #1e293b;
    }
    
    /* Responsive */
    @media (max-width: 1024px) {
        nav, .hero, .search-section, .categories, .data-section, .info-section, footer {
            padding-left: 40px;
            padding-right: 40px;
        }
        
        .hero {
            flex-direction: column;
            text-align: center;
        }
        
        .hero-desc {
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .hero-btns {
            justify-content: center;
        }
    }
    
    @media (max-width: 640px) {
        .hero-title {
            font-size: 48px;
        }
        .hero-title span {
            font-size: 42px;
        }
        .cat-grid {
            grid-template-columns: 1fr 1fr;
        }
        .info-grid {
            grid-template-columns: 1fr;
        }
        .info-card.highlight {
            grid-column: span 1;
            flex-direction: column;
            text-align: center;
        }
        .info-card-header {
            flex-direction: column;
        }
        .footer-grid {
            grid-template-columns: 1fr;
            gap: 30px;
        }
    }
    
    /* Print styles */
    @media print {
        nav, .hero-btns, .search-section, .chart-nav, .social-links, .btn-nav {
            display: none !important;
        }
        .hero {
            background: none;
            padding: 20px;
        }
        .chart-card {
            break-inside: avoid;
            page-break-inside: avoid;
        }
    }
</style>
</head>
<body>

<!-- NAVBAR -->
<nav>
    <a href="/" class="nav-logo">
        <img src="{{ asset('images/logo-bps.png') }}" alt="BPS" height="40" onerror="this.style.display='none'">
        <div>
            <div style="font-size:14px;font-weight:800;color:#1e293b;line-height:1.2">BPS Kutai Timur</div>
            <div style="font-size:11px;color:#64748b">Badan Pusat Statistik</div>
        </div>
    </a>
    <div class="nav-links">
        <a href="/">Home</a>
        <a href="/data-statistik" class="active">Data Statistik</a>
        <a href="/konsultasi">Konsultasi Statistik</a>
        <a href="/login" class="btn-nav">Daftar/Masuk</a>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="hero-content">
        <div class="hero-tag">
            <i class="ti ti-chart-dots" style="color:var(--blue)"></i>
            Portal Data Statistik Resmi
        </div>
        <h1 class="hero-title">Data Statistik<br><span>Kabupaten Kutai</span><br><span>Timur</span></h1>
        <p class="hero-desc">Akses berbagai data statistik resmi Kabupaten Kutai Timur yang akurat, terbaru, dan mudah dipahami untuk kebutuhan informasi, penelitian, dan perencanaan.</p>
        <div class="hero-btns">
            <a href="#data" class="btn-primary"><i class="ti ti-search"></i> Jelajahi Data</a>
            <a href="#info" class="btn-secondary">Pelajari Lebih Lanjut</a>
        </div>
    </div>

    <div class="hero-chart">
        @php 
            $featured = $statistics->first(); 
            $featuredData = $featured ? $featured->values->sortBy('year') : collect();
        @endphp
        <div class="hero-chart-title">{{ $featured->judul_data ?? 'Persentase Penduduk Miskin di Kab. Kutai Timur' }} {{ $featuredData->min('year') ?? '2018' }}–{{ $featuredData->max('year') ?? '2024' }}</div>
        <div class="hero-chart-sub">Update Terakhir: {{ $featured->updated_at->format('F Y') ?? 'Desember 2024' }}</div>
        <div style="height:220px"><canvas id="heroChart"></canvas></div>
    </div>
</section>

<!-- SEARCH -->
<section class="search-section" id="data">
    <div class="search-bar">
        <i class="ti ti-search"></i>
        <input type="text" id="searchInput" placeholder="Cari data disini..." oninput="filterData()">
        <i class="ti ti-filter" style="cursor:pointer" onclick="toggleFilter()"></i>
    </div>
</section>

<!-- CATEGORIES -->
<section class="categories">
    <p class="cat-hint">Silakan pilih salah satu dari empat kategori indikator berikut untuk mulai menjelajahi data</p>
    <div class="cat-grid">
        <a href="?indikator=indikator_ekonomi" class="cat-card {{ request('indikator') === 'indikator_ekonomi' ? 'active' : '' }}">
            <div class="cat-icon" style="background:#fef3c7">💰</div>
            <div class="cat-name">Indikator Ekonomi</div>
        </a>
        <a href="?indikator=indikator_ketenagakerjaan" class="cat-card {{ request('indikator') === 'indikator_ketenagakerjaan' ? 'active' : '' }}">
            <div class="cat-icon" style="background:#fce7f3">👷</div>
            <div class="cat-name">Indikator Ketenagakerjaan</div>
        </a>
        <a href="?indikator=indikator_sosial" class="cat-card {{ request('indikator') === 'indikator_sosial' ? 'active' : '' }}">
            <div class="cat-icon" style="background:#d1fae5">👥</div>
            <div class="cat-name">Indikator Sosial</div>
        </a>
        <a href="?indikator=indikator_pembangunan_manusia" class="cat-card {{ request('indikator') === 'indikator_pembangunan_manusia' ? 'active' : '' }}">
            <div class="cat-icon" style="background:#e0f2fe">📊</div>
            <div class="cat-name">Indikator Pembangunan Manusia</div>
        </a>
    </div>
</section>

<!-- DATA TERBARU -->
<section class="data-section">
    <h2 class="section-title">Data Terbaru</h2>

    <div class="charts-wrapper">
        <div class="charts-track" id="chartsTrack">
            @forelse($statistics as $stat)
            <div class="chart-card" data-judul="{{ strtolower($stat->judul_data) }}" data-indikator="{{ $stat->indikator_data }}">
                <div class="chart-card-title">{{ $stat->judul_data }} {{ $stat->values->min('year') }}–{{ $stat->values->max('year') }}</div>
                <div class="chart-card-sub">{{ $stat->wilayah_data }} · Update: {{ $stat->updated_at->format('M Y') }}</div>
                <div style="height:180px"><canvas id="chart-{{ $stat->id }}"></canvas></div>
                <div style="display:flex;justify-content:space-between;margin-top:16px;font-size:11px;color:var(--muted)">
                    <span>Min: {{ $stat->values->min('value') }}</span>
                    <span>Max: {{ $stat->values->max('value') }}</span>
                </div>
            </div>
            @empty
            @php
                $demoData = [
                    ['judul' => 'Persentase Penduduk Miskin', 'wilayah' => 'Kutai Timur', 'tahun' => '2018-2024', 'values' => [9.28,9.51,9.65,9.91,9.38,8.78,8.61]],
                    ['judul' => 'Tingkat Partisipasi Angkatan Kerja', 'wilayah' => 'Kutai Timur', 'tahun' => '2019-2024', 'values' => [67.2,68.1,68.5,69.2,70.1,70.8]],
                    ['judul' => 'Indeks Pembangunan Manusia', 'wilayah' => 'Kutai Timur', 'tahun' => '2019-2024', 'values' => [71.2,71.8,72.3,72.9,73.4,74.1]],
                    ['judul' => 'Rata-rata Lama Sekolah', 'wilayah' => 'Kutai Timur', 'tahun' => '2019-2024', 'values' => [8.2,8.4,8.5,8.7,8.9,9.1]],
                ];
            @endphp
            @foreach($demoData as $index => $demo)
            <div class="chart-card" data-judul="{{ strtolower($demo['judul']) }}">
                <div class="chart-card-title">{{ $demo['judul'] }} {{ $demo['tahun'] }}</div>
                <div class="chart-card-sub">{{ $demo['wilayah'] }} · Update: {{ ['Des 2024','Nov 2024','Okt 2024','Sep 2024'][$index] }}</div>
                <div style="height:180px"><canvas id="demo-{{ $index }}"></canvas></div>
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

<!-- INFO -->
<section class="info-section" id="info">
    <h2 class="info-title">Informasi Layanan Data Statistik</h2>
    <p class="info-sub">Pelajari lebih lanjut tentang layanan data statistik BPS Kabupaten Kutai Timur, mulai dari jenis<br>data yang tersedia, sumber data, hingga cara menggunakannya.</p>

    <div class="info-grid">
        <div class="info-card">
            <div style="font-size:32px;margin-bottom:16px">📊</div>
            <h3>Jenis Data</h3>
            <p>Beragam data tersedia seperti indikator ekonomi, indikator ketenagakerjaan, indikator sosial, dan indikator pembangunan manusia.</p>
        </div>
        <div class="info-card">
            <div style="font-size:32px;margin-bottom:16px">📚</div>
            <h3>Sumber Data</h3>
            <p>Data berasal dari publikasi resmi, survei, dan kegiatan statistik BPS sehingga dapat digunakan sebagai rujukan terpercaya.</p>
        </div>
        <div class="info-card">
            <div style="font-size:32px;margin-bottom:16px">📱</div>
            <h3>Cara Menggunakan</h3>
            <p>Cari data melalui fitur pencarian atau kategori, lihat dalam bentuk grafik atau tabel, lalu unduh sesuai kebutuhan.</p>
        </div>
        <div class="info-card highlight">
            <div class="info-card-header">
                <div style="display:flex;align-items:center;gap:16px">
                    <div style="font-size:40px">💬</div>
                    <div>
                        <h3 style="margin-bottom:4px">Bantuan</h3>
                        <p style="margin-bottom:0">Bingung memahami data? Gunakan fitur Layanan Konsultasi untuk mendapatkan bantuan dari petugas.</p>
                    </div>
                </div>
                <a href="/konsultasi" class="btn-primary" style="font-size:14px;padding:12px 24px">
                    <i class="ti ti-headset"></i> Mulai Konsultasi
                </a>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer>
    <div class="footer-grid">
        <div>
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px">
                <img src="{{ asset('images/logo-bps.png') }}" height="44" onerror="this.style.display='none'">
                <div>
                    <div style="font-size:16px;font-weight:800">BPS Kutai Timur</div>
                    <div style="font-size:12px;color:#64748b">Badan Pusat Statistik</div>
                </div>
            </div>
            <p class="footer-info">
                Badan Pusat Statistik Kabupaten Kutai Timur<br>
                Jl. A. W. Sjahranie, Sangatta Utara<br>
                Kode Pos 75683<br>
                Telp (62-549) 23223 · Faks (62-549) 24745<br>
                Email: <a href="/cdn-cgi/l/email-protection" style="color:var(--blue);text-decoration:none">bps.6404@bps.go.id</a>
            </p>
        </div>
        <div class="footer-col">
            <h4>Tentang Kami</h4>
            <a href="#">Profil BPS</a>
            <a href="#">PPID</a>
            <a href="#">Kebijakan Diseminasi</a>
            <a href="#">Pustaka</a>
        </div>
        <div class="footer-col">
            <h4>Ikuti Kami di Media Sosial</h4>
            <div class="social-links">
                <a href="#" class="social-link"><i class="ti ti-brand-instagram"></i></a>
                <a href="#" class="social-link"><i class="ti ti-brand-youtube"></i></a>
                <a href="#" class="social-link"><i class="ti ti-brand-tiktok"></i></a>
                <a href="#" class="social-link"><i class="ti ti-brand-twitter"></i></a>
                <a href="#" class="social-link"><i class="ti ti-brand-facebook"></i></a>
            </div>
            <div style="margin-top:24px">
                <h4>Layanan Statistik</h4>
                <a href="#">Konsultasi Statistik</a>
                <a href="#">Permintaan Data</a>
                <a href="#">Survei Online</a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        © {{ date('Y') }} BPS Kabupaten Kutai Timur. Seluruh hak cipta dilindungi.
    </div>
</footer>

<script data-cfasync="false">
// Hero chart
@php
    $heroStat = $statistics->first();
    if ($heroStat) {
        $heroLabels = $heroStat->values->sortBy('year')->pluck('year');
        $heroValues = $heroStat->values->sortBy('year')->pluck('value');
    } else {
        $heroLabels = [2018,2019,2020,2021,2022,2023,2024];
        $heroValues = [9.28,9.51,9.65,9.91,9.38,8.78,8.61];
    }
@endphp
const heroLabels = @json($heroLabels);
const heroData   = @json($heroValues);

new Chart(document.getElementById('heroChart').getContext('2d'), {
    type: 'line',
    data: {
        labels: heroLabels,
        datasets: [{
            data: heroData,
            borderColor: '#1a56db',
            backgroundColor: 'rgba(26,86,219,0.06)',
            borderWidth: 3,
            pointBackgroundColor: '#1a56db',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 6,
            pointHoverRadius: 8,
            fill: true,
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: c => c.parsed.y + '%'
                }
            }
        },
        scales: {
            x: {
                title: { display: true, text: 'Tahun', font: { size: 10, weight: 500 } },
                grid: { display: false },
                ticks: { font: { size: 10 } }
            },
            y: {
                title: { display: true, text: 'Persen', font: { size: 10, weight: 500 } },
                grid: { color: '#f1f5f9' },
                ticks: { font: { size: 10 } }
            }
        }
    }
});

// Demo charts untuk data statis
@if(!$statistics || $statistics->isEmpty())
const demoDataSets = [
    [9.28, 9.51, 9.65, 9.91, 9.38, 8.78, 8.61],
    [67.2, 68.1, 68.5, 69.2, 70.1, 70.8],
    [71.2, 71.8, 72.3, 72.9, 73.4, 74.1],
    [8.2, 8.4, 8.5, 8.7, 8.9, 9.1]
];

const demoLabels = [
    [2018,2019,2020,2021,2022,2023,2024],
    [2019,2020,2021,2022,2023,2024],
    [2019,2020,2021,2022,2023,2024],
    [2019,2020,2021,2022,2023,2024]
];

for (let i = 0; i < 4; i++) {
    const el = document.getElementById(`demo-${i}`);
    if (!el) continue;
    
    new Chart(el.getContext('2d'), {
        type: 'line',
        data: {
            labels: demoLabels[i],
            datasets: [{
                data: demoDataSets[i],
                borderColor: '#1a56db',
                backgroundColor: 'rgba(26,86,219,0.05)',
                borderWidth: 2.5,
                pointBackgroundColor: '#1a56db',
                pointBorderColor: '#fff',
                pointBorderWidth: 1.5,
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: c => c.parsed.y + (i === 0 ? '%' : '')
                    }
                }
            },
            scales: {
                x: { 
                    grid: { display: false }, 
                    ticks: { font: { size: 9 } } 
                },
                y: { 
                    grid: { color: '#f8fafc' }, 
                    ticks: { font: { size: 9 } } 
                }
            }
        }
    });
}
@endif

// Real charts untuk data dari database
@foreach($statistics as $stat)
(function() {
    const el = document.getElementById('chart-{{ $stat->id }}');
    if (!el) return;
    
    const labels = {!! json_encode($stat->values->sortBy('year')->pluck('year')) !!};
    const values = {!! json_encode($stat->values->sortBy('year')->pluck('value')) !!};
    
    new Chart(el.getContext('2d'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                borderColor: '#1a56db',
                backgroundColor: 'rgba(26,86,219,0.05)',
                borderWidth: 2.5,
                pointBackgroundColor: '#1a56db',
                pointBorderColor: '#fff',
                pointBorderWidth: 1.5,
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: c => c.parsed.y
                    }
                }
            },
            scales: {
                x: { 
                    grid: { display: false }, 
                    ticks: { font: { size: 9 } } 
                },
                y: { 
                    grid: { color: '#f8fafc' }, 
                    ticks: { font: { size: 9 } } 
                }
            }
        }
    });
})();
@endforeach

// Charts carousel
let currentIndex = 0;
const track = document.getElementById('chartsTrack');
const cards = track ? track.querySelectorAll('.chart-card') : [];
const dotsEl = document.getElementById('chartDots');
const perView = window.innerWidth < 768 ? 1 : window.innerWidth < 1024 ? 2 : 3;
const maxIndex = Math.max(0, cards.length - perView);

// Initialize dots
if (dotsEl) {
    dotsEl.innerHTML = '';
    for (let i = 0; i <= maxIndex; i++) {
        const dot = document.createElement('button');
        dot.className = 'dot' + (i === 0 ? ' active' : '');
        dot.setAttribute('data-index', i);
        dot.onclick = function() { moveToIndex(i); };
        dotsEl.appendChild(dot);
    }
}

function moveToIndex(index) {
    if (!track || cards.length === 0) return;
    
    currentIndex = Math.max(0, Math.min(index, maxIndex));
    const cardWidth = cards[0] ? cards[0].offsetWidth + 24 : 364;
    track.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
    
    // Update dots
    const dots = dotsEl.querySelectorAll('.dot');
    dots.forEach((dot, i) => {
        dot.classList.toggle('active', i === currentIndex);
    });
}

// Previous button
const prevBtn = document.getElementById('chartPrev');
if (prevBtn) {
    prevBtn.addEventListener('click', function() {
        moveToIndex(currentIndex - 1);
    });
}

// Next button
const nextBtn = document.getElementById('chartNext');
if (nextBtn) {
    nextBtn.addEventListener('click', function() {
        moveToIndex(currentIndex + 1);
    });
}

// Search filter function
function filterData() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const cards = document.querySelectorAll('.chart-card');
    let visibleCount = 0;
    
    cards.forEach(card => {
        const judul = card.getAttribute('data-judul') || '';
        const matches = judul.includes(searchTerm);
        card.style.display = matches ? '' : 'none';
        if (matches) visibleCount++;
    });
    
    // Reset carousel jika perlu
    if (visibleCount > 0) {
        moveToIndex(0);
    }
}

// Toggle filter (placeholder function)
function toggleFilter() {
    alert('Fitur filter akan segera hadir!');
}

// Category filter dari URL
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const activeIndikator = urlParams.get('indikator');
    
    if (activeIndikator && cards.length > 0) {
        // Filter cards berdasarkan indikator
        cards.forEach(card => {
            const indikator = card.getAttribute('data-indikator');
            if (indikator && indikator === activeIndikator) {
                card.style.display = '';
            } else if (indikator) {
                card.style.display = 'none';
            }
        });
        
        // Reset carousel
        moveToIndex(0);
    }
});

// Handle resize
let resizeTimeout;
window.addEventListener('resize', function() {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(function() {
        // Recalculate perView dan maxIndex
        const newPerView = window.innerWidth < 768 ? 1 : window.innerWidth < 1024 ? 2 : 3;
        if (newPerView !== perView) {
            location.reload(); // Simple solution: reload untuk recalculate
        }
    }, 250);
});

// Smooth scroll untuk anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Card click handler untuk navigasi ke detail
document.querySelectorAll('.chart-card').forEach(card => {
    card.addEventListener('click', function(e) {
        // Jangan navigasi jika klik di canvas
        if (e.target.tagName === 'CANVAS') return;
        
        const judul = this.querySelector('.chart-card-title')?.textContent || '';
        // Redirect ke halaman detail atau preview
        window.location.href = '/preview?judul=' + encodeURIComponent(judul);
    });
});

// Intersection Observer untuk animasi scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Animate cards on scroll
document.querySelectorAll('.chart-card, .info-card, .cat-card').forEach(el => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(20px)';
    el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
    observer.observe(el);
});

// Tooltip initialization (jika diperlukan)
document.querySelectorAll('[data-tooltip]').forEach(el => {
    el.addEventListener('mouseenter', function(e) {
        const tooltip = document.createElement('div');
        tooltip.className = 'tooltip';
        tooltip.textContent = this.getAttribute('data-tooltip');
        tooltip.style.cssText = `
            position: absolute;
            background: #1e293b;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            z-index: 1000;
            pointer-events: none;
        `;
        
        document.body.appendChild(tooltip);
        
        const rect = this.getBoundingClientRect();
        tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
        tooltip.style.top = rect.top - tooltip.offsetHeight - 5 + 'px';
        
        this.addEventListener('mouseleave', function() {
            tooltip.remove();
        }, { once: true });
    });
});

// Lazy loading untuk chart.js (optimasi performa)
if ('IntersectionObserver' in window) {
    const chartObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const canvas = entry.target;
                // Trigger chart render ulang jika diperlukan
                const chartId = canvas.id;
                if (chartId && Chart.getChart(chartId)) {
                    Chart.getChart(chartId).update();
                }
                chartObserver.unobserve(canvas);
            }
        });
    });
    
    document.querySelectorAll('canvas').forEach(canvas => {
        chartObserver.observe(canvas);
    });
}

// Dark mode detection (opsional)
if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
    document.documentElement.style.setProperty('--bg', '#1e293b');
    document.documentElement.style.setProperty('--text', '#f1f5f9');
}

// Error handling untuk chart
window.addEventListener('error', function(e) {
    if (e.target.tagName === 'CANVAS') {
        console.warn('Chart render error, but continuing...');
        e.preventDefault();
    }
}, true);
</script>

</body>
</html>