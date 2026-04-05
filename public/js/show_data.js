// public/js/show_data.js
// Logika identik dengan grafik_blade.php

// ── STATE ─────────────────────────────────────────────────────────────────
let chartInstance = null;
let currentData = {};
let wilayahList = [];
let allComponents = [];
let currentTab = "grafik";

const COLORS = [
    { border: "#2563eb", bg: "rgba(37,99,235,0.10)" },
    { border: "#dc2626", bg: "rgba(220,38,38,0.10)" },
    { border: "#16a34a", bg: "rgba(22,163,74,0.10)" },
    { border: "#d97706", bg: "rgba(217,119,6,0.10)" },
    { border: "#7c3aed", bg: "rgba(124,58,237,0.10)" },
];

// ── INIT ──────────────────────────────────────────────────────────────────
document.addEventListener("DOMContentLoaded", function () {
    const cfg = window.DATA_CONFIG;
    if (!cfg) return;

    currentData = {
        judul: cfg.judul || "",
        interpKecil: cfg.interp?.kecil || "",
        interpBesar: cfg.interp?.besar || "",
        interpTetap: cfg.interp?.tetap || "",
    };

    wilayahList = (cfg.wilayahList || []).map((w) => ({
        ...w,
        interp_kecil: w.interp_kecil || cfg.interp?.kecil || "",
        interp_besar: w.interp_besar || cfg.interp?.besar || "",
        interp_tetap: w.interp_tetap || cfg.interp?.tetap || "",
        values: (w.values || []).map((v) => ({
            ...v,
            x_label: v.x_label || null,
            y_label: v.y_label || (v.year ? String(v.year) : null),
        })),
    }));

    allComponents = cfg.components || [];

    // Build filters
    buildWilayahFilter();
    buildKategoriFilter();

    // Tab events — pakai onclick attribute di blade, TAPI juga bind di sini sebagai fallback
    const btnGrafik = document.getElementById("tab-grafik");
    const btnTabel = document.getElementById("tab-tabel");
    if (btnGrafik)
        btnGrafik.addEventListener("click", () => switchTab("grafik"));
    if (btnTabel) btnTabel.addEventListener("click", () => switchTab("tabel"));

    // Pastikan state awal benar
    _applyTabVisibility("grafik");
    applyFilters();
});

// ── TAB SWITCH ────────────────────────────────────────────────────────────
function switchTab(tab) {
    currentTab = tab;
    _applyTabVisibility(tab);
    applyFilters();
}

function _applyTabVisibility(tab) {
    const isG = tab === "grafik";

    // View panels
    const vGrafik = document.getElementById("view-grafik");
    const vTabel = document.getElementById("view-tabel");
    if (vGrafik) {
        vGrafik.style.display = isG ? "" : "none";
        vGrafik.classList.toggle("hidden", !isG);
    }
    if (vTabel) {
        vTabel.style.display = isG ? "none" : "";
        vTabel.classList.toggle("hidden", isG);
    }

    // Filter komponen — sembunyikan di tab tabel
    const fKat = document.getElementById("filter-kategori-wrap");
    if (fKat) {
        fKat.style.display = isG ? "" : "none";
        fKat.classList.toggle("hidden", !isG);
    }

    // Tab button styling
    const btnG = document.getElementById("tab-grafik");
    const btnT = document.getElementById("tab-tabel");
    if (btnG) btnG.className = isG ? "show-tab active" : "show-tab";
    if (btnT) btnT.className = !isG ? "show-tab active" : "show-tab";
}

// ── BUILD FILTER WILAYAH ──────────────────────────────────────────────────
function buildWilayahFilter() {
    const div = document.getElementById("filter-wilayah");
    if (!div) return;

    div.innerHTML = wilayahList
        .map((w, wi) => {
            const color = COLORS[wi % COLORS.length].border;
            return `<label>
            <input type="checkbox" value="${escH(w.wilayah)}" checked class="wilayah-check" onchange="applyFilters()">
            <span class="w-2.5 h-2.5 rounded-full shrink-0" style="display:inline-block;width:10px;height:10px;border-radius:50%;background:${color};vertical-align:middle;margin-right:4px"></span>
            ${escH(w.wilayah)}
        </label>`;
        })
        .join("");
}

// ── BUILD FILTER KATEGORI — hanya tampilkan NON-sub ───────────────────────
function buildKategoriFilter() {
    // Hanya komponen utama (bukan sub) yang ditampilkan sebagai pilihan radio
    const mainComponents = allComponents.filter((c) => !c.is_sub);

    const katDiv = document.getElementById("filter-kategori");
    if (!katDiv) return;

    if (mainComponents.length > 0) {
        katDiv.innerHTML =
            `<p class="text-xs text-blue-400 font-semibold mb-2">Pilih salah satu ↓</p>` +
            mainComponents
                .map((c) => {
                    const label = c.nama.replace(/^· /, "");
                    return `<label>
                    <input type="radio" name="kat_radio" value="${escH(c.nama)}" class="kat-radio" onchange="onKategoriChange()">
                    <span class="truncate" title="${escH(label)}">${escH(label)}</span>
                </label>`;
                })
                .join("");

        const allYears = [
            ...new Set(
                wilayahList
                    .flatMap((w) =>
                        w.values.map((v) => v.y_label || String(v.year)),
                    )
                    .filter(Boolean),
            ),
        ].sort();
        buildTahunFilter(allYears);
        document
            .getElementById("filter-tahun")
            .querySelectorAll(".tahun-check")
            .forEach((cb) => (cb.disabled = true));
    } else {
        katDiv.innerHTML =
            '<p class="text-xs text-gray-400 italic">Tidak ada kategori</p>';
        const allYears = [
            ...new Set(
                wilayahList
                    .flatMap((w) =>
                        w.values.map((v) => v.y_label || String(v.year)),
                    )
                    .filter(Boolean),
            ),
        ].sort();
        buildTahunFilter(allYears);
        applyFilters();
    }
}

function onKategoriChange() {
    document
        .getElementById("filter-tahun")
        .querySelectorAll(".tahun-check")
        .forEach((cb) => {
            cb.disabled = false;
            cb.checked = true;
        });
    applyFilters();
}

// ── BUILD FILTER TAHUN ────────────────────────────────────────────────────
function buildTahunFilter(years) {
    const tahunDiv = document.getElementById("filter-tahun");
    if (!tahunDiv) return;
    if (!years.length) {
        tahunDiv.innerHTML =
            '<p class="text-xs text-gray-400">Tidak ada data</p>';
        return;
    }
    tahunDiv.innerHTML = years
        .map(
            (y) => `
        <label>
            <input type="checkbox" value="${y}" checked class="tahun-check"> ${y}
        </label>`,
        )
        .join("");
    tahunDiv
        .querySelectorAll(".tahun-check")
        .forEach((cb) => cb.addEventListener("change", applyFilters));
}

// ── APPLY FILTERS ─────────────────────────────────────────────────────────
function applyFilters() {
    if (!wilayahList.length) return;

    const selectedCat =
        document.querySelector(".kat-radio:checked")?.value ?? null;
    const checkedYears = [
        ...document.querySelectorAll(".tahun-check:checked"),
    ].map((c) => c.value);
    const checkedWilayah = [
        ...document.querySelectorAll(".wilayah-check:checked"),
    ].map((c) => c.value);

    const datasets = [];
    wilayahList.forEach((w, wi) => {
        if (!checkedWilayah.includes(w.wilayah)) return;

        const rows = w.values
            .filter(
                (v) =>
                    currentTab === "tabel" ||
                    !selectedCat ||
                    v.x_label === selectedCat,
            )
            .filter((v) => checkedYears.includes(v.y_label || String(v.year)))
            .sort((a, b) =>
                String(a.y_label || a.year).localeCompare(
                    String(b.y_label || b.year),
                ),
            );

        if (!rows.length) return;

        const color = COLORS[wi % COLORS.length];
        datasets.push({
            wilayah: w.wilayah,
            updated: w.updated || "",
            labels: rows.map((v) => v.y_label || String(v.year)),
            values: rows.map((v) => parseFloat(v.value)),
            rawRows: rows,
            color,
            interp_kecil: w.interp_kecil,
            interp_besar: w.interp_besar,
            interp_tetap: w.interp_tetap,
        });
    });

    if (currentTab === "grafik") {
        renderChart(datasets, selectedCat);
        renderInterpretasiGrafik(datasets, selectedCat);
    } else {
        renderTable(datasets, selectedCat);
        renderInterpretasiTabel(datasets, selectedCat);
    }
}

// ── RENDER CHART ──────────────────────────────────────────────────────────
function renderChart(datasets, kategori) {
    const canvas = document.getElementById("mainChart");
    if (!canvas) return;
    if (!datasets.length) return;

    const katLabel = kategori
        ? kategori.startsWith("· ")
            ? kategori.slice(2)
            : kategori
        : currentData.judul;

    const titleEl = document.getElementById("chart-title");
    const subtitleEl = document.getElementById("chart-subtitle");
    if (titleEl) titleEl.textContent = currentData.judul + " — " + katLabel;
    if (subtitleEl)
        subtitleEl.textContent =
            datasets.map((d) => d.wilayah).join(", ") +
            (datasets[0].updated
                ? " · Update Terakhir: " + datasets[0].updated
                : "");

    const allLabels = [...new Set(datasets.flatMap((d) => d.labels))].sort();

    if (chartInstance) {
        chartInstance.destroy();
        chartInstance = null;
    }

    chartInstance = new Chart(canvas.getContext("2d"), {
        type: "line",
        data: {
            labels: allLabels,
            datasets: datasets.map((d) => ({
                label: d.wilayah,
                data: allLabels.map((lbl) => {
                    const i = d.labels.indexOf(lbl);
                    return i >= 0 ? d.values[i] : null;
                }),
                borderColor: d.color.border,
                backgroundColor: d.color.bg,
                borderWidth: 2,
                pointBackgroundColor: d.color.border,
                pointRadius: 5,
                pointHoverRadius: 7,
                fill: datasets.length === 1,
                tension: 0.3,
                spanGaps: true,
            })),
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: datasets.length > 1,
                    position: "top",
                    labels: { boxWidth: 12, font: { size: 11 } },
                },
                tooltip: { mode: "index", intersect: false },
            },
            scales: {
                x: {
                    title: { display: true, text: "Tahun", font: { size: 11 } },
                    grid: { display: false },
                },
                y: {
                    title: { display: true, text: "Nilai", font: { size: 11 } },
                    grid: { color: "#f3f4f6" },
                },
            },
        },
    });
}

// ── INTERPRETASI GRAFIK ───────────────────────────────────────────────────
function renderInterpretasiGrafik(datasets, selectedCat) {
    const section = document.getElementById("interpretasi-section");
    const kompDiv = document.getElementById("interpretasi-tabel-komponen");
    if (kompDiv) kompDiv.classList.add("hidden");

    if (!datasets.length) {
        if (section) section.classList.add("hidden");
        return;
    }

    const komponen = allComponents.find((c) => c.nama === selectedCat) || null;

    if (datasets.length === 1) {
        const d = datasets[0];
        if (d.labels.length < 2) {
            if (section) section.classList.add("hidden");
            return;
        }

        document.getElementById("tren-card")?.classList.remove("hidden");
        document
            .getElementById("interpretasi-card")
            ?.classList.remove("hidden");
        document
            .getElementById("interpretasi-wilayah")
            ?.classList.add("hidden");
        renderTrenCard(d.labels, d.values, d, komponen);
        renderPairsForDataset(d.labels, d.values, d, komponen);
        if (section) section.classList.remove("hidden");
    } else {
        document.getElementById("tren-card")?.classList.add("hidden");
        document.getElementById("interpretasi-card")?.classList.add("hidden");

        let html = "";
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

        const pairsDiv = document.getElementById("interpretasi-pairs");
        if (pairsDiv) pairsDiv.innerHTML = html;
        renderPerbandinganWilayahMultiTahun(datasets, selectedCat);
        if (section) section.classList.remove("hidden");
    }
}

// ── MINI TREN CARD (multi-wilayah) ────────────────────────────────────────
function buildTrenMiniCard(labels, values, dataset, komponen) {
    const vA = values[0],
        vB = values[values.length - 1];
    const sel = vB - vA;
    const tren = sel > 0 ? "naik" : sel < 0 ? "turun" : "tetap";
    const cfg = {
        naik: {
            color: "red",
            icon: "ti-trending-up",
            label: "Naik",
            sign: "+",
        },
        turun: {
            color: "green",
            icon: "ti-trending-down",
            label: "Turun",
            sign: "",
        },
        tetap: { color: "gray", icon: "ti-minus", label: "Tetap", sign: "" },
    }[tren];
    return `<div class="flex items-center justify-between gap-3 p-3 rounded-xl bg-${cfg.color}-50 border border-${cfg.color}-100">
        <div class="text-center"><p class="text-[10px] text-gray-400">${labels[0]}</p><p class="text-lg font-black text-gray-800">${vA.toFixed(2)}</p></div>
        <div class="flex flex-col items-center gap-0.5">
            <i class="ti ${cfg.icon} text-xl text-${cfg.color}-500"></i>
            <span class="text-xs font-bold text-${cfg.color}-500">${cfg.label}</span>
            <span class="text-xs text-${cfg.color}-400">${cfg.sign}${Math.abs(sel).toFixed(2)}</span>
        </div>
        <div class="text-center"><p class="text-[10px] text-gray-400">${labels[labels.length - 1]}</p><p class="text-lg font-black text-gray-800">${vB.toFixed(2)}</p></div>
    </div>`;
}

// ── TREN CARD UTAMA (1 wilayah) ───────────────────────────────────────────
function renderTrenCard(labels, values, dataset, komponen) {
    const vA = values[0],
        vB = values[values.length - 1];
    const tahunAwal = labels[0],
        tahunAkhir = labels[labels.length - 1];
    const sel = vB - vA;
    const tren = sel > 0 ? "naik" : sel < 0 ? "turun" : "tetap";
    const cfg = {
        naik: {
            color: "red",
            icon: "ti-trending-up",
            label: "Naik",
            sign: "+",
        },
        turun: {
            color: "green",
            icon: "ti-trending-down",
            label: "Turun",
            sign: "",
        },
        tetap: { color: "gray", icon: "ti-minus", label: "Tetap", sign: "" },
    }[tren];

    const interpKecil =
        komponen?.interpretasi_lebih_kecil ||
        dataset?.interp_kecil ||
        currentData.interpKecil ||
        "";
    const interpBesar =
        komponen?.interpretasi_lebih_besar ||
        dataset?.interp_besar ||
        currentData.interpBesar ||
        "";
    const interpTetap =
        komponen?.interpretasi_tetap ||
        dataset?.interp_tetap ||
        currentData.interpTetap ||
        "";
    const teksMap = {
        naik: interpBesar || "Data mengalami kenaikan.",
        turun: interpKecil || "Data mengalami penurunan.",
        tetap: interpTetap || "Data tidak berubah secara signifikan.",
    };

    document.getElementById("tren-tahun-awal").textContent =
        "Tahun " + tahunAwal;
    document.getElementById("tren-nilai-awal").textContent = vA.toFixed(2);
    document.getElementById("tren-tahun-akhir").textContent =
        "Tahun " + tahunAkhir;
    document.getElementById("tren-nilai-akhir").textContent = vB.toFixed(2);

    document.getElementById("tren-card").className =
        `flex items-center justify-between gap-4 p-5 rounded-2xl border bg-${cfg.color}-50 dark:bg-${cfg.color}-900/20 border-${cfg.color}-100 dark:border-${cfg.color}-800`;
    document.getElementById("tren-icon").className =
        `text-3xl ti ${cfg.icon} text-${cfg.color}-500`;
    document.getElementById("tren-label").className =
        `text-xs font-bold uppercase tracking-widest text-${cfg.color}-500`;
    document.getElementById("tren-label").textContent = cfg.label;
    document.getElementById("tren-selisih").className =
        `text-xs font-semibold text-${cfg.color}-400`;
    document.getElementById("tren-selisih").textContent =
        cfg.sign + Math.abs(sel).toFixed(2);

    document.getElementById("interpretasi-card").className =
        `rounded-2xl border p-5 border-${cfg.color}-100 dark:border-${cfg.color}-800 bg-${cfg.color}-50/50 dark:bg-${cfg.color}-900/10`;
    document.getElementById("interpretasi-icon-wrap").className =
        `mt-0.5 shrink-0 w-8 h-8 rounded-xl flex items-center justify-center bg-${cfg.color}-100 dark:bg-${cfg.color}-900/30`;
    document.getElementById("interpretasi-icon").className =
        `ti ${cfg.icon} text-${cfg.color}-500 text-lg`;
    document.getElementById("interpretasi-label").className =
        `text-xs font-bold uppercase tracking-widest mb-2 text-${cfg.color}-500`;
    document.getElementById("interpretasi-label").textContent =
        `Interpretasi Keseluruhan ${tahunAwal}–${tahunAkhir}`;
    document.getElementById("interpretasi-teks").textContent = teksMap[tren];

    renderPairsForDataset(labels, values, dataset, komponen);
}

// ── PAIRS FOR SINGLE DATASET ──────────────────────────────────────────────
function renderPairsForDataset(labels, values, dataset, komponen) {
    const pairsDiv = document.getElementById("interpretasi-pairs");
    if (!pairsDiv) return;
    let html = `<div class="flex items-center gap-2 mb-1">
        <div class="flex-1 h-px bg-gray-100 dark:bg-gray-700"></div>
        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Perubahan Per Periode</span>
        <div class="flex-1 h-px bg-gray-100 dark:bg-gray-700"></div>
    </div>`;
    for (let i = 0; i < labels.length - 1; i++) {
        html += buildPairCard(
            labels[i],
            labels[i + 1],
            values[i],
            values[i + 1],
            false,
            labels,
            values,
            komponen,
            dataset,
        );
    }
    if (labels.length > 2) {
        html += `<div class="flex items-center gap-2 mt-4 mb-1">
            <div class="flex-1 h-px bg-gray-100 dark:bg-gray-700"></div>
            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Perubahan Total</span>
            <div class="flex-1 h-px bg-gray-100 dark:bg-gray-700"></div>
        </div>`;
        html += buildPairCard(
            labels[0],
            labels[labels.length - 1],
            values[0],
            values[values.length - 1],
            true,
            labels,
            values,
            komponen,
            dataset,
        );
    }
    pairsDiv.innerHTML = html;
}

// ── BUILD PAIRS HTML (multi-wilayah, return string) ───────────────────────
function buildPairsHtml(labels, values, dataset, komponen) {
    let html = `<div class="space-y-2"><p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Perubahan Per Periode</p>`;
    for (let i = 0; i < labels.length - 1; i++) {
        html += buildPairCard(
            labels[i],
            labels[i + 1],
            values[i],
            values[i + 1],
            false,
            labels,
            values,
            komponen,
            dataset,
        );
    }
    if (labels.length > 2) {
        html += `<p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-3">Perubahan Total</p>`;
        html += buildPairCard(
            labels[0],
            labels[labels.length - 1],
            values[0],
            values[values.length - 1],
            true,
            labels,
            values,
            komponen,
            dataset,
        );
    }
    return html + "</div>";
}

// ── PERBANDINGAN MULTI WILAYAH ────────────────────────────────────────────
function renderPerbandinganWilayahMultiTahun(datasets, kategori) {
    const container = document.getElementById("interpretasi-wilayah");
    if (!container) return;
    if (datasets.length < 2) {
        container.classList.add("hidden");
        return;
    }

    const allYears = [...new Set(datasets.flatMap((d) => d.labels))].sort();
    const headerCells = datasets
        .map(
            (d, i) =>
                `<th class="px-3 py-2 text-xs font-bold text-center" style="color:${COLORS[i % COLORS.length].border}">${escH(d.wilayah)}</th>`,
        )
        .join("");
    const rowsHtml = allYears
        .map((year) => {
            const vals = datasets.map((d) => {
                const i = d.labels.indexOf(year);
                return i >= 0 ? d.values[i] : null;
            });
            const valid = vals.filter((v) => v !== null);
            if (!valid.length) return "";
            const maxV = Math.max(...valid),
                minV = Math.min(...valid);
            const cells = datasets
                .map((d, i) => {
                    const v = vals[i];
                    const cls =
                        v === maxV && valid.length > 1
                            ? "text-red-600 font-bold"
                            : v === minV && maxV !== minV
                              ? "text-green-600 font-bold"
                              : "text-gray-700";
                    return `<td class="px-3 py-2 text-xs ${cls} text-center">${v !== null ? v.toFixed(2) : "-"}</td>`;
                })
                .join("");
            return `<tr class="border-b border-gray-50 hover:bg-gray-50/50"><td class="px-3 py-2 text-xs font-semibold text-gray-600">${year}</td>${cells}</tr>`;
        })
        .join("");

    const lastYear = allYears[allYears.length - 1];
    const lastVals = datasets
        .map((d) => {
            const i = d.labels.indexOf(lastYear);
            return { wilayah: d.wilayah, value: i >= 0 ? d.values[i] : null };
        })
        .filter((x) => x.value !== null)
        .sort((a, b) => b.value - a.value);
    const rataRata = lastVals.length
        ? (lastVals.reduce((s, x) => s + x.value, 0) / lastVals.length).toFixed(
              2,
          )
        : "-";
    const tertinggi = lastVals[0],
        terendah = lastVals[lastVals.length - 1];
    const selisih =
        tertinggi && terendah
            ? (tertinggi.value - terendah.value).toFixed(2)
            : "-";

    container.innerHTML = `
        <div class="flex items-start gap-3">
            <div class="w-8 h-8 flex items-center justify-center rounded-xl bg-indigo-100 shrink-0"><i class="ti ti-map-pin text-indigo-600"></i></div>
            <div class="flex-1">
                <p class="text-xs font-bold uppercase text-indigo-500 mb-3">Perbandingan Antar Wilayah (${datasets.length} wilayah, ${allYears.length} tahun)</p>
                <div class="overflow-x-auto mb-4">
                    <table class="w-full text-sm">
                        <thead><tr class="border-b border-gray-100"><th class="px-3 py-2 text-xs font-bold text-left text-gray-500">Tahun</th>${headerCells}</tr></thead>
                        <tbody>${rowsHtml}</tbody>
                    </table>
                </div>
                <div class="grid grid-cols-2 gap-2 text-xs">
                    <div class="p-2 rounded-lg bg-red-50 border border-red-100"><p class="text-red-500 font-bold mb-0.5">Tertinggi (${lastYear})</p><p class="text-gray-700 font-semibold">${tertinggi ? escH(tertinggi.wilayah) : "-"} — ${tertinggi ? tertinggi.value.toFixed(2) : "-"}</p></div>
                    <div class="p-2 rounded-lg bg-green-50 border border-green-100"><p class="text-green-600 font-bold mb-0.5">Terendah (${lastYear})</p><p class="text-gray-700 font-semibold">${terendah ? escH(terendah.wilayah) : "-"} — ${terendah ? terendah.value.toFixed(2) : "-"}</p></div>
                    <div class="p-2 rounded-lg bg-blue-50 border border-blue-100"><p class="text-blue-500 font-bold mb-0.5">Rata-rata (${lastYear})</p><p class="text-gray-700 font-semibold">${rataRata}</p></div>
                    <div class="p-2 rounded-lg bg-purple-50 border border-purple-100"><p class="text-purple-500 font-bold mb-0.5">Selisih</p><p class="text-gray-700 font-semibold">${selisih}</p></div>
                </div>
            </div>
        </div>`;
    container.classList.remove("hidden");
}

// ── INTERPRETASI TABEL ────────────────────────────────────────────────────
function renderInterpretasiTabel(datasets, selectedCat) {
    const section = document.getElementById("interpretasi-section");
    const kompDiv = document.getElementById("interpretasi-tabel-komponen");

    document.getElementById("tren-card")?.classList.add("hidden");
    document.getElementById("interpretasi-card")?.classList.add("hidden");
    const pairsDiv = document.getElementById("interpretasi-pairs");
    if (pairsDiv) pairsDiv.innerHTML = "";
    document.getElementById("interpretasi-wilayah")?.classList.add("hidden");

    if (!datasets.length) {
        if (section) section.classList.add("hidden");
        return;
    }

    const allKatsRaw = allComponents.length
        ? allComponents
        : [
              ...new Set(
                  datasets
                      .flatMap((d) => (d.rawRows || []).map((r) => r.x_label))
                      .filter(Boolean),
              ),
          ].map((n) => ({ nama: n, is_sub: n.startsWith("· ") }));

    if (!allKatsRaw.length) {
        if (section) section.classList.add("hidden");
        return;
    }

    let html = `<div class="flex items-center gap-2 mb-3">
        <div class="flex-1 h-px bg-gray-100"></div>
        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Interpretasi Per Komponen</span>
        <div class="flex-1 h-px bg-gray-100"></div>
    </div>`;

    allKatsRaw.forEach(({ nama: kat, is_sub: isSub }) => {
        const komponen = allComponents.find((c) => c.nama === kat) || null;
        const katLabel = isSub ? kat.replace(/^· /, "") : kat;
        const headerBg = isSub
            ? "bg-indigo-50/40 border-indigo-100"
            : "border-gray-100";

        const katDatasets = datasets
            .map((d) => {
                const rows = (
                    d.rawRows ||
                    d.labels.map((lbl, i) => ({
                        x_label: selectedCat || kat,
                        y_label: lbl,
                        value: d.values[i],
                    }))
                )
                    .filter((r) => r.x_label === kat)
                    .sort((a, b) =>
                        String(a.y_label || a.year).localeCompare(
                            String(b.y_label || b.year),
                        ),
                    );
                if (!rows.length) return null;
                return {
                    wilayah: d.wilayah,
                    labels: rows.map((r) => r.y_label || String(r.year)),
                    values: rows.map((r) => parseFloat(r.value)),
                    color: d.color,
                    interp_kecil: d.interp_kecil,
                    interp_besar: d.interp_besar,
                    interp_tetap: d.interp_tetap,
                };
            })
            .filter(Boolean);

        if (!katDatasets.length) return;

        html += `<div class="rounded-2xl border p-4 space-y-3 ${headerBg}">
            <div class="flex items-center gap-2 ${isSub ? "pl-3" : ""}">
                <i class="ti ${isSub ? "ti-minus text-indigo-300" : "ti-category text-blue-500"} text-sm"></i>
                <span class="text-sm font-${isSub ? "medium text-gray-500 italic" : "bold text-gray-700"}">${isSub ? '<span class="text-indigo-300 mr-1">·</span>' : ""}${escH(katLabel)}</span>
                ${komponen?.satuan ? `<span class="text-xs text-gray-400">(${escH(komponen.satuan)})</span>` : ""}
            </div>`;

        katDatasets.forEach((kd, i) => {
            if (kd.labels.length < 2) return;
            const vA = kd.values[0],
                vB = kd.values[kd.values.length - 1];
            const sel = vB - vA;
            const pct =
                vA !== 0 ? ((sel / Math.abs(vA)) * 100).toFixed(1) : "0.0";
            const tren = sel > 0 ? "naik" : sel < 0 ? "turun" : "tetap";
            const cfg = {
                naik: {
                    color: "red",
                    icon: "ti-trending-up",
                    label: "Naik",
                    sign: "+",
                },
                turun: {
                    color: "green",
                    icon: "ti-trending-down",
                    label: "Turun",
                    sign: "",
                },
                tetap: {
                    color: "gray",
                    icon: "ti-minus",
                    label: "Tetap",
                    sign: "",
                },
            }[tren];
            const teksAdmin =
                tren === "naik"
                    ? komponen?.interpretasi_lebih_besar ||
                      kd.interp_besar ||
                      currentData.interpBesar ||
                      ""
                    : tren === "turun"
                      ? komponen?.interpretasi_lebih_kecil ||
                        kd.interp_kecil ||
                        currentData.interpKecil ||
                        ""
                      : komponen?.interpretasi_tetap ||
                        kd.interp_tetap ||
                        currentData.interpTetap ||
                        "";
            const absSel = Math.abs(sel).toFixed(2),
                absPct = Math.abs(parseFloat(pct)).toFixed(1);
            let teksCerita = `Nilai ${escH(currentData.judul)} (${escH(kat)}) di ${escH(kd.wilayah)} `;
            teksCerita +=
                tren === "tetap"
                    ? `tidak berubah dari ${kd.labels[0]} hingga ${kd.labels[kd.labels.length - 1]}, tetap di ${vA.toFixed(2)}.`
                    : `${tren === "naik" ? "meningkat" : "menurun"} sebesar ${absSel} (${absPct}%) dari ${kd.labels[0]} (${vA.toFixed(2)}) ke ${kd.labels[kd.labels.length - 1]} (${vB.toFixed(2)}).`;
            if (teksAdmin) teksCerita += " " + teksAdmin;
            const colorBar = COLORS[i % COLORS.length].border;
            html += `<div class="flex items-start gap-3 p-3 rounded-xl border border-${cfg.color}-100 bg-${cfg.color}-50/40">
                <span class="w-2 h-full rounded-full shrink-0 self-stretch" style="background:${colorBar};min-width:4px;min-height:24px"></span>
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-xs font-semibold text-gray-600">${escH(kd.wilayah)}</span>
                        <span class="inline-flex items-center gap-1 text-xs font-bold text-${cfg.color}-500 bg-${cfg.color}-100 px-2 py-0.5 rounded-lg">
                            <i class="ti ${cfg.icon}"></i> ${cfg.label} ${cfg.sign}${absSel} (${absPct}%)
                        </span>
                    </div>
                    <p class="text-xs text-gray-600 leading-relaxed">${teksCerita}</p>
                </div>
            </div>`;
        });

        if (katDatasets.length > 1) {
            const lastY = [...new Set(katDatasets.flatMap((d) => d.labels))]
                .sort()
                .at(-1);
            const lv = katDatasets
                .map((d) => {
                    const i = d.labels.indexOf(lastY);
                    return {
                        wilayah: d.wilayah,
                        value: i >= 0 ? d.values[i] : null,
                    };
                })
                .filter((x) => x.value !== null)
                .sort((a, b) => b.value - a.value);
            if (lv.length > 1) {
                const t = lv[0],
                    b = lv.at(-1);
                html += `<div class="flex items-center gap-2 p-2 rounded-lg bg-indigo-50 border border-indigo-100 text-xs text-indigo-700">
                    <i class="ti ti-arrows-diff text-indigo-400"></i>
                    Pada ${lastY}: <b>${escH(t.wilayah)}</b> tertinggi (${t.value.toFixed(2)}), <b>${escH(b.wilayah)}</b> terendah (${b.value.toFixed(2)}), selisih <b>${(t.value - b.value).toFixed(2)}</b>
                </div>`;
            }
        }
        html += `</div>`;
    });

    if (kompDiv) {
        kompDiv.innerHTML = html;
        kompDiv.classList.remove("hidden");
    }
    if (section) section.classList.remove("hidden");
}

// ── RENDER TABLE ──────────────────────────────────────────────────────────
function renderTable(datasets, kategori) {
    const tbody = document.getElementById("table-body");
    const thead = document.getElementById("table-head");
    if (!tbody || !thead) return;

    if (!datasets.length) {
        tbody.innerHTML =
            '<tr><td colspan="4" class="table-empty">Tidak ada data</td></tr>';
        return;
    }

    const allKats = allComponents.length
        ? allComponents.map((c) => ({
              nama: c.nama,
              is_sub: c.is_sub,
              satuan: c.satuan,
          }))
        : [
              ...new Set(
                  datasets
                      .flatMap((d) => (d.rawRows || []).map((r) => r.x_label))
                      .filter(Boolean),
              ),
          ].map((n) => ({ nama: n, is_sub: n.startsWith("· "), satuan: "" }));

    const allYears = [
        ...new Set(
            datasets
                .flatMap((d) =>
                    (d.rawRows || d.labels.map((l) => ({ y_label: l }))).map(
                        (r) => r.y_label || String(r.year),
                    ),
                )
                .filter(Boolean),
        ),
    ].sort();

    thead.innerHTML = `<tr class="border-b border-gray-100">
        <th class="text-left px-4 py-3 font-semibold text-blue-600">Kategori</th>
        <th class="text-left px-4 py-3 font-semibold text-blue-600">Satuan</th>
        <th class="text-left px-4 py-3 font-semibold text-blue-600">Tahun</th>
        ${datasets.map((d) => `<th class="text-left px-4 py-3 font-semibold text-blue-600">${escH(d.wilayah)}</th>`).join("")}
    </tr>`;

    let bodyHtml = "";
    if (allKats.length) {
        allKats.forEach(({ nama: kat, is_sub: isSub, satuan: satuanMeta }) => {
            const komp = allComponents.find((c) => c.nama === kat);
            const satuan = komp?.satuan || satuanMeta || "";
            const katDisplay = isSub ? kat.replace(/^· /, "") : kat;
            const colSpan = datasets.length + 3;
            if (isSub) {
                bodyHtml += `<tr class="border-b border-indigo-100 bg-indigo-50/40"><td colspan="${colSpan}" class="px-4 py-2 text-xs font-semibold text-indigo-400 italic"><span class="text-indigo-300 mr-1">·</span>${escH(katDisplay)}</td></tr>`;
                return;
            }
            allYears.forEach((year, yi) => {
                const cells = datasets
                    .map((d) => {
                        const row = (d.rawRows || []).find(
                            (r) =>
                                r.x_label === kat &&
                                (r.y_label || String(r.year)) === year,
                        );
                        return `<td class="px-4 py-2.5 text-gray-700 text-sm font-semibold">${row ? parseFloat(row.value).toFixed(2) : "-"}</td>`;
                    })
                    .join("");
                bodyHtml += `<tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">
                    ${yi === 0 ? `<td class="px-4 py-2.5 text-gray-800 text-sm font-medium" rowspan="${allYears.length}">${escH(katDisplay)}</td><td class="px-4 py-2.5 text-gray-400 text-xs" rowspan="${allYears.length}">${escH(satuan)}</td>` : ""}
                    <td class="px-4 py-2.5 text-gray-700 text-sm">${year}</td>${cells}
                </tr>`;
            });
        });
    } else {
        allYears.forEach((year) => {
            const cells = datasets
                .map((d) => {
                    const i = d.labels.indexOf(year);
                    return `<td class="px-4 py-2.5 text-gray-700 text-sm font-semibold">${i >= 0 ? d.values[i].toFixed(2) : "-"}</td>`;
                })
                .join("");
            bodyHtml += `<tr class="border-b border-gray-50 hover:bg-gray-50/50 transition"><td class="px-4 py-2.5 text-gray-500 text-xs">-</td><td class="px-4 py-2.5 text-gray-400 text-xs">-</td><td class="px-4 py-2.5 text-gray-700 text-sm">${year}</td>${cells}</tr>`;
        });
    }
    tbody.innerHTML =
        bodyHtml ||
        '<tr><td colspan="6" class="table-empty">Tidak ada data</td></tr>';
}

// ── DOWNLOAD CSV ──────────────────────────────────────────────────────────
function downloadTable() {
    const checkedYears = [
        ...document.querySelectorAll(".tahun-check:checked"),
    ].map((c) => c.value);
    const checkedWilayah = [
        ...document.querySelectorAll(".wilayah-check:checked"),
    ].map((c) => c.value);
    const datasets = wilayahList
        .map((w, wi) => {
            if (!checkedWilayah.includes(w.wilayah)) return null;
            const rows = w.values
                .filter((v) =>
                    checkedYears.includes(v.y_label || String(v.year)),
                )
                .sort((a, b) =>
                    String(a.y_label || a.year).localeCompare(
                        String(b.y_label || b.year),
                    ),
                );
            if (!rows.length) return null;
            return {
                wilayah: w.wilayah,
                labels: rows.map((v) => v.y_label || String(v.year)),
                values: rows.map((v) => parseFloat(v.value)),
                rawRows: rows,
            };
        })
        .filter(Boolean);
    if (!datasets.length) {
        alert("Tidak ada data");
        return;
    }

    const allKats = allComponents.length
        ? allComponents.map((c) => c.nama)
        : [
              ...new Set(
                  datasets
                      .flatMap((d) => (d.rawRows || []).map((r) => r.x_label))
                      .filter(Boolean),
              ),
          ];
    const allYears = [
        ...new Set(
            datasets
                .flatMap((d) =>
                    (d.rawRows || d.labels.map((l) => ({ y_label: l }))).map(
                        (r) => r.y_label || String(r.year),
                    ),
                )
                .filter(Boolean),
        ),
    ].sort();

    let csv =
        "Kategori,Satuan,Tahun," +
        datasets.map((d) => d.wilayah).join(",") +
        "\n";
    if (allKats.length) {
        allKats.forEach((kat) => {
            const komp = allComponents.find((c) => c.nama === kat);
            if (komp?.is_sub) return;
            allYears.forEach((year) => {
                const vals = datasets
                    .map((d) => {
                        const r = (d.rawRows || []).find(
                            (v) =>
                                v.x_label === kat &&
                                (v.y_label || String(v.year)) === year,
                        );
                        return r ? parseFloat(r.value).toFixed(2) : "";
                    })
                    .join(",");
                csv += `"${kat.replace(/"/g, '""')}","${komp?.satuan || ""}","${year}",${vals}\n`;
            });
        });
    } else {
        allYears.forEach((year) => {
            const vals = datasets
                .map((d) => {
                    const i = d.labels.indexOf(year);
                    return i >= 0 ? d.values[i].toFixed(2) : "";
                })
                .join(",");
            csv += `"-","-","${year}",${vals}\n`;
        });
    }
    const blob = new Blob([csv], { type: "text/csv;charset=utf-8;" });
    const a = document.createElement("a");
    a.href = URL.createObjectURL(blob);
    a.download = `data_${currentData.judul}_${new Date().toISOString().slice(0, 10)}.csv`;
    a.style.display = "none";
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}

// ── BUILD PAIR CARD ───────────────────────────────────────────────────────
function buildPairCard(
    tA,
    tB,
    vA,
    vB,
    isTotal,
    allLabels,
    allVals,
    komponen,
    dataset,
) {
    const selisih = vB - vA;
    const pct = vA !== 0 ? ((selisih / Math.abs(vA)) * 100).toFixed(1) : "0.0";
    const tren = selisih > 0 ? "naik" : selisih < 0 ? "turun" : "tetap";
    const cfg = {
        naik: {
            color: "red",
            icon: "ti-trending-up",
            label: "Naik",
            sign: "+",
        },
        turun: {
            color: "green",
            icon: "ti-trending-down",
            label: "Turun",
            sign: "",
        },
        tetap: { color: "gray", icon: "ti-minus", label: "Tetap", sign: "" },
    }[tren];
    const selisihStr = cfg.sign + selisih.toFixed(2);
    const pctFormatted = (parseFloat(pct) > 0 ? "+" : "") + pct + "%";
    const borderCls = isTotal
        ? `border-2 border-${cfg.color}-300`
        : `border border-${cfg.color}-100`;
    const teksInterp = generateInterpretasiTeks(
        tA,
        tB,
        vA,
        vB,
        selisih,
        pct,
        tren,
        isTotal,
        allLabels,
        komponen,
        dataset,
    );
    return `<div class="rounded-2xl p-4 bg-${cfg.color}-50/60 ${borderCls}">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-bold uppercase tracking-widest text-${cfg.color}-500">${isTotal ? "⭐ " : ""}${tA} → ${tB}</span>
            <span class="inline-flex items-center gap-1 text-xs font-bold text-${cfg.color}-500 bg-${cfg.color}-100 px-2 py-0.5 rounded-lg"><i class="ti ${cfg.icon}"></i> ${cfg.label}</span>
        </div>
        <div class="flex items-center justify-between mb-4">
            <div class="text-center"><p class="text-xs text-gray-400 mb-0.5">Tahun ${tA}</p><p class="text-xl font-black text-gray-800">${vA.toFixed(2)}</p></div>
            <div class="flex flex-col items-center gap-0.5 px-4">
                <i class="ti ${cfg.icon} text-2xl text-${cfg.color}-400"></i>
                <span class="text-sm font-bold text-${cfg.color}-500">${selisihStr}</span>
                <span class="text-xs text-${cfg.color}-400">${pctFormatted}</span>
            </div>
            <div class="text-center"><p class="text-xs text-gray-400 mb-0.5">Tahun ${tB}</p><p class="text-xl font-black text-gray-800">${vB.toFixed(2)}</p></div>
        </div>
        <div class="flex items-start gap-2.5 bg-white/70 rounded-xl p-3 border border-${cfg.color}-100/60">
            <div class="shrink-0 w-6 h-6 rounded-lg bg-${cfg.color}-100 flex items-center justify-center mt-0.5"><i class="ti ti-info-circle text-${cfg.color}-500 text-xs"></i></div>
            <p class="text-xs text-gray-600 leading-relaxed">${teksInterp}</p>
        </div>
    </div>`;
}

// ── GENERATE TEKS INTERPRETASI ────────────────────────────────────────────
function generateInterpretasiTeks(
    tA,
    tB,
    vA,
    vB,
    selisih,
    pct,
    tren,
    isTotal,
    allLabels,
    komponen,
    dataset,
) {
    const judul = currentData.judul || "data";
    const wilayah = dataset?.wilayah || "wilayah ini";
    const absSel = Math.abs(selisih).toFixed(2);
    const absPct = Math.abs(parseFloat(pct)).toFixed(1);
    const mag = Math.abs(parseFloat(pct));
    const skala = mag < 2 ? "kecil" : mag < 5 ? "sedang" : "besar";
    let teksAdmin = "";
    if (tren === "tetap")
        teksAdmin =
            komponen?.interpretasi_tetap ||
            dataset?.interp_tetap ||
            currentData.interpTetap ||
            "";
    else if (tren === "naik")
        teksAdmin =
            komponen?.interpretasi_lebih_besar ||
            dataset?.interp_besar ||
            currentData.interpBesar ||
            "";
    else
        teksAdmin =
            komponen?.interpretasi_lebih_kecil ||
            dataset?.interp_kecil ||
            currentData.interpKecil ||
            "";

    if (tren === "tetap")
        return (
            `Nilai ${judul} di ${wilayah} tidak berubah antara ${tA} dan ${tB}, tetap di ${vA.toFixed(2)}. ` +
            (teksAdmin || "")
        ).trim();

    const arah = tren === "naik" ? "meningkat" : "menurun";
    const arahkata = tren === "naik" ? "Peningkatan" : "Penurunan";
    let teks = `Pada periode ${tA}–${tB}, nilai ${judul} di ${wilayah} ${arah} sebesar ${absSel} (${absPct}%), dari ${vA.toFixed(2)} menjadi ${vB.toFixed(2)}. `;
    if (skala === "kecil")
        teks += "Perubahan ini tergolong kecil dan kondisi relatif stabil. ";
    else if (skala === "sedang")
        teks += `${arahkata} ini cukup signifikan dan perlu mendapat perhatian. `;
    else
        teks += `${arahkata} yang cukup besar ini memerlukan perhatian khusus dari pemangku kebijakan. `;
    if (teksAdmin) teks += teksAdmin + " ";
    if (isTotal && allLabels?.length > 2)
        teks += `Secara keseluruhan selama ${allLabels.length} periode (${tA}–${tB}), tren menunjukkan ${tren === "naik" ? "kenaikan" : "penurunan"} kumulatif.`;
    return teks.trim();
}

// ── HELPERS ───────────────────────────────────────────────────────────────
function scrollToInterpretasi() {
    document
        .getElementById("interpretasi-section")
        ?.scrollIntoView({ behavior: "smooth" });
}

function resetFilters() {
    document
        .querySelectorAll(".wilayah-check")
        .forEach((cb) => (cb.checked = true));
    document.querySelectorAll(".tahun-check").forEach((cb) => {
        cb.checked = true;
        cb.disabled = false;
    });
    document.querySelectorAll(".kat-radio").forEach((r) => (r.checked = false));
    applyFilters();
}

function escH(str) {
    return String(str)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;");
}
