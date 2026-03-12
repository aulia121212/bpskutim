@extends('layouts.app')

@section('content')
<div class="p-6">

    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Preview Grafik dan Tabel</h1>

    {{-- Tab Toggle --}}
    <div class="flex gap-2 mb-6">
        <button id="tab-grafik" onclick="switchTab('grafik')"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition bg-blue-600 text-white">
            <i class="ti ti-chart-line"></i> Grafik
        </button>
        <button id="tab-tabel" onclick="switchTab('tabel')"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition border border-gray-200 text-gray-600 hover:bg-gray-50">
            <i class="ti ti-table"></i> Tabel
        </button>
    </div>

    <div class="flex gap-6">

        {{-- Left: Chart / Table + Interpretasi --}}
        <div class="flex-1 space-y-4">

            {{-- Chart Card --}}
            <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm p-6">
                <div id="view-grafik">
                    <div id="chart-header" class="mb-1">
                        <h2 id="chart-title" class="text-sm font-bold text-gray-800 dark:text-white">-</h2>
                        <p class="text-xs text-gray-400" id="chart-subtitle">-</p>
                    </div>
                    <div class="relative mt-4" style="height: 320px;">
                        <canvas id="mainChart"></canvas>
                    </div>
                </div>
                <div id="view-tabel" class="hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm" id="data-table">
                            <thead id="table-head"></thead>
                            <tbody id="table-body">
                                <tr><td colspan="5" class="text-center py-8 text-gray-400">Pilih data untuk ditampilkan</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- INTERPRETASI --}}
            <div id="interpretasi-section" class="hidden space-y-4">
                <div id="tren-card" class="flex items-center justify-between gap-4 p-5 rounded-2xl border">
                    <div class="text-center">
                        <p class="text-xs text-gray-400 mb-0.5" id="tren-tahun-awal">-</p>
                        <p class="text-2xl font-black text-gray-800 dark:text-white" id="tren-nilai-awal">-</p>
                    </div>
                    <div class="flex flex-col items-center gap-1">
                        <i id="tren-icon" class="text-3xl ti ti-minus text-gray-400"></i>
                        <span id="tren-label" class="text-xs font-bold uppercase tracking-widest text-gray-400">-</span>
                        <span id="tren-selisih" class="text-xs font-semibold text-gray-400">-</span>
                    </div>
                    <div class="text-center">
                        <p class="text-xs text-gray-400 mb-0.5" id="tren-tahun-akhir">-</p>
                        <p class="text-2xl font-black text-gray-800 dark:text-white" id="tren-nilai-akhir">-</p>
                    </div>
                </div>
                <div id="interpretasi-card" class="rounded-2xl border p-5">
                    <div class="flex items-start gap-3">
                        <div id="interpretasi-icon-wrap" class="mt-0.5 shrink-0 w-8 h-8 rounded-xl flex items-center justify-center">
                            <i id="interpretasi-icon" class="ti ti-equal text-gray-400 text-lg"></i>
                        </div>
                        <div class="flex-1">
                            <p id="interpretasi-label" class="text-xs font-bold uppercase tracking-widest mb-2 text-gray-400">Interpretasi</p>
                            <p id="interpretasi-teks" class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">-</p>
                        </div>
                    </div>
                </div>
                <div id="interpretasi-pairs" class="space-y-3"></div>
            </div>
        </div>

        {{-- Right: Filter Panel --}}
        <div class="w-64 bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm p-5 h-fit space-y-5">

            <h3 class="text-sm font-bold text-gray-700 dark:text-white">Sesuaikan tampilan grafik</h3>

            {{-- Filter: Judul Data (digroup per judul unik) --}}
            <div>
                <label class="block text-sm font-semibold text-blue-500 mb-2">Judul data</label>
                <div class="relative">
                    <select id="filter-judul"
                        class="w-full appearance-none border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih judul data...</option>
                        @php
                            // Group statistics by statistic_title_id, ambil unik per judul
                            $grouped = $statistics->groupBy('statistic_title_id');
                        @endphp
                        @foreach($grouped as $titleId => $group)
                            @php
                                $first = $group->first();
                                // Kumpulkan semua wilayah + values untuk judul ini
                                // Group by wilayah, gabungkan values jika wilayah sama
                                $allWilayah = $group->groupBy('wilayah_data')->map(function($wGroup) {
                                    $wFirst  = $wGroup->first();
                                    $allVals = $wGroup->flatMap(fn($s) => $s->values)->values();
                                    return [
                                        'wilayah'      => $wFirst->wilayah_data,
                                        'updated'      => $wFirst->updated_at->format('F Y'),
                                        'values'       => $allVals,
                                        'interp_kecil' => $wFirst->interpretasi_lebih_kecil ?? '',
                                        'interp_besar' => $wFirst->interpretasi_lebih_besar ?? '',
                                        'interp_tetap' => $wFirst->interpretasi_tetap ?? '',
                                    ];
                                })->values();
                            @endphp
                            <option value="{{ $titleId }}"
                                data-judul="{{ $first->judul_data }}"
                                data-updated="{{ $first->updated_at->format('F Y') }}"
                                data-interp-kecil="{{ addslashes($first->interpretasi_lebih_kecil ?? '') }}"
                                data-interp-besar="{{ addslashes($first->interpretasi_lebih_besar ?? '') }}"
                                data-interp-tetap="{{ addslashes($first->interpretasi_tetap ?? '') }}"
                                data-wilayah-list="{{ htmlspecialchars(json_encode($allWilayah), ENT_QUOTES, 'UTF-8') }}"
                                data-components="{{ htmlspecialchars(json_encode($first->statisticTitle->components ?? []), ENT_QUOTES, 'UTF-8') }}">
                                {{ $first->judul_data }}
                            </option>
                        @endforeach
                    </select>
                    <i class="ti ti-chevron-down absolute right-3 top-2.5 text-gray-400 pointer-events-none"></i>
                </div>
            </div>

            {{-- Filter: Wilayah (dinamis sesuai judul dipilih) --}}
            <div>
                <label class="block text-sm font-semibold text-blue-500 mb-2">Wilayah data</label>
                <div id="filter-wilayah" class="space-y-2">
                    <p class="text-xs text-gray-400">Pilih judul data dulu</p>
                </div>
            </div>

            {{-- Filter: Komponen/Kategori --}}
            <div>
                <label class="block text-sm font-semibold text-blue-500 mb-2">Komponen / Kategori</label>
                <div id="filter-kategori" class="space-y-1.5">
                    <p class="text-xs text-gray-400">Pilih judul data dulu</p>
                </div>
            </div>

            {{-- Filter: Tahun --}}
            <div>
                <label class="block text-sm font-semibold text-blue-500 mb-2">Tahun data</label>
                <div id="filter-tahun" class="space-y-1.5">
                    <p class="text-xs text-gray-400">Pilih kategori dulu</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// ── State ─────────────────────────────────────────────────────────────────
let chartInstance  = null;
let currentData    = {};   // { judul, interpKecil, interpBesar, interpTetap }
let wilayahList    = [];   // [{ wilayah, updated, values:[{x_label,y_label,value}], interp_* }]
let allComponents  = [];   // komponen dari statistic_title

const COLORS = [
    { border: '#2563eb', bg: 'rgba(37,99,235,0.10)' },
    { border: '#dc2626', bg: 'rgba(220,38,38,0.10)' },
    { border: '#16a34a', bg: 'rgba(22,163,74,0.10)' },
    { border: '#d97706', bg: 'rgba(217,119,6,0.10)' },
    { border: '#7c3aed', bg: 'rgba(124,58,237,0.10)' },
];

// ── Tab switch ────────────────────────────────────────────────────────────
function switchTab(tab) {
    const isG = tab === 'grafik';
    document.getElementById('view-grafik').classList.toggle('hidden', !isG);
    document.getElementById('view-tabel').classList.toggle('hidden',  isG);
    document.getElementById('tab-grafik').className = isG
        ? 'inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition bg-blue-600 text-white'
        : 'inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition border border-gray-200 text-gray-600 hover:bg-gray-50';
    document.getElementById('tab-tabel').className = !isG
        ? 'inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition bg-blue-600 text-white'
        : 'inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition border border-gray-200 text-gray-600 hover:bg-gray-50';
    if (!isG) applyFilters();
}

// ── Pilih judul data ──────────────────────────────────────────────────────
document.getElementById('filter-judul').addEventListener('change', function () {
    const opt = this.options[this.selectedIndex];
    resetAll();
    if (!opt.value) return;

    currentData = {
        judul:       opt.dataset.judul,
        interpKecil: opt.dataset.interpKecil || '',
        interpBesar: opt.dataset.interpBesar || '',
        interpTetap: opt.dataset.interpTetap || '',
    };

    const decode = s => { const t = document.createElement('textarea'); t.innerHTML = s; return t.value; };
    wilayahList   = JSON.parse(decode(opt.getAttribute('data-wilayah-list') || '[]'));
    allComponents = JSON.parse(decode(opt.getAttribute('data-components')   || '[]'));

    // Normalisasi values tiap wilayah
    wilayahList = wilayahList.map(w => ({
        ...w,
        values: (w.values || []).map((v, i) => ({
            ...v,
            x_label: v.x_label || (allComponents[i] ? allComponents[i].nama : null),
            y_label: v.y_label || (v.year ? String(v.year) : null),
        }))
    }));

    // Build wilayah checkboxes
    const wilDiv = document.getElementById('filter-wilayah');
    wilDiv.innerHTML = wilayahList.map((w, wi) => {
        const color = COLORS[wi % COLORS.length].border;
        return `<label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 cursor-pointer">
            <input type="checkbox" value="${escH(w.wilayah)}" checked class="wilayah-check rounded accent-blue-600"
                onchange="applyFilters()">
            <span class="w-2.5 h-2.5 rounded-full shrink-0" style="background:${color}"></span>
            ${escH(w.wilayah)}
        </label>`;
    }).join('');

    // Build kategori
    buildKategoriFilter();
});

function resetAll() {
    document.getElementById('interpretasi-section').classList.add('hidden');
    document.getElementById('filter-wilayah').innerHTML  = '<p class="text-xs text-gray-400">Pilih judul data dulu</p>';
    document.getElementById('filter-kategori').innerHTML = '<p class="text-xs text-gray-400">Pilih judul data dulu</p>';
    document.getElementById('filter-tahun').innerHTML    = '<p class="text-xs text-gray-400">Pilih kategori dulu</p>';
    if (chartInstance) { chartInstance.destroy(); chartInstance = null; }
    document.getElementById('chart-title').textContent    = '-';
    document.getElementById('chart-subtitle').textContent = '-';
}

function buildKategoriFilter() {
    // Hanya tampilkan kategori utama (bukan sub, prefix '· ')
    const categories = allComponents.length
        ? allComponents.filter(c => !c.is_sub).map(c => c.nama)
        : [...new Set(wilayahList.flatMap(w => w.values.map(v => v.x_label)).filter(Boolean))].filter(n => !n.startsWith('· '));

    const katDiv = document.getElementById('filter-kategori');

    if (categories.length > 0) {
        katDiv.innerHTML = `<p class="text-xs text-blue-400 font-semibold mb-2">Pilih salah satu ↓</p>`
            + categories.map(cat => {
                const isSub = cat.startsWith('· ');
                const label = isSub ? cat.slice(2) : cat;
                return `<label class="flex items-center gap-2 text-xs cursor-pointer hover:text-blue-600 transition ${isSub ? 'pl-3 text-gray-400 italic' : 'text-gray-600 font-medium'}">
                    <input type="radio" name="kat_radio" value="${escH(cat)}" class="kat-radio shrink-0 accent-blue-600" onchange="onKategoriChange()">
                    ${isSub ? '<span class="text-indigo-300">·</span>' : ''}
                    <span class="truncate" title="${escH(label)}">${escH(label)}</span>
                </label>`;
            }).join('');

        // Tahun dari semua wilayah gabungan
        const allYears = [...new Set(
            wilayahList.flatMap(w => w.values.map(v => v.y_label || String(v.year))).filter(Boolean)
        )].sort();
        buildTahunFilter(allYears);
        // Disable tahun sampai kategori dipilih
        document.getElementById('filter-tahun').querySelectorAll('.tahun-check').forEach(cb => cb.disabled = true);
    } else {
        katDiv.innerHTML = '<p class="text-xs text-gray-400 italic">Data tidak memiliki kategori</p>';
        const allYears = [...new Set(
            wilayahList.flatMap(w => w.values.map(v => v.y_label || String(v.year))).filter(Boolean)
        )].sort();
        buildTahunFilter(allYears);
        applyFilters();
    }
}

function onKategoriChange() {
    document.getElementById('filter-tahun').querySelectorAll('.tahun-check')
        .forEach(cb => { cb.disabled = false; cb.checked = true; });
    applyFilters();
}

function buildTahunFilter(years) {
    const tahunDiv = document.getElementById('filter-tahun');
    if (!years.length) { tahunDiv.innerHTML = '<p class="text-xs text-gray-400">Tidak ada data tahun</p>'; return; }
    tahunDiv.innerHTML = years.map(y => `
        <label class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-400 cursor-pointer hover:text-blue-600 transition">
            <input type="checkbox" value="${y}" checked class="tahun-check rounded accent-blue-600"> ${y}
        </label>`).join('');
    tahunDiv.querySelectorAll('.tahun-check').forEach(cb => cb.addEventListener('change', applyFilters));
}

// ── Apply filter & render ─────────────────────────────────────────────────
function applyFilters() {
    if (!wilayahList.length) return;

    const selectedCat    = document.querySelector('.kat-radio:checked')?.value ?? null;
    const checkedYears   = [...document.querySelectorAll('.tahun-check:checked')].map(c => c.value);
    const checkedWilayah = [...document.querySelectorAll('.wilayah-check:checked')].map(c => c.value);

    // Build dataset per wilayah yang dicentang
    const datasets = [];
    wilayahList.forEach((w, wi) => {
        if (!checkedWilayah.includes(w.wilayah)) return;

        const rows = w.values
            .filter(v => !selectedCat || v.x_label === selectedCat)
            .filter(v => checkedYears.includes(v.y_label || String(v.year)))
            .sort((a, b) => String(a.y_label || a.year).localeCompare(String(b.y_label || b.year)));

        if (!rows.length) return;

        const color = COLORS[wi % COLORS.length];
        datasets.push({
            wilayah: w.wilayah,
            updated: w.updated,
            labels:  rows.map(v => v.y_label || String(v.year)),
            values:  rows.map(v => parseFloat(v.value)),
            color,
            interp_kecil: w.interp_kecil,
            interp_besar: w.interp_besar,
            interp_tetap: w.interp_tetap,
        });
    });

    renderChart(datasets, selectedCat);
    renderTable(datasets, selectedCat);

    // Interpretasi: pakai dataset pertama yang dipilih
    if (datasets.length > 0) {
        const komponen = allComponents.find(c => c.nama === selectedCat) || null;
        renderInterpretasi(datasets[0].labels, datasets[0].values, selectedCat, datasets[0], komponen);
    } else {
        document.getElementById('interpretasi-section').classList.add('hidden');
    }
}

// ── Render chart (multi-line) ─────────────────────────────────────────────
function renderChart(datasets, kategori) {
    if (!datasets.length) return;

    const katLabel = kategori
        ? (kategori.startsWith('· ') ? kategori.slice(2) : kategori)
        : currentData.judul;

    const wilayahNames = datasets.map(d => d.wilayah).join(', ');
    document.getElementById('chart-title').textContent    = currentData.judul + ' — ' + katLabel;
    document.getElementById('chart-subtitle').textContent = wilayahNames + ' · Update Terakhir: ' + datasets[0].updated;

    // Gabungkan semua labels unik
    const allLabels = [...new Set(datasets.flatMap(d => d.labels))].sort();

    if (chartInstance) chartInstance.destroy();
    const ctx = document.getElementById('mainChart').getContext('2d');
    chartInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: allLabels,
            datasets: datasets.map(d => ({
                label:               d.wilayah,
                data:                allLabels.map(lbl => {
                    const idx = d.labels.indexOf(lbl);
                    return idx >= 0 ? d.values[idx] : null;
                }),
                borderColor:         d.color.border,
                backgroundColor:     d.color.bg,
                borderWidth:         2,
                pointBackgroundColor: d.color.border,
                pointRadius:         5,
                pointHoverRadius:    7,
                fill:                datasets.length === 1,
                tension:             0.3,
                spanGaps:            true,
            }))
        },
        options: {
            responsive:          true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display:  datasets.length > 1,
                    position: 'top',
                    labels:   { boxWidth: 12, font: { size: 11 } }
                },
                tooltip: { mode: 'index', intersect: false },
            },
            scales: {
                x: { title: { display: true, text: 'Tahun', font: { size: 11 } }, grid: { display: false } },
                y: { title: { display: true, text: 'Nilai',  font: { size: 11 } }, grid: { color: '#f3f4f6' } }
            }
        }
    });
}

// ── Render tabel (multi-wilayah, dengan satuan) ───────────────────────────
function renderTable(datasets, kategori) {
    const katLabel = kategori
        ? (kategori.startsWith('· ') ? kategori.slice(2) : kategori)
        : currentData.judul;

    // Cari satuan dari komponen
    const komponen = allComponents.find(c => c.nama === kategori);
    const satuan   = komponen?.satuan || '';

    document.getElementById('table-head').innerHTML = `
        <tr class="border-b border-gray-100">
            <th class="text-left px-4 py-3 font-semibold text-blue-600">Tahun</th>
            <th class="text-left px-4 py-3 font-semibold text-blue-600">Kategori</th>
            <th class="text-left px-4 py-3 font-semibold text-blue-600">Satuan</th>
            ${datasets.map(d => `<th class="text-left px-4 py-3 font-semibold text-blue-600">${escH(d.wilayah)}</th>`).join('')}
        </tr>`;

    if (!datasets.length) {
        document.getElementById('table-body').innerHTML =
            '<tr><td colspan="4" class="text-center py-8 text-gray-400">Tidak ada data</td></tr>';
        return;
    }

    // Semua tahun unik
    const allLabels = [...new Set(datasets.flatMap(d => d.labels))].sort();

    document.getElementById('table-body').innerHTML = allLabels.map(y => {
        const cells = datasets.map(d => {
            const idx = d.labels.indexOf(y);
            const val = idx >= 0 ? d.values[idx] : '-';
            return `<td class="px-4 py-3 text-gray-700 text-sm font-semibold">${val !== '-' ? val : '-'}</td>`;
        }).join('');
        return `<tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">
            <td class="px-4 py-3 text-gray-700 text-sm">${y}</td>
            <td class="px-4 py-3 text-gray-500 text-xs">${escH(katLabel)}</td>
            <td class="px-4 py-3 text-gray-400 text-xs">${escH(satuan)}</td>
            ${cells}
        </tr>`;
    }).join('');
}

// ── Render interpretasi ───────────────────────────────────────────────────
function renderInterpretasi(labels, values, selectedCat, dataset, komponen) {
    const section = document.getElementById('interpretasi-section');
    if (!labels || labels.length < 2) { section.classList.add('hidden'); return; }

    const nilaiAwal  = values[0];
    const nilaiAkhir = values[values.length - 1];
    const tahunAwal  = labels[0];
    const tahunAkhir = labels[labels.length - 1];
    const selisih    = nilaiAkhir - nilaiAwal;
    const tren       = selisih > 0 ? 'naik' : selisih < 0 ? 'turun' : 'tetap';

    const interpKecil = komponen?.interpretasi_lebih_kecil || dataset?.interp_kecil || currentData.interpKecil || '';
    const interpBesar = komponen?.interpretasi_lebih_besar || dataset?.interp_besar || currentData.interpBesar || '';
    const interpTetap = komponen?.interpretasi_tetap       || dataset?.interp_tetap || currentData.interpTetap || '';

    const cfgMap = {
        naik:  { color: 'red',   icon: 'ti-trending-up',   label: 'Naik',  sign: '+', teks: interpBesar || 'Data mengalami kenaikan.' },
        turun: { color: 'green', icon: 'ti-trending-down',  label: 'Turun', sign: '',  teks: interpKecil || 'Data mengalami penurunan.' },
        tetap: { color: 'gray',  icon: 'ti-minus',          label: 'Tetap', sign: '',  teks: interpTetap || 'Data tidak berubah secara signifikan.' },
    };
    const cfg = cfgMap[tren];

    document.getElementById('tren-tahun-awal').textContent  = 'Tahun ' + tahunAwal;
    document.getElementById('tren-nilai-awal').textContent  = nilaiAwal.toFixed(2);
    document.getElementById('tren-tahun-akhir').textContent = 'Tahun ' + tahunAkhir;
    document.getElementById('tren-nilai-akhir').textContent = nilaiAkhir.toFixed(2);
    document.getElementById('tren-card').className          = `flex items-center justify-between gap-4 p-5 rounded-2xl border bg-${cfg.color}-50 dark:bg-${cfg.color}-900/20 border-${cfg.color}-100 dark:border-${cfg.color}-800`;
    document.getElementById('tren-icon').className          = `text-3xl ti ${cfg.icon} text-${cfg.color}-500`;
    document.getElementById('tren-label').className         = `text-xs font-bold uppercase tracking-widest text-${cfg.color}-500`;
    document.getElementById('tren-label').textContent       = cfg.label;
    document.getElementById('tren-selisih').className       = `text-xs font-semibold text-${cfg.color}-400`;
    document.getElementById('tren-selisih').textContent     = cfg.sign + Math.abs(selisih).toFixed(2);

    document.getElementById('interpretasi-card').className      = `rounded-2xl border p-5 border-${cfg.color}-100 dark:border-${cfg.color}-800 bg-${cfg.color}-50/50 dark:bg-${cfg.color}-900/10`;
    document.getElementById('interpretasi-icon-wrap').className = `mt-0.5 shrink-0 w-8 h-8 rounded-xl flex items-center justify-center bg-${cfg.color}-100 dark:bg-${cfg.color}-900/30`;
    document.getElementById('interpretasi-icon').className      = `ti ${cfg.icon} text-${cfg.color}-500 text-lg`;
    document.getElementById('interpretasi-label').className     = `text-xs font-bold uppercase tracking-widest mb-2 text-${cfg.color}-500`;
    document.getElementById('interpretasi-label').textContent   = `Interpretasi Keseluruhan ${tahunAwal}–${tahunAkhir}`;
    document.getElementById('interpretasi-teks').textContent    = cfg.teks;

    const pairsDiv = document.getElementById('interpretasi-pairs');
    let html = `
        <div class="flex items-center gap-2 mb-1">
            <div class="flex-1 h-px bg-gray-100 dark:bg-gray-700"></div>
            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Perubahan Per Periode</span>
            <div class="flex-1 h-px bg-gray-100 dark:bg-gray-700"></div>
        </div>`;

    for (let i = 0; i < labels.length - 1; i++) {
        html += buildPairCard(labels[i], labels[i+1], values[i], values[i+1], false, labels, values, komponen, dataset);
    }

    if (labels.length > 2) {
        html += `
            <div class="flex items-center gap-2 mt-4 mb-1">
                <div class="flex-1 h-px bg-gray-100 dark:bg-gray-700"></div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Perubahan Total</span>
                <div class="flex-1 h-px bg-gray-100 dark:bg-gray-700"></div>
            </div>`;
        html += buildPairCard(tahunAwal, tahunAkhir, nilaiAwal, nilaiAkhir, true, labels, values, komponen, dataset);
    }

    pairsDiv.innerHTML = html;
    section.classList.remove('hidden');
}

// ── Generate teks interpretasi ────────────────────────────────────────────
function generateInterpretasiTeks(tA, tB, vA, vB, selisih, pct, tren, isTotal, allLabels, komponen, dataset) {
    const judulData  = currentData.judul   || 'data';
    const wilayah    = dataset?.wilayah    || 'wilayah ini';
    const absSelisih = Math.abs(selisih).toFixed(2);
    const absPct     = Math.abs(parseFloat(pct)).toFixed(1);
    const mag        = Math.abs(parseFloat(pct));
    const skala      = mag < 2 ? 'kecil' : mag < 5 ? 'sedang' : 'besar';

    let teksAdmin = '';
    if (tren === 'tetap') {
        teksAdmin = komponen?.interpretasi_tetap       || dataset?.interp_tetap || currentData.interpTetap || '';
    } else if (tren === 'naik') {
        teksAdmin = komponen?.interpretasi_lebih_besar || dataset?.interp_besar || currentData.interpBesar || '';
    } else {
        teksAdmin = komponen?.interpretasi_lebih_kecil || dataset?.interp_kecil || currentData.interpKecil || '';
    }

    if (tren === 'tetap') {
        let teks = `Nilai ${judulData} di ${wilayah} tidak mengalami perubahan antara tahun ${tA} dan ${tB}, tetap berada di angka ${vA.toFixed(2)}. `;
        if (teksAdmin) teks += teksAdmin;
        return teks.trim();
    }

    const arah     = tren === 'naik' ? 'meningkat'   : 'menurun';
    const arahkata = tren === 'naik' ? 'Peningkatan' : 'Penurunan';

    let teks = `Pada periode ${tA}–${tB}, nilai ${judulData} di ${wilayah} ${arah} sebesar ${absSelisih} (${absPct}%), dari ${vA.toFixed(2)} menjadi ${vB.toFixed(2)}. `;

    if (skala === 'kecil') {
        teks += `Perubahan ini tergolong kecil dan kondisi relatif stabil. `;
    } else if (skala === 'sedang') {
        teks += `${arahkata} ini cukup signifikan dan perlu mendapat perhatian. `;
    } else {
        teks += `${arahkata} yang cukup besar ini memerlukan perhatian khusus dari pemangku kebijakan. `;
    }

    if (teksAdmin) teks += teksAdmin + ' ';

    if (isTotal && allLabels && allLabels.length > 2) {
        teks += `Secara keseluruhan selama ${allLabels.length} periode pengamatan (${tA}–${tB}), tren menunjukkan ${tren === 'naik' ? 'kenaikan' : 'penurunan'} kumulatif.`;
    }

    return teks.trim();
}

// ── Build kartu satu pasangan tahun ──────────────────────────────────────
function buildPairCard(tA, tB, vA, vB, isTotal, allLabels, allVals, komponen, dataset) {
    const selisih = vB - vA;
    const pct     = vA !== 0 ? ((selisih / Math.abs(vA)) * 100).toFixed(1) : '0.0';
    const tren    = selisih > 0 ? 'naik' : selisih < 0 ? 'turun' : 'tetap';
    const cfg     = {
        naik:  { color: 'red',   icon: 'ti-trending-up',   label: 'Naik',  sign: '+' },
        turun: { color: 'green', icon: 'ti-trending-down',  label: 'Turun', sign: ''  },
        tetap: { color: 'gray',  icon: 'ti-minus',          label: 'Tetap', sign: ''  },
    }[tren];

    const selisihStr   = cfg.sign + selisih.toFixed(2);
    const pctFormatted = (parseFloat(pct) > 0 ? '+' : '') + pct + '%';
    const borderCls    = isTotal
        ? `border-2 border-${cfg.color}-300 dark:border-${cfg.color}-700`
        : `border border-${cfg.color}-100 dark:border-${cfg.color}-800`;
    const teksInterp   = generateInterpretasiTeks(tA, tB, vA, vB, selisih, pct, tren, isTotal, allLabels, komponen, dataset);

    return `
        <div class="rounded-2xl p-4 bg-${cfg.color}-50/60 dark:bg-${cfg.color}-900/10 ${borderCls}">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-widest text-${cfg.color}-500">${isTotal ? '⭐ ' : ''}${tA} → ${tB}</span>
                <span class="inline-flex items-center gap-1 text-xs font-bold text-${cfg.color}-500 bg-${cfg.color}-100 dark:bg-${cfg.color}-900/30 px-2 py-0.5 rounded-lg">
                    <i class="ti ${cfg.icon}"></i> ${cfg.label}
                </span>
            </div>
            <div class="flex items-center justify-between mb-4">
                <div class="text-center">
                    <p class="text-xs text-gray-400 mb-0.5">Tahun ${tA}</p>
                    <p class="text-xl font-black text-gray-800 dark:text-white">${vA.toFixed(2)}</p>
                </div>
                <div class="flex flex-col items-center gap-0.5 px-4">
                    <i class="ti ${cfg.icon} text-2xl text-${cfg.color}-400"></i>
                    <span class="text-sm font-bold text-${cfg.color}-500">${selisihStr}</span>
                    <span class="text-xs text-${cfg.color}-400">${pctFormatted}</span>
                </div>
                <div class="text-center">
                    <p class="text-xs text-gray-400 mb-0.5">Tahun ${tB}</p>
                    <p class="text-xl font-black text-gray-800 dark:text-white">${vB.toFixed(2)}</p>
                </div>
            </div>
            <div class="flex items-start gap-2.5 bg-white/70 dark:bg-gray-900/40 rounded-xl p-3 border border-${cfg.color}-100/60">
                <div class="shrink-0 w-6 h-6 rounded-lg bg-${cfg.color}-100 dark:bg-${cfg.color}-900/30 flex items-center justify-center mt-0.5">
                    <i class="ti ti-info-circle text-${cfg.color}-500 text-xs"></i>
                </div>
                <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">${teksInterp}</p>
            </div>
        </div>`;
}

function escH(str) {
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
</script>
@endsection