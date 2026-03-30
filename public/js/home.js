/* ═══════════════════════════════════════════════
   home.js — BPS Kutai Timur Homepage
   ═══════════════════════════════════════════════ */

document.addEventListener('DOMContentLoaded', function () {

    // ── HERO SLIDER ──────────────────────────────
    const track  = document.getElementById('heroTrack');
    const dots   = document.querySelectorAll('.slider-dots .dot');
    const slides = document.querySelectorAll('.slide');
    const total  = slides.length;
    let   idx    = 0;
    let   timer;

    function goTo(n) {
        idx = (n + total) % total;
        track.style.transform = `translateX(-${idx * 100}%)`;
        dots.forEach((d, i) => d.classList.toggle('active', i === idx));
    }

    function startAuto() {
        clearInterval(timer);
        timer = setInterval(() => goTo(idx + 1), 5000);
    }

    document.getElementById('heroPrev')?.addEventListener('click', () => { goTo(idx - 1); startAuto(); });
    document.getElementById('heroNext')?.addEventListener('click', () => { goTo(idx + 1); startAuto(); });

    dots.forEach((d, i) => d.addEventListener('click', () => { goTo(i); startAuto(); }));

    // dot row prev/next buttons
    document.getElementById('dotPrev')?.addEventListener('click', () => { goTo(idx - 1); startAuto(); });
    document.getElementById('dotNext')?.addEventListener('click', () => { goTo(idx + 1); startAuto(); });

    startAuto();

    // ── CHARTS CAROUSEL ──────────────────────────
    let   chartIdx   = 0;
    const chartsTrack = document.getElementById('chartsTrack');
    const chartCards  = chartsTrack?.querySelectorAll('.chart-card') ?? [];
    const perView     = window.innerWidth < 768 ? 1 : window.innerWidth < 1024 ? 2 : 3;
    const maxChartIdx = Math.max(0, chartCards.length - perView);
    const dotsEl      = document.getElementById('chartDots');

    if (dotsEl && chartCards.length > perView) {
        for (let i = 0; i <= maxChartIdx; i++) {
            const d = document.createElement('button');
            d.className = 'chart-dot' + (i === 0 ? ' active' : '');
            d.addEventListener('click', () => moveCharts(i));
            dotsEl.appendChild(d);
        }
    }

    function moveCharts(n) {
        chartIdx = Math.max(0, Math.min(n, maxChartIdx));
        const cardW = chartCards[0] ? chartCards[0].offsetWidth + 20 : 380;
        if (chartsTrack) chartsTrack.style.transform = `translateX(-${chartIdx * cardW}px)`;
        dotsEl?.querySelectorAll('.chart-dot').forEach((d, i) => d.classList.toggle('active', i === chartIdx));
    }

    document.getElementById('chartPrev')?.addEventListener('click', () => moveCharts(chartIdx - 1));
    document.getElementById('chartNext')?.addEventListener('click', () => moveCharts(chartIdx + 1));

    // ── DEMO CHARTS (Chart.js) ────────────────────
    const demoLabels   = [2018, 2019, 2020, 2021, 2022, 2023, 2024];
    const demoDatasets = [
        [9.28, 9.51, 9.65, 9.91, 9.38, 8.78, 8.61],
        [8.50, 8.90, 9.20, 9.50, 9.10, 8.80, 8.30],
        [7.80, 8.10, 8.40, 8.70, 8.50, 8.20, 7.90],
    ];

    function makeChart(canvasId, labels, data) {
        const canvas = document.getElementById(canvasId);
        if (!canvas) return;
        new Chart(canvas.getContext('2d'), {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    data,
                    borderColor:     '#1a56db',
                    backgroundColor: 'rgba(26,86,219,.07)',
                    borderWidth:     2,
                    pointBackgroundColor: '#1a56db',
                    pointRadius:     4,
                    fill:            true,
                    tension:         0.35,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 10 } } },
                    y: { grid: { color: '#f1f5f9' }, ticks: { font: { size: 10 } } },
                },
            },
        });
    }

    // Demo charts
    for (let i = 0; i < 3; i++) {
        makeChart(`demo-chart-${i}`, demoLabels, demoDatasets[i]);
    }

    // Real charts — data injected via inline script in blade
    if (window.homeCharts) {
        window.homeCharts.forEach(({ id, labels, values }) => makeChart(id, labels, values));
    }

});