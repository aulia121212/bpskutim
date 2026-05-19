// public/js/konsultasi.js

let activeKeahlian = null;

// ── Filter keahlian via sidebar ───────────────────────────────────────
function filterKeahlian(el) {
    const keahlian = el.dataset.keahlian;

    // Toggle off jika klik yg sama
    if (activeKeahlian === keahlian || keahlian === "semua") {
        hapusFilter();
        return;
    }
    activeKeahlian = keahlian;

    // Aktifkan tombol sidebar
    document
        .querySelectorAll(".filter-btn")
        .forEach((btn) => btn.classList.remove("active"));
    el.classList.add("active");

    // Tampilkan tombol reset
    const btnReset = document.getElementById("btnResetFilter");
    if (btnReset) btnReset.style.display = "flex";

    // Filter kartu petugas
    const cards = document.querySelectorAll(".petugas-card");
    let visible = 0;
    cards.forEach((card) => {
        const tags = (card.dataset.keahlian || "")
            .split("|")
            .map((t) => t.trim().toLowerCase());
        const match = tags.some((t) => t === keahlian.toLowerCase());
        card.style.display = match ? "" : "none";
        if (match) visible++;
    });

    // Sembunyikan paginasi
    const paginasi = document.getElementById("paginasiWrap");
    if (paginasi) paginasi.style.display = "none";

    // Empty state
    const emptyEl = document.getElementById("filterEmpty");
    const emptyTopik = document.getElementById("filterEmptyTopik");
    if (emptyEl) {
        emptyEl.style.display = visible === 0 ? "flex" : "none";
        if (emptyTopik) emptyTopik.textContent = keahlian;
    }
}

// ── Legacy alias (jika ada tombol lain yang masih pakai filterTopik) ──
function filterTopik(el) {
    // Topik section sekarang display-only, tidak ada aksi
}

// ── Hapus filter ──────────────────────────────────────────────────────
function hapusFilter() {
    activeKeahlian = null;

    document
        .querySelectorAll(".filter-btn")
        .forEach((btn) => btn.classList.remove("active"));
    // Aktifkan "Semua Keahlian"
    const semuaBtn = document.querySelector(
        '.filter-btn[data-keahlian="semua"]',
    );
    if (semuaBtn) semuaBtn.classList.add("active");

    document
        .querySelectorAll(".petugas-card")
        .forEach((card) => (card.style.display = ""));

    const btnReset = document.getElementById("btnResetFilter");
    if (btnReset) btnReset.style.display = "none";

    const emptyEl = document.getElementById("filterEmpty");
    if (emptyEl) emptyEl.style.display = "none";

    const paginasi = document.getElementById("paginasiWrap");
    if (paginasi) paginasi.style.display = "";
}

function animateSteps() {
    const caraSection = document.querySelector(".cara-section");
    if (!caraSection) return;

    const rows = caraSection.querySelectorAll(".step-row");
    if (!rows.length) return;

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("visible");
                    observer.unobserve(entry.target);
                }
            });
        },
        {
            threshold: 0.2,
        },
    );

    rows.forEach((row) => observer.observe(row));
}

// Jalankan setelah halaman siap
document.addEventListener("DOMContentLoaded", () => {
    animateSteps();
});
