// ============================================================
// public/js/data-statistik.js
// ============================================================

// ── Chart config helper ───────────────────────────────────────
function makeChartConfig(labels, values) {
    return {
        type: "line",
        data: {
            labels,
            datasets: [
                {
                    data: values,
                    borderColor: "#1a56db",
                    backgroundColor: "rgba(26,86,219,0.05)",
                    borderWidth: 2.5,
                    pointBackgroundColor: "#1a56db",
                    pointBorderColor: "#fff",
                    pointBorderWidth: 1.5,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.3,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 9 } } },
                y: { grid: { color: "#f8fafc" }, ticks: { font: { size: 9 } } },
            },
        },
    };
}

// ── Hero chart (data di-inject dari blade) ────────────────────
function initHeroChart(labels, values) {
    const el = document.getElementById("heroChart");
    if (!el) return;

    new Chart(el.getContext("2d"), {
        type: "line",
        data: {
            labels,
            datasets: [
                {
                    data: values,
                    borderColor: "#1a56db",
                    backgroundColor: "rgba(26,86,219,0.06)",
                    borderWidth: 3,
                    pointBackgroundColor: "#1a56db",
                    pointBorderColor: "#fff",
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    fill: true,
                    tension: 0.3,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: (c) => c.parsed.y } },
            },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 10 } } },
                y: {
                    grid: { color: "#f1f5f9" },
                    ticks: { font: { size: 10 } },
                },
            },
        },
    });
}

// ── Render chart per card (dipanggil dari blade) ──────────────
function initStatChart(id, labels, values) {
    const el = document.getElementById(id);
    if (!el) return;
    new Chart(el.getContext("2d"), makeChartConfig(labels, values));
}

// ── Carousel ──────────────────────────────────────────────────
(function initCarousel() {
    const track = document.getElementById("chartsTrack");
    const dotsEl = document.getElementById("chartDots");
    if (!track) return;

    const cards = track.querySelectorAll(".chart-card");
    const perView =
        window.innerWidth < 768 ? 1 : window.innerWidth < 1024 ? 2 : 3;
    const maxIdx = Math.max(0, cards.length - perView);
    let current = 0;

    // Build dots
    if (dotsEl) {
        for (let i = 0; i <= maxIdx; i++) {
            const dot = document.createElement("button");
            dot.className = "dot" + (i === 0 ? " active" : "");
            dot.onclick = () => moveTo(i);
            dotsEl.appendChild(dot);
        }
    }

    function moveTo(index) {
        current = Math.max(0, Math.min(index, maxIdx));
        const w = cards[0] ? cards[0].offsetWidth + 24 : 364;
        track.style.transform = `translateX(-${current * w}px)`;
        dotsEl?.querySelectorAll(".dot").forEach((d, i) => {
            d.classList.toggle("active", i === current);
        });
    }

    document
        .getElementById("chartPrev")
        ?.addEventListener("click", () => moveTo(current - 1));
    document
        .getElementById("chartNext")
        ?.addEventListener("click", () => moveTo(current + 1));

    // expose moveTo for filterData
    window._carouselMoveTo = moveTo;
})();

// ── Search / filter ───────────────────────────────────────────
function filterData() {
    const q = document.getElementById("searchInput").value.toLowerCase();
    document.querySelectorAll(".chart-card").forEach((c) => {
        c.style.display = (c.dataset.judul || "").includes(q) ? "" : "none";
    });
    window._carouselMoveTo?.(0);
}

function toggleFilter() {
    alert("Fitur filter akan segera hadir!");
}

// ── Scroll animations ─────────────────────────────────────────
document.addEventListener("DOMContentLoaded", function () {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((e) => {
                if (e.isIntersecting) {
                    e.target.style.opacity = "1";
                    e.target.style.transform = "translateY(0)";
                }
            });
        },
        { threshold: 0.1 },
    );

    document
        .querySelectorAll(".chart-card, .info-card, .cat-card")
        .forEach((el) => {
            el.style.opacity = "0";
            el.style.transform = "translateY(20px)";
            el.style.transition = "opacity 0.5s ease, transform 0.5s ease";
            observer.observe(el);
        });

    // Smooth scroll untuk anchor links
    document.querySelectorAll('a[href^="#"]').forEach((a) => {
        a.addEventListener("click", (e) => {
            e.preventDefault();
            document
                .querySelector(a.getAttribute("href"))
                ?.scrollIntoView({ behavior: "smooth" });
        });
    });
});
