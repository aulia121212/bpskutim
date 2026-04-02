{{-- resources/views/data-statistik/show.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $stat->judul_data }} - BPS Kabupaten Kutai Timur</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #1a3a6b;
            --accent:  #0e7fd4;
            --accent-soft: #e8f4fd;
            --text:    #1a1a2e;
            --muted:   #6b7280;
            --border:  #e5e9f0;
            --bg:      #f8fafc;
            --white:   #ffffff;
            --shadow:  0 2px 12px rgba(26,58,107,.08);
            --radius:  16px;
        }
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Plus Jakarta Sans',sans-serif; background:var(--bg); color:var(--text); }

        /* Breadcrumb */
        .breadcrumb { padding:20px 40px; font-size:13px; color:var(--muted); }
        .breadcrumb a { color:var(--accent); text-decoration:none; }
        .breadcrumb a:hover { text-decoration:underline; }
        .breadcrumb span { margin:0 6px; }

        /* Tab bar */
        .tab-bar { display:flex; align-items:center; gap:8px; padding:0 40px 20px; }
        .tab-btn {
            display:inline-flex; align-items:center; gap:8px;
            padding:10px 20px; border-radius:12px;
            font-family:'Plus Jakarta Sans',sans-serif; font-size:14px; font-weight:600;
            cursor:pointer; border:1.5px solid var(--border); background:var(--white);
            color:var(--muted); transition:all .2s; text-decoration:none;
        }
        .tab-btn.active { background:var(--primary); border-color:var(--primary); color:#fff; }
        .tab-btn:hover:not(.active) { border-color:var(--accent); color:var(--accent); }
        .spacer { flex:1; }
        .interpretasi-link {
            padding:10px 24px; border-radius:12px; border:1.5px solid var(--border);
            background:var(--white); font-family:'Plus Jakarta Sans',sans-serif;
            font-size:14px; font-weight:600; color:var(--text); cursor:pointer;
            transition:all .2s; text-decoration:none; display:inline-block;
        }
        .interpretasi-link:hover { border-color:var(--accent); color:var(--accent); }

        /* Main layout */
        .main-wrap { display:flex; gap:24px; padding:0 40px 40px; align-items:flex-start; }
        .left-panel { flex:1; min-width:0; display:flex; flex-direction:column; gap:16px; }

        /* Chart card */
        .card {
            background:var(--white); border:1px solid var(--border);
            border-radius:var(--radius); box-shadow:var(--shadow);
        }
        .card-body { padding:24px 28px; }

        /* Tab views */
        .hidden { display:none !important; }

        /* Chart */
        #chart-header { margin-bottom:4px; }
        #chart-title  { font-size:14px; font-weight:700; color:var(--text); }
        #chart-subtitle { font-size:12px; color:var(--muted); margin-top:2px; }
        .chart-canvas-wrap { position:relative; height:320px; margin-top:16px; }

        /* Table */
        .table-top { display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; }
        .table-top h3 { font-size:14px; font-weight:600; color:var(--text); }
        .dl-btn {
            display:inline-flex; align-items:center; gap:6px;
            padding:6px 14px; font-size:12px; font-weight:600;
            color:var(--accent); background:#eff6ff; border-radius:8px;
            border:none; cursor:pointer; transition:background .2s;
        }
        .dl-btn:hover { background:var(--accent-soft); }
        .overflow-x { overflow-x:auto; }
        #data-table { width:100%; border-collapse:collapse; font-size:13px; }
        #data-table th { padding:12px 16px; text-align:left; font-weight:700; color:var(--accent); border-bottom:1px solid var(--border); }
        #data-table td { padding:10px 16px; border-bottom:1px solid #f3f4f6; }
        #data-table tr:hover td { background:#f8fafc; }

        /* Interpretasi section */
        #interpretasi-section { display:flex; flex-direction:column; gap:12px; }

        /* Tren card */
        #tren-card { display:flex; align-items:center; justify-content:space-between; gap:16px; padding:20px; border-radius:var(--radius); border:1px solid var(--border); }

        /* Interpretasi card */
        #interpretasi-card { border-radius:var(--radius); border:1px solid var(--border); padding:20px; }
        .interp-inner { display:flex; align-items:flex-start; gap:12px; }
        #interpretasi-icon-wrap { flex-shrink:0; width:32px; height:32px; border-radius:10px; display:flex; align-items:center; justify-content:center; margin-top:2px; }

        /* Right sidebar */
        .filter-sidebar {
            width:260px; flex-shrink:0;
            background:var(--white); border:1px solid var(--border);
            border-radius:var(--radius); box-shadow:var(--shadow);
            padding:20px; position:sticky; top:20px;
            display:flex; flex-direction:column; gap:20px;
        }
        .filter-sidebar h3 { font-size:14px; font-weight:700; color:var(--text); }
        .filter-group { display:flex; flex-direction:column; gap:8px; }
        .filter-label { font-size:13px; font-weight:700; color:var(--accent); }
        .filter-opts  { display:flex; flex-direction:column; gap:6px; }
        .filter-opts p { font-size:12px; color:var(--muted); }

        .check-row, .radio-row {
            display:flex; align-items:center; gap:8px;
            font-size:13px; color:#4b5563; cursor:pointer;
        }
        .check-row input, .radio-row input { accent-color:var(--primary); cursor:pointer; }

        .pratinjau-btn {
            width:100%; display:flex; align-items:center; justify-content:center; gap:8px;
            padding:11px; background:var(--primary); color:#fff; border:none;
            border-radius:10px; font-family:'Plus Jakarta Sans',sans-serif;
            font-size:14px; font-weight:700; cursor:pointer; transition:background .2s;
        }
        .pratinjau-btn:hover { background:#2a55a0; }

        /* Pair cards */
        .pair-card { border-radius:12px; padding:16px; margin-bottom:10px; }
        .pair-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:12px; }
        .pair-badge { display:inline-flex; align-items:center; gap:4px; font-size:11px; font-weight:700; padding:3px 10px; border-radius:8px; }
        .pair-values { display:flex; align-items:center; justify-content:space-between; margin-bottom:12px; }
        .pair-val-box { text-align:center; }
        .pair-val-box .pv-year { font-size:11px; color:var(--muted); margin-bottom:2px; }
        .pair-val-box .pv-num  { font-size:22px; font-weight:900; color:var(--text); }
        .pair-mid { display:flex; flex-direction:column; align-items:center; gap:2px; padding:0 12px; }
        .pair-mid i   { font-size:24px; }
        .pair-mid .pm-delta { font-size:13px; font-weight:700; }
        .pair-mid .pm-pct   { font-size:11px; }
        .pair-info { display:flex; align-items:flex-start; gap:10px; padding:10px 12px; border-radius:10px; }
        .pair-info-icon { flex-shrink:0; width:24px; height:24px; border-radius:8px; display:flex; align-items:center; justify-content:center; margin-top:1px; }
        .pair-info p { font-size:12px; color:#4b5563; line-height:1.6; }

        /* Separator */
        .section-sep { display:flex; align-items:center; gap:12px; margin:8px 0; }
        .section-sep .sep-line { flex:1; height:1px; background:var(--border); }
        .section-sep span { font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:.05em; white-space:nowrap; }

        /* Perbandingan wilayah */
        #interpretasi-wilayah { border-radius:var(--radius); border:1px solid var(--border); padding:20px; }
        .comp-table { width:100%; border-collapse:collapse; font-size:12px; margin-bottom:12px; }
        .comp-table th { padding:8px 12px; font-weight:700; text-align:left; border-bottom:1px solid var(--border); }
        .comp-table td { padding:8px 12px; border-bottom:1px solid #f3f4f6; }
        .comp-table tr:hover td { background:#f8fafc; }
        .comp-grid { display:grid; grid-template-columns:1fr 1fr; gap:8px; }
        .comp-box  { padding:8px 10px; border-radius:8px; font-size:11px; }
        .comp-box .cb-label { font-weight:700; margin-bottom:2px; }
        .comp-box .cb-val   { font-size:13px; font-weight:600; color:var(--text); }

        @media(max-width:900px) {
            .main-wrap { flex-direction:column; }
            .filter-sidebar { width:100%; position:static; }
            .breadcrumb, .tab-bar, .main-wrap { padding-left:16px; padding-right:16px; }
        }
    </style>
</head>
<body>

@include('partials.navbar')

{{-- Breadcrumb --}}
<div class="breadcrumb">
    <a href="{{ route('data-statistik.index') }}">Data Statistik</a>
    <span>›</span>
    <a href="{{ route('data-statistik.indikator', $slug) }}">{{ $stat->indikator_data }}</a>
    <span>›</span>
    <strong>{{ $stat->judul_data }}</strong>
</div>

{{-- Tab Bar --}}
<div class="tab-bar">
    <button class="tab-btn active" id="tab-grafik" onclick="switchTab('grafik')">
        <i class="ti ti-chart-line"></i> Grafik
    </button>
    <button class="tab-btn" id="tab-tabel" onclick="switchTab('tabel')">
        <i class="ti ti-table"></i> Tabel
    </button>
    <span class="spacer"></span>
    <a href="#interpretasi-section" class="interpretasi-link" onclick="scrollToInterp(event)">Lihat Interpretasi</a>
</div>

{{-- Main --}}
<div class="main-wrap">

    {{-- Left panel --}}
    <div class="left-panel">

        {{-- Chart / Table card --}}
        <div class="card">
            <div class="card-body">

                {{-- Grafik view --}}
                <div id="view-grafik">
                    <div id="chart-header">
                        <h2 id="chart-title">-</h2>
                        <p id="chart-subtitle">-</p>
                    </div>
                    <div class="chart-canvas-wrap">
                        <canvas id="mainChart"></canvas>
                    </div>
                </div>

                {{-- Tabel view --}}
                <div id="view-tabel" class="hidden">
                    <div class="table-top">
                        <h3>Data Tabel</h3>
                        <button class="dl-btn" onclick="downloadTable()">
                            <i class="ti ti-download"></i> Download CSV
                        </button>
                    </div>
                    <div class="overflow-x">
                        <table id="data-table">
                            <thead id="table-head"></thead>
                            <tbody id="table-body">
                                <tr><td colspan="5" style="text-align:center;padding:32px;color:var(--muted)">Pilih data untuk ditampilkan</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        {{-- Interpretasi section --}}
        <div id="interpretasi-section" class="hidden" style="display:none">

            {{-- Tren card --}}
            <div id="tren-card" class="hidden card" style="display:none">
                <div class="card-body" style="display:flex;align-items:center;justify-content:space-between;gap:16px">
                    <div style="text-align:center">
                        <p id="tren-tahun-awal" style="font-size:11px;color:var(--muted);margin-bottom:4px">-</p>
                        <p id="tren-nilai-awal" style="font-size:28px;font-weight:900;color:var(--text)">-</p>
                    </div>
                    <div style="display:flex;flex-direction:column;align-items:center;gap:4px">
                        <i id="tren-icon" class="ti ti-minus" style="font-size:28px;color:var(--muted)"></i>
                        <span id="tren-label" style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:var(--muted)">-</span>
                        <span id="tren-selisih" style="font-size:11px;font-weight:600;color:var(--muted)">-</span>
                    </div>
                    <div style="text-align:center">
                        <p id="tren-tahun-akhir" style="font-size:11px;color:var(--muted);margin-bottom:4px">-</p>
                        <p id="tren-nilai-akhir" style="font-size:28px;font-weight:900;color:var(--text)">-</p>
                    </div>
                </div>
            </div>

            {{-- Interpretasi card --}}
            <div id="interpretasi-card" class="card hidden" style="display:none">
                <div class="card-body interp-inner">
                    <div id="interpretasi-icon-wrap">
                        <i id="interpretasi-icon" class="ti ti-equal" style="font-size:16px;color:var(--muted)"></i>
                    </div>
                    <div style="flex:1">
                        <p id="interpretasi-label" style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.05em;margin-bottom:8px;color:var(--muted)">Interpretasi</p>
                        <p id="interpretasi-teks" style="font-size:13px;color:#374151;line-height:1.7">-</p>
                    </div>
                </div>
            </div>

            {{-- Pair cards --}}
            <div id="interpretasi-pairs"></div>

            {{-- Perbandingan wilayah --}}
            <div id="interpretasi-wilayah" class="card hidden" style="display:none">
                <div class="card-body"></div>
            </div>

            {{-- Interpretasi tabel per komponen --}}
            <div id="interpretasi-tabel-komponen" class="hidden" style="display:none;flex-direction:column;gap:12px"></div>

        </div>
    </div>

    {{-- Right: Filter Sidebar --}}
    <div class="filter-sidebar">
        <h3>Sesuaikan tampilan grafik</h3>

        {{-- Wilayah --}}
        <div class="filter-group">
            <div class="filter-label">Wilayah data</div>
            <div class="filter-opts" id="filter-wilayah">
                <p>Memuat...</p>
            </div>
        </div>

        {{-- Komponen/Kategori --}}
        <div class="filter-group" id="filter-kategori-wrap">
            <div class="filter-label">Komponen / Kategori</div>
            <div class="filter-opts" id="filter-kategori">
                <p>Memuat...</p>
            </div>
        </div>

        {{-- Tahun --}}
        <div class="filter-group">
            <div class="filter-label">Tahun data</div>
            <div class="filter-opts" id="filter-tahun">
                <p>Pilih kategori dulu</p>
            </div>
        </div>

        <button class="pratinjau-btn" onclick="applyFilters()">
            <i class="ti ti-search"></i> Pratinjau
        </button>
    </div>

</div>

@include('partials.footer')

{{-- ============================================================
     DATA dari server – di-inject sebagai JS variable
     ============================================================ --}}
<script>
// ── Data dari Eloquent ──────────────────────────────────────────────────
@php
    $sortedValues  = $stat->values->sortBy('year');
    $allWilayahs   = $stat->values->groupBy('wilayah_data')->map(function($group) use ($stat) {
        $sorted = $group->sortBy('year');
        return [
            'wilayah'      => $group->first()->wilayah_data ?? ($stat->wilayah_data ?? 'Kabupaten Kutai Timur'),
            'updated'      => $stat->updated_at?->format('F Y') ?? '-',
            'values'       => $sorted->map(fn($v) => [
                'x_label' => $v->x_label  ?? null,
                'y_label' => $v->y_label  ?? (string)$v->year,
                'year'    => $v->year,
                'value'   => $v->value,
            ])->values()->toArray(),
            'interp_kecil' => $stat->interpretasi_lebih_kecil ?? '',
            'interp_besar' => $stat->interpretasi_lebih_besar ?? '',
            'interp_tetap' => $stat->interpretasi_tetap       ?? '',
        ];
    })->values();

    // Jika tidak ada grup wilayah (kolom wilayah_data di values kosong),
    // buat satu grup dari wilayah_data di tabel statistics/statistictitles
    if ($allWilayahs->isEmpty()) {
        $allWilayahs = collect([[
            'wilayah'      => $stat->wilayah_data ?? 'Kabupaten Kutai Timur',
            'updated'      => $stat->updated_at?->format('F Y') ?? '-',
            'values'       => $sortedValues->map(fn($v) => [
                'x_label' => $v->x_label ?? null,
                'y_label' => $v->y_label ?? (string)$v->year,
                'year'    => $v->year,
                'value'   => $v->value,
            ])->values()->toArray(),
            'interp_kecil' => $stat->interpretasi_lebih_kecil ?? '',
            'interp_besar' => $stat->interpretasi_lebih_besar ?? '',
            'interp_tetap' => $stat->interpretasi_tetap       ?? '',
        ]]);
    }

    $components = $stat->statisticTitle->components ?? collect();
@endphp

const WILAYAH_LIST   = @json($allWilayahs->toArray());
const ALL_COMPONENTS = @json($components instanceof \Illuminate\Support\Collection ? $components->toArray() : (array)$components);
const DATA_JUDUL     = @json($stat->judul_data);
const DATA_INTERP_KECIL = @json($stat->interpretasi_lebih_kecil ?? '');
const DATA_INTERP_BESAR = @json($stat->interpretasi_lebih_besar ?? '');
const DATA_INTERP_TETAP = @json($stat->interpretasi_tetap       ?? '');
</script>

{{-- ============================================================
     LOGIKA GRAFIK — sama persis dengan preview grafik admin
     ============================================================ --}}
<script>
// ── State ──────────────────────────────────────────────────────────────
let chartInstance = null;
let wilayahList   = WILAYAH_LIST;
let allComponents = ALL_COMPONENTS;
let currentData   = {
    judul:       DATA_JUDUL,
    interpKecil: DATA_INTERP_KECIL,
    interpBesar: DATA_INTERP_BESAR,
    interpTetap: DATA_INTERP_TETAP,
};
let currentTab = 'grafik';

const COLORS = [
    { border:'#2563eb', bg:'rgba(37,99,235,.10)' },
    { border:'#dc2626', bg:'rgba(220,38,38,.10)' },
    { border:'#16a34a', bg:'rgba(22,163,74,.10)' },
    { border:'#d97706', bg:'rgba(217,119,6,.10)' },
    { border:'#7c3aed', bg:'rgba(124,58,237,.10)' },
];

// ── Init (otomatis saat load) ──────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function() {
    buildWilayahFilter();
    buildKategoriFilter();
    applyFilters();
});

// ── Tab switch ─────────────────────────────────────────────────────────
function switchTab(tab) {
    currentTab = tab;
    const isG = tab === 'grafik';
    show('view-grafik', isG);
    show('view-tabel', !isG);
    document.getElementById('filter-kategori-wrap').style.display = isG ? '' : 'none';

    document.getElementById('tab-grafik').className = isG
        ? 'tab-btn active' : 'tab-btn';
    document.getElementById('tab-tabel').className = !isG
        ? 'tab-btn active' : 'tab-btn';

    applyFilters();
}

function scrollToInterp(e) {
    e.preventDefault();
    const el = document.getElementById('interpretasi-section');
    if (el) el.scrollIntoView({ behavior:'smooth' });
}

// ── Build filter wilayah ───────────────────────────────────────────────
function buildWilayahFilter() {
    const div = document.getElementById('filter-wilayah');
    div.innerHTML = wilayahList.map((w, wi) => {
        const color = COLORS[wi % COLORS.length].border;
        return `<label class="check-row">
            <input type="checkbox" value="${escH(w.wilayah)}" checked class="wilayah-check" onchange="applyFilters()">
            <span style="width:10px;height:10px;border-radius:50%;background:${color};flex-shrink:0"></span>
            ${escH(w.wilayah)}
        </label>`;
    }).join('');
}

// ── Build filter kategori ──────────────────────────────────────────────
function buildKategoriFilter() {
    const categories = allComponents.length
        ? allComponents.filter(c => !c.is_sub).map(c => c.nama)
        : [...new Set(wilayahList.flatMap(w => w.values.map(v => v.x_label)).filter(Boolean))]
            .filter(n => n && !n.startsWith('· '));

    const div = document.getElementById('filter-kategori');

    if (categories.length > 0) {
        div.innerHTML = `<p style="font-size:11px;color:var(--accent);font-weight:600;margin-bottom:4px">Pilih salah satu ↓</p>`
            + allComponents.map(c => {
                const isSub = c.is_sub || c.nama.startsWith('· ');
                const label = isSub ? c.nama.replace(/^· /, '') : c.nama;
                return `<label class="radio-row" style="${isSub ? 'padding-left:12px;font-style:italic;color:var(--muted)' : ''}">
                    <input type="radio" name="kat_radio" value="${escH(c.nama)}" class="kat-radio" onchange="onKategoriChange()">
                    ${isSub ? '<span style="color:#a5b4fc;margin-right:2px">·</span>' : ''}
                    <span title="${escH(label)}">${escH(label)}</span>
                </label>`;
            }).filter(Boolean).join('');

        buildTahunFilter([...new Set(
            wilayahList.flatMap(w => w.values.map(v => v.y_label || String(v.year))).filter(Boolean)
        )].sort());
        document.querySelectorAll('.tahun-check').forEach(cb => cb.disabled = true);
    } else {
        div.innerHTML = '<p style="font-size:12px;color:var(--muted);font-style:italic">Data tidak memiliki kategori</p>';
        buildTahunFilter([...new Set(
            wilayahList.flatMap(w => w.values.map(v => v.y_label || String(v.year))).filter(Boolean)
        )].sort());
        applyFilters();
    }
}

function onKategoriChange() {
    document.querySelectorAll('.tahun-check').forEach(cb => { cb.disabled = false; cb.checked = true; });
    applyFilters();
}

function buildTahunFilter(years) {
    const div = document.getElementById('filter-tahun');
    if (!years.length) { div.innerHTML = '<p style="font-size:12px;color:var(--muted)">Tidak ada data</p>'; return; }
    div.innerHTML = years.map(y =>
        `<label class="check-row">
            <input type="checkbox" value="${y}" checked class="tahun-check" onchange="applyFilters()"> ${y}
        </label>`
    ).join('');
}

// ── Apply filter & render ──────────────────────────────────────────────
function applyFilters() {
    const selectedCat    = document.querySelector('.kat-radio:checked')?.value ?? null;
    const checkedYears   = [...document.querySelectorAll('.tahun-check:checked')].map(c => c.value);
    const checkedWilayah = [...document.querySelectorAll('.wilayah-check:checked')].map(c => c.value);

    const datasets = [];
    wilayahList.forEach((w, wi) => {
        if (!checkedWilayah.includes(w.wilayah)) return;
        const rows = w.values
            .filter(v => currentTab === 'tabel' || !selectedCat || v.x_label === selectedCat)
            .filter(v => checkedYears.includes(v.y_label || String(v.year)))
            .sort((a,b) => String(a.y_label||a.year).localeCompare(String(b.y_label||b.year)));
        if (!rows.length) return;
        datasets.push({
            wilayah: w.wilayah, updated: w.updated,
            labels:  rows.map(v => v.y_label || String(v.year)),
            values:  rows.map(v => parseFloat(v.value)),
            rawRows: rows,
            color:   COLORS[wi % COLORS.length],
            interp_kecil: w.interp_kecil,
            interp_besar: w.interp_besar,
            interp_tetap: w.interp_tetap,
        });
    });

    if (currentTab === 'grafik') {
        renderChart(datasets, selectedCat);
        renderInterpretasiGrafik(datasets, selectedCat);
    } else {
        renderTable(datasets, selectedCat);
        renderInterpretasiTabel(datasets, selectedCat);
    }
}

// ── Render chart ───────────────────────────────────────────────────────
function renderChart(datasets, kategori) {
    if (!datasets.length) return;
    const katLabel   = kategori ? (kategori.startsWith('· ') ? kategori.slice(2) : kategori) : currentData.judul;
    const wilNames   = datasets.map(d => d.wilayah).join(', ');
    document.getElementById('chart-title').textContent    = currentData.judul + (kategori ? ' — ' + katLabel : '');
    document.getElementById('chart-subtitle').textContent = wilNames + ' · Update Terakhir: ' + datasets[0].updated;

    const allLabels = [...new Set(datasets.flatMap(d => d.labels))].sort();
    if (chartInstance) chartInstance.destroy();
    const ctx = document.getElementById('mainChart').getContext('2d');
    chartInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: allLabels,
            datasets: datasets.map(d => ({
                label: d.wilayah,
                data:  allLabels.map(lbl => { const i = d.labels.indexOf(lbl); return i >= 0 ? d.values[i] : null; }),
                borderColor:          d.color.border,
                backgroundColor:      d.color.bg,
                borderWidth: 2, pointBackgroundColor: d.color.border,
                pointRadius: 5, pointHoverRadius: 7,
                fill: datasets.length === 1, tension: .3, spanGaps: true,
            }))
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: {
                legend: { display: datasets.length > 1, position:'top', labels:{ boxWidth:12, font:{size:11} } },
                tooltip: { mode:'index', intersect:false },
            },
            scales: {
                x: { title:{ display:true, text:'Tahun', font:{size:11} }, grid:{ display:false } },
                y: { title:{ display:true, text:'Nilai',  font:{size:11} }, grid:{ color:'#f3f4f6' } }
            }
        }
    });
}

// ── Interpretasi Grafik ────────────────────────────────────────────────
function renderInterpretasiGrafik(datasets, selectedCat) {
    const section = document.getElementById('interpretasi-section');
    hide('interpretasi-tabel-komponen');

    if (!datasets.length) { hide('interpretasi-section'); return; }

    const komponen = allComponents.find(c => c.nama === selectedCat) || null;

    if (datasets.length === 1) {
        const d = datasets[0];
        if (d.labels.length < 2) { hide('interpretasi-section'); return; }
        showEl('tren-card'); showEl('interpretasi-card'); hide('interpretasi-wilayah');
        renderTrenCard(d.labels, d.values, d, komponen);
        renderPairsForDataset(d.labels, d.values, d, komponen);
    } else {
        hide('tren-card'); hide('interpretasi-card');
        let html = '';
        datasets.forEach((d, i) => {
            if (d.labels.length < 2) return;
            const color = COLORS[i % COLORS.length].border;
            html += `<div class="card" style="padding:16px;display:flex;flex-direction:column;gap:10px">
                <div style="display:flex;align-items:center;gap:8px">
                    <span style="width:12px;height:12px;border-radius:50%;background:${color};flex-shrink:0"></span>
                    <span style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:var(--text)">${escH(d.wilayah)}</span>
                </div>`;
            html += buildTrenMiniCard(d.labels, d.values, d, komponen);
            html += buildPairsHtml(d.labels, d.values, d, komponen);
            html += `</div>`;
        });
        document.getElementById('interpretasi-pairs').innerHTML = html;
        renderPerbandinganWilayahMultiTahun(datasets, selectedCat);
    }

    showEl('interpretasi-section');
}

// ── Tren card utama (1 wilayah) ────────────────────────────────────────
function renderTrenCard(labels, values, dataset, komponen) {
    const vA = values[0], vB = values[values.length-1];
    const sel = vB - vA;
    const tren = sel > 0 ? 'naik' : sel < 0 ? 'turun' : 'tetap';
    const cfg = trenCfg(tren);
    const interp = getInterp(tren, komponen, dataset);

    document.getElementById('tren-tahun-awal').textContent  = 'Tahun ' + labels[0];
    document.getElementById('tren-nilai-awal').textContent  = vA.toFixed(2);
    document.getElementById('tren-tahun-akhir').textContent = 'Tahun ' + labels[labels.length-1];
    document.getElementById('tren-nilai-akhir').textContent = vB.toFixed(2);

    const tc = document.getElementById('tren-card').querySelector('.card-body') || document.getElementById('tren-card');
    setColor(tc, cfg.color, ['border-color', 'background']);

    const ti = document.getElementById('tren-icon');
    ti.className  = `ti ${cfg.icon}`;
    ti.style.color = cfg.hex;

    const tl = document.getElementById('tren-label');
    tl.textContent = cfg.label;
    tl.style.color = cfg.hex;

    const ts = document.getElementById('tren-selisih');
    ts.textContent = cfg.sign + Math.abs(sel).toFixed(2);
    ts.style.color = cfg.hex;

    const ic = document.getElementById('interpretasi-card');
    ic.style.borderColor = cfg.hexLight;
    ic.style.background  = cfg.bg;

    const iw = document.getElementById('interpretasi-icon-wrap');
    iw.style.background = cfg.bgDark;
    const ii = document.getElementById('interpretasi-icon');
    ii.className  = `ti ${cfg.icon}`;
    ii.style.color = cfg.hex;

    const il = document.getElementById('interpretasi-label');
    il.textContent = `Interpretasi Keseluruhan ${labels[0]}–${labels[labels.length-1]}`;
    il.style.color  = cfg.hex;

    document.getElementById('interpretasi-teks').textContent = interp;

    renderPairsForDataset(labels, values, dataset, komponen);
}

// ── Pairs for single dataset ───────────────────────────────────────────
function renderPairsForDataset(labels, values, dataset, komponen) {
    const div = document.getElementById('interpretasi-pairs');
    let html = sep('Perubahan Per Periode');
    for (let i = 0; i < labels.length - 1; i++) {
        html += buildPairCard(labels[i], labels[i+1], values[i], values[i+1], false, labels, values, komponen, dataset);
    }
    if (labels.length > 2) {
        html += sep('Perubahan Total');
        html += buildPairCard(labels[0], labels[labels.length-1], values[0], values[values.length-1], true, labels, values, komponen, dataset);
    }
    div.innerHTML = html;
}

// ── Mini tren card (multi wilayah) ─────────────────────────────────────
function buildTrenMiniCard(labels, values, dataset, komponen) {
    const vA = values[0], vB = values[values.length-1];
    const sel = vB - vA;
    const tren = sel > 0 ? 'naik' : sel < 0 ? 'turun' : 'tetap';
    const cfg  = trenCfg(tren);
    return `<div style="display:flex;align-items:center;justify-content:space-between;gap:12px;padding:12px;border-radius:10px;background:${cfg.bg};border:1px solid ${cfg.hexLight}">
        <div style="text-align:center"><p style="font-size:10px;color:var(--muted)">${labels[0]}</p><p style="font-size:18px;font-weight:900;color:var(--text)">${vA.toFixed(2)}</p></div>
        <div style="display:flex;flex-direction:column;align-items:center;gap:2px">
            <i class="ti ${cfg.icon}" style="font-size:20px;color:${cfg.hex}"></i>
            <span style="font-size:11px;font-weight:700;color:${cfg.hex}">${cfg.label}</span>
            <span style="font-size:10px;color:${cfg.hex}">${cfg.sign}${Math.abs(sel).toFixed(2)}</span>
        </div>
        <div style="text-align:center"><p style="font-size:10px;color:var(--muted)">${labels[labels.length-1]}</p><p style="font-size:18px;font-weight:900;color:var(--text)">${vB.toFixed(2)}</p></div>
    </div>`;
}

// ── Build pairs HTML (string, untuk multi wilayah) ─────────────────────
function buildPairsHtml(labels, values, dataset, komponen) {
    let html = `<div style="display:flex;flex-direction:column;gap:8px"><p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:var(--muted)">Perubahan Per Periode</p>`;
    for (let i = 0; i < labels.length - 1; i++) {
        html += buildPairCard(labels[i], labels[i+1], values[i], values[i+1], false, labels, values, komponen, dataset);
    }
    if (labels.length > 2) {
        html += `<p style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:var(--muted);margin-top:6px">Perubahan Total</p>`;
        html += buildPairCard(labels[0], labels[labels.length-1], values[0], values[values.length-1], true, labels, values, komponen, dataset);
    }
    html += '</div>';
    return html;
}

// ── Pair card ──────────────────────────────────────────────────────────
function buildPairCard(tA, tB, vA, vB, isTotal, allLabels, allVals, komponen, dataset) {
    const sel  = vB - vA;
    const pct  = vA !== 0 ? ((sel / Math.abs(vA)) * 100).toFixed(1) : '0.0';
    const tren = sel > 0 ? 'naik' : sel < 0 ? 'turun' : 'tetap';
    const cfg  = trenCfg(tren);
    const selStr  = cfg.sign + sel.toFixed(2);
    const pctStr  = (parseFloat(pct) > 0 ? '+' : '') + pct + '%';
    const border  = isTotal ? `2px solid ${cfg.hexLight}` : `1px solid ${cfg.hexLight}`;
    const teks    = generateInterpretasiTeks(tA, tB, vA, vB, sel, pct, tren, isTotal, allLabels, komponen, dataset);

    return `<div class="pair-card" style="background:${cfg.bg};border:${border}">
        <div class="pair-header">
            <span style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:${cfg.hex}">${isTotal ? '⭐ ' : ''}${tA} → ${tB}</span>
            <span class="pair-badge" style="color:${cfg.hex};background:${cfg.bgDark}"><i class="ti ${cfg.icon}"></i> ${cfg.label}</span>
        </div>
        <div class="pair-values">
            <div class="pair-val-box"><div class="pv-year">Tahun ${tA}</div><div class="pv-num">${vA.toFixed(2)}</div></div>
            <div class="pair-mid">
                <i class="ti ${cfg.icon}" style="color:${cfg.hex}"></i>
                <span class="pm-delta" style="color:${cfg.hex}">${selStr}</span>
                <span class="pm-pct"   style="color:${cfg.hex}">${pctStr}</span>
            </div>
            <div class="pair-val-box"><div class="pv-year">Tahun ${tB}</div><div class="pv-num">${vB.toFixed(2)}</div></div>
        </div>
        <div class="pair-info" style="background:rgba(255,255,255,.7);border:1px solid ${cfg.hexLight}">
            <div class="pair-info-icon" style="background:${cfg.bgDark}"><i class="ti ti-info-circle" style="font-size:12px;color:${cfg.hex}"></i></div>
            <p>${teks}</p>
        </div>
    </div>`;
}

// ── Perbandingan multi wilayah ─────────────────────────────────────────
function renderPerbandinganWilayahMultiTahun(datasets, kategori) {
    const container = document.getElementById('interpretasi-wilayah');
    if (datasets.length < 2) { hide('interpretasi-wilayah'); return; }

    const allYears = [...new Set(datasets.flatMap(d => d.labels))].sort();
    const headerCells = datasets.map((d, i) => {
        const color = COLORS[i % COLORS.length].border;
        return `<th style="padding:8px 12px;font-weight:700;text-align:center;color:${color}">${escH(d.wilayah)}</th>`;
    }).join('');

    const rows = allYears.map(year => {
        const vals = datasets.map(d => { const i = d.labels.indexOf(year); return i >= 0 ? d.values[i] : null; });
        const valid = vals.filter(v => v !== null);
        if (!valid.length) return '';
        const maxV = Math.max(...valid), minV = Math.min(...valid);
        const cells = datasets.map((d, i) => {
            const v   = vals[i];
            const cls = v === maxV && valid.length > 1 ? 'color:#dc2626;font-weight:700' : v === minV && maxV !== minV ? 'color:#16a34a;font-weight:700' : 'color:#374151';
            return `<td style="padding:8px 12px;font-size:12px;text-align:center;${cls}">${v !== null ? v.toFixed(2) : '-'}</td>`;
        }).join('');
        return `<tr style="border-bottom:1px solid #f3f4f6"><td style="padding:8px 12px;font-size:12px;font-weight:600;color:var(--muted)">${year}</td>${cells}</tr>`;
    }).join('');

    const lastYear = allYears.at(-1);
    const lastVals = datasets.map(d => { const i = d.labels.indexOf(lastYear); return { wilayah:d.wilayah, value: i>=0?d.values[i]:null }; }).filter(x=>x.value!==null).sort((a,b)=>b.value-a.value);
    const top = lastVals[0], bot = lastVals.at(-1);
    const avg = lastVals.length ? (lastVals.reduce((s,x)=>s+x.value,0)/lastVals.length).toFixed(2) : '-';
    const gap = top && bot ? (top.value - bot.value).toFixed(2) : '-';

    container.innerHTML = `<div style="display:flex;align-items:flex-start;gap:12px">
        <div style="width:32px;height:32px;border-radius:10px;background:#eef2ff;display:flex;align-items:center;justify-content:center;flex-shrink:0"><i class="ti ti-map-pin" style="color:#6366f1"></i></div>
        <div style="flex:1">
            <p style="font-size:11px;font-weight:700;text-transform:uppercase;color:#6366f1;margin-bottom:12px">Perbandingan Antar Wilayah (${datasets.length} wilayah, ${allYears.length} tahun)</p>
            <div style="overflow-x:auto;margin-bottom:12px">
                <table class="comp-table">
                    <thead><tr style="border-bottom:1px solid var(--border)"><th style="padding:8px 12px;font-weight:700;text-align:left;color:var(--muted)">Tahun</th>${headerCells}</tr></thead>
                    <tbody>${rows}</tbody>
                </table>
            </div>
            <div class="comp-grid">
                <div class="comp-box" style="background:#fef2f2;border:1px solid #fecaca"><div class="cb-label" style="color:#dc2626">Tertinggi (${lastYear})</div><div class="cb-val">${top?escH(top.wilayah):'-'} — ${top?top.value.toFixed(2):'-'}</div></div>
                <div class="comp-box" style="background:#f0fdf4;border:1px solid #bbf7d0"><div class="cb-label" style="color:#16a34a">Terendah (${lastYear})</div><div class="cb-val">${bot?escH(bot.wilayah):'-'} — ${bot?bot.value.toFixed(2):'-'}</div></div>
                <div class="comp-box" style="background:#eff6ff;border:1px solid #bfdbfe"><div class="cb-label" style="color:#2563eb">Rata-rata (${lastYear})</div><div class="cb-val">${avg}</div></div>
                <div class="comp-box" style="background:#faf5ff;border:1px solid #e9d5ff"><div class="cb-label" style="color:#7c3aed">Selisih</div><div class="cb-val">${gap}</div></div>
            </div>
        </div>
    </div>`;
    showEl('interpretasi-wilayah');
}

// ── Interpretasi Tabel ─────────────────────────────────────────────────
function renderInterpretasiTabel(datasets, selectedCat) {
    const section = document.getElementById('interpretasi-section');
    const kompDiv = document.getElementById('interpretasi-tabel-komponen');
    hide('tren-card'); hide('interpretasi-card');
    hide('interpretasi-wilayah');
    document.getElementById('interpretasi-pairs').innerHTML = '';

    if (!datasets.length) { hide('interpretasi-section'); return; }

    const allKatsRaw = allComponents.length
        ? allComponents
        : [...new Set(datasets.flatMap(d => (d.rawRows||[]).map(r => r.x_label)).filter(Boolean))]
            .map(n => ({ nama:n, is_sub:n.startsWith('· ') }));

    if (!allKatsRaw.length) { hide('interpretasi-section'); return; }

    let html = sep('Interpretasi Per Komponen');

    allKatsRaw.forEach(({ nama:kat, is_sub:isSub }) => {
        const komponen = allComponents.find(c => c.nama === kat) || null;
        const katLabel = isSub ? kat.replace(/^· /,'') : kat;

        const katDatasets = datasets.map(d => {
            const rows = (d.rawRows||[]).filter(r => r.x_label === kat)
                .sort((a,b) => String(a.y_label||a.year).localeCompare(String(b.y_label||b.year)));
            if (!rows.length) return null;
            return { wilayah:d.wilayah, labels:rows.map(r=>r.y_label||String(r.year)), values:rows.map(r=>parseFloat(r.value)), color:d.color, interp_kecil:d.interp_kecil, interp_besar:d.interp_besar, interp_tetap:d.interp_tetap };
        }).filter(Boolean);

        if (!katDatasets.length) return;

        const hdrBg = isSub ? 'background:#f5f3ff;border-color:#e9d5ff' : '';
        html += `<div class="card" style="padding:16px;display:flex;flex-direction:column;gap:10px;${hdrBg}">
            <div style="display:flex;align-items:center;gap:6px;${isSub?'padding-left:12px':''}">
                <i class="ti ${isSub?'ti-minus':'ti-category'}" style="font-size:13px;color:${isSub?'#a5b4fc':'var(--accent)'}"></i>
                <span style="font-size:13px;font-weight:${isSub?'500':'700'};color:${isSub?'var(--muted)':'var(--text)'};font-style:${isSub?'italic':'normal'}">${isSub?'<span style="color:#a5b4fc;margin-right:2px">·</span>':''}${escH(katLabel)}</span>
                ${komponen?.satuan?`<span style="font-size:11px;color:var(--muted)">(${escH(komponen.satuan)})</span>`:''}
            </div>`;

        katDatasets.forEach((kd, i) => {
            if (kd.labels.length < 2) return;
            const vA = kd.values[0], vB = kd.values.at(-1);
            const sel = vB - vA;
            const pct = vA !== 0 ? ((sel/Math.abs(vA))*100).toFixed(1) : '0.0';
            const tren = sel > 0 ? 'naik' : sel < 0 ? 'turun' : 'tetap';
            const cfg  = trenCfg(tren);
            const interpAdmin = getInterp(tren, komponen, kd);
            const absSel = Math.abs(sel).toFixed(2), absPct = Math.abs(parseFloat(pct)).toFixed(1);
            let teksCerita = `Nilai ${escH(currentData.judul)} (${escH(kat)}) di ${escH(kd.wilayah)} `;
            teksCerita += tren==='tetap'
                ? `tidak berubah dari ${kd.labels[0]} hingga ${kd.labels.at(-1)}, tetap di ${vA.toFixed(2)}.`
                : `${tren==='naik'?'meningkat':'menurun'} sebesar ${absSel} (${absPct}%) dari ${kd.labels[0]} (${vA.toFixed(2)}) ke ${kd.labels.at(-1)} (${vB.toFixed(2)}).`;
            if (interpAdmin) teksCerita += ' ' + interpAdmin;

            html += `<div style="display:flex;align-items:flex-start;gap:10px;padding:10px;border-radius:10px;border:1px solid ${cfg.hexLight};background:${cfg.bg}">
                <span style="width:4px;border-radius:4px;flex-shrink:0;align-self:stretch;background:${COLORS[i%COLORS.length].border}"></span>
                <div style="flex:1">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:4px">
                        <span style="font-size:12px;font-weight:600;color:var(--text)">${escH(kd.wilayah)}</span>
                        <span style="display:inline-flex;align-items:center;gap:4px;font-size:11px;font-weight:700;color:${cfg.hex};background:${cfg.bgDark};padding:2px 8px;border-radius:6px">
                            <i class="ti ${cfg.icon}"></i> ${cfg.label} ${cfg.sign}${absSel} (${absPct}%)
                        </span>
                    </div>
                    <p style="font-size:12px;color:#4b5563;line-height:1.6">${teksCerita}</p>
                </div>
            </div>`;
        });

        if (katDatasets.length > 1) {
            const lastYear = [...new Set(katDatasets.flatMap(d=>d.labels))].sort().at(-1);
            const lv = katDatasets.map(d=>{const i=d.labels.indexOf(lastYear);return{wilayah:d.wilayah,value:i>=0?d.values[i]:null};}).filter(x=>x.value!==null).sort((a,b)=>b.value-a.value);
            if (lv.length > 1) {
                const t=lv[0], b=lv.at(-1);
                html += `<div style="display:flex;align-items:center;gap:8px;padding:8px 10px;border-radius:8px;background:#eef2ff;border:1px solid #c7d2fe;font-size:11px;color:#4338ca">
                    <i class="ti ti-arrows-diff" style="color:#818cf8"></i>
                    Pada ${lastYear}: <b>${escH(t.wilayah)}</b> tertinggi (${t.value.toFixed(2)}), <b>${escH(b.wilayah)}</b> terendah (${b.value.toFixed(2)}), selisih <b>${(t.value-b.value).toFixed(2)}</b>
                </div>`;
            }
        }
        html += `</div>`;
    });

    kompDiv.innerHTML = html;
    showEl('interpretasi-tabel-komponen');
    showEl('interpretasi-section');
}

// ── Render Table ───────────────────────────────────────────────────────
function renderTable(datasets, kategori) {
    if (!datasets.length) {
        document.getElementById('table-body').innerHTML = '<tr><td colspan="4" style="text-align:center;padding:32px;color:var(--muted)">Tidak ada data</td></tr>';
        return;
    }

    const allKats = allComponents.length
        ? allComponents.map(c => ({nama:c.nama, is_sub:c.is_sub, satuan:c.satuan}))
        : [...new Set(datasets.flatMap(d=>(d.rawRows||[]).map(r=>r.x_label)).filter(Boolean))]
            .map(n => ({nama:n, is_sub:n.startsWith('· '), satuan:''}));

    const allYears = [...new Set(datasets.flatMap(d=>
        (d.rawRows||d.labels.map(l=>({y_label:l}))).map(r=>r.y_label||String(r.year))
    ).filter(Boolean))].sort();

    document.getElementById('table-head').innerHTML = `<tr style="border-bottom:1px solid var(--border)">
        <th>Kategori</th><th>Satuan</th><th>Tahun</th>
        ${datasets.map(d=>`<th>${escH(d.wilayah)}</th>`).join('')}
    </tr>`;

    let body = '';
    if (allKats.length) {
        allKats.forEach(({nama:kat, is_sub:isSub, satuan:satuanMeta}) => {
            const komp   = allComponents.find(c=>c.nama===kat);
            const satuan = komp?.satuan || satuanMeta || '';
            const katDisplay = isSub ? kat.replace(/^· /,'') : kat;
            const colSpan = datasets.length + 3;
            if (isSub) {
                body += `<tr style="border-bottom:1px solid #ede9fe;background:#f5f3ff"><td colspan="${colSpan}" style="padding:8px 16px;font-size:12px;font-weight:600;color:#8b5cf6;font-style:italic"><span style="color:#a5b4fc;margin-right:4px">·</span>${escH(katDisplay)}</td></tr>`;
                return;
            }
            allYears.forEach((year, yi) => {
                const cells = datasets.map(d => {
                    const row = (d.rawRows||[]).find(r => r.x_label===kat && (r.y_label||String(r.year))===year);
                    return `<td style="padding:10px 16px;font-size:13px;font-weight:600;color:var(--text)">${row?parseFloat(row.value).toFixed(2):'-'}</td>`;
                }).join('');
                body += `<tr style="border-bottom:1px solid #f9fafb">
                    ${yi===0?`<td style="padding:10px 16px;font-size:13px" rowspan="${allYears.length}">${escH(katDisplay)}</td>
                    <td style="padding:10px 16px;font-size:11px;color:var(--muted)" rowspan="${allYears.length}">${escH(satuan)}</td>`:''}
                    <td style="padding:10px 16px;font-size:13px;color:var(--text)">${year}</td>${cells}
                </tr>`;
            });
        });
    } else {
        allYears.forEach(year => {
            const cells = datasets.map(d => { const i=d.labels.indexOf(year); return `<td style="padding:10px 16px;font-size:13px;font-weight:600">${i>=0?d.values[i].toFixed(2):'-'}</td>`; }).join('');
            body += `<tr style="border-bottom:1px solid #f9fafb"><td style="padding:10px 16px;color:var(--muted)">-</td><td style="padding:10px 16px;color:var(--muted)">-</td><td style="padding:10px 16px">${year}</td>${cells}</tr>`;
        });
    }

    document.getElementById('table-body').innerHTML = body || '<tr><td colspan="6" style="text-align:center;padding:32px;color:var(--muted)">Tidak ada data</td></tr>';
}

// ── Download CSV ───────────────────────────────────────────────────────
function downloadTable() {
    const selectedCat    = document.querySelector('.kat-radio:checked')?.value ?? null;
    const checkedYears   = [...document.querySelectorAll('.tahun-check:checked')].map(c=>c.value);
    const checkedWilayah = [...document.querySelectorAll('.wilayah-check:checked')].map(c=>c.value);
    const datasets = wilayahList.map((w,wi) => {
        if (!checkedWilayah.includes(w.wilayah)) return null;
        const rows = w.values.filter(v=>checkedYears.includes(v.y_label||String(v.year))).sort((a,b)=>String(a.y_label||a.year).localeCompare(String(b.y_label||b.year)));
        if (!rows.length) return null;
        return {wilayah:w.wilayah, labels:rows.map(v=>v.y_label||String(v.year)), values:rows.map(v=>parseFloat(v.value)), rawRows:rows, color:COLORS[wi%COLORS.length]};
    }).filter(Boolean);
    if (!datasets.length) return;

    const allKats  = allComponents.length ? allComponents.map(c=>c.nama) : [...new Set(datasets.flatMap(d=>(d.rawRows||[]).map(r=>r.x_label)).filter(Boolean))];
    const allYears = [...new Set(datasets.flatMap(d=>(d.rawRows||d.labels.map(l=>({y_label:l}))).map(r=>r.y_label||String(r.year))).filter(Boolean))].sort();

    let csv = 'Kategori,Satuan,Tahun,' + datasets.map(d=>d.wilayah).join(',') + '\n';
    if (allKats.length) {
        allKats.forEach(kat => {
            const komp = allComponents.find(c=>c.nama===kat);
            allYears.forEach(year => {
                const vals = datasets.map(d=>{const r=(d.rawRows||[]).find(v=>v.x_label===kat&&(v.y_label||String(v.year))===year);return r?parseFloat(r.value).toFixed(2):'';}).join(',');
                csv += `"${kat.replace(/"/g,'""')}","${komp?.satuan||''}","${year}",${vals}\n`;
            });
        });
    } else {
        allYears.forEach(year => {
            const vals = datasets.map(d=>{const i=d.labels.indexOf(year);return i>=0?d.values[i].toFixed(2):'';}).join(',');
            csv += `"-","-","${year}",${vals}\n`;
        });
    }

    const blob = new Blob([csv], {type:'text/csv;charset=utf-8;'});
    const a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = `data_${currentData.judul}_${new Date().toISOString().slice(0,10)}.csv`;
    a.style.display = 'none';
    document.body.appendChild(a); a.click(); document.body.removeChild(a);
}

// ── Generate interpretasi teks ─────────────────────────────────────────
function generateInterpretasiTeks(tA, tB, vA, vB, sel, pct, tren, isTotal, allLabels, komponen, dataset) {
    const judul    = currentData.judul || 'data';
    const wilayah  = dataset?.wilayah  || 'wilayah ini';
    const absSel   = Math.abs(sel).toFixed(2);
    const absPct   = Math.abs(parseFloat(pct)).toFixed(1);
    const mag      = Math.abs(parseFloat(pct));
    const skala    = mag < 2 ? 'kecil' : mag < 5 ? 'sedang' : 'besar';
    const teksAdmin = getInterp(tren, komponen, dataset);

    if (tren === 'tetap') {
        return `Nilai ${judul} di ${wilayah} tidak berubah antara ${tA} dan ${tB}, tetap di ${vA.toFixed(2)}.${teksAdmin?' '+teksAdmin:''}`;
    }
    const arah = tren==='naik'?'meningkat':'menurun';
    const arahkata = tren==='naik'?'Peningkatan':'Penurunan';
    let teks = `Pada periode ${tA}–${tB}, nilai ${judul} di ${wilayah} ${arah} sebesar ${absSel} (${absPct}%), dari ${vA.toFixed(2)} menjadi ${vB.toFixed(2)}. `;
    if (skala==='kecil') teks += `Perubahan ini tergolong kecil dan kondisi relatif stabil. `;
    else if (skala==='sedang') teks += `${arahkata} ini cukup signifikan dan perlu mendapat perhatian. `;
    else teks += `${arahkata} yang cukup besar ini memerlukan perhatian khusus dari pemangku kebijakan. `;
    if (teksAdmin) teks += teksAdmin + ' ';
    if (isTotal && allLabels?.length > 2) teks += `Secara keseluruhan selama ${allLabels.length} periode (${tA}–${tB}), tren menunjukkan ${tren==='naik'?'kenaikan':'penurunan'} kumulatif.`;
    return teks.trim();
}

// ── Helper: tren config ────────────────────────────────────────────────
function trenCfg(tren) {
    return {
        naik:  { label:'Naik',  sign:'+', icon:'ti-trending-up',   hex:'#dc2626', hexLight:'#fecaca', bg:'rgba(254,242,242,.6)', bgDark:'#fee2e2' },
        turun: { label:'Turun', sign:'',  icon:'ti-trending-down',  hex:'#16a34a', hexLight:'#bbf7d0', bg:'rgba(240,253,244,.6)', bgDark:'#dcfce7' },
        tetap: { label:'Tetap', sign:'',  icon:'ti-minus',          hex:'#6b7280', hexLight:'#e5e7eb', bg:'rgba(249,250,251,.6)', bgDark:'#f3f4f6' },
    }[tren];
}

// ── Helper: ambil teks interpretasi dari admin ─────────────────────────
function getInterp(tren, komponen, dataset) {
    if (tren === 'naik')  return komponen?.interpretasi_lebih_besar || dataset?.interp_besar || currentData.interpBesar || '';
    if (tren === 'turun') return komponen?.interpretasi_lebih_kecil || dataset?.interp_kecil || currentData.interpKecil || '';
    return komponen?.interpretasi_tetap || dataset?.interp_tetap || currentData.interpTetap || '';
}

// ── Separator ─────────────────────────────────────────────────────────
function sep(label) {
    return `<div class="section-sep"><div class="sep-line"></div><span>${label}</span><div class="sep-line"></div></div>`;
}

// ── DOM helpers ────────────────────────────────────────────────────────
function show(id, visible) { const el=document.getElementById(id); if(el) el.style.display = visible ? '' : 'none'; }
function showEl(id)  { const el=document.getElementById(id); if(el) el.style.display = ''; }
function hide(id)    { const el=document.getElementById(id); if(el) el.style.display = 'none'; }
function setColor(el, color, props) {}
function escH(str)   { return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }
</script>

</body>
</html>