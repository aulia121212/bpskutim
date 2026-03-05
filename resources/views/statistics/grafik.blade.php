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
                    <div id="chart-title" class="mb-1">
                        <h2 class="text-sm font-bold text-gray-800 dark:text-white">-</h2>
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
                            <thead>
                                <tr class="border-b border-gray-100">
                                    <th class="text-left px-4 py-3 font-semibold text-blue-600">Tahun</th>
                                    <th class="text-left px-4 py-3 font-semibold text-blue-600">Nilai</th>
                                    <th class="text-left px-4 py-3 font-semibold text-blue-600">Wilayah</th>
                                    <th class="text-left px-4 py-3 font-semibold text-blue-600">Judul</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                <tr>
                                    <td colspan="4" class="text-center py-8 text-gray-400">Pilih data untuk ditampilkan</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            {{-- ============================================================ --}}
            {{-- INTERPRETASI PERBANDINGAN DATA (muncul setelah pilih judul)  --}}
            {{-- ============================================================ --}}
            <div id="interpretasi-section" class="hidden">

                {{-- Ringkasan Tren --}}
                <div id="tren-card" class="flex items-center justify-between gap-4 p-5 rounded-2xl border mb-4">
                    <div class="text-center">
                        <p class="text-xs text-gray-400 mb-0.5" id="tren-tahun-awal">-</p>
                        <p class="text-2xl font-black text-gray-800 dark:text-white" id="tren-nilai-awal">-</p>
                    </div>
                    <div class="flex flex-col items-center gap-1" id="tren-icon-wrap">
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
                            <p id="interpretasi-label" class="text-xs font-bold uppercase tracking-widest mb-2 text-gray-400">
                                Interpretasi
                            </p>
                            <p id="interpretasi-teks" class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                                -
                            </p>
                        </div>
                    </div>
                </div>

            </div>
            {{-- ============================================================ --}}

        </div>

        {{-- Right: Filter Panel --}}
        <div class="w-64 bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm p-5 h-fit">

            <h3 class="text-sm font-bold text-gray-700 dark:text-white mb-4">Sesuaikan tampilan grafik</h3>

            {{-- Filter: Judul Data --}}
            <div class="mb-5">
                <label class="block text-sm font-semibold text-blue-500 mb-2">Judul data</label>
                <div class="relative">
                    <select id="filter-judul"
                        class="w-full appearance-none border border-gray-200 rounded-xl px-3 py-2 text-sm text-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Judul Data</option>
                        @foreach($statistics as $stat)
                            <option value="{{ $stat->id }}"
                                data-judul="{{ $stat->judul_data }}"
                                data-wilayah="{{ $stat->wilayah_data }}"
                                data-years="{{ $stat->values->pluck('year')->toJson() }}"
                                data-values="{{ $stat->values->sortBy('year')->pluck('value')->toJson() }}"
                                data-updated="{{ $stat->updated_at->format('F Y') }}"
                                data-interp-kecil="{{ addslashes($stat->interpretasi_lebih_kecil) }}"
                                data-interp-besar="{{ addslashes($stat->interpretasi_lebih_besar) }}">
                                {{ $stat->judul_data }}
                            </option>
                        @endforeach
                    </select>
                    <i class="ti ti-chevron-down absolute right-3 top-2.5 text-gray-400 pointer-events-none"></i>
                </div>
            </div>

            {{-- Filter: Wilayah --}}
            <div class="mb-5">
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

            {{-- Filter: Tahun --}}
            <div class="mb-2">
                <label class="block text-sm font-semibold text-blue-500 mb-2">Tahun data</label>
                <div id="filter-tahun" class="space-y-2">
                    <p class="text-xs text-gray-400">Pilih judul data dulu</p>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let chartInstance = null;
let currentData = {
    labels: [], values: [], judul: '', wilayah: '', updated: '',
    interpKecil: '', interpBesar: ''
};

// Tab switch
function switchTab(tab) {
    const isGrafik = tab === 'grafik';
    document.getElementById('view-grafik').classList.toggle('hidden', !isGrafik);
    document.getElementById('view-tabel').classList.toggle('hidden', isGrafik);
    document.getElementById('tab-grafik').className = isGrafik
        ? 'inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition bg-blue-600 text-white'
        : 'inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition border border-gray-200 text-gray-600 hover:bg-gray-50';
    document.getElementById('tab-tabel').className = !isGrafik
        ? 'inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition bg-blue-600 text-white'
        : 'inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition border border-gray-200 text-gray-600 hover:bg-gray-50';
    if (!isGrafik) renderTable();
}

// Judul filter change
document.getElementById('filter-judul').addEventListener('change', function () {
    const opt = this.options[this.selectedIndex];
    if (!opt.value) {
        document.getElementById('interpretasi-section').classList.add('hidden');
        return;
    }

    const years  = JSON.parse(opt.dataset.years);
    const values = JSON.parse(opt.dataset.values);

    currentData = {
        labels:      years,
        values:      values,
        judul:       opt.dataset.judul,
        wilayah:     opt.dataset.wilayah,
        updated:     opt.dataset.updated,
        interpKecil: opt.dataset.interpKecil,
        interpBesar: opt.dataset.interpBesar,
    };

    // Render tahun checkboxes
    const tahunDiv = document.getElementById('filter-tahun');
    tahunDiv.innerHTML = years.map(y => `
        <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
            <input type="checkbox" value="${y}" checked class="tahun-check rounded border-gray-300 text-blue-600">
            ${y}
        </label>
    `).join('');

    document.querySelectorAll('.tahun-check').forEach(cb => {
        cb.addEventListener('change', applyFilters);
    });

    applyFilters();
});

function applyFilters() {
    const checkedYears = [...document.querySelectorAll('.tahun-check:checked')].map(c => parseInt(c.value));
    const filteredLabels = currentData.labels.filter((_, i) => checkedYears.includes(parseInt(currentData.labels[i])));
    const filteredValues = currentData.values.filter((_, i) => checkedYears.includes(parseInt(currentData.labels[i])));

    renderChart(filteredLabels, filteredValues);
    renderTable(filteredLabels, filteredValues);
    renderInterpretasi(filteredLabels, filteredValues);
}

function renderChart(labels, values) {
    document.getElementById('chart-title').querySelector('h2').textContent =
        currentData.judul + ' di ' + currentData.wilayah + ' ' + (labels[0] ?? '') + '–' + (labels[labels.length - 1] ?? '');
    document.getElementById('chart-subtitle').textContent = 'Update Terakhir: ' + currentData.updated;

    if (chartInstance) chartInstance.destroy();

    const ctx = document.getElementById('mainChart').getContext('2d');
    chartInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: currentData.judul,
                data: values,
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37,99,235,0.08)',
                borderWidth: 2,
                pointBackgroundColor: '#2563eb',
                pointRadius: 5,
                pointHoverRadius: 7,
                fill: true,
                tension: 0.3,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: ctx => ctx.parsed.y + '%' } },
            },
            scales: {
                x: { title: { display: true, text: 'Tahun', font: { size: 11 } }, grid: { display: false } },
                y: { title: { display: true, text: 'Persen', font: { size: 11 } }, grid: { color: '#f3f4f6' } }
            }
        }
    });
}

function renderTable(labels, values) {
    labels = labels || currentData.labels;
    values = values || currentData.values;
    const tbody = document.getElementById('table-body');
    if (!labels.length) {
        tbody.innerHTML = '<tr><td colspan="4" class="text-center py-8 text-gray-400">Tidak ada data</td></tr>';
        return;
    }
    tbody.innerHTML = labels.map((y, i) => `
        <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
            <td class="px-4 py-3 text-gray-700">${y}</td>
            <td class="px-4 py-3 text-gray-700">${values[i]}%</td>
            <td class="px-4 py-3 text-gray-700">${currentData.wilayah}</td>
            <td class="px-4 py-3 text-gray-700">${currentData.judul}</td>
        </tr>
    `).join('');
}

function renderInterpretasi(labels, values) {
    if (labels.length < 2) {
        document.getElementById('interpretasi-section').classList.add('hidden');
        return;
    }

    const nilaiAwal  = parseFloat(values[0]);
    const nilaiAkhir = parseFloat(values[values.length - 1]);
    const tahunAwal  = labels[0];
    const tahunAkhir = labels[labels.length - 1];
    const selisih    = nilaiAkhir - nilaiAwal;

    let tren = selisih > 0 ? 'naik' : selisih < 0 ? 'turun' : 'tetap';

    // Update nilai
    document.getElementById('tren-tahun-awal').textContent  = 'Tahun ' + tahunAwal;
    document.getElementById('tren-nilai-awal').textContent  = nilaiAwal.toFixed(2);
    document.getElementById('tren-tahun-akhir').textContent = 'Tahun ' + tahunAkhir;
    document.getElementById('tren-nilai-akhir').textContent = nilaiAkhir.toFixed(2);

    const trenCard        = document.getElementById('tren-card');
    const interpretCard   = document.getElementById('interpretasi-card');
    const trenIcon        = document.getElementById('tren-icon');
    const trenLabel       = document.getElementById('tren-label');
    const trenSelisih     = document.getElementById('tren-selisih');
    const interpIconWrap  = document.getElementById('interpretasi-icon-wrap');
    const interpIcon      = document.getElementById('interpretasi-icon');
    const interpLabel     = document.getElementById('interpretasi-label');
    const interpTeks      = document.getElementById('interpretasi-teks');

    if (tren === 'naik') {
        trenCard.className      = 'flex items-center justify-between gap-4 p-5 rounded-2xl border mb-4 bg-red-50 dark:bg-red-900/20 border-red-100 dark:border-red-800';
        interpretCard.className = 'rounded-2xl border p-5 border-red-100 dark:border-red-800 bg-red-50/50 dark:bg-red-900/10';
        trenIcon.className      = 'text-3xl ti ti-trending-up text-red-500';
        trenLabel.className     = 'text-xs font-bold uppercase tracking-widest text-red-500';
        trenLabel.textContent   = 'Naik';
        trenSelisih.className   = 'text-xs font-semibold text-red-400';
        trenSelisih.textContent = '+' + Math.abs(selisih).toFixed(2);
        interpIconWrap.className= 'mt-0.5 shrink-0 w-8 h-8 rounded-xl flex items-center justify-center bg-red-100 dark:bg-red-900/30';
        interpIcon.className    = 'ti ti-arrow-up text-red-500 text-lg';
        interpLabel.className   = 'text-xs font-bold uppercase tracking-widest mb-2 text-red-400';
        interpLabel.textContent = 'Interpretasi — Data Lebih Besar (Naik)';
        interpTeks.textContent  = currentData.interpBesar || 'Tidak ada interpretasi yang tersedia.';

    } else if (tren === 'turun') {
        trenCard.className      = 'flex items-center justify-between gap-4 p-5 rounded-2xl border mb-4 bg-green-50 dark:bg-green-900/20 border-green-100 dark:border-green-800';
        interpretCard.className = 'rounded-2xl border p-5 border-green-100 dark:border-green-800 bg-green-50/50 dark:bg-green-900/10';
        trenIcon.className      = 'text-3xl ti ti-trending-down text-green-500';
        trenLabel.className     = 'text-xs font-bold uppercase tracking-widest text-green-500';
        trenLabel.textContent   = 'Turun';
        trenSelisih.className   = 'text-xs font-semibold text-green-400';
        trenSelisih.textContent = '-' + Math.abs(selisih).toFixed(2);
        interpIconWrap.className= 'mt-0.5 shrink-0 w-8 h-8 rounded-xl flex items-center justify-center bg-green-100 dark:bg-green-900/30';
        interpIcon.className    = 'ti ti-arrow-down text-green-500 text-lg';
        interpLabel.className   = 'text-xs font-bold uppercase tracking-widest mb-2 text-green-500';
        interpLabel.textContent = 'Interpretasi — Data Lebih Kecil (Turun)';
        interpTeks.textContent  = currentData.interpKecil || 'Tidak ada interpretasi yang tersedia.';

    } else {
        trenCard.className      = 'flex items-center justify-between gap-4 p-5 rounded-2xl border mb-4 bg-gray-50 dark:bg-gray-800 border-gray-200 dark:border-gray-700';
        interpretCard.className = 'rounded-2xl border p-5 border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800';
        trenIcon.className      = 'text-3xl ti ti-minus text-gray-400';
        trenLabel.className     = 'text-xs font-bold uppercase tracking-widest text-gray-400';
        trenLabel.textContent   = 'Tetap';
        trenSelisih.className   = 'text-xs font-semibold text-gray-400';
        trenSelisih.textContent = '0';
        interpIconWrap.className= 'mt-0.5 shrink-0 w-8 h-8 rounded-xl flex items-center justify-center bg-gray-100 dark:bg-gray-700';
        interpIcon.className    = 'ti ti-equal text-gray-400 text-lg';
        interpLabel.className   = 'text-xs font-bold uppercase tracking-widest mb-2 text-gray-400';
        interpLabel.textContent = 'Interpretasi — Data Tidak Berubah';
        interpTeks.textContent  = 'Data tidak mengalami perubahan antara tahun ' + tahunAwal + ' dan ' + tahunAkhir + '.';
    }

    document.getElementById('interpretasi-section').classList.remove('hidden');
}
</script>
@endsection