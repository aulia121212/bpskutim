<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BPS Kabupaten Kutai Timur</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --blue: #1a56db;
            --blue-dark: #1341b0;
            --blue-light: #e8f0fe;
            --teal: #0ea5e9;
            --text: #1e293b;
            --muted: #64748b;
            --border: #e2e8f0;
            --bg: #f8fafc;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; color: var(--text); background: #fff; }
        .serif { font-family: 'Playfair Display', serif; }

        /* NAVBAR */
        nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 48px; height: 68px;
            background: rgba(255,255,255,0.95); backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
        }
        .nav-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .nav-logo img { height: 40px; }
        .nav-links { display: flex; align-items: center; gap: 32px; }
        .nav-links a { text-decoration: none; color: var(--muted); font-size: 14px; font-weight: 500; transition: color .2s; }
        .nav-links a:hover { color: var(--blue); }
        .nav-links a.active { color: var(--blue); font-weight: 600; }
        .btn-nav {
            background: var(--blue); color: #fff; border: none; border-radius: 10px;
            padding: 9px 22px; font-size: 14px; font-weight: 600; cursor: pointer;
            text-decoration: none; transition: background .2s;
        }
        .btn-nav:hover { background: var(--blue-dark); }

        /* HERO SLIDER */
        .hero { margin-top: 68px; position: relative; overflow: hidden; }
        .slider-track { display: flex; transition: transform .5s ease; }
        .slide {
            min-width: 100%; padding: 80px 80px 80px 80px;
            display: flex; align-items: center; justify-content: space-between;
            background: linear-gradient(135deg, #eef4ff 0%, #f0f9ff 100%);
            min-height: 480px; position: relative; overflow: hidden;
        }
        .slide::before {
            content: ''; position: absolute; right: -100px; top: -100px;
            width: 500px; height: 500px; border-radius: 50%;
            background: radial-gradient(circle, rgba(26,86,219,0.08) 0%, transparent 70%);
        }
        .slide-content { max-width: 480px; z-index: 2; }
        .slide-tag {
            display: inline-block; background: var(--blue-light); color: var(--blue);
            font-size: 12px; font-weight: 600; padding: 4px 12px; border-radius: 20px; margin-bottom: 16px;
        }
        .slide-title { font-size: 42px; line-height: 1.2; font-weight: 700; margin-bottom: 12px; color: var(--text); }
        .slide-title em { font-family: 'Playfair Display', serif; font-style: italic; color: var(--blue); }
        .slide-desc { font-size: 15px; color: var(--muted); line-height: 1.7; margin-bottom: 28px; }
        .btn-hero {
            display: inline-flex; align-items: center; gap: 8px;
            background: var(--blue); color: #fff; text-decoration: none;
            padding: 12px 24px; border-radius: 12px; font-weight: 600; font-size: 14px;
            transition: all .2s; box-shadow: 0 4px 16px rgba(26,86,219,0.3);
        }
        .btn-hero:hover { background: var(--blue-dark); transform: translateY(-1px); }
        .slide-image { width: 420px; z-index: 2; }
        .slide-image img { width: 100%; object-fit: contain; }
        .slider-dots { display: flex; justify-content: center; gap: 8px; padding: 20px 0; background: #fff; }
        .dot { width: 8px; height: 8px; border-radius: 50%; background: var(--border); cursor: pointer; transition: all .2s; border: none; }
        .dot.active { background: var(--blue); width: 24px; border-radius: 4px; }
        .slider-btn {
            position: absolute; top: 50%; transform: translateY(-50%);
            width: 40px; height: 40px; border-radius: 50%; background: #fff;
            border: 1px solid var(--border); cursor: pointer; display: flex; align-items: center; justify-content: center;
            z-index: 10; transition: all .2s; box-shadow: 0 2px 8px rgba(0,0,0,.1);
        }
        .slider-btn:hover { background: var(--blue); color: #fff; border-color: var(--blue); }
        .slider-btn.prev { left: 24px; }
        .slider-btn.next { right: 24px; }

        /* PUBLIKASI */
        .publikasi {
            padding: 80px;
            background: linear-gradient(160deg, #f0f6ff 0%, #e8f4ff 50%, #f0f9ff 100%);
            display: flex; align-items: center; gap: 60px; position: relative; overflow: hidden;
        }
        .publikasi::before {
            content: ''; position: absolute; left: -200px; top: -200px;
            width: 600px; height: 600px; border-radius: 50%;
            background: radial-gradient(circle, rgba(14,165,233,0.08) 0%, transparent 70%);
        }
        .publikasi-content { flex: 1; z-index: 2; }
        .publikasi-title { font-size: 46px; line-height: 1.1; font-weight: 700; margin-bottom: 20px; }
        .publikasi-title em { font-family: 'Playfair Display', serif; font-style: italic; color: var(--blue); display: block; }
        .publikasi-desc { font-size: 15px; color: var(--muted); line-height: 1.8; max-width: 400px; margin-bottom: 32px; }
        .btn-outline {
            display: inline-flex; align-items: center; gap: 8px;
            border: 2px solid var(--blue); color: var(--blue); text-decoration: none;
            padding: 12px 28px; border-radius: 12px; font-weight: 600; font-size: 14px; transition: all .2s;
        }
        .btn-outline:hover { background: var(--blue); color: #fff; }
        .publikasi-img { width: 420px; z-index: 2; }
        .publikasi-img img { width: 100%; }

        /* DATA TERBARU */
        .data-section { padding: 80px; background: #fff; }
        .section-header { text-align: center; margin-bottom: 48px; }
        .section-title { font-size: 42px; font-weight: 700; line-height: 1.2; }
        .section-title em { font-family: 'Playfair Display', serif; font-style: italic; color: var(--blue); display: block; }
        .btn-search {
            display: inline-flex; align-items: center; gap: 8px; margin-top: 20px;
            background: var(--blue-light); color: var(--blue); border: none;
            padding: 10px 24px; border-radius: 20px; font-weight: 600; font-size: 14px; cursor: pointer;
            text-decoration: none; transition: all .2s;
        }
        .btn-search:hover { background: var(--blue); color: #fff; }
        .charts-slider { position: relative; overflow: hidden; }
        .charts-track { display: flex; gap: 24px; transition: transform .4s ease; padding: 4px 0; }
        .chart-card {
            min-width: 380px; background: #fff; border: 1px solid var(--border);
            border-radius: 20px; padding: 24px; box-shadow: 0 2px 12px rgba(0,0,0,.06);
            transition: transform .2s, box-shadow .2s;
        }
        .chart-card:hover { transform: translateY(-4px); box-shadow: 0 8px 32px rgba(0,0,0,.1); }
        .chart-card-title { font-size: 13px; font-weight: 700; color: var(--text); margin-bottom: 4px; }
        .chart-card-sub { font-size: 11px; color: var(--muted); margin-bottom: 16px; }
        .chart-nav { display: flex; justify-content: center; align-items: center; gap: 16px; margin-top: 32px; }
        .chart-nav-btn {
            width: 40px; height: 40px; border-radius: 50%; background: #fff;
            border: 1px solid var(--border); cursor: pointer; display: flex; align-items: center; justify-content: center;
            transition: all .2s;
        }
        .chart-nav-btn:hover { background: var(--blue); color: #fff; border-color: var(--blue); }
        .chart-dots { display: flex; gap: 6px; }
        .chart-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--border); border: none; cursor: pointer; transition: all .2s; }
        .chart-dot.active { background: var(--blue); }

        /* POPUP BANNER */
        .popup-banner {
            margin: 0 80px 80px; border-radius: 24px; overflow: hidden;
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            display: flex; align-items: center; justify-content: space-between;
            padding: 48px 64px; position: relative;
        }
        .popup-banner-content h2 { font-size: 36px; font-weight: 800; color: var(--text); line-height: 1.2; margin-bottom: 24px; }
        .popup-banner-content h2 span { color: var(--blue); }
        .btn-konsultasi {
            display: inline-flex; align-items: center; gap: 8px;
            background: var(--blue); color: #fff; text-decoration: none;
            padding: 14px 32px; border-radius: 30px; font-weight: 700; font-size: 15px;
            box-shadow: 0 4px 20px rgba(26,86,219,0.35); transition: all .2s;
        }
        .btn-konsultasi:hover { background: var(--blue-dark); transform: translateY(-2px); }
        .popup-banner-img { width: 320px; }
        .popup-banner-img img { width: 100%; }

        /* FOOTER */
        footer {
            background: #fff; border-top: 1px solid var(--border);
            padding: 48px 80px 32px;
        }
        .footer-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 48px; margin-bottom: 40px; }
        .footer-brand { display: flex; align-items: flex-start; gap: 12px; margin-bottom: 16px; }
        .footer-brand img { height: 40px; }
        .footer-info { font-size: 13px; color: var(--muted); line-height: 1.8; }
        .footer-col h4 { font-size: 14px; font-weight: 700; color: var(--text); margin-bottom: 16px; }
        .footer-col a { display: block; font-size: 13px; color: var(--muted); text-decoration: none; margin-bottom: 8px; transition: color .2s; }
        .footer-col a:hover { color: var(--blue); }
        .social-links { display: flex; gap: 12px; margin-top: 16px; }
        .social-link {
            width: 36px; height: 36px; border-radius: 50%; background: var(--bg);
            border: 1px solid var(--border); display: flex; align-items: center; justify-content: center;
            text-decoration: none; color: var(--muted); font-size: 16px; transition: all .2s;
        }
        .social-link:hover { background: var(--blue); color: #fff; border-color: var(--blue); }
        .footer-bottom { border-top: 1px solid var(--border); padding-top: 24px; text-align: center; font-size: 12px; color: var(--muted); }

        @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .fade-up { animation: fadeUp .6s ease forwards; }
        .fade-up-2 { animation: fadeUp .6s .15s ease both; }
        .fade-up-3 { animation: fadeUp .6s .3s ease both; }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav>
    <a href="/" class="nav-logo">
        <img src="{{ asset('images/bpslogo.svg') }}" alt="BPS Kutai Timur" onerror="this.style.display='none'">
        <div>
            <div style="font-size:13px;font-weight:700;color:#1e293b;line-height:1.2">BPS Kutai Timur</div>
            <div style="font-size:11px;color:#64748b">Badan Pusat Statistik</div>
        </div>
    </a>
    <div class="nav-links">
        <a href="/" class="active">Home</a>
        <a href="/data-statistik">Data Statistik</a>
        <a href="/konsultasi">Konsultasi Statistik</a>
        <a href="/login" class="btn-nav">Daftar/Masuk</a>
    </div>
</nav>

<!-- HERO SLIDER -->
<section class="hero">
    <div style="position:relative; overflow:hidden;">
        <div class="slider-track" id="heroTrack">

            <!-- Slide 1 -->
            <div class="slide">
                <div class="slide-content fade-up">
                    <span class="slide-tag">Layanan BPS Kutai Timur</span>
                    <h1 class="slide-title">Layanan<br><em>Konsultasi</em> Statistik</h1>
                    <p class="slide-desc">Butuh Bantuan Memahami Data Statistik?<br>
                    Dapatkan pendampingan dari petugas terkini sebagai referensi terpercaya untuk memahami data, indikator, dan konsep statistik sesuai kebutuhan Anda.</p>
                    <a href="/konsultasi" class="btn-hero">
                        <i class="ti ti-headset"></i> Mulai Konsultasi
                    </a>
                </div>
                <div class="slide-image fade-up-2">
                    <img src="https://cdnjs.cloudflare.com/ajax/libs/twemoji/14.0.2/svg/1f4ca.svg"
                         onerror="this.parentElement.innerHTML='<div style=\'width:400px;height:300px;background:linear-gradient(135deg,#dbeafe,#bfdbfe);border-radius:24px;display:flex;align-items:center;justify-content:center\'><i class=\'ti ti-chart-line\' style=\'font-size:80px;color:#1a56db;opacity:.5\'></i></div>'"
                         style="width:380px;height:280px;object-fit:contain">
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="slide" style="background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);">
                <div class="slide-content">
                    <span class="slide-tag" style="background:#dcfce7;color:#16a34a">Data Terpercaya</span>
                    <h1 class="slide-title">Data <em style="color:#16a34a">Statistik</em><br>Kutai Timur</h1>
                    <p class="slide-desc">Akses ribuan data statistik resmi dari BPS Kabupaten Kutai Timur. Data yang akurat, terkini, dan terpercaya untuk mendukung pengambilan keputusan.</p>
                    <a href="/data-statistik" class="btn-hero" style="background:#16a34a;box-shadow:0 4px 16px rgba(22,163,74,.3)">
                        <i class="ti ti-database"></i> Jelajahi Data
                    </a>
                </div>
                <div class="slide-image" style="display:flex;align-items:center;justify-content:center">
                    <div style="width:360px;height:260px;background:linear-gradient(135deg,#dcfce7,#bbf7d0);border-radius:24px;display:flex;align-items:center;justify-content:center">
                        <i class="ti ti-database" style="font-size:80px;color:#16a34a;opacity:.6"></i>
                    </div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="slide" style="background: linear-gradient(135deg, #fef9f0 0%, #fef3c7 100%);">
                <div class="slide-content">
                    <span class="slide-tag" style="background:#fef9c3;color:#ca8a04">Publikasi Resmi</span>
                    <h1 class="slide-title">Publikasi <em style="color:#ca8a04">BPS</em><br>Kutai Timur</h1>
                    <p class="slide-desc">Temukan berbagai publikasi statistik resmi yang menyajikan data, analisis, dan informasi terkini sebagai referensi terpercaya untuk memahami perkembangan daerah.</p>
                    <a href="/publikasi" class="btn-hero" style="background:#ca8a04;box-shadow:0 4px 16px rgba(202,138,4,.3)">
                        <i class="ti ti-book"></i> Akses Publikasi
                    </a>
                </div>
                <div class="slide-image" style="display:flex;align-items:center;justify-content:center">
                    <div style="width:360px;height:260px;background:linear-gradient(135deg,#fef9c3,#fde68a);border-radius:24px;display:flex;align-items:center;justify-content:center">
                        <i class="ti ti-books" style="font-size:80px;color:#ca8a04;opacity:.6"></i>
                    </div>
                </div>
            </div>

        </div>

        <button class="slider-btn prev" id="heroPrev"><i class="ti ti-chevron-left"></i></button>
        <button class="slider-btn next" id="heroNext"><i class="ti ti-chevron-right"></i></button>
    </div>
    <div class="slider-dots" id="heroDots">
        <button class="dot active" onclick="goToSlide(0)"></button>
        <button class="dot" onclick="goToSlide(1)"></button>
        <button class="dot" onclick="goToSlide(2)"></button>
    </div>
</section>

<!-- PUBLIKASI -->
<section class="publikasi">
    <div class="publikasi-content">
        <h2 class="publikasi-title">
            <em>Publikasi</em>
            BPS Kutai Timur
        </h2>
        <p class="publikasi-desc">Temukan berbagai publikasi statistik resmi yang menyajikan data, analisis, dan informasi terkini sebagai referensi terpercaya untuk memahami perkembangan daerah.</p>
        <a href="/publikasi" class="btn-outline">
            <i class="ti ti-link"></i> Akses Publikasi
        </a>
    </div>
    <div class="publikasi-img">
        <div style="width:420px;height:320px;background:linear-gradient(135deg,#dbeafe,#bfdbfe);border-radius:24px;display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden">
            <div style="position:absolute;inset:0;background:url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><circle cx=%2220%22 cy=%2280%22 r=%2240%22 fill=%22rgba(255,255,255,0.15)%22/><circle cx=%2280%22 cy=%2220%22 r=%2230%22 fill=%22rgba(255,255,255,0.1)%22/></svg>') no-repeat center/cover"></div>
            <i class="ti ti-books" style="font-size:100px;color:#1a56db;opacity:.35;position:relative;z-index:1"></i>
        </div>
    </div>
</section>

<!-- DATA TERBARU -->
<section class="data-section">
    <div class="section-header">
        <h2 class="section-title">Data<br><em>Terbaru</em></h2>
        <a href="/data-statistik" class="btn-search">
            <i class="ti ti-search"></i> Jelajahi Data Sekarang
        </a>
    </div>

    <div class="charts-slider" style="position:relative">
        <div class="charts-track" id="chartsTrack">
            @php
                $chartData = $statistics ?? collect();
            @endphp

            @forelse($chartData as $stat)
            <div class="chart-card">
                <div class="chart-card-title">{{ $stat->judul_data }}</div>
                <div class="chart-card-sub">{{ $stat->wilayah_data }} · Update Terakhir: {{ $stat->updated_at->format('F Y') }}</div>
                <div style="height:180px">
                    <canvas id="chart-{{ $stat->id }}"></canvas>
                </div>
            </div>
            @empty
            @for($i = 0; $i < 3; $i++)
            <div class="chart-card">
                <div class="chart-card-title">Persentase Penduduk Miskin di Kab. Kutai Timur 2018–2024</div>
                <div class="chart-card-sub">Kutai Timur · Update Terakhir: Desember 2024</div>
                <div style="height:180px">
                    <canvas id="demo-chart-{{ $i }}"></canvas>
                </div>
            </div>
            @endfor
            @endforelse
        </div>
    </div>

    <div class="chart-nav">
        <button class="chart-nav-btn" id="chartPrev"><i class="ti ti-chevron-left"></i></button>
        <div class="chart-dots" id="chartDots"></div>
        <button class="chart-nav-btn" id="chartNext"><i class="ti ti-chevron-right"></i></button>
    </div>
</section>

<!-- POPUP BANNER -->
@php $activeBanner = $popups->first() ?? null; @endphp
<div class="popup-banner">
    <div class="popup-banner-content">
        <h2>Tidak menemukan<br><span>data yang dicari?</span></h2>
        <a href="/konsultasi" class="btn-konsultasi">
            <i class="ti ti-message-circle"></i> Hubungi Layanan Konsultasi
        </a>
    </div>
    <div class="popup-banner-img">
        @if($activeBanner)
        <img src="{{ asset($activeBanner->foto) }}" alt="Konsultasi" style="border-radius:16px">
        @else
        <div style="width:300px;height:220px;background:linear-gradient(135deg,#bfdbfe,#93c5fd);border-radius:20px;display:flex;align-items:center;justify-content:center">
            <i class="ti ti-users" style="font-size:80px;color:#1a56db;opacity:.5"></i>
        </div>
        @endif
    </div>
</div>

<!-- FOOTER -->
<footer>
    <div class="footer-grid">
        <div>
            <div class="footer-brand">
                <img src="{{ asset('images/bpslogo.svg') }}" alt="BPS" onerror="this.style.display='none'">
                <div>
                    <div style="font-size:13px;font-weight:700;color:#1e293b">BPS Kutai Timur</div>
                    <div style="font-size:11px;color:#64748b">Badan Pusat Statistik</div>
                </div>
            </div>
            <p class="footer-info">
                Badan Pusat Statistik Kabupaten Kutai Timur<br>
                Jl. A. W. Sjahranie, Sangatta Utara Kode Pos 75683<br>
                Telp (62-549) 23223<br>
                Faks (62-549) 24745<br>
                Mailbox: bps6404@bps.go.id
            </p>
        </div>
        <div class="footer-col">
            <h4>Tentang Kami</h4>
            <a href="/profil">Profil BPS</a>
            <a href="/ppid">PPID</a>
            <a href="/kebijakan">Kebijakan Diseminasi</a>
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
    <div class="footer-bottom">
        © {{ date('Y') }} BPS Kabupaten Kutai Timur. Seluruh hak cipta dilindungi.
    </div>
</footer>

<script>
// Hero Slider
let heroIdx = 0;
const heroTrack = document.getElementById('heroTrack');
const heroDots  = document.getElementById('heroDots').querySelectorAll('.dot');

function goToSlide(n) {
    heroIdx = n;
    heroTrack.style.transform = `translateX(-${heroIdx * 100}%)`;
    heroDots.forEach((d, i) => d.classList.toggle('active', i === heroIdx));
}
document.getElementById('heroPrev').addEventListener('click', () => goToSlide((heroIdx - 1 + 3) % 3));
document.getElementById('heroNext').addEventListener('click', () => goToSlide((heroIdx + 1) % 3));
setInterval(() => goToSlide((heroIdx + 1) % 3), 5000);

// Demo Charts
const demoLabels = [2018, 2019, 2020, 2021, 2022, 2023, 2024];
const demoDatasets = [
    [9.28, 9.51, 9.65, 9.91, 9.38, 8.78, 8.61],
    [8.5, 8.9, 9.2, 9.5, 9.1, 8.8, 8.3],
    [7.8, 8.1, 8.4, 8.7, 8.5, 8.2, 7.9],
];

for (let i = 0; i < 3; i++) {
    const canvas = document.getElementById(`demo-chart-${i}`);
    if (!canvas) continue;
    new Chart(canvas.getContext('2d'), {
        type: 'line',
        data: {
            labels: demoLabels,
            datasets: [{
                data: demoDatasets[i],
                borderColor: '#1a56db',
                backgroundColor: 'rgba(26,86,219,0.06)',
                borderWidth: 2,
                pointBackgroundColor: '#1a56db',
                pointRadius: 4,
                fill: true, tension: 0.3,
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 10 } } },
                y: { grid: { color: '#f1f5f9' }, ticks: { font: { size: 10 } } }
            }
        }
    });
}

// Real charts from server
@foreach($chartData ?? [] as $stat)
(function() {
    const canvas = document.getElementById('chart-{{ $stat->id }}');
    if (!canvas) return;
    new Chart(canvas.getContext('2d'), {
        type: 'line',
        data: {
            labels: {!! json_encode($stat->values->sortBy('year')->pluck('year')) !!},
            datasets: [{
                data: {!! json_encode($stat->values->sortBy('year')->pluck('value')) !!},
                borderColor: '#1a56db',
                backgroundColor: 'rgba(26,86,219,0.06)',
                borderWidth: 2, pointBackgroundColor: '#1a56db',
                pointRadius: 4, fill: true, tension: 0.3,
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 10 } } },
                y: { grid: { color: '#f1f5f9' }, ticks: { font: { size: 10 } } }
            }
        }
    });
})();
@endforeach

// Charts carousel
let chartIdx = 0;
const chartsTrack = document.getElementById('chartsTrack');
const cards = chartsTrack.querySelectorAll('.chart-card');
const perView = 3;
const maxIdx = Math.max(0, cards.length - perView);
const dotsEl = document.getElementById('chartDots');

for (let i = 0; i <= maxIdx; i++) {
    const d = document.createElement('button');
    d.className = 'chart-dot' + (i === 0 ? ' active' : '');
    d.onclick = () => moveCharts(i);
    dotsEl.appendChild(d);
}

function moveCharts(n) {
    chartIdx = Math.max(0, Math.min(n, maxIdx));
    const cardW = cards[0] ? cards[0].offsetWidth + 24 : 404;
    chartsTrack.style.transform = `translateX(-${chartIdx * cardW}px)`;
    dotsEl.querySelectorAll('.chart-dot').forEach((d, i) => d.classList.toggle('active', i === chartIdx));
}
document.getElementById('chartPrev').addEventListener('click', () => moveCharts(chartIdx - 1));
document.getElementById('chartNext').addEventListener('click', () => moveCharts(chartIdx + 1));
</script>
</body>
</html>