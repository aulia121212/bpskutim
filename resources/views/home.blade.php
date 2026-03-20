<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BPS Kabupaten Kutai Timur</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Nunito+Sans:ital,wght@1,800&display=swap" rel="stylesheet">
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

        /* HERO SLIDER */
        .hero { margin-top: 68px; position: relative; overflow: hidden; }
        .slider-track { display: flex; transition: transform .5s ease; }
        .slide {
            min-width: 100%; padding: 80px;
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

        @keyframes fadeUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .fade-up   { animation: fadeUp .6s ease forwards; }
        .fade-up-2 { animation: fadeUp .6s .15s ease both; }
        .fade-up-3 { animation: fadeUp .6s .3s ease both; }
    </style>
</head>
<body>

{{-- Navbar --}}
@include('partials.navbar')

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
                    <a href="/konsultasi" class="btn-hero"><i class="ti ti-headset"></i> Mulai Konsultasi</a>
                </div>
                <div class="slide-image fade-up-2">
                    <div style="width:380px;height:280px;background:linear-gradient(135deg,#dbeafe,#bfdbfe);border-radius:24px;display:flex;align-items:center;justify-content:center">
                        <i class="ti ti-chart-line" style="font-size:80px;color:#1a56db;opacity:.5"></i>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="slide" style="background:linear-gradient(135deg,#f0fdf4,#ecfdf5)">
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
            <div class="slide" style="background:linear-gradient(135deg,#fef9f0,#fef3c7)">
                <div class="slide-content">
                    <span class="slide-tag" style="background:#fef9c3;color:#ca8a04">Publikasi Resmi</span>
                    <h1 class="slide-title">Publikasi <em style="color:#ca8a04">BPS</em><br>Kutai Timur</h1>
                    <p class="slide-desc">Temukan berbagai publikasi statistik resmi yang menyajikan data, analisis, dan informasi terkini sebagai referensi terpercaya.</p>
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
        <h2 class="publikasi-title"><em>Publikasi</em>BPS Kutai Timur</h2>
        <p class="publikasi-desc">Temukan berbagai publikasi statistik resmi yang menyajikan data, analisis, dan informasi terkini sebagai referensi terpercaya untuk memahami perkembangan daerah.</p>
        <a href="/publikasi" class="btn-outline"><i class="ti ti-link"></i> Akses Publikasi</a>
    </div>
    <div class="publikasi-img">
        <div style="width:420px;height:320px;background:linear-gradient(135deg,#dbeafe,#bfdbfe);border-radius:24px;display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden">
            <i class="ti ti-books" style="font-size:100px;color:#1a56db;opacity:.35;position:relative;z-index:1"></i>
        </div>
    </div>
</section>

<!-- DATA TERBARU -->
<section class="data-section">
    <div class="section-header">
        <h2 class="section-title">Data<br><em>Terbaru</em></h2>
        <a href="/data-statistik" class="btn-search"><i class="ti ti-search"></i> Jelajahi Data Sekarang</a>
    </div>
    <div class="charts-slider">
        <div class="charts-track" id="chartsTrack">
            @php $chartData = $statistics ?? collect(); @endphp
            @forelse($chartData as $stat)
            <div class="chart-card">
                <div class="chart-card-title">{{ $stat->judul_data }}</div>
                <div class="chart-card-sub">{{ $stat->wilayah_data }} · Update: {{ $stat->updated_at?->format('F Y') }}</div>
                <div style="height:180px"><canvas id="chart-{{ $stat->id }}"></canvas></div>
            </div>
            @empty
            @for($i = 0; $i < 3; $i++)
            <div class="chart-card">
                <div class="chart-card-title">Persentase Penduduk Miskin di Kab. Kutai Timur 2018–2024</div>
                <div class="chart-card-sub">Kutai Timur · Update Terakhir: Desember 2024</div>
                <div style="height:180px"><canvas id="demo-chart-{{ $i }}"></canvas></div>
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
        <a href="/konsultasi" class="btn-konsultasi"><i class="ti ti-message-circle"></i> Hubungi Layanan Konsultasi</a>
    </div>
    <div>
        @if($activeBanner)
        <img src="{{ asset($activeBanner->foto) }}" alt="Konsultasi" style="width:300px;border-radius:16px">
        @else
        <div style="width:300px;height:220px;background:linear-gradient(135deg,#bfdbfe,#93c5fd);border-radius:20px;display:flex;align-items:center;justify-content:center">
            <i class="ti ti-users" style="font-size:80px;color:#1a56db;opacity:.5"></i>
        </div>
        @endif
    </div>
</div>

{{-- Footer --}}
@include('partials.footer')

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
const demoLabels   = [2018,2019,2020,2021,2022,2023,2024];
const demoDatasets = [[9.28,9.51,9.65,9.91,9.38,8.78,8.61],[8.5,8.9,9.2,9.5,9.1,8.8,8.3],[7.8,8.1,8.4,8.7,8.5,8.2,7.9]];

for (let i = 0; i < 3; i++) {
    const canvas = document.getElementById(`demo-chart-${i}`);
    if (!canvas) continue;
    new Chart(canvas.getContext('2d'), {
        type: 'line',
        data: { labels: demoLabels, datasets: [{ data: demoDatasets[i], borderColor: '#1a56db', backgroundColor: 'rgba(26,86,219,0.06)', borderWidth: 2, pointBackgroundColor: '#1a56db', pointRadius: 4, fill: true, tension: 0.3 }] },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { x: { grid: { display: false }, ticks: { font: { size: 10 } } }, y: { grid: { color: '#f1f5f9' }, ticks: { font: { size: 10 } } } } }
    });
}

// Real charts
@foreach($chartData ?? [] as $stat)
(function() {
    const canvas = document.getElementById('chart-{{ $stat->id }}');
    if (!canvas) return;
    new Chart(canvas.getContext('2d'), {
        type: 'line',
        data: { labels: {!! json_encode($stat->values->sortBy('year')->pluck('year')) !!}, datasets: [{ data: {!! json_encode($stat->values->sortBy('year')->pluck('value')) !!}, borderColor: '#1a56db', backgroundColor: 'rgba(26,86,219,0.06)', borderWidth: 2, pointBackgroundColor: '#1a56db', pointRadius: 4, fill: true, tension: 0.3 }] },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { x: { grid: { display: false }, ticks: { font: { size: 10 } } }, y: { grid: { color: '#f1f5f9' }, ticks: { font: { size: 10 } } } } }
    });
})();
@endforeach

// Charts carousel
let chartIdx = 0;
const chartsTrack = document.getElementById('chartsTrack');
const chartCards  = chartsTrack.querySelectorAll('.chart-card');
const perView     = 3;
const maxIdx      = Math.max(0, chartCards.length - perView);
const dotsEl      = document.getElementById('chartDots');

for (let i = 0; i <= maxIdx; i++) {
    const d = document.createElement('button');
    d.className = 'chart-dot' + (i === 0 ? ' active' : '');
    d.onclick = () => moveCharts(i);
    dotsEl.appendChild(d);
}

function moveCharts(n) {
    chartIdx = Math.max(0, Math.min(n, maxIdx));
    const cardW = chartCards[0] ? chartCards[0].offsetWidth + 24 : 404;
    chartsTrack.style.transform = `translateX(-${chartIdx * cardW}px)`;
    dotsEl.querySelectorAll('.chart-dot').forEach((d, i) => d.classList.toggle('active', i === chartIdx));
}
document.getElementById('chartPrev').addEventListener('click', () => moveCharts(chartIdx - 1));
document.getElementById('chartNext').addEventListener('click', () => moveCharts(chartIdx + 1));
</script>
</body>
</html>