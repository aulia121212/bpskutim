<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konsultasi Statistik - BPS Kabupaten Kutai Timur</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Nunito+Sans:ital,wght@1,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/konsultasi.css') }}">
</head>
<body>

@include('partials.navbar')

<!-- HERO -->
<section class="hero">
    <div class="hero-left">
        <div style="position:relative">
            <div class="hero-tag-left">
                <i class="ti ti-clock"></i> Pilih Waktu Konsultasi
            </div>
            <div class="hero-card" style="margin-top:20px">
                <div class="hero-card-badge">
                    <i class="ti ti-circle-check"></i> Online
                </div>
                <div class="hero-card-avatar">🧑‍💼</div>
                <p class="fw-bold">Ahli BPS</p>
                <p class="text-muted">Statistikawan Berpengalaman</p>
                <div class="hero-card-label">
                    <i class="ti ti-circle-dot"></i> Konsultasi Online Tersedia
                </div>
            </div>
        </div>
    </div>

    <div class="hero-right">
        <h1 class="hero-title">Layanan Konsultasi<br>Statistik</h1>
        <p class="hero-desc">
            BPS Kabupaten Kutai Timur menyediakan <strong>layanan konsultasi bersama Statistisi Ahli</strong>
            untuk membantu masyarakat dalam memahami data statistik.
        </p>
        <div class="hero-btns">
            <a href="#reservasi" class="btn-primary">Mulai Konsultasi</a>
            <a href="#cara" class="btn-secondary">Pelajari</a>
        </div>
    </div>
</section>

<!-- CARA -->
<section class="cara-section" id="cara">
    <h2 class="section-title">Cara Reservasi</h2>
    <p class="section-sub">
        Silakan <a href="{{ route('login') }}">login</a> atau
        <a href="{{ route('register') }}">daftar</a> terlebih dahulu.
    </p>
</section>

<!-- PETUGAS -->
<section class="reservasi-section" id="reservasi">
    <h2 class="section-title">Reservasi Konsultasi</h2>

    <div class="petugas-grid">
        @forelse($petugas as $p)
        <div class="petugas-card">
            <div class="petugas-header">
                <div class="petugas-avatar">
                    @if($p->foto)
                        <img src="{{ asset($p->foto) }}" alt="{{ $p->nama_lengkap }}">
                    @else
                        🧑‍💼
                    @endif
                </div>
                <div>
                    <div class="petugas-name">{{ $p->nama_lengkap }}</div>
                    <div class="petugas-instansi">BPS Kutai Timur</div>
                    <div class="petugas-role">{{ $p->jabatan }}</div>
                </div>
            </div>

           <div class="petugas-tags">
    @foreach($p->bidang_keahlian ?? [] as $tag)
        <span class="petugas-tag">{{ $tag }}</span>
    @endforeach
</div>

            <a href="{{ route('konsultasi.reservasi', $p->id) }}" class="btn-reservasi">
                Buat Reservasi
            </a>
        </div>
        @empty
        <p style="text-align:center;color:#64748b;padding:40px 0;">
            Belum ada petugas tersedia.
        </p>
        @endforelse
    </div>

    <div style="margin-top:20px">
        {{ $petugas->links() }}
    </div>
</section>

@include('partials.footer')

<script src="{{ asset('js/konsultasi.js') }}"></script>
</body>
</html>