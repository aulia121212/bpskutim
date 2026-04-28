document.addEventListener("DOMContentLoaded", function () {
  const track = document.getElementById("heroTrack");
    const dots = document.querySelectorAll(".slider-dots .dot");
    const slides = document.querySelectorAll(".slide");
    const total = slides.length;
    let idx = 0;
    let timer = null;

    function goTo(n) {
        idx = (n + total) % total;
        if (track) track.style.transform = `translateX(-${idx * 100}%)`;
        dots.forEach((d, i) => d.classList.toggle("active", i === idx));
    }
    function startAuto() {
        clearInterval(timer);
        timer = setInterval(() => goTo(idx + 1), 5000);
    }
    document.getElementById("heroPrev")?.addEventListener("click", () => {
        goTo(idx - 1);
        startAuto();
    });
    document.getElementById("heroNext")?.addEventListener("click", () => {
        goTo(idx + 1);
        startAuto();
    });
    document.getElementById("dotPrev")?.addEventListener("click", () => {
        goTo(idx - 1);
        startAuto();
    });
    document.getElementById("dotNext")?.addEventListener("click", () => {
        goTo(idx + 1);
        startAuto();
    });
    dots.forEach((d, i) =>
        d.addEventListener("click", () => {
            goTo(i);
            startAuto();
        }),
    );
    goTo(0);
    startAuto();

    // ════════════════════════════════════════════════════
    // HELPERS
    // ════════════════════════════════════════════════════
    const REGION_COLORS = [
        "#035f9c",
        "#e11d48",
        "#16a34a",
        "#d97706",
        "#7c3aed",
    ];

    function hexToRgba(hex, alpha) {
        const r = parseInt(hex.slice(1, 3), 16);
        const g = parseInt(hex.slice(3, 5), 16);
        const b = parseInt(hex.slice(5, 7), 16);
        return `rgba(${r},${g},${b},${alpha})`;
    }

    function _showEmptyMsg(canvas) {
        const wrap = canvas.parentElement;
        if (!wrap) return;
        canvas.style.display = "none";
        if (!wrap.querySelector(".chart-empty-msg")) {
            const p = document.createElement("p");
            p.className = "chart-empty-msg";
            p.textContent = "Data belum tersedia";
            p.style.cssText =
                "text-align:center;color:#9ca3af;font-size:.8rem;padding:60px 0";
            wrap.appendChild(p);
        }
    }

    // ════════════════════════════════════════════════════
    // NORMALIZE
    //
    // Struktur DB (statistic_values):
    //   x_label  = nama sub-indikator  → nama dataset / legend
    //   y_label  = tahun (2021, 2022…) → SUMBU X chart
    //   year     = NULL (tidak dipakai)
    //   value    = nilai numerik
    //
    // Backend mengirim ke window.homeCharts:
    //   stat.y_labels  = ["2021","2022","2023","2024","2025"]  ← sumbu X
    //   stat.datasets  = [{label: "UHH saat Lahir", values:[…]}, …]
    //                    label = x_label (nama sub-indikator)
    //   stat.values    = […]   ← format lama single-wilayah (fallback)
    //   stat.labels    = […]   ← DIABAIKAN untuk sumbu X (isinya x_label)
    // ════════════════════════════════════════════════════
    function normalizeChartData(stat) {
        const isTahun = (v) => {
            const s = String(v).trim();
            return /^\d{4}$/.test(s) && +s >= 1900 && +s <= 2100;
        };

        // ── 1. Tentukan sumbu X ───────────────────────────────────────
        // Prioritas: y_labels → years → labels (kalau isinya tahun) → fallback index
        let xLabels;
        if (Array.isArray(stat.y_labels) && stat.y_labels.length > 0) {
            // Format baru: backend kirim kolom y_label dari DB
            xLabels = stat.y_labels.map(String);
        } else if (Array.isArray(stat.years) && stat.years.length > 0) {
            // Fallback lama
            xLabels = stat.years.map(String);
        } else if (Array.isArray(stat.labels) && stat.labels.every(isTahun)) {
            // labels kebetulan sudah berisi tahun
            xLabels = stat.labels.map(String);
        } else {
            // Tidak ada tahun sama sekali — pakai indeks agar chart tetap tampil
            const len = (stat.datasets?.[0]?.values ?? stat.values ?? [])
                .length;
            xLabels = Array.from({ length: len }, (_, i) => String(i + 1));
            console.warn(
                `[homeCharts] id=${stat.id}: y_labels/years tidak ditemukan, sumbu X pakai indeks.`,
            );
        }

        // ── 2. Susun datasets ─────────────────────────────────────────
        let datasets = stat.datasets || null;
        if (!datasets) {
            datasets = [
                { label: stat.wilayah || "Data", values: stat.values || [] },
            ];
        }

        // ── 3. Ambil 5 tahun terakhir ─────────────────────────────────
        if (xLabels.length > 5) {
            const start = xLabels.length - 5;
            xLabels = xLabels.slice(start);
            datasets = datasets.map((ds) => ({
                ...ds,
                values: (ds.values || []).slice(start),
            }));
        }

        return { labels: xLabels, datasets };
    }

    // ════════════════════════════════════════════════════
    // BUILD LEGEND
    // ════════════════════════════════════════════════════
    function buildLegend(cardEl, datasets) {
        const legendEl = cardEl.querySelector(".chart-legend");
        if (!legendEl) return;
        legendEl.innerHTML = "";

        datasets.forEach((ds, i) => {
            if (
                !ds.values ||
                ds.values.every((v) => v === null || v === undefined)
            )
                return;
            const color = REGION_COLORS[i % REGION_COLORS.length];
            const item = document.createElement("div");
            item.className = "legend-item";
            item.innerHTML = `<span class="legend-dot" style="background:${color}"></span>${ds.label}`;
            legendEl.appendChild(item);
        });
    }

    // ════════════════════════════════════════════════════
    // MAKE CHART
    // ════════════════════════════════════════════════════
    function makeMultiChart(canvasId, labels, datasets) {
        const canvas = document.getElementById(canvasId);
        if (!canvas) return;

        if (!labels || !labels.length || !datasets || !datasets.length) {
            _showEmptyMsg(canvas);
            return;
        }

        const existing = Chart.getChart(canvas);
        if (existing) existing.destroy();

        const chartDatasets = datasets
            .map((ds, i) => {
                const color = REGION_COLORS[i % REGION_COLORS.length];
                if (!ds.values || !ds.values.some((v) => v != null))
                    return null;
                return {
                    label: ds.label,
                    data: ds.values,
                    borderColor: color,
                    backgroundColor: hexToRgba(color, 0.07),
                    borderWidth: 2.5,
                    pointRadius: 4,
                    pointHoverRadius: 7,
                    pointBackgroundColor: color,
                    pointBorderColor: "#fff",
                    pointBorderWidth: 2,
                    fill: true,
                    tension: 0.35,
                };
            })
            .filter(Boolean);

        if (!chartDatasets.length) {
            _showEmptyMsg(canvas);
            return;
        }

        new Chart(canvas, {
            type: "line",
            data: { labels, datasets: chartDatasets },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { intersect: false, mode: "index" },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: "rgba(15,23,42,0.92)",
                        titleColor: "#f1f5f9",
                        bodyColor: "#cbd5e1",
                        padding: { x: 14, y: 10 },
                        borderRadius: 10,
                        callbacks: {
                            label: (ctx) =>
                                ` ● ${ctx.dataset.label}: ${Number(ctx.parsed.y).toLocaleString("id-ID")}`,
                        },
                    },
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: "Tahun",
                            color: "#94a3b8",
                            font: { size: 11 },
                        },
                        ticks: {
                            font: { size: 11 },
                            color: "#94a3b8",
                            maxRotation: 0,
                        },
                        grid: { display: false },
                    },
                    y: {
                        title: {
                            display: true,
                            text: "Nilai",
                            color: "#94a3b8",
                            font: { size: 11 },
                        },
                        ticks: {
                            font: { size: 10 },
                            color: "#94a3b8",
                            maxTicksLimit: 5,
                            callback: (v) => Number(v).toLocaleString("id-ID"),
                        },
                        grid: { color: "rgba(0,0,0,.04)" },
                    },
                },
            },
        });
    }

    // ════════════════════════════════════════════════════
    // RENDER ALL CHARTS
    // ════════════════════════════════════════════════════
    if (Array.isArray(window.homeCharts) && window.homeCharts.length > 0) {
        window.homeCharts.forEach((stat) => {
            const { labels, datasets } = normalizeChartData(stat);
            const card = document.querySelector(
                `.chart-card[data-id="${stat.id}"]`,
            );
            if (card) buildLegend(card, datasets);
            makeMultiChart(`chart-${stat.id}`, labels, datasets);
        });
    }

    // ════════════════════════════════════════════════════
    // FOCUS CAROUSEL
    // FIX: card pertama mentok kiri karena getCardOffset()
    // dipanggil sebelum CSS scale ter-apply.
    // Solusi: gunakan translateX berbasis posisi nominal card
    // (index × (cardWidth + gap)) dikurangi offset viewport tengah.
    // ════════════════════════════════════════════════════
    const chartsTrack = document.getElementById("chartsTrack");
    const dotsEl = document.getElementById("chartDots");
    const cards = chartsTrack
        ? Array.from(chartsTrack.querySelectorAll(".chart-card"))
        : [];

    if (cards.length === 0) return;

    let activeIdx = 0;

    /**
     * Hitung offset translateX agar card[n] muncul di tengah viewport.
     * Menggunakan getBoundingClientRect yang sudah mempertimbangkan CSS.
     */
    function calcOffset(n) {
        // Setelah is-active diterapkan, ukur ulang
        const card = cards[n];
        const trackEl = chartsTrack;

        // Posisi kiri card relatif terhadap track (tanpa transform)
        // Kita pakai offsetLeft agar tidak terpengaruh transform yang sedang berjalan
        let left = 0;
        let el = card;
        while (el && el !== trackEl) {
            left += el.offsetLeft;
            el = el.offsetParent;
        }
        // Tengah card
        const cardCenter = left + card.offsetWidth / 2;
        // Tengah viewport
        const viewMid = window.innerWidth / 2;
        return cardCenter - viewMid;
    }

    function setActiveCard(n) {
        activeIdx = Math.max(0, Math.min(n, cards.length - 1));

        cards.forEach((c, i) =>
            c.classList.toggle("is-active", i === activeIdx),
        );

        // Beri satu frame agar browser apply class sebelum kita ukur
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                const offset = calcOffset(activeIdx);
                chartsTrack.style.transform = `translateX(-${offset}px)`;
            });
        });

        dotsEl
            ?.querySelectorAll(".chart-dot")
            .forEach((d, i) => d.classList.toggle("active", i === activeIdx));
    }

    function buildCarouselDots() {
        if (!dotsEl) return;
        dotsEl.innerHTML = "";
        cards.forEach((_, i) => {
            const d = document.createElement("button");
            d.className = "chart-dot" + (i === 0 ? " active" : "");
            d.setAttribute("aria-label", `Kartu ${i + 1}`);
            d.addEventListener("click", () => setActiveCard(i));
            dotsEl.appendChild(d);
        });
    }

    // Klik card non-aktif → fokus
    cards.forEach((card, i) => {
        card.addEventListener("click", () => {
            if (i !== activeIdx) setActiveCard(i);
        });
    });

    document
        .getElementById("chartPrev")
        ?.addEventListener("click", () => setActiveCard(activeIdx - 1));
    document
        .getElementById("chartNext")
        ?.addEventListener("click", () => setActiveCard(activeIdx + 1));

    // Touch / swipe
    let touchStartX = 0;
    chartsTrack?.addEventListener(
        "touchstart",
        (e) => {
            touchStartX = e.touches[0].clientX;
        },
        { passive: true },
    );
    chartsTrack?.addEventListener("touchend", (e) => {
        const diff = touchStartX - e.changedTouches[0].clientX;
        if (Math.abs(diff) > 40)
            setActiveCard(diff > 0 ? activeIdx + 1 : activeIdx - 1);
    });

    buildCarouselDots();

    // Init setelah layout stabil (font + image load singkat)
    // Double rAF + small timeout untuk keamanan
    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            setTimeout(() => setActiveCard(0), 60);
        });
    });

    // Resize recalculation
    let resizeTimer;
    window.addEventListener("resize", () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            // Nonaktifkan transisi sementara agar tidak "meloncat"
            chartsTrack.style.transition = "none";
            setActiveCard(activeIdx);
            setTimeout(() => {
                chartsTrack.style.transition = "";
            }, 50);
        }, 150);
    });

    // ════════════════════════════════════════════════════
    // POPUP
    // ════════════════════════════════════════════════════
    const popupId = window.popupData?.id;

    function tutupPopup() {
        const el = document.getElementById("popup-overlay");
        if (!el) return;
        el.style.opacity = "0";
        setTimeout(() => el.remove(), 250);
        if (popupId) sessionStorage.setItem("popup_closed_" + popupId, "1");
    }
    window.tutupPopup = tutupPopup;

    document
        .getElementById("popup-overlay")
        ?.addEventListener("click", function (e) {
            if (e.target === this) tutupPopup();
        });
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") tutupPopup();
    });

    if (popupId && sessionStorage.getItem("popup_closed_" + popupId)) {
        document.getElementById("popup-overlay")?.remove();
    }
});
