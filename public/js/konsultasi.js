// public/js/konsultasi.js

let activeTopik = null;

// ── Filter topik ──────────────────────────────────────────────────────
function filterTopik(el) {
    const topik = el.dataset.topik;

    if (activeTopik === topik) {
        hapusFilter();
        return;
    }
    activeTopik = topik;

    // Tombol aktif
    document
        .querySelectorAll(".topik-item")
        .forEach((btn) => btn.classList.remove("active"));
    el.classList.add("active");

    // Tampilkan tombol hapus filter
    const btnHapus = document.getElementById("btnHapusFilter");
    if (btnHapus) btnHapus.style.display = "inline-flex";

    // Filter kartu petugas
    const cards = document.querySelectorAll(".petugas-card");
    let visible = 0;
    cards.forEach((card) => {
        const keahlian = card.dataset.keahlian || "";
        const tags = keahlian.split("|").map((t) => t.trim().toLowerCase());
        const match = tags.some((t) => t === topik.toLowerCase());
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
        if (emptyTopik) emptyTopik.textContent = topik;
    }

    // Scroll ke reservasi
    document
        .getElementById("reservasi")
        ?.scrollIntoView({ behavior: "smooth", block: "start" });
}

// ── Hapus filter ──────────────────────────────────────────────────────
function hapusFilter() {
    activeTopik = null;
    document
        .querySelectorAll(".topik-item")
        .forEach((btn) => btn.classList.remove("active"));
    document
        .querySelectorAll(".petugas-card")
        .forEach((card) => (card.style.display = ""));

    const btnHapus = document.getElementById("btnHapusFilter");
    if (btnHapus) btnHapus.style.display = "none";

    const emptyEl = document.getElementById("filterEmpty");
    if (emptyEl) emptyEl.style.display = "none";

    const paginasi = document.getElementById("paginasiWrap");
    if (paginasi) paginasi.style.display = "";
}
