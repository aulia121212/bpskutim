<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Statistik - BPS Kabupaten Kutai Timur</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --blue: #1a56db; --blue-dark: #1341b0; --blue-light: #e8f0fe;
            --text: #1e293b; --muted: #64748b; --border: #e2e8f0; --bg: #f8fafc;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; color: var(--text); background: #fff; }

        /* NAVBAR */
        nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 48px; height: 68px;
            background: rgba(255,255,255,0.95); backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
        }
        .nav-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .nav-links { display: flex; align-items: center; gap: 32px; }
        .nav-links a { text-decoration: none; color: var(--muted); font-size: 14px; font-weight: 500; transition: color .2s; }
        .nav-links a:hover, .nav-links a.active { color: var(--blue); font-weight: 600; }
        .btn-nav { background: var(--blue); color: #fff; border: none; border-radius: 10px; padding: 9px 22px; font-size: 14px; font-weight: 600; cursor: pointer; text-decoration: none; transition: background .2s; }
        .btn-nav:hover { background: var(--blue-dark); }

        /* HERO */
        .hero {
            margin-top: 68px; padding: 72px 80px 80px;
            background: linear-gradient(160deg, #cfe0ff 0%, #ddeeff 30%, #eaf3ff 60%, #f5f0ff 100%);
            display: flex; align-items: center; gap: 60px; min-height: 580px;
            position: relative; overflow: hidden;
        }
        .hero::before {
            content: ''; position: absolute; left: -250px; top: -250px;
            width: 800px; height: 800px; border-radius: 50%;
            background: radial-gradient(circle, rgba(120,180,255,0.22) 0%, transparent 60%);
            pointer-events: none;
        }
        .hero::after {
            content: ''; position: absolute; right: 250px; bottom: -120px;
            width: 500px; height: 500px; border-radius: 50%;
            background: radial-gradient(circle, rgba(160,200,255,0.18) 0%, transparent 70%);
            pointer-events: none;
        }
        .hero-content { flex: 1; z-index: 2; }
        .hero-tag {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(255,255,255,0.7); border: 1px solid rgba(255,255,255,0.95);
            border-radius: 20px; padding: 7px 16px;
            font-size: 12px; font-weight: 600; color: var(--muted);
            margin-bottom: 28px; backdrop-filter: blur(8px);
            box-shadow: 0 2px 10px rgba(0,0,0,.07);
        }
        .hero-title {
            font-size: 62px; font-weight: 800; line-height: 1.0;
            margin-bottom: 22px; letter-spacing: -1.5px;
        }
        .hero-title span { color: var(--blue); display: block; }
        .hero-desc { font-size: 15px; color: #4a6080; line-height: 1.85; max-width: 380px; margin-bottom: 38px; }
        .hero-btns { display: flex; gap: 12px; align-items: center; }
        .btn-primary {
            display: inline-flex; align-items: center; gap: 8px;
            background: var(--blue); color: #fff; text-decoration: none;
            padding: 14px 32px; border-radius: 12px; font-weight: 700; font-size: 14px;
            transition: all .2s; box-shadow: 0 6px 24px rgba(26,86,219,.4);
        }
        .btn-primary:hover { background: var(--blue-dark); transform: translateY(-2px); box-shadow: 0 10px 28px rgba(26,86,219,.45); }
        .btn-secondary {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,0.75); color: var(--text); text-decoration: none;
            padding: 14px 28px; border-radius: 12px; font-weight: 600; font-size: 14px;
            border: 1.5px solid rgba(255,255,255,0.95); transition: all .2s;
            backdrop-filter: blur(8px); box-shadow: 0 2px 8px rgba(0,0,0,.07);
        }
        .btn-secondary:hover { border-color: var(--blue); color: var(--blue); background: #fff; }
        .hero-chart {
            width: 480px; flex-shrink: 0; background: #fff; border-radius: 24px;
            border: 1px solid rgba(220,235,255,0.8); padding: 28px;
            box-shadow: 0 20px 60px rgba(26,86,219,.13), 0 4px 16px rgba(0,0,0,.05);
            z-index: 2;
        }
        .hero-chart-title { font-size: 14px; font-weight: 700; color: var(--text); margin-bottom: 5px; line-height: 1.4; }
        .hero-chart-sub { font-size: 12px; color: var(--muted); margin-bottom: 20px; }

        /* SEARCH */
        .search-section { padding: 40px 80px 0; }
        .search-bar {
            display: flex; align-items: center; gap: 12px;
            background: #fff; border: 1.5px solid var(--border); border-radius: 16px;
            padding: 14px 20px; box-shadow: 0 2px 12px rgba(0,0,0,.06); transition: border-color .2s;
        }
        .search-bar:focus-within { border-color: var(--blue); }
        .search-bar input { flex: 1; border: none; outline: none; font-size: 15px; font-family: inherit; color: var(--text); }
        .search-bar input::placeholder { color: var(--muted); }
        .search-bar i { font-size: 20px; color: var(--muted); }

        /* CATEGORIES */
        .categories { padding: 40px 80px; }
        .cat-hint { text-align: center; font-size: 14px; color: var(--muted); margin-bottom: 24px; }
        .cat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; }
        .cat-card {
            background: #fff; border: 1.5px solid var(--border); border-radius: 16px;
            padding: 28px 20px; text-align: center; cursor: pointer;
            transition: all .2s; text-decoration: none; color: var(--text);
        }
        .cat-card:hover, .cat-card.active { border-color: var(--blue); background: var(--blue-light); }
        .cat-icon {
            width: 64px; height: 64px; border-radius: 16px; background: var(--bg);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 12px; font-size: 28px;
        }
        .cat-card:hover .cat-icon, .cat-card.active .cat-icon { background: #fff; }
        .cat-name { font-size: 14px; font-weight: 600; color: var(--text); }

        /* DATA TERBARU */
        .data-section { padding: 60px 80px; background: var(--bg); }
        .section-title { text-align: center; font-size: 36px; font-weight: 800; margin-bottom: 40px; }
        .charts-wrapper { position: relative; overflow: hidden; }
        .charts-track { display: flex; gap: 24px; transition: transform .4s ease; padding: 8px 4px; }
        .chart-card {
            min-width: 360px; background: #fff; border: 1px solid var(--border);
            border-radius: 20px; padding: 24px; box-shadow: 0 2px 12px rgba(0,0,0,.06);
            cursor: pointer; transition: all .2s;
        }
        .chart-card:hover { transform: translateY(-4px); box-shadow: 0 8px 32px rgba(0,0,0,.1); border-color: var(--blue); }
        .chart-card.expanded { min-width: 460px; }
        .chart-card-title { font-size: 13px; font-weight: 700; color: var(--text); margin-bottom: 4px; }
        .chart-card-sub { font-size: 11px; color: var(--muted); margin-bottom: 16px; }
        .chart-nav { display: flex; justify-content: center; align-items: center; gap: 16px; margin-top: 32px; }
        .nav-btn {
            width: 40px; height: 40px; border-radius: 50%; background: #fff;
            border: 1px solid var(--border); cursor: pointer; display: flex; align-items: center; justify-content: center;
            transition: all .2s; font-size: 16px;
        }
        .nav-btn:hover { background: var(--blue); color: #fff; border-color: var(--blue); }
        .dots { display: flex; gap: 6px; }
        .dot { width: 8px; height: 8px; border-radius: 50%; background: var(--border); border: none; cursor: pointer; transition: all .2s; }
        .dot.active { background: var(--blue); width: 20px; border-radius: 4px; }

        /* INFO CARDS */
        .info-section { padding: 60px 80px; }
        .info-title { text-align: center; font-size: 32px; font-weight: 800; margin-bottom: 8px; }
        .info-sub { text-align: center; font-size: 14px; color: var(--muted); margin-bottom: 40px; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .info-card {
            background: #fff; border: 1.5px solid var(--border); border-radius: 20px;
            padding: 28px; transition: all .2s;
        }
        .info-card:hover { border-color: var(--blue); box-shadow: 0 4px 20px rgba(26,86,219,.1); }
        .info-card h3 { font-size: 16px; font-weight: 700; color: var(--blue); margin-bottom: 12px; }
        .info-card p { font-size: 14px; color: var(--muted); line-height: 1.7; }
        .info-card.highlight { background: var(--blue-light); border-color: var(--blue); }
        .info-card-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; }

        /* FOOTER */
        footer { background: #fff; border-top: 1px solid var(--border); padding: 48px 80px 32px; }
        .footer-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 48px; margin-bottom: 40px; }
        .footer-col h4 { font-size: 14px; font-weight: 700; margin-bottom: 16px; }
        .footer-col a { display: block; font-size: 13px; color: var(--muted); text-decoration: none; margin-bottom: 8px; transition: color .2s; }
        .footer-col a:hover { color: var(--blue); }
        .footer-info { font-size: 13px; color: var(--muted); line-height: 1.8; margin-top: 12px; }
        .social-links { display: flex; gap: 10px; margin-top: 16px; }
        .social-link {
            width: 36px; height: 36px; border-radius: 50%; background: var(--bg);
            border: 1px solid var(--border); display: flex; align-items: center; justify-content: center;
            text-decoration: none; color: var(--muted); font-size: 16px; transition: all .2s;
        }
        .social-link:hover { background: var(--blue); color: #fff; border-color: var(--blue); }
        .footer-bottom { border-top: 1px solid var(--border); padding-top: 24px; text-align: center; font-size: 12px; color: var(--muted); }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav>
    <a href="/" class="nav-logo">
        <img src="{{ asset('images/logo-bps.png') }}" alt="BPS" height="36" onerror="this.style.display='none'">
        <div>
            <div style="font-size:13px;font-weight:700;color:#1e293b;line-height:1.2">BPS Kutai Timur</div>
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
            <a href="#data" class="btn-primary"><i class="ti ti-search"></i> Jelajahi Data <i class="ti ti-arrow-right"></i></a>
            <a href="#info" class="btn-secondary">Pelajari Lebih Lanjut</a>
        </div>
    </div>

    <div class="hero-chart">
        @php $featured = $statistics->first(); @endphp
        @if($featured)
        <div class="hero-chart-title">{{ $featured->judul_data }} {{ $featured->values->min('year') }}–{{ $featured->values->max('year') }}</div>
        <div class="hero-chart-sub">Update Terakhir: {{ $featured->updated_at->format('F Y') }}</div>
        <div style="height:220px"><canvas id="heroChart"></canvas></div>
        @else
        <div class="hero-chart-title">Persentase Penduduk Miskin di Kab. Kutai Timur 2018–2024</div>
        <div class="hero-chart-sub">Update Terakhir: Desember 2024</div>
        <div style="height:220px"><canvas id="heroChart"></canvas></div>
        @endif
    </div>
</section>

<!-- SEARCH -->
<section class="search-section" id="data">
    <div class="search-bar">
        <i class="ti ti-search"></i>
        <input type="text" id="searchInput" placeholder="Cari data disini..." oninput="filterData()">
    </div>
</section>

<!-- CATEGORIES -->
<section class="categories">
    <p class="cat-hint">Silakan pilih salah satu dari empat kategori indikator berikut untuk mulai menjelajahi data</p>
    <div class="cat-grid">
        <a href="?indikator=indikator_ekonomi" class="cat-card {{ request('indikator') === 'indikator_ekonomi' ? 'active' : '' }}">
            <div class="cat-icon" style="background:#fef9c3">💰</div>
            <div class="cat-name">Indikator Ekonomi</div>
        </a>
        <a href="?indikator=indikator_ketenagakerjaan" class="cat-card {{ request('indikator') === 'indikator_ketenagakerjaan' ? 'active' : '' }}">
            <div class="cat-icon" style="background:#fce7f3">👷</div>
            <div class="cat-name">Indikator Ketenagakerjaan</div>
        </a>
        <a href="?indikator=indikator_sosial" class="cat-card {{ request('indikator') === 'indikator_sosial' ? 'active' : '' }}">
            <div class="cat-icon" style="background:#dcfce7">👥</div>
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
            </div>
            @empty
            @for($i = 0; $i < 4; $i++)
            <div class="chart-card">
                <div class="chart-card-title">Persentase Penduduk Miskin di Kab. Kutai Timur 2018–2024</div>
                <div class="chart-card-sub">Kutai Timur · Update: Des 2024</div>
                <div style="height:180px"><canvas id="demo-{{ $i }}"></canvas></div>
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

<!-- INFO -->
<section class="info-section" id="info">
    <h2 class="info-title">Informasi Layanan Data Statistik</h2>
    <p class="info-sub">Pelajari lebih lanjut tentang layanan data statistik BPS Kabupaten Kutai Timur, mulai dari jenis<br>data yang tersedia, sumber data, hingga cara menggunakannya.</p>

    <div class="info-grid">
        <div class="info-card">
            <h3>Jenis Data</h3>
            <p>Beragam data tersedia seperti indikator ekonomi, indikator ketenagakerjaan, indikator sosial, dan indikator pembangunan manusia.</p>
        </div>
        <div class="info-card">
            <h3>Sumber Data</h3>
            <p>Data berasal dari publikasi resmi, survei, dan kegiatan statistik BPS sehingga dapat digunakan sebagai rujukan terpercaya.</p>
        </div>
        <div class="info-card">
            <h3>Cara Menggunakan</h3>
            <p>Cari data melalui fitur pencarian atau kategori, lihat dalam bentuk grafik atau tabel, lalu unduh sesuai kebutuhan.</p>
        </div>
        <div class="info-card highlight">
            <div class="info-card-header">
                <h3>Bantuan</h3>
                <a href="/konsultasi" class="btn-primary" style="font-size:12px;padding:6px 14px">
                    <i class="ti ti-headset"></i> Mulai Konsultasi
                </a>
            </div>
            <p>Bingung memahami data? Gunakan fitur Layanan Konsultasi untuk mendapatkan bantuan dari petugas.</p>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer>
    <div class="footer-grid">
        <div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px">
                <img src="{{ asset('images/logo-bps.png') }}" height="36" onerror="this.style.display='none'">
                <div>
                    <div style="font-size:13px;font-weight:700">BPS Kutai Timur</div>
                    <div style="font-size:11px;color:#64748b">Badan Pusat Statistik</div>
                </div>
            </div>
            <p class="footer-info">Badan Pusat Statistik Kabupaten Kutai Timur<br>Jl. A. W. Sjahranie, Sangatta Utara Kode Pos 75683<br>Telp (62-549) 23223 · Faks (62-549) 24745<br>Mailbox: <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="0b697b783d3f3b3f4b697b78256c6425626f">[email&#160;protected]</a></p>
        </div>
        <div class="footer-col">
            <h4>Tentang Kami</h4>
            <a href="#">Profil BPS</a>
            <a href="#">PPID</a>
            <a href="#">Kebijakan Diseminasi</a>
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
        </div>
    </div>
    <div class="footer-bottom">© {{ date('Y') }} BPS Kabupaten Kutai Timur. Seluruh hak cipta dilindungi.</div>
</footer>

<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script>
// Hero chart
@php
    $heroStat   = $statistics->first();
    $heroLabels = $heroStat ? $heroStat->values->sortBy('year')->pluck('year') : [2018,2019,2020,2021,2022,2023,2024];
    $heroValues = $heroStat ? $heroStat->values->sortBy('year')->pluck('value') : [9.28,9.51,9.65,9.91,9.38,8.78,8.61];
@endphp
const heroLabels = @json($heroLabels);
const heroData   = @json($heroValues);

new Chart(document.getElementById('heroChart').getContext('2d'), {
    type: 'line',
    data: {
        labels: heroLabels,
        datasets: [{ data: heroData, borderColor: '#1a56db', backgroundColor: 'rgba(26,86,219,0.06)', borderWidth: 2.5, pointBackgroundColor: '#1a56db', pointRadius: 5, fill: true, tension: 0.3 }]
    },
    options: {
        responsive: true, maintainAspectRatio: false,
        plugins: { legend: { display: false }, tooltip: { callbacks: { label: c => c.parsed.y + '%' } } },
        scales: {
            x: { title: { display: true, text: 'Tahun', font: { size: 10 } }, grid: { display: false }, ticks: { font: { size: 10 } } },
            y: { title: { display: true, text: 'Persen', font: { size: 10 } }, grid: { color: '#f1f5f9' }, ticks: { font: { size: 10 } } }
        }
    }
});

// Demo charts
for (let i = 0; i < 4; i++) {
    const el = document.getElementById(`demo-${i}`);
    if (!el) continue;
    const base = [9.28,9.51,9.65,9.91,9.38,8.78,8.61].map(v => +(v + (Math.random()-.5)).toFixed(2));
    new Chart(el.getContext('2d'), {
        type: 'line',
        data: { labels: [2018,2019,2020,2021,2022,2023,2024], datasets: [{ data: base, borderColor: '#1a56db', backgroundColor: 'rgba(26,86,219,0.05)', borderWidth: 2, pointRadius: 3, fill: true, tension: 0.3 }] },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { x: { grid: { display: false }, ticks: { font: { size: 9 } } }, y: { grid: { color: '#f8fafc' }, ticks: { font: { size: 9 } } } } }
    });
}

// Real charts
@foreach($statistics as $stat)
(function() {
    const el = document.getElementById('chart-{{ $stat->id }}');
    if (!el) return;
    new Chart(el.getContext('2d'), {
        type: 'line',
        data: {
            labels: {!! json_encode($stat->values->sortBy('year')->pluck('year')) !!},
            datasets: [{ data: {!! json_encode($stat->values->sortBy('year')->pluck('value')) !!}, borderColor: '#1a56db', backgroundColor: 'rgba(26,86,219,0.05)', borderWidth: 2, pointBackgroundColor: '#1a56db', pointRadius: 4, fill: true, tension: 0.3 }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { x: { grid: { display: false }, ticks: { font: { size: 9 } } }, y: { grid: { color: '#f8fafc' }, ticks: { font: { size: 9 } } } } }
    });
})();
@endforeach

// Charts carousel
let idx = 0;
const track   = document.getElementById('chartsTrack');
const cards   = track.querySelectorAll('.chart-card');
const dotsEl  = document.getElementById('chartDots');
const perView = 3;
const maxIdx  = Math.max(0, cards.length - perView);

for (let i = 0; i <= maxIdx; i++) {
    const d = document.createElement('button');
    d.className = 'dot' + (i === 0 ? ' active' : '');
    d.onclick = () => move(i);
    dotsEl.appendChild(d);
}

function move(n) {
    idx = Math.max(0, Math.min(n, maxIdx));
    const w = cards[0] ? cards[0].offsetWidth + 24 : 384;
    track.style.transform = `translateX(-${idx * w}px)`;
    dotsEl.querySelectorAll('.dot').forEach((d, i) => d.classList.toggle('active', i === idx));
}

document.getElementById('chartPrev').onclick = () => move(idx - 1);
document.getElementById('chartNext').onclick = () => move(idx + 1);

// Search filter
function filterData() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    cards.forEach(c => {
        c.style.display = c.dataset.judul?.includes(q) ? '' : 'none';
    });
}

// Category filter from URL
const urlParams = new URLSearchParams(window.location.search);
const activeIndikator = urlParams.