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
<section class="publikasi-new">
    <div class="publikasi-new-inner">

        {{-- Badge --}}
        <div class="pub-badge">Publikasi</div>

        {{-- Konten utama: judul kiri + deskripsi & tombol kanan --}}
        <div class="pub-top">
            <div class="pub-left">
                <h2 class="pub-title">
                    <span class="title-main">Publikasi</span><br>
                    <span class="title-main">Badan Pusat Statistik</span><br>
                    <span class="title-accent">Kabupaten</span>
                    <span class="title-accent">Kutai Timur</span>

                </h2>
            </div>
            <div class="pub-right">
                <p class="pub-desc">
                    Temukan berbagai publikasi statistik resmi yang menyajikan data, analisis,
                    dan informasi terkini sebagai referensi terpercaya untuk memahami
                    perkembangan daerah.
                </p>
                @if($publikasi && $publikasi->link)
                    <a href="{{ $publikasi->link }}" target="_blank" class="btn-outline">
                @else
                    <a href="#" onclick="notifPublikasi()" class="btn-outline">
                @endif
                    <i class="ti ti-link"></i> Akses Publikasi
                    </a>
            </div>
        </div>

        {{-- Gambar penuh lebar --}}
        <div class="pub-image">
            <img src="{{ asset('images/publikasiii.jpeg') }}" alt="Publikasi BPS Kutai Timur">
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

<section class="konsultasi-section">
    <div class="konsultasi-container">

        <div class="konsultasi-content">
            <h2 class="banner-title">
                <span class="title-main">Tidak Menemukan</span><br>
                <span class="title-accent">Data yang Dicari?</span>
            </h2>

            <div class="divider"></div>

            <a href="/konsultasi" class="btn-konsultasi">
                <i class="ti ti-message-circle"></i>
                Hubungi Layanan Konsultasi
            </a>
        </div>

        <div class="konsultasi-image-grid">
            <div class="grid-bento">
                <div class="item item-top-left">
            <img src="{{ asset('images/pelayanan_1.jpeg') }}" alt="Foto 1">
        </div>

        <div class="item item-right">
            <img src="{{ asset('images/pelayanan.jpeg') }}" alt="Foto 2">
        </div>

        <div class="item item-bottom-left">
            <img src="{{ asset('images/pelayanan_2.jpeg') }}" alt="Foto 3">
        </div>
        <div class="item item-bottom-right">
            <img src="{{ asset('images/pelayanan_3.jpeg') }}" alt="Foto 4">
        </div>
    </div>

    <!-- <div class="grid-bento">
                <div class="item item-top-left">
            <img src="{{ asset('images/2.jpeg') }}" alt="Foto 1">
        </div>

        <div class="item item-right">
            <img src="{{ asset('images/1.jpeg') }}" alt="Foto 2">
        </div>

        <div class="item item-bottom-left">
            <img src="{{ asset('images/3.jpeg') }}" alt="Foto 3">
        </div>
        <div class="item item-bottom-right">
            <img src="{{ asset('images/4.jpeg') }}" alt="Foto 4">
        </div>
    </div> -->

</div>

    </div>
</section>

@if(isset($activePopup) && $activePopup)
<div id="popup-overlay"
     style="position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;background:rgba(0,0,0,0.6);backdrop-filter:blur(4px);padding:16px">

    <div style="position:relative;background:#fff;border-radius:20px;overflow:hidden;max-width:480px;width:100%;animation:popupIn .35s ease">

        <img src="{{ asset($activePopup->foto) }}"
             style="width:100%;max-height:70vh;object-fit:contain">

        <button onclick="tutupPopup()"
            style="position:absolute;top:12px;right:12px;background:#fff;border-radius:50%;width:32px;height:32px;border:none;cursor:pointer">
            ✕
        </button>

    </div>
</div>
@endif


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

<script>
window.popupData = {
    id: "{{ $activePopup->id ?? '' }}"
};
</script>

<script>
function tutupPopup() {
    const overlay = document.getElementById('popup-overlay');
    if (overlay) {
        overlay.style.display = 'none';
    }
}

// Opsional: Tutup saat klik di luar area gambar
window.onclick = function(event) {
    const overlay = document.getElementById('popup-overlay');
    if (event.target == overlay) {
        tutupPopup();
    }
}
</script>

<!-- <script>
function notifPublikasi() {
    alert('Publikasi belum tersedia');
}
</script> -->

<script>
function notifPublikasi() {
    const toast = document.createElement('div');
    toast.innerText = 'Publikasi belum tersedia';
    toast.style.position = 'fixed';
    toast.style.bottom = '20px';
    toast.style.right = '20px';
    toast.style.background = '#f59e0b';
    toast.style.color = '#fff';
    toast.style.padding = '10px 16px';
    toast.style.borderRadius = '8px';
    toast.style.boxShadow = '0 4px 10px rgba(0,0,0,0.2)';
    toast.style.zIndex = '9999';

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 2500);
}
</script>

<script src="{{ asset('js/home.js') }}"></script>

</body>
</html>