/* ========================
   Bootstrap & Alpine
   ======================== */
import "./bootstrap";
import Alpine from "alpinejs";
import collapse from "@alpinejs/collapse";

window.Alpine = Alpine;
Alpine.plugin(collapse);

/* ========================
   Third-party Libraries
   ======================== */
import Swal from "sweetalert2";
window.Swal = Swal;

/* ========================
   Theme Helpers
   ======================== */
function applyTheme(theme) {
    // Jika theme adalah 'dark', aktifkan class dark.
    // Jika 'light' atau tidak ada, maka default ke light (hapus class dark).
    if (theme === "dark") {
        document.documentElement.classList.add("dark");
    } else {
        document.documentElement.classList.remove("dark");
    }
}

/* ========================
   Alpine Stores
   ======================== */
document.addEventListener("alpine:init", () => {
    Alpine.store("sidebar", {
        isExpanded: localStorage.getItem("sidebar-expanded") !== "false",
        isMobileOpen: false,
        // isHovered bisa dihapus atau dibiarkan false
        isHovered: false,

        toggleExpanded() {
            this.isExpanded = !this.isExpanded;
            localStorage.setItem("sidebar-expanded", this.isExpanded);
        },
        toggleMobileOpen() {
            this.isMobileOpen = !this.isMobileOpen;
        },
        setHovered(val) {
            // Fungsi ini sekarang tidak akan terpanggil dari sidebar.blade.php
            this.isHovered = val;
        },
    });

    /* Theme Store Tetap Sama */
    Alpine.store("theme", {
        theme: localStorage.getItem("theme") || "light",
        toggle() {
            this.theme = this.theme === "light" ? "dark" : "light";
            localStorage.setItem("theme", this.theme);
            applyTheme(this.theme);
        },
    });
});

/* ========================
   Apply Theme on Load
   ======================== */
// Langsung jalankan saat script dimuat untuk mencegah flicker
const savedTheme = localStorage.getItem("theme") || "light";
applyTheme(savedTheme);

/* ========================
   Start Alpine
   ======================== */
Alpine.start();

/* ========================
   Session Alert Handler
   ======================== */
document.addEventListener("DOMContentLoaded", () => {
    const alert = window.laravelAlert;
    if (!alert || !alert.message) return;
    const isDark = document.documentElement.classList.contains("dark");
    Swal.fire({
        title: alert.title ?? (alert.type === "success" ? "Berhasil" : "Info"),
        text: alert.message ?? "",
        icon: alert.type ?? "info",
        confirmButtonColor: "#4f46e5", // Indigo-600 agar matching dengan UI
        background: isDark ? "#030712" : "#ffffff", // Gray-950 : White
        color: isDark ? "#f3f4f6" : "#111827",
    });
});

