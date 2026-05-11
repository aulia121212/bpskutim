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

    {{-- Sisi kiri: ilustrasi lingkaran + floating cards --}}
    <div class="hero-left">

        {{-- Dekorasi bintang --}}
        <span class="hero-star s1"><i class="ti ti-sparkles"></i></span>
        <span class="hero-star s2"><i class="ti ti-sparkles"></i></span>

        {{-- Floating card: kiri atas --}}
        <div class="float-card top-left">
            <!-- <span class="icon">🕙</span> -->

            <i class="ti ti-clock"></i>
            Pilih Waktu<br>Konsultasi
        </div>

        {{-- Floating card: kanan atas --}}
        <div class="float-card top-right">
                        <!-- <span class="icon">🧑🏼‍💼</span> -->

            <i class="ti ti-shield-check"></i>
            Ahli BPS
            <!-- <span class="float-badge"><i class="ti ti-circle-check"></i> Verified</span> -->
        </div>

        {{-- Lingkaran besar dengan ikon headset --}}
        <div class="hero-circle">
            <span class="hero-circle-icon">📈</span>
        </div>

        {{-- Floating card: kiri bawah --}}
        <div class="float-card bot-left">
            <!-- <span class="icon">🆓</span> -->

            <i class="ti ti-cash-off"></i>
            Gratis
        </div>

        {{-- Floating card: kanan bawah --}}
        <div class="float-card bot-right">
                        <!-- <span class="icon">💻</span> -->

            <i class="ti ti-device-laptop"></i>
            Konsultasi<br>Online Tersedia
        </div>
    </div>

    {{-- Sisi kanan: card konten teks --}}
    <div class="hero-right">
        <div class="hero-content-card">
            <h1 class="hero-title">
                <!-- Layanan <em>Konsultasi</em> Statistik -->
                Layanan Konsultasi Statistik

            </h1>
            <p class="hero-desc">
                Dapatkan wawasan mendalam langsung dari <strong>Statistisi Ahli BPS</strong>.
                Kami membantu Anda memecahkan kompleksitas data lebih tepat.
            </p>
            <div class="hero-mini-features">
                <div class="hero-mini-feature">
                    <i class="ti ti-users"></i>
                    <span>Konsultasi langsung dengan statistikawan berpengalaman</span>
                </div>
                <div class="hero-mini-feature">
                    <i class="ti ti-calendar-time"></i>
                    <span>Jadwal fleksibel sesuai kebutuhan Anda</span>
                </div>
            </div>
            <div class="hero-btns">
                <a href="#reservasi" class="btn-primary">
                    <i class="ti ti-sparkles"></i> Mulai Konsultasi
                </a>
                <a href="#cara" class="btn-secondary">
                    Pelajari Lebih Lanjut <i class="ti ti-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

</section>

<!-- CARA RESERVASI -->
<section class="cara-section" id="cara">
    <h2 class="section-title">Alur Reservasi Mudah</h2>
    <p class="section-sub">
        Empat langkah sederhana untuk mendapatkan bantuan konsultasi data profesional secara gratis.
    </p>

    <div class="steps-grid">
        <div class="step-card">
            <div class="step-number-big">1.</div>
            <div class="step-icon-wrap"><i class="ti ti-user-check"></i></div>
            <h4>Pilih Petugas</h4>
            <p>Pilih petugas konsultasi yang sesuai dengan kebutuhan dan bidang data Anda.</p>
        </div>
        <div class="step-card">
            <div class="step-number-big">2.</div>
            <div class="step-icon-wrap"><i class="ti ti-clipboard-list"></i></div>
            <h4>Isi Formulir</h4>
            <p>Isi formulir reservasi lengkap dan tentukan jenis konsultasi Online atau Offline.</p>
        </div>
        <div class="step-card">
            <div class="step-number-big">3.</div>
            <div class="step-icon-wrap"><i class="ti ti-mail-check"></i></div>
            <h4>Tinjau Pengajuan</h4>
            <p>Petugas akan meninjau dan mengirim konfirmasi jadwal melalui WhatsApp Anda.</p>
        </div>
        <div class="step-card">
            <div class="step-number-big">4.</div>
            <div class="step-icon-wrap"><i class="ti ti-video"></i></div>
            <h4>Mulai Sesi</h4>
            <p>Untuk Online, Anda akan menerima link meeting. Offline, datang ke lokasi yang ditentukan.</p>
            <p class="step-note">Pastikan terdaftar dan login terlebih dahulu.</p>
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