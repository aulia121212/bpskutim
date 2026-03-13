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
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-sm font-semibold text-gray-700">Data Tabel</h3>
                        <button onclick="downloadTable()"
                            class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition">
                            <i class="ti ti-download"></i> Download CSV
                        </button>
                    </div>
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
                {{-- Tren card (hanya untuk grafik 1 wilayah 1 kategori) --}}
                <div id="tren-card" class="hidden flex items-center justify-between gap-4 p-5 rounded-2xl border">
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
                <div id="interpretasi-wilayah" class="rounded-2xl border p-5 hidden"></div>

                {{-- Interpretasi tabel: tiap komponen --}}
                <div id="interpretasi-tabel-komponen" class="hidden space-y-3"></div>
            </div>
        </div>

        {{-- Right: Filter Panel --}}
        <div class="w-64 bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm p-5 h-fit space-y-5">
<!-- 
            {{-- BPS Logo --}}
            <div class="flex items-center gap-2 pb-3 border-b border-gray-100 dark:border-gray-700">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f9/Logo_BPS.svg/200px-Logo_BPS.svg.png"
                     alt="Logo BPS" class="h-8 w-auto">
                <div>
                    <p class="text-xs font-bold text-gray-700 dark:text-white leading-tight">Badan Pusat Statistik</p>
                    <p class="text-[10px] text-gray-400 leading-tight">Statistics Indonesia</p>
                </div>
            </div> -->

            <h3 class="text-sm font-bold text-gray-700 dark:text-white">Sesuaikan tampilan grafik</h3>

            {{-- Filter: Judul Data --}}
            <div>
                <label class="block text-sm font-semibold text-blue-500 mb-2">Judul data</label>
                <div class="relative">
                    <select id="filter-judul"
                        class="w-full appearance-none border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih judul data...</option>
                        @php
                            $grouped = $statistics->groupBy('statistic_title_id');
                        @endphp
                        @foreach($grouped as $titleId => $group)
                            @php
                                $first = $group->first();
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

            {{-- Filter: Wilayah --}}
            <div>
                <label class="block text-sm font-semibold text-blue-500 mb-2">Wilayah data</label>
                <div id="filter-wilayah" class="space-y-2">
                    <p class="text-xs text-gray-400">Pilih judul data dulu</p>
                </div>
            </div>

            {{-- Filter: Komponen/Kategori — HANYA tampil di tab Grafik --}}
            <div id="filter-kategori-wrap">
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
let currentData    = {};
let wilayahList    = [];
let allComponents  = [];
let currentTab     = 'grafik'; // track active tab

const COLORS = [
    { border: '#2563eb', bg: 'rgba(37,99,235,0.10)' },
    { border: '#dc2626', bg: 'rgba(220,38,38,0.10)' },
    { border: '#16a34a', bg: 'rgba(22,163,74,0.10)' },
    { border: '#d97706', bg: 'rgba(217,119,6,0.10)' },
    { border: '#7c3aed', bg: 'rgba(124,58,237,0.10)' },
];

// ── Tab switch ─────────────────────────────────────────────────────────────
function switchTab(tab) {
    currentTab = tab;
    const isG = tab === 'grafik';
    document.getElementById('view-grafik').classList.toggle('hidden', !isG);
    document.getElementById('view-tabel').classList.toggle('hidden',  isG);

    // Sembunyikan filter komponen di tab tabel
    document.getElementById('filter-kategori-wrap').classList.toggle('hidden', !isG);

    document.getElementById('tab-grafik').className = isG
        ? 'inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition bg-blue-600 text-white'
        : 'inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition border border-gray-200 text-gray-600 hover:bg-gray-50';
    document.getElementById('tab-tabel').className = !isG
        ? 'inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition bg-blue-600 text-white'
        : 'inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition border border-gray-200 text-gray-600 hover:bg-gray-50';

    applyFilters();
}

// ── Pilih judul data ───────────────────────────────────────────────────────
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

        const allYears = [...new Set(
            wilayahList.flatMap(w => w.values.map(v => v.y_label || String(v.year))).filter(Boolean)
        )].sort();
        buildTahunFilter(allYears);
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

// ── Apply filter & render ──────────────────────────────────────────────────
function applyFilters() {
    if (!wilayahList.length) return;

    const selectedCat    = document.querySelector('.kat-radio:checked')?.value ?? null;
    const checkedYears   = [...document.querySelectorAll('.tahun-check:checked')].map(c => c.value);
    const checkedWilayah = [...document.querySelectorAll('.wilayah-check:checked')].map(c => c.value);

    const datasets = [];
    wilayahList.forEach((w, wi) => {
        if (!checkedWilayah.includes(w.wilayah)) return;

        // Di tab tabel: tidak filter per kategori, ambil semua kategori
        const rows = w.values
            .filter(v => currentTab === 'tabel' || !selectedCat || v.x_label === selectedCat)
            .filter(v => checkedYears.includes(v.y_label || String(v.year)))
            .sort((a, b) => String(a.y_label || a.year).localeCompare(String(b.y_label || b.year)));

        if (!rows.length) return;

        const color = COLORS[wi % COLORS.length];
        datasets.push({
            wilayah: w.wilayah,
            updated: w.updated,
            labels:  rows.map(v => v.y_label || String(v.year)),
            values:  rows.map(v => parseFloat(v.value)),
            rawRows: rows, // simpan rows lengkap untuk tabel
            color,
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

// ── Render chart (multi-line) ──────────────────────────────────────────────
function renderChart(datasets, kategori) {
    if (!datasets.length) return;

    const katLabel = kategori
        ? (kategori.startsWith('· ') ? kategori.slice(2) : kategori)
        : currentData.judul;

    const wilayahNames = datasets.map(d => d.wilayah).join(', ');
    document.getElementById('chart-title').textContent    = currentData.judul + ' — ' + katLabel;
    document.getElementById('chart-subtitle').textContent = wilayahNames + ' · Update Terakhir: ' + datasets[0].updated;

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

// ── Interpretasi Grafik ────────────────────────────────────────────────────
// Menampilkan: tren card + interpretasi tiap pasangan tahun per wilayah + perbandingan antar wilayah (jika >1)
function renderInterpretasiGrafik(datasets, selectedCat) {
    const section = document.getElementById('interpretasi-section');
    document.getElementById('interpretasi-tabel-komponen').classList.add('hidden');

    if (!datasets.length) {
        section.classList.add('hidden');
        return;
    }

    const komponen = allComponents.find(c => c.nama === selectedCat) || null;

    if (datasets.length === 1) {
        // 1 wilayah: tren + perubahan per periode
        const d = datasets[0];
        if (d.labels.length < 2) { section.classList.add('hidden'); return; }

        document.getElementById('tren-card').classList.remove('hidden');
        document.getElementById('interpretasi-card').classList.remove('hidden');
        document.getElementById('interpretasi-wilayah').classList.add('hidden');
        renderTrenCard(d.labels, d.values, d, komponen);
        renderPairsForDataset(d.labels, d.values, d, komponen);
        section.classList.remove('hidden');
    } else {
        // Multi wilayah: per-wilayah tren + perbandingan
        document.getElementById('tren-card').classList.add('hidden');
        document.getElementById('interpretasi-card').classList.add('hidden');

        let html = '';
        datasets.forEach((d, i) => {
            if (d.labels.length < 2) return;
            const color = COLORS[i % COLORS.length].border;
            html += `<div class="rounded-2xl border border-gray-100 p-4 space-y-3">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full shrink-0" style="background:${color}"></span>
                    <span class="text-xs font-bold text-gray-700 uppercase tracking-wide">${escH(d.wilayah)}</span>
                </div>`;
            html += buildTrenMiniCard(d.labels, d.values, d, komponen);
            html += buildPairsHtml(d.labels, d.values, d, komponen);
            html += `</div>`;
        });

        document.getElementById('interpretasi-pairs').innerHTML = html;

        // Perbandingan antar wilayah multi-tahun
        renderPerbandinganWilayahMultiTahun(datasets, selectedCat);
        section.classList.remove('hidden');
    }
}

// ── Mini tren card untuk multi-wilayah ───────────────────────────────────
function buildTrenMiniCard(labels, values, dataset, komponen) {
    const nilaiAwal  = values[0];
    const nilaiAkhir = values[values.length - 1];
    const selisih    = nilaiAkhir - nilaiAwal;
    const tren       = selisih > 0 ? 'naik' : selisih < 0 ? 'turun' : 'tetap';
    const cfg        = { naik: { color: 'red', icon: 'ti-trending-up', label: 'Naik', sign: '+' }, turun: { color: 'green', icon: 'ti-trending-down', label: 'Turun', sign: '' }, tetap: { color: 'gray', icon: 'ti-minus', label: 'Tetap', sign: '' } }[tren];
    return `<div class="flex items-center justify-between gap-3 p-3 rounded-xl bg-${cfg.color}-50 border border-${cfg.color}-100">
        <div class="text-center">
            <p class="text-[10px] text-gray-400">${labels[0]}</p>
            <p class="text-lg font-black text-gray-800">${nilaiAwal.toFixed(2)}</p>
        </div>
        <div class="flex flex-col items-center gap-0.5">
            <i class="ti ${cfg.icon} text-xl text-${cfg.color}-500"></i>
            <span class="text-xs font-bold text-${cfg.color}-500">${cfg.label}</span>
            <span class="text-xs text-${cfg.color}-400">${cfg.sign}${Math.abs(selisih).toFixed(2)}</span>
        </div>
        <div class="text-center">
            <p class="text-[10px] text-gray-400">${labels[labels.length-1]}</p>
            <p class="text-lg font-black text-gray-800">${nilaiAkhir.toFixed(2)}</p>
        </div>
    </div>`;
}

// ── Render tren card utama (1 wilayah) ────────────────────────────────────
function renderTrenCard(labels, values, dataset, komponen) {
    const nilaiAwal  = values[0];
    const nilaiAkhir = values[values.length - 1];
    const tahunAwal  = labels[0];
    const tahunAkhir = labels[labels.length - 1];
    const selisih    = nilaiAkhir - nilaiAwal;
    const tren       = selisih > 0 ? 'naik' : selisih < 0 ? 'turun' : 'tetap';
    const cfg        = { naik: { color: 'red', icon: 'ti-trending-up', label: 'Naik', sign: '+' }, turun: { color: 'green', icon: 'ti-trending-down', label: 'Turun', sign: '' }, tetap: { color: 'gray', icon: 'ti-minus', label: 'Tetap', sign: '' } }[tren];

    const interpKecil = komponen?.interpretasi_lebih_kecil || dataset?.interp_kecil || currentData.interpKecil || '';
    const interpBesar = komponen?.interpretasi_lebih_besar || dataset?.interp_besar || currentData.interpBesar || '';
    const interpTetap = komponen?.interpretasi_tetap       || dataset?.interp_tetap || currentData.interpTetap || '';
    const teksMap     = { naik: interpBesar || 'Data mengalami kenaikan.', turun: interpKecil || 'Data mengalami penurunan.', tetap: interpTetap || 'Data tidak berubah secara signifikan.' };

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
    document.getElementById('interpretasi-teks').textContent    = teksMap[tren];

    renderPairsForDataset(labels, values, dataset, komponen);
}

// ── Render perubahan per periode untuk 1 dataset (1 wilayah) ─────────────
function renderPairsForDataset(labels, values, dataset, komponen) {
    const pairsDiv = document.getElementById('interpretasi-pairs');
    let html = `<div class="flex items-center gap-2 mb-1">
        <div class="flex-1 h-px bg-gray-100 dark:bg-gray-700"></div>
        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Perubahan Per Periode</span>
        <div class="flex-1 h-px bg-gray-100 dark:bg-gray-700"></div>
    </div>`;

    for (let i = 0; i < labels.length - 1; i++) {
        html += buildPairCard(labels[i], labels[i+1], values[i], values[i+1], false, labels, values, komponen, dataset);
    }

    if (labels.length > 2) {
        html += `<div class="flex items-center gap-2 mt-4 mb-1">
            <div class="flex-1 h-px bg-gray-100 dark:bg-gray-700"></div>
            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Perubahan Total</span>
            <div class="flex-1 h-px bg-gray-100 dark:bg-gray-700"></div>
        </div>`;
        html += buildPairCard(labels[0], labels[labels.length-1], values[0], values[values.length-1], true, labels, values, komponen, dataset);
    }

    pairsDiv.innerHTML = html;
}

// ── Build pairs HTML (return string, untuk multi-wilayah) ─────────────────
function buildPairsHtml(labels, values, dataset, komponen) {
    let html = `<div class="space-y-2">
        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Perubahan Per Periode</p>`;
    for (let i = 0; i < labels.length - 1; i++) {
        html += buildPairCard(labels[i], labels[i+1], values[i], values[i+1], false, labels, values, komponen, dataset);
    }
    if (labels.length > 2) {
        html += `<p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-3">Perubahan Total</p>`;
        html += buildPairCard(labels[0], labels[labels.length-1], values[0], values[values.length-1], true, labels, values, komponen, dataset);
    }
    html += '</div>';
    return html;
}

// ── Perbandingan antar wilayah MULTI TAHUN (untuk grafik >1 wilayah) ──────
function renderPerbandinganWilayahMultiTahun(datasets, kategori) {
    const container = document.getElementById('interpretasi-wilayah');
    if (datasets.length < 2) { container.classList.add('hidden'); return; }

    // Kumpulkan semua tahun unik
    const allYears = [...new Set(datasets.flatMap(d => d.labels))].sort();

    // Buat tabel perbandingan per tahun
    let rowsHtml = allYears.map(year => {
        const vals = datasets.map(d => {
            const idx = d.labels.indexOf(year);
            return idx >= 0 ? d.values[idx] : null;
        });

        const validVals = vals.filter(v => v !== null);
        if (!validVals.length) return '';

        const maxVal = Math.max(...validVals);
        const minVal = Math.min(...validVals);

        const cells = datasets.map((d, i) => {
            const v = vals[i];
            const isMax = v === maxVal && validVals.length > 1;
            const isMin = v === minVal && validVals.length > 1 && maxVal !== minVal;
            const cls = isMax ? 'text-red-600 font-bold' : isMin ? 'text-green-600 font-bold' : 'text-gray-700';
            return `<td class="px-3 py-2 text-xs ${cls} text-center">${v !== null ? v.toFixed(2) : '-'}</td>`;
        }).join('');

        return `<tr class="border-b border-gray-50 hover:bg-gray-50/50">
            <td class="px-3 py-2 text-xs font-semibold text-gray-600">${year}</td>
            ${cells}
        </tr>`;
    }).join('');

    const headerCells = datasets.map((d, i) => {
        const color = COLORS[i % COLORS.length].border;
        return `<th class="px-3 py-2 text-xs font-bold text-center" style="color:${color}">${escH(d.wilayah)}</th>`;
    }).join('');

    // Ringkasan tiap tahun terakhir
    const lastYear = allYears[allYears.length - 1];
    const lastVals = datasets.map(d => {
        const idx = d.labels.indexOf(lastYear);
        return { wilayah: d.wilayah, value: idx >= 0 ? d.values[idx] : null };
    }).filter(x => x.value !== null).sort((a, b) => b.value - a.value);

    const totalSum  = lastVals.reduce((s, x) => s + x.value, 0);
    const rataRata  = lastVals.length ? (totalSum / lastVals.length).toFixed(2) : '-';
    const tertinggi = lastVals[0];
    const terendah  = lastVals[lastVals.length - 1];
    const selisih   = tertinggi && terendah ? (tertinggi.value - terendah.value).toFixed(2) : '-';

    container.innerHTML = `
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 flex items-center justify-center rounded-xl bg-indigo-100 shrink-0">
                <i class="ti ti-map-pin text-indigo-600"></i>
            </div>
            <div class="flex-1">
                <p class="text-xs font-bold uppercase text-indigo-500 mb-3">
                    Perbandingan Antar Wilayah (${datasets.length} wilayah, ${allYears.length} tahun)
                </p>
                <div class="overflow-x-auto mb-4">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="px-3 py-2 text-xs font-bold text-left text-gray-500">Tahun</th>
                                ${headerCells}
                            </tr>
                        </thead>
                        <tbody>${rowsHtml}</tbody>
                    </table>
                </div>
                <div class="grid grid-cols-2 gap-2 text-xs">
                    <div class="p-2 rounded-lg bg-red-50 border border-red-100">
                        <p class="text-red-500 font-bold mb-0.5">Tertinggi (${lastYear})</p>
                        <p class="text-gray-700 font-semibold">${tertinggi ? escH(tertinggi.wilayah) : '-'} — ${tertinggi ? tertinggi.value.toFixed(2) : '-'}</p>
                    </div>
                    <div class="p-2 rounded-lg bg-green-50 border border-green-100">
                        <p class="text-green-600 font-bold mb-0.5">Terendah (${lastYear})</p>
                        <p class="text-gray-700 font-semibold">${terendah ? escH(terendah.wilayah) : '-'} — ${terendah ? terendah.value.toFixed(2) : '-'}</p>
                    </div>
                    <div class="p-2 rounded-lg bg-blue-50 border border-blue-100">
                        <p class="text-blue-500 font-bold mb-0.5">Rata-rata (${lastYear})</p>
                        <p class="text-gray-700 font-semibold">${rataRata}</p>
                    </div>
                    <div class="p-2 rounded-lg bg-purple-50 border border-purple-100">
                        <p class="text-purple-500 font-bold mb-0.5">Selisih</p>
                        <p class="text-gray-700 font-semibold">${selisih}</p>
                    </div>
                </div>
            </div>
        </div>`;
    container.classList.remove('hidden');
}

// ── Interpretasi Tabel ─────────────────────────────────────────────────────
// Menampilkan interpretasi tiap komponen (tanpa perubahan per periode)
function renderInterpretasiTabel(datasets, selectedCat) {
    const section   = document.getElementById('interpretasi-section');
    const kompDiv   = document.getElementById('interpretasi-tabel-komponen');

    // Sembunyikan elemen grafik
    document.getElementById('tren-card').classList.add('hidden');
    document.getElementById('interpretasi-card').classList.add('hidden');
    document.getElementById('interpretasi-pairs').innerHTML = '';
    document.getElementById('interpretasi-wilayah').classList.add('hidden');

    if (!datasets.length) { section.classList.add('hidden'); return; }

    // Semua komponen termasuk sub-kategori
    const allKatsRaw = allComponents.length
        ? allComponents
        : [...new Set(datasets.flatMap(d => (d.rawRows || []).map(r => r.x_label)).filter(Boolean))]
            .map(n => ({ nama: n, is_sub: n.startsWith('· ') }));
    const katsFromData = allKatsRaw.map(c => c.nama);

    if (!katsFromData.length) { section.classList.add('hidden'); return; }

    let html = `<div class="flex items-center gap-2 mb-3">
        <div class="flex-1 h-px bg-gray-100 dark:bg-gray-700"></div>
        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Interpretasi Per Komponen</span>
        <div class="flex-1 h-px bg-gray-100 dark:bg-gray-700"></div>
    </div>`;

    katsFromData.forEach(kat => {
        const kompMeta = allKatsRaw.find(c => c.nama === kat) || null;
        const komponen = allComponents.find(c => c.nama === kat) || null;
        const isSub    = kompMeta?.is_sub || kat.startsWith('· ');
        const katLabel = isSub ? kat.replace(/^· /, '') : kat;
        const headerBg = isSub
            ? 'bg-indigo-50/40 dark:bg-indigo-900/10 border-indigo-100 dark:border-indigo-900'
            : 'border-gray-100 dark:border-gray-800';

        // Ambil data per wilayah untuk komponen ini
        const katDatasets = datasets.map(d => {
            const rows = (d.rawRows || d.labels.map((lbl, i) => ({ x_label: selectedCat || kat, y_label: lbl, value: d.values[i] })))
                .filter(r => r.x_label === kat)
                .sort((a, b) => String(a.y_label || a.year).localeCompare(String(b.y_label || b.year)));
            if (!rows.length) return null;
            return {
                wilayah: d.wilayah,
                labels:  rows.map(r => r.y_label || String(r.year)),
                values:  rows.map(r => parseFloat(r.value)),
                color:   d.color,
                interp_kecil: d.interp_kecil,
                interp_besar: d.interp_besar,
                interp_tetap: d.interp_tetap,
            };
        }).filter(Boolean);

        if (!katDatasets.length) return;

        html += `<div class="rounded-2xl border p-4 space-y-3 ${headerBg}">
            <div class="flex items-center gap-2 ${isSub ? 'pl-3' : ''}">
                <i class="ti ${isSub ? 'ti-minus text-indigo-300' : 'ti-category text-blue-500'} text-sm"></i>
                <span class="text-sm font-${isSub ? 'medium text-gray-500 italic' : 'bold text-gray-700 dark:text-white'}">${isSub ? '<span class="text-indigo-300 mr-1">·</span>' : ''}${escH(katLabel)}</span>
                ${komponen?.satuan ? `<span class="text-xs text-gray-400">(${escH(komponen.satuan)})</span>` : ''}
            </div>`;

        // Per wilayah
        katDatasets.forEach((kd, i) => {
            if (kd.labels.length < 2) return;
            const nilaiAwal  = kd.values[0];
            const nilaiAkhir = kd.values[kd.values.length - 1];
            const selisih    = nilaiAkhir - nilaiAwal;
            const pct        = nilaiAwal !== 0 ? ((selisih / Math.abs(nilaiAwal)) * 100).toFixed(1) : '0.0';
            const tren       = selisih > 0 ? 'naik' : selisih < 0 ? 'turun' : 'tetap';
            const cfg        = { naik: { color: 'red', icon: 'ti-trending-up', label: 'Naik', sign: '+' }, turun: { color: 'green', icon: 'ti-trending-down', label: 'Turun', sign: '' }, tetap: { color: 'gray', icon: 'ti-minus', label: 'Tetap', sign: '' } }[tren];

            const interpKecil = komponen?.interpretasi_lebih_kecil || kd?.interp_kecil || currentData.interpKecil || '';
            const interpBesar = komponen?.interpretasi_lebih_besar || kd?.interp_besar || currentData.interpBesar || '';
            const interpTetap = komponen?.interpretasi_tetap       || kd?.interp_tetap || currentData.interpTetap || '';
            const teksAdmin   = tren === 'naik' ? interpBesar : tren === 'turun' ? interpKecil : interpTetap;

            const absSelisih = Math.abs(selisih).toFixed(2);
            const absPct     = Math.abs(parseFloat(pct)).toFixed(1);

            let teksCerita = `Nilai ${escH(currentData.judul)} (${escH(kat)}) di ${escH(kd.wilayah)} `;
            if (tren === 'tetap') {
                teksCerita += `tidak berubah dari ${kd.labels[0]} hingga ${kd.labels[kd.labels.length-1]}, tetap di ${nilaiAwal.toFixed(2)}.`;
            } else {
                teksCerita += `${tren === 'naik' ? 'meningkat' : 'menurun'} sebesar ${absSelisih} (${absPct}%) dari ${kd.labels[0]} (${nilaiAwal.toFixed(2)}) ke ${kd.labels[kd.labels.length-1]} (${nilaiAkhir.toFixed(2)}).`;
            }
            if (teksAdmin) teksCerita += ' ' + teksAdmin;

            const colorBar = COLORS[i % COLORS.length].border;
            html += `<div class="flex items-start gap-3 p-3 rounded-xl border border-${cfg.color}-100 bg-${cfg.color}-50/40">
                <span class="w-2 h-full rounded-full shrink-0 self-stretch" style="background:${colorBar}; min-width:4px; min-height:24px"></span>
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs font-semibold text-gray-600">${escH(kd.wilayah)}</span>
                        <span class="inline-flex items-center gap-1 text-xs font-bold text-${cfg.color}-500 bg-${cfg.color}-100 px-2 py-0.5 rounded-lg">
                            <i class="ti ${cfg.icon}"></i> ${cfg.label} ${cfg.sign}${absSelisih} (${absPct}%)
                        </span>
                    </div>
                    <p class="text-xs text-gray-600 dark:text-gray-400 leading-relaxed">${teksCerita}</p>
                </div>
            </div>`;
        });

        // Jika multi-wilayah: ringkasan komparasi komponen ini di tahun terakhir
        if (katDatasets.length > 1) {
            const lastYear    = [...new Set(katDatasets.flatMap(d => d.labels))].sort().at(-1);
            const lastVals    = katDatasets.map(d => { const idx = d.labels.indexOf(lastYear); return { wilayah: d.wilayah, value: idx >= 0 ? d.values[idx] : null }; }).filter(x => x.value !== null).sort((a,b) => b.value - a.value);
            if (lastVals.length > 1) {
                const top = lastVals[0]; const bot = lastVals[lastVals.length-1];
                html += `<div class="flex items-center gap-2 p-2 rounded-lg bg-indigo-50 border border-indigo-100 text-xs text-indigo-700">
                    <i class="ti ti-arrows-diff text-indigo-400"></i>
                    Pada ${lastYear}: <b>${escH(top.wilayah)}</b> tertinggi (${top.value.toFixed(2)}), 
                    <b>${escH(bot.wilayah)}</b> terendah (${bot.value.toFixed(2)}), 
                    selisih <b>${(top.value - bot.value).toFixed(2)}</b>
                </div>`;
            }
        }

        html += `</div>`;
    });

    kompDiv.innerHTML = html;
    kompDiv.classList.remove('hidden');
    section.classList.remove('hidden');
}

// ── Render tabel (multi-wilayah, semua komponen termasuk sub) ────────────
function renderTable(datasets, kategori) {
    if (!datasets.length) {
        document.getElementById('table-body').innerHTML =
            '<tr><td colspan="4" class="text-center py-8 text-gray-400">Tidak ada data</td></tr>';
        return;
    }

    // Semua komponen termasuk sub-kategori, urut sesuai urutan master
    const allKats  = allComponents.length
        ? allComponents.map(c => ({ nama: c.nama, is_sub: c.is_sub, satuan: c.satuan }))
        : [...new Set(datasets.flatMap(d => (d.rawRows || []).map(r => r.x_label)).filter(Boolean))]
            .map(n => ({ nama: n, is_sub: n.startsWith('· '), satuan: '' }));
    const katsFromData = allKats.map(k => k.nama);

    const allYears = [...new Set(datasets.flatMap(d =>
        (d.rawRows || d.labels.map((l, i) => ({ y_label: l }))).map(r => r.y_label || String(r.year))
    ).filter(Boolean))].sort();

    document.getElementById('table-head').innerHTML = `
        <tr class="border-b border-gray-100">
            <th class="text-left px-4 py-3 font-semibold text-blue-600">Kategori</th>
            <th class="text-left px-4 py-3 font-semibold text-blue-600">Satuan</th>
            <th class="text-left px-4 py-3 font-semibold text-blue-600">Tahun</th>
            ${datasets.map(d => `<th class="text-left px-4 py-3 font-semibold text-blue-600">${escH(d.wilayah)}</th>`).join('')}
        </tr>`;

    let bodyHtml = '';

    if (katsFromData.length > 0) {
        allKats.forEach(({ nama: kat, is_sub: isSub, satuan: satuanMeta }) => {
            const komp   = allComponents.find(c => c.nama === kat);
            const satuan = komp?.satuan || satuanMeta || '';
            const katDisplay = isSub ? kat.replace(/^· /, '') : kat;
            const colSpan = datasets.length + 3; // Kategori + Satuan + Tahun + N wilayah

            if (isSub) {
                // Sub-kategori: 1 baris penuh sebagai separator/header grup
                bodyHtml += `<tr class="border-b border-indigo-100 bg-indigo-50/40">
                    <td colspan="${colSpan}" class="px-4 py-2 text-xs font-semibold text-indigo-400 italic">
                        <span class="text-indigo-300 mr-1">·</span>${escH(katDisplay)}
                    </td>
                </tr>`;
                return;
            }

            // Kategori biasa: 1 baris per tahun
            allYears.forEach((year, yi) => {
                const cells = datasets.map(d => {
                    const row = (d.rawRows || []).find(r => r.x_label === kat && (r.y_label || String(r.year)) === year);
                    const val = row ? parseFloat(row.value).toFixed(2) : '-';
                    return `<td class="px-4 py-2.5 text-gray-700 text-sm font-semibold">${val}</td>`;
                }).join('');
                const isFirstRow = yi === 0;
                bodyHtml += `<tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">
                    ${isFirstRow ? `<td class="px-4 py-2.5 text-gray-800 text-sm font-medium" rowspan="${allYears.length}">${escH(katDisplay)}</td>
                    <td class="px-4 py-2.5 text-gray-400 text-xs" rowspan="${allYears.length}">${escH(satuan)}</td>` : ''}
                    <td class="px-4 py-2.5 text-gray-700 text-sm">${year}</td>
                    ${cells}
                </tr>`;
            });
        });
    } else {
        // Tanpa kategori: tampilkan per tahun saja
        allYears.forEach(year => {
            const cells = datasets.map(d => {
                const idx = d.labels.indexOf(year);
                const val = idx >= 0 ? d.values[idx].toFixed(2) : '-';
                return `<td class="px-4 py-2.5 text-gray-700 text-sm font-semibold">${val}</td>`;
            }).join('');
            bodyHtml += `<tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">
                <td class="px-4 py-2.5 text-gray-500 text-xs">-</td>
                <td class="px-4 py-2.5 text-gray-400 text-xs">-</td>
                <td class="px-4 py-2.5 text-gray-700 text-sm">${year}</td>
                ${cells}
            </tr>`;
        });
    }

    document.getElementById('table-body').innerHTML = bodyHtml || '<tr><td colspan="6" class="text-center py-8 text-gray-400">Tidak ada data</td></tr>';
}

// ── Download tabel sebagai CSV ─────────────────────────────────────────────
function downloadTable() {
    const datasets = getCurrentDatasets();
    if (!datasets.length) { alert('Tidak ada data untuk di-download'); return; }

    const allKats  = allComponents.length
        ? allComponents.map(c => c.nama)
        : [...new Set(datasets.flatMap(d => (d.rawRows || []).map(r => r.x_label)).filter(Boolean))];
    const allYears = [...new Set(datasets.flatMap(d =>
        (d.rawRows || d.labels.map((l, i) => ({ y_label: l }))).map(r => r.y_label || String(r.year))
    ).filter(Boolean))].sort();

    let csv = 'Kategori,Satuan,Tahun,' + datasets.map(d => d.wilayah).join(',') + '\n';

    if (allKats.length) {
        allKats.forEach(kat => {
            const komp   = allComponents.find(c => c.nama === kat);
            const isSub  = komp?.is_sub || kat.startsWith('· ');
            const satuan = komp?.satuan || '';
            const katDisplay = kat.replace(/^· /, '');

            if (isSub) {
                // Sub-kategori: 1 baris separator tanpa nilai
                csv += `"· ${katDisplay}","","","${datasets.map(() => '').join('","')}"\n`;
                return;
            }

            allYears.forEach(year => {
                const vals = datasets.map(d => {
                    const row = (d.rawRows || []).find(r => r.x_label === kat && (r.y_label || String(r.year)) === year);
                    return row ? parseFloat(row.value).toFixed(2) : '';
                }).join(',');
                csv += `"${katDisplay}","${satuan}","${year}",${vals}\n`;
            });
        });
    } else {
        allYears.forEach(year => {
            const vals = datasets.map(d => {
                const idx = d.labels.indexOf(year);
                return idx >= 0 ? d.values[idx].toFixed(2) : '';
            }).join(',');
            csv += `"-","-","${year}",${vals}\n`;
        });
    }

    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.setAttribute('href', URL.createObjectURL(blob));
    link.setAttribute('download', `data_${currentData.judul}_${new Date().toISOString().slice(0,10)}.csv`);
    link.style.visibility = 'hidden';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function getCurrentDatasets() {
    if (!wilayahList.length) return [];
    const selectedCat    = document.querySelector('.kat-radio:checked')?.value ?? null;
    const checkedYears   = [...document.querySelectorAll('.tahun-check:checked')].map(c => c.value);
    const checkedWilayah = [...document.querySelectorAll('.wilayah-check:checked')].map(c => c.value);

    return wilayahList.map((w, wi) => {
        if (!checkedWilayah.includes(w.wilayah)) return null;
        const rows = w.values
            .filter(v => !selectedCat || currentTab === 'tabel' || v.x_label === selectedCat)
            .filter(v => checkedYears.includes(v.y_label || String(v.year)))
            .sort((a, b) => String(a.y_label || a.year).localeCompare(String(b.y_label || b.year)));
        if (!rows.length) return null;
        return {
            wilayah: w.wilayah,
            labels:  rows.map(v => v.y_label || String(v.year)),
            values:  rows.map(v => parseFloat(v.value)),
            rawRows: rows,
            color:   COLORS[wi % COLORS.length],
        };
    }).filter(Boolean);
}

// ── Build kartu satu pasangan tahun ───────────────────────────────────────
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

// ── Generate teks interpretasi ─────────────────────────────────────────────
function generateInterpretasiTeks(tA, tB, vA, vB, selisih, pct, tren, isTotal, allLabels, komponen, dataset) {
    const judulData  = currentData.judul   || 'data';
    const wilayah    = dataset?.wilayah    || 'wilayah ini';
    const absSelisih = Math.abs(selisih).toFixed(2);
    const absPct     = Math.abs(parseFloat(pct)).toFixed(1);
    const mag        = Math.abs(parseFloat(pct));
    const skala      = mag < 2 ? 'kecil' : mag < 5 ? 'sedang' : 'besar';

    let teksAdmin = '';
    if (tren === 'tetap')       teksAdmin = komponen?.interpretasi_tetap       || dataset?.interp_tetap || currentData.interpTetap || '';
    else if (tren === 'naik')   teksAdmin = komponen?.interpretasi_lebih_besar || dataset?.interp_besar || currentData.interpBesar || '';
    else                        teksAdmin = komponen?.interpretasi_lebih_kecil || dataset?.interp_kecil || currentData.interpKecil || '';

    if (tren === 'tetap') {
        let teks = `Nilai ${judulData} di ${wilayah} tidak berubah antara ${tA} dan ${tB}, tetap di ${vA.toFixed(2)}. `;
        if (teksAdmin) teks += teksAdmin;
        return teks.trim();
    }

    const arah     = tren === 'naik' ? 'meningkat' : 'menurun';
    const arahkata = tren === 'naik' ? 'Peningkatan' : 'Penurunan';
    let teks = `Pada periode ${tA}–${tB}, nilai ${judulData} di ${wilayah} ${arah} sebesar ${absSelisih} (${absPct}%), dari ${vA.toFixed(2)} menjadi ${vB.toFixed(2)}. `;

    if (skala === 'kecil')        teks += `Perubahan ini tergolong kecil dan kondisi relatif stabil. `;
    else if (skala === 'sedang')  teks += `${arahkata} ini cukup signifikan dan perlu mendapat perhatian. `;
    else                          teks += `${arahkata} yang cukup besar ini memerlukan perhatian khusus dari pemangku kebijakan. `;

    if (teksAdmin) teks += teksAdmin + ' ';

    if (isTotal && allLabels && allLabels.length > 2) {
        teks += `Secara keseluruhan selama ${allLabels.length} periode (${tA}–${tB}), tren menunjukkan ${tren === 'naik' ? 'kenaikan' : 'penurunan'} kumulatif.`;
    }

    return teks.trim();
}

function escH(str) {
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
</script>
@endsection