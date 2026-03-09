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

                {{-- GRAFIK VIEW --}}
                <div id="view-grafik">
                    <div id="chart-header" class="mb-1">
                        <h2 id="chart-title" class="text-sm font-bold text-gray-800 dark:text-white">-</h2>
                        <p class="text-xs text-gray-400" id="chart-subtitle">-</p>
                    </div>
                    <div class="relative mt-4" style="height: 320px;">
                        <canvas id="mainChart"></canvas>
                    </div>
                </div>

                {{-- TABEL VIEW --}}
                <div id="view-tabel" class="hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm" id="data-table">
                            <thead id="table-head">
                                <tr class="border-b border-gray-100">
                                    <th class="text-left px-4 py-3 font-semibold text-blue-600">Tahun</th>
                                    <th class="text-left px-4 py-3 font-semibold text-blue-600">Nilai</th>
                                    <th class="text-left px-4 py-3 font-semibold text-blue-600">Wilayah</th>
                                    <th class="text-left px-4 py-3 font-semibold text-blue-600">Judul</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                <tr><td colspan="4" class="text-center py-8 text-gray-400">Pilih data untuk ditampilkan</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            {{-- INTERPRETASI --}}
            <div id="interpretasi-section" class="hidden">

                {{-- Ringkasan Tren --}}
                <div id="tren-card" class="flex items-center justify-between gap-4 p-5 rounded-2xl border mb-4">
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

                {{-- Teks Interpretasi --}}
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

            </div>

        </div>

        {{-- Right: Filter Panel --}}
        <div class="w-64 bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm p-5 h-fit space-y-5">

            <h3 class="text-sm font-bold text-gray-700 dark:text-white">Sesuaikan tampilan grafik</h3>

            {{-- Filter: Judul Data --}}
            <div>
                <label class="block text-sm font-semibold text-blue-500 mb-2">Judul data</label>
                <div class="relative">
                    <select id="filter-judul"
                        class="w-full appearance-none border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih judul data...</option>
                        @foreach($statistics as $stat)
                            <option value="{{ $stat->id }}"
                                data-judul="{{ $stat->judul_data }}"
                                data-wilayah="{{ $stat->wilayah_data }}"
                                data-updated="{{ $stat->updated_at->format('F Y') }}"
                                data-interp-kecil="{{ addslashes($stat->interpretasi_lebih_kecil) }}"
                                data-interp-besar="{{ addslashes($stat->interpretasi_lebih_besar) }}"
                                data-values="{{ $stat->values->toJson() }}">
                                {{ $stat->judul_data }}
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
                    @foreach($statistics->pluck('wilayah_data')->unique() as $wilayah)
                    <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 cursor-pointer">
                        <input type="checkbox" value="{{ $wilayah }}" class="wilayah-check rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        {{ $wilayah }}
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Filter: Komponen/Kategori — RADIO pilih 1 --}}
            <div>
                <label class="block text-sm font-semibold text-blue-500 mb-2">Komponen / Kategori</label>
                <div id="filter-kategori" class="space-y-1.5">
                    <p class="text-xs text-gray-400">Pilih judul data dulu</p>
                </div>
            </div>

            {{-- Filter: Tahun — Checkbox --}}
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
let chartInstance = null;
let currentData   = {};  // { judul, wilayah, updated, interpKecil, interpBesar }
let allValues     = [];  // raw array dari data-values

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
    if (!isG) renderTable();
}

// ── Pilih judul data ──────────────────────────────────────────────────────
document.getElementById('filter-judul').addEventListener('change', function () {
    const opt = this.options[this.selectedIndex];
    if (!opt.value) {
        document.getElementById('interpretasi-section').classList.add('hidden');
        document.getElementById('filter-kategori').innerHTML = '<p class="text-xs text-gray-400">Pilih judul data dulu</p>';
        document.getElementById('filter-tahun').innerHTML    = '<p class="text-xs text-gray-400">Pilih kategori dulu</p>';
        return;
    }

    currentData = {
        judul:       opt.dataset.judul,
        wilayah:     opt.dataset.wilayah,
        updated:     opt.dataset.updated,
        interpKecil: opt.dataset.interpKecil,
        interpBesar: opt.dataset.interpBesar,
    };

    // Parse semua nilai dari data-values
    // Format kemungkinan: [{x_label, y_label, year, value}, ...]
    allValues = JSON.parse(opt.dataset.values || '[]');

    // Normalisasi: pastikan x_label dan y_label terisi
    allValues = allValues.map(v => ({
        ...v,
        x_label: v.x_label || null,
        y_label: v.y_label || (v.year ? String(v.year) : null),
        year:    v.year    || null,
    }));

    // Ambil semua kategori unik dari x_label
    const categories = [...new Set(allValues.map(v => v.x_label).filter(Boolean))];

    const katDiv = document.getElementById('filter-kategori');

    if (categories.length > 0) {
        // Ada x_label → data 2D, render radio TANPA auto-select
        katDiv.innerHTML = `<p class="text-xs text-blue-400 font-semibold mb-2">Pilih salah satu ↓</p>`
            + categories.map((cat) => {
            const isSub  = cat.startsWith('· ');
            const label  = isSub ? cat.slice(2) : cat;
            return `<label class="flex items-center gap-2 text-xs cursor-pointer hover:text-blue-600 transition
                        ${isSub ? 'pl-3 text-gray-400 italic' : 'text-gray-600 font-medium'}">
                <input type="radio" name="kat_radio" value="${escH(cat)}"
                    class="kat-radio shrink-0 accent-blue-600"
                    onchange="onKategoriChange()">
                ${isSub ? '<span class="text-indigo-300">·</span>' : ''}
                <span class="truncate" title="${escH(label)}">${escH(label)}</span>
            </label>`;
        }).join('');

        // Tahun: ambil semua unique dari semua values (bukan per kategori)
        const allYears = [...new Set(allValues.map(v => v.y_label || String(v.year)).filter(Boolean))].sort();
        buildTahunFilter(allYears, false); // false = belum dicentang

        // Sembunyikan chart sampai kategori dipilih
        hideChart();

    } else {
        // Tidak ada x_label → data 1D (hanya tahun + nilai)
        katDiv.innerHTML = '<p class="text-xs text-gray-400 italic">Data tidak memiliki kategori</p>';
        buildTahunFilter1D();
    }
});

function hideChart() {
    document.getElementById('interpretasi-section').classList.add('hidden');
    if (chartInstance) { chartInstance.destroy(); chartInstance = null; }
    document.getElementById('chart-title').textContent  = '-';
    document.getElementById('chart-subtitle').textContent = '-';
    document.getElementById('filter-tahun').querySelectorAll('.tahun-check')
        .forEach(cb => cb.disabled = true);
}

// ── Saat kategori (radio) berubah → enable tahun + render ────────────────
function onKategoriChange() {
    const selectedCat = document.querySelector('.kat-radio:checked')?.value;
    if (!selectedCat) return;

    // Enable semua checkbox tahun
    document.getElementById('filter-tahun').querySelectorAll('.tahun-check')
        .forEach(cb => { cb.disabled = false; cb.checked = true; });

    applyFilters();
}

// ── Build filter tahun (untuk data 2D) ───────────────────────────────────
function buildTahunFilter(years) {
    const tahunDiv = document.getElementById('filter-tahun');
    if (!years.length) {
        tahunDiv.innerHTML = '<p class="text-xs text-gray-400">Tidak ada data tahun</p>';
        return;
    }
    tahunDiv.innerHTML = years.map(y => `
        <label class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-400 cursor-pointer hover:text-blue-600 transition">
            <input type="checkbox" value="${y}" checked class="tahun-check rounded accent-blue-600">
            ${y}
        </label>
    `).join('');
    tahunDiv.querySelectorAll('.tahun-check').forEach(cb =>
        cb.addEventListener('change', applyFilters)
    );
}

// ── Build filter tahun (untuk data 1D) ───────────────────────────────────
function buildTahunFilter1D() {
    const years = [...new Set(allValues.map(v => v.y_label || String(v.year)).filter(Boolean))].sort();
    buildTahunFilter(years);
    applyFilters();
}

// ── Apply filter & render ─────────────────────────────────────────────────
function applyFilters() {
    if (!allValues.length) return;

    const selectedCat  = document.querySelector('.kat-radio:checked')?.value ?? null;
    const checkedYears = [...document.querySelectorAll('.tahun-check:checked')].map(c => c.value);

    let labels = [];
    let values = [];

    if (selectedCat) {
        // 2D: filter berdasarkan kategori + tahun
        const rows = allValues
            .filter(v => v.x_label === selectedCat)
            .filter(v => checkedYears.includes(v.y_label || String(v.year)))
            .sort((a, b) => String(a.y_label || a.year).localeCompare(String(b.y_label || b.year)));

        labels = rows.map(v => v.y_label || String(v.year));
        values = rows.map(v => parseFloat(v.value));

    } else {
        // 1D: hanya filter tahun
        const rows = allValues
            .filter(v => checkedYears.includes(v.y_label || String(v.year)))
            .sort((a, b) => String(a.y_label || a.year).localeCompare(String(b.y_label || b.year)));

        labels = rows.map(v => v.y_label || String(v.year));
        values = rows.map(v => parseFloat(v.value));
    }

    renderChart(labels, values, selectedCat);
    renderTable(labels, values, selectedCat);
    renderInterpretasi(labels, values);
}

// ── Render chart ──────────────────────────────────────────────────────────
function renderChart(labels, values, kategori) {
    const katLabel = kategori
        ? (kategori.startsWith('· ') ? kategori.slice(2) : kategori)
        : currentData.judul;

    document.getElementById('chart-title').textContent =
        currentData.judul + ' — ' + (kategori ? katLabel : currentData.wilayah);
    document.getElementById('chart-subtitle').textContent =
        currentData.wilayah + ' · Update Terakhir: ' + currentData.updated;

    if (chartInstance) chartInstance.destroy();

    const ctx = document.getElementById('mainChart').getContext('2d');
    chartInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label:            katLabel,
                data:             values,
                borderColor:      '#2563eb',
                backgroundColor:  'rgba(37,99,235,0.08)',
                borderWidth:      2,
                pointBackgroundColor: '#2563eb',
                pointRadius:      5,
                pointHoverRadius: 7,
                fill:             true,
                tension:          0.3,
            }]
        },
        options: {
            responsive:          true,
            maintainAspectRatio: false,
            plugins: {
                legend:  { display: false },
                tooltip: { callbacks: { label: ctx => ' ' + ctx.dataset.label + ': ' + ctx.parsed.y } },
            },
            scales: {
                x: { title: { display: true, text: 'Tahun', font: { size: 11 } }, grid: { display: false } },
                y: { title: { display: true, text: 'Nilai',  font: { size: 11 } }, grid: { color: '#f3f4f6' } }
            }
        }
    });
}

// ── Render tabel ──────────────────────────────────────────────────────────
function renderTable(labels, values, kategori) {
    const katLabel = kategori
        ? (kategori.startsWith('· ') ? kategori.slice(2) : kategori)
        : currentData.judul;

    document.getElementById('table-head').innerHTML = `
        <tr class="border-b border-gray-100">
            <th class="text-left px-4 py-3 font-semibold text-blue-600">Tahun</th>
            <th class="text-left px-4 py-3 font-semibold text-blue-600">Nilai</th>
            <th class="text-left px-4 py-3 font-semibold text-blue-600">Kategori</th>
            <th class="text-left px-4 py-3 font-semibold text-blue-600">Wilayah</th>
        </tr>`;

    if (!labels.length) {
        document.getElementById('table-body').innerHTML =
            '<tr><td colspan="4" class="text-center py-8 text-gray-400">Tidak ada data</td></tr>';
        return;
    }

    document.getElementById('table-body').innerHTML = labels.map((y, i) => `
        <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">
            <td class="px-4 py-3 text-gray-700 text-sm">${y}</td>
            <td class="px-4 py-3 text-gray-700 text-sm font-semibold">${values[i]}</td>
            <td class="px-4 py-3 text-gray-500 text-xs">${escH(katLabel)}</td>
            <td class="px-4 py-3 text-gray-500 text-xs">${escH(currentData.wilayah)}</td>
        </tr>
    `).join('');
}

// ── Render interpretasi ───────────────────────────────────────────────────
function renderInterpretasi(labels, values) {
    const section = document.getElementById('interpretasi-section');
    if (labels.length < 2) { section.classList.add('hidden'); return; }

    const nilaiAwal  = values[0];
    const nilaiAkhir = values[values.length - 1];
    const tahunAwal  = labels[0];
    const tahunAkhir = labels[labels.length - 1];
    const selisih    = nilaiAkhir - nilaiAwal;
    const tren       = selisih > 0 ? 'naik' : selisih < 0 ? 'turun' : 'tetap';

    document.getElementById('tren-tahun-awal').textContent  = 'Tahun ' + tahunAwal;
    document.getElementById('tren-nilai-awal').textContent  = nilaiAwal.toFixed(2);
    document.getElementById('tren-tahun-akhir').textContent = 'Tahun ' + tahunAkhir;
    document.getElementById('tren-nilai-akhir').textContent = nilaiAkhir.toFixed(2);

    const cfg = {
        naik:  { bg: 'red',   icon: 'ti-trending-up',   label: 'Naik',  sign: '+', teks: currentData.interpBesar || 'Data mengalami kenaikan.' },
        turun: { bg: 'green', icon: 'ti-trending-down',  label: 'Turun', sign: '-', teks: currentData.interpKecil || 'Data mengalami penurunan.' },
        tetap: { bg: 'gray',  icon: 'ti-minus',          label: 'Tetap', sign: '',  teks: 'Data tidak berubah antara ' + tahunAwal + ' dan ' + tahunAkhir + '.' },
    }[tren];

    document.getElementById('tren-card').className =
        `flex items-center justify-between gap-4 p-5 rounded-2xl border mb-4 bg-${cfg.bg}-50 dark:bg-${cfg.bg}-900/20 border-${cfg.bg}-100 dark:border-${cfg.bg}-800`;
    document.getElementById('interpretasi-card').className =
        `rounded-2xl border p-5 border-${cfg.bg}-100 dark:border-${cfg.bg}-800 bg-${cfg.bg}-50/50 dark:bg-${cfg.bg}-900/10`;
    document.getElementById('tren-icon').className =
        `text-3xl ti ${cfg.icon} text-${cfg.bg}-500`;
    document.getElementById('tren-label').className  = `text-xs font-bold uppercase tracking-widest text-${cfg.bg}-500`;
    document.getElementById('tren-label').textContent = cfg.label;
    document.getElementById('tren-selisih').className  = `text-xs font-semibold text-${cfg.bg}-400`;
    document.getElementById('tren-selisih').textContent = cfg.sign + Math.abs(selisih).toFixed(2);
    document.getElementById('interpretasi-icon-wrap').className =
        `mt-0.5 shrink-0 w-8 h-8 rounded-xl flex items-center justify-center bg-${cfg.bg}-100 dark:bg-${cfg.bg}-900/30`;
    document.getElementById('interpretasi-icon').className = `ti ${cfg.icon} text-${cfg.bg}-500 text-lg`;
    document.getElementById('interpretasi-label').className  = `text-xs font-bold uppercase tracking-widest mb-2 text-${cfg.bg}-500`;
    document.getElementById('interpretasi-label').textContent = 'Interpretasi — Data ' + cfg.label;
    document.getElementById('interpretasi-teks').textContent  = cfg.teks;

    section.classList.remove('hidden');
}

function escH(str) {
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
</script>
@endsection