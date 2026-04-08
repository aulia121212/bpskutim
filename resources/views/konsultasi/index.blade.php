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
                <p style="font-weight:700;margin-bottom:4px">Ahli BPS</p>
                <p style="color:#64748b;font-size:13px">Statistikawan Berpengalaman</p>
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
            untuk membantu masyarakat, instansi, akademisi, dan pelaku usaha dalam memahami data statistik secara benar.
        </p>
        <div class="hero-features">
            <div class="hero-feature">
                <div class="hero-feature-icon"><i class="ti ti-messages"></i></div>
                <div>
                    <h4>Bicara dengan Ahli</h4>
                    <p>Konsultasi langsung dengan statistikawan berpengalaman di bidangnya.</p>
                </div>
            </div>
            <div class="hero-feature">
                <div class="hero-feature-icon"><i class="ti ti-calendar-time"></i></div>
                <div>
                    <h4>Jadwal Fleksibel</h4>
                    <p>Pilih waktu konsultasi yang paling sesuai dengan waktu Anda.</p>
                </div>
            </div>
        </div>
        <div class="hero-btns">
            <a href="#reservasi" class="btn-primary">
                <i class="ti ti-calendar-plus"></i> Mulai Konsultasi
            </a>
            <a href="#cara" class="btn-secondary">Pelajari Lebih Lanjut</a>
        </div>
    </div>
</section>

<!-- CARA RESERVASI -->
<section class="cara-section" id="cara">
    <h2 class="section-title">Cara Melakukan Reservasi Konsultasi</h2>
    <p class="section-sub">
        Pengguna <strong>wajib</strong> memiliki akun untuk dapat mengisi formulir.
        Silakan <a href="{{ route('login') }}">login/masuk</a> atau
        <a href="{{ route('register') }}">daftar</a> terlebih dahulu.
    </p>
    <div style="text-align:center;margin-bottom:48px">
        <a href="#reservasi" class="btn-konsultasi-sm">
            <i class="ti ti-arrow-right"></i> Mulai Konsultasi
        </a>
    </div>

    <div class="steps-grid">
        <div class="step-card">
            <div class="step-number">1</div>
            <span class="step-icon">🧑‍💼</span>
            <p>Pilih petugas konsultasi yang sesuai dengan kebutuhan Anda.</p>
        </div>
        <div class="step-card">
            <div class="step-number">2</div>
            <span class="step-icon">📋</span>
            <p>Isi formulir reservasi dan tentukan jenis konsultasi (Online atau Offline).</p>
        </div>
        <div class="step-card">
            <div class="step-number">3</div>
            <span class="step-icon">📱</span>
            <p>Petugas akan meninjau pengajuan Anda dan mengirimkan konfirmasi jadwal melalui nomor WhatsApp yang terdaftar.</p>
        </div>
        <div class="step-card">
            <div class="step-number">4</div>
            <span class="step-icon">💻</span>
            <p>Jika memilih <strong>Online</strong>, Anda akan menerima link meeting melalui WhatsApp.</p>
            <p class="step-note">Jika memilih <strong>Offline</strong>, silahkan datang ke lokasi yang telah ditentukan sesuai jadwal.</p>
        </div>
    </div>
</section>

<!-- RESERVASI PETUGAS -->
<section class="reservasi-section" id="reservasi">
    <div class="reservasi-header">
        <div>
            <h2 class="section-title" style="margin-bottom:8px">Reservasi Konsultasi</h2>
            <p class="section-sub" id="reservasiSub" style="margin:0">
                Pilih petugas konsultasi berdasarkan bidang keahlian yang sesuai dengan topik konsultasi Anda untuk mendapatkan pelayanan yang maksimal.
            </p>
        </div>
    </div>

    <div class="petugas-grid" id="petugasGrid">
        @forelse($petugas as $p)
        <div class="petugas-card"
             data-keahlian="{{ implode('|', $p->bidang_keahlian ?? []) }}">
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
        <p style="text-align:center;color:#64748b;padding:40px 0;grid-column:1/-1">
            Belum ada petugas tersedia.
        </p>
        @endforelse
    </div>

    <!-- Empty state filter -->
    <div class="filter-empty" id="filterEmpty">
        <i class="ti ti-search-off"></i>
        <p>Tidak ada petugas untuk topik <strong id="filterEmptyTopik"></strong></p>
        <button onclick="hapusFilter()">Lihat semua petugas</button>
    </div>

    <div id="paginasiWrap" style="margin-top:20px">
        {{ $petugas->links() }}
    </div>
</section>

<!-- TOPIK KONSULTASI -->
@php
$semuaTopik = [
    ['file' => '1_pelayanan_umu.png',                        'label' => 'Pelayanan Umum'],
    ['file' => '2_pembeliandata.png',                        'label' => 'Pembelian Data Mikro'],
    ['file' => '3_potensidesa.png',                          'label' => 'Potensi Desa'],
    ['file' => '4_kependudukan.png',                         'label' => 'Kependudukan'],
    ['file' => '5_tenagaKerja.png',                          'label' => 'Tenaga Kerja'],
    ['file' => '6_pertumbuhanEkonomi.png',                   'label' => 'Pertumbuhan Ekonomi'],
    ['file' => '7_ekspor_impor.png',                         'label' => 'Ekspor-Impor'],
    ['file' => '8_konsumsi.png',                             'label' => 'Konsumsi'],
    ['file' => '9_pertanian_peternakan_perikanan.png',        'label' => 'Pertanian, Peternakan, dan Perikanan'],
    ['file' => '10_statistik_industri.png',                  'label' => 'Statistik Industri'],
    ['file' => '11_indeks_pembangunan_manusia.png',           'label' => 'Indeks Pembangunan Manusia'],
    ['file' => '12_pertambangan_energi_danKonstruksi.png',   'label' => 'Pertambangan, Energi, dan Konstruksi'],
    ['file' => '13_bigData.png',                             'label' => 'Big Data'],
    ['file' => '14_nilaiTukarTani.png',                      'label' => 'Nilai Tukar Petani'],
    ['file' => '15_kemiskinan.png',                          'label' => 'Kemiskinan'],
    ['file' => '16_statistikSektoral.png',                   'label' => 'Statistik Sektoral'],
    ['file' => '17_sainsData.png',                           'label' => 'Sains Data'],
    ['file' => '18_pariwisata.png',                          'label' => 'Pariwisata'],
    ['file' => '19_harga_danInflasi.png',                    'label' => 'Harga & Inflasi'],
    ['file' => '20_demokrasi_dan_kriminalitas.png',          'label' => 'Demokrasi dan Kriminalitas'],
    ['file' => '21_logo_ppid.png',                           'label' => 'Layanan Pengaduan'],
    ['file' => '21_logo_ppid.png',                           'label' => 'Petugas PPID'],
];
@endphp

<section class="topik-section" id="topik">
    <div class="topik-header">
        <div>
            <h2 class="section-title" style="margin-bottom:8px">Topik Konsultasi</h2>
            <p class="section-sub" style="margin:0">
                Klik salah satu kategori untuk memudahkan Anda dalam menemukan petugas yang sesuai dengan permasalahan Anda.
            </p>
        </div>
        <button class="btn-hapus-filter" id="btnHapusFilter" onclick="hapusFilter()" style="display:none">
            <i class="ti ti-filter-off"></i> Hapus Filter
        </button>
    </div>

    <div class="topik-grid">
        @foreach($semuaTopik as $topik)
        <button class="topik-item" data-topik="{{ $topik['label'] }}" onclick="filterTopik(this)">
            <div class="topik-icon">
                <img src="{{ asset('images/logo_topik_konsultasi/' . $topik['file']) }}"
                     alt="{{ $topik['label'] }}"
                     loading="lazy">
            </div>
            <span class="topik-label">{{ $topik['label'] }}</span>
        </button>
        @endforeach
    </div>
</section>

@include('partials.footer')

<script src="{{ asset('js/konsultasi.js') }}"></script>
</body>
</html>