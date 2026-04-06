{{-- resources/views/partials/navbar-public.blade.php --}}
<nav id="main-nav">
    <a href="/" class="nav-logo">
<img src="{{ asset('images/bpslogo.svg') }}" alt="BPS" class="nav-logo-img">             
<div>
            <div class="nav-logo-title">BADAN PUSAT STATISTIK</div>
            <div class="nav-logo-title">KABUPATEN KUTAI TIMUR</div>
        </div>
    </a>                                      
    <div class="nav-links">
        <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Home</a>
        <a href="/data-statistik" class="{{ request()->is('data-statistik') ? 'active' : '' }}">Data Statistik</a>
        <a href="/konsultasi" class="{{ request()->is('konsultasi') ? 'active' : '' }}">Konsultasi Statistik</a>
        @auth
    <a href="{{ route('user.profile') }}" class="btn-nav" style="display:flex;align-items:center;gap:8px;padding:6px 16px 6px 6px!important;">
        <div style="width:32px;height:32px;border-radius:50%;background:#e8f0fe;display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;">
            @if(auth()->user()->foto)
                <img src="{{ asset(auth()->user()->foto) }}" style="width:100%;height:100%;object-fit:cover;">
            @else
                <i class="ti ti-user" style="color:#1a56db;font-size:16px;"></i>
            @endif
        </div>
        {{ auth()->user()->name }}
    </a>
@else
    <a href="{{ route('login') }}" class="btn-nav">Daftar/Masuk</a>
@endauth
    </div>
</nav>

<style>

    .nav-logo-img {
    height: 40px;
    width: auto;
    object-fit: contain;
}
#main-nav {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 48px;
    height: 72px;
    /* Transparan saat di atas */
    background: transparent;
    border-bottom: 1px solid transparent;
    transition: background 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
}

/* Saat scroll — jadi putih solid */
#main-nav.scrolled {
    background: #ffffff;
    border-bottom-color: #e2e8f0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.nav-logo {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
}

.nav-logo-title {
    font-family: 'Nunito Sans', sans-serif;
    font-size: 14px;
    font-weight: 800;
    font-style: italic;
    color: #00A2E9;
    line-height: 1.2;
    transition: color 0.3s;
}

.nav-logo-sub {
    font-size: 11px;
    color: #64748b;
    transition: color 0.3s;
}

#main-nav.scrolled .nav-logo-title {
    color: #00A2E9;
}

#main-nav.scrolled .nav-logo-sub {
    color: #64748b;
}

.nav-links {
    display: flex;
    align-items: center;
    gap: 40px;
}

.nav-links a {
    text-decoration: none;
    color: #64748b;
    font-size: 14px;
    font-weight: 600;
    transition: color 0.2s;
    letter-spacing: 0.3px;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.nav-links a:hover,
.nav-links a.active {
    color: #1a56db;
}

#main-nav.scrolled .nav-links a {
    color: #64748b;
}

#main-nav.scrolled .nav-links a:hover,
#main-nav.scrolled .nav-links a.active {
    color: #1a56db;
}

.btn-nav {
    background: #1a56db !important;
    color: #ffffff !important;
    border: 1.5px solid #1a56db !important;
    border-radius: 10px !important;
    padding: 9px 22px !important;
    font-size: 14px !important;
    font-weight: 600 !important;
    cursor: pointer !important;
    text-decoration: none !important;
    transition: all 0.2s !important;
}

.btn-nav:hover {
    background: #1341b0 !important;
    color: #ffffff !important;
}

#main-nav.scrolled .btn-nav {
    background: #1a56db !important;
    color: #ffffff !important;
    border-color: #1a56db !important;
}

#main-nav.scrolled .btn-nav:hover {
    background: #1341b0 !important;
}

@media (max-width: 1024px) {
    #main-nav { padding: 0 24px; }
    .nav-links { gap: 24px; }
}

@media (max-width: 768px) {
    .nav-links a:not(.btn-nav) { display: none; }
}
</style>

<script>
(function() {
    const nav = document.getElementById('main-nav');
    if (!nav) return;

    function updateNav() {
        if (window.scrollY > 20) {
            nav.classList.add('scrolled');
        } else {
            nav.classList.remove('scrolled');
        }
    }

    window.addEventListener('scroll', updateNav, { passive: true });
    updateNav(); // run on load
})();
</script>