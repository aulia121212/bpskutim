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
            {{-- DROPDOWN USER --}}
            <div class="nav-user-wrap" id="navUserWrap">
                <button class="btn-nav nav-user-btn" id="navUserBtn" type="button"
                        style="display:flex;align-items:center;gap:8px;padding:6px 14px 6px 6px!important;cursor:pointer;border:none;background:#1a56db;border-radius:12px;">
                    <div style="width:32px;height:32px;border-radius:50%;background:#e8f0fe;display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;border: 1px solid rgba(255,255,255,0.2);">
                        @if(auth()->user()->foto_profil)
                            <img src="{{ asset(auth()->user()->foto_profil) . '?v=' . time() }}" style="width:100%;height:100%;object-fit:cover;">
                        @else
                            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:bold;color:#1a56db;background:#fff;">
{{ Str::of(auth()->user()->name)
    ->explode(' ')
    ->map(fn($word) => strtoupper(substr($word, 0, 1)))
    ->take(2)
    ->implode('') }}                            </div>
                        @endif
                    </div>
                    <div style="display:flex;flex-direction:column;align-items:flex-start;line-height:1.2;">
                        <span style="font-size:13px;font-weight:700;color:#fff;max-width:120px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                            {{ auth()->user()->name }}
                        </span>
                        <span style="font-size:10px;font-weight:600;color:rgba(255,255,255,0.8);text-transform:uppercase;letter-spacing:0.5px;">
                            {{ auth()->user()->role_label }}
                        </span>
                    </div>
                    <i class="ti ti-chevron-down" id="navChevron" style="color:#fff;font-size:13px;transition:transform .2s;margin-left:4px;"></i>
                </button>

                {{-- Dropdown panel --}}
                <div class="nav-dropdown" id="navDropdown">
                    <div style="padding:14px 16px 10px;border-bottom:1px solid #f1f5f9;">
                        <p style="font-size:13px;font-weight:700;color:#1e293b;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ auth()->user()->name }}
                        </p>
                        <p style="font-size:11px;color:#94a3b8;margin:2px 0 0;">
                            {{ auth()->user()->email }}
                        </p>
                    </div>

                    <div style="padding:6px;">
                        @php
                            $profileRoute = auth()->user()->isAdmin() ? route('admin.profile') : route('user.profile');
                        @endphp
                        <a href="{{ $profileRoute }}"
                           style="display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:8px;text-decoration:none;color:#374151;font-size:13px;font-weight:600;transition:background .15s;">
                            <i class="ti ti-user-circle" style="font-size:16px;color:#1a56db;"></i>
                            Profil Saya
                        </a>

                        <div style="height:1px;background:#f1f5f9;margin:4px 0;"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    style="display:flex;align-items:center;gap:10px;width:100%;padding:9px 12px;border-radius:8px;border:none;background:none;color:#ef4444;font-size:13px;font-weight:600;cursor:pointer;transition:background .15s;font-family:inherit;">
                                <i class="ti ti-logout" style="font-size:16px;"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}" class="btn-nav">Daftar/Masuk</a>
        @endauth
    </div>

    {{-- RIGHT SIDE: Login (guest) + Hamburger --}}
    <div class="nav-right">
        {{-- Daftar/Masuk di kiri hamburger — hanya untuk guest --}}
        @guest
            <a href="{{ route('login') }}" class="btn-nav nav-login-mobile">Daftar/Masuk</a>
        @endguest

        {{-- HAMBURGER --}}
        <div class="nav-hamburger" id="navHamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</nav>

{{-- MOBILE MENU DROPDOWN --}}
<div class="nav-mobile" id="navMobile">
    <a href="/" class="{{ request()->is('/') ? 'mobile-active' : '' }}">
        <i class="ti ti-home"></i> Home
    </a>
    <a href="/data-statistik" class="{{ request()->is('data-statistik') ? 'mobile-active' : '' }}">
        <i class="ti ti-chart-bar"></i> Data Statistik
    </a>
    <a href="/konsultasi" class="{{ request()->is('konsultasi') ? 'mobile-active' : '' }}">
        <i class="ti ti-headset"></i> Konsultasi Statistik
    </a>

    @auth
        <div style="height:1px;background:#e2e8f0;margin:8px 0;"></div>
        <div style="padding:10px 0 6px;display:flex;align-items:center;gap:10px;">
            <div style="width:36px;height:36px;border-radius:50%;overflow:hidden;flex-shrink:0;border:1.5px solid var(--biru);display:flex;align-items:center;justify-content:center;background:#e8f0fe;">
                @if(auth()->user()->foto_profil)
                    <img src="{{ asset(auth()->user()->foto_profil) . '?v=' . time() }}" style="width:100%;height:100%;object-fit:cover;">
                @else
                    <span style="font-size:13px;font-weight:700;color:var(--biru);">{{ strtoupper(substr(auth()->user()->name, 0, 2)) }}</span>
                @endif
            </div>
            <div>
                <div style="font-size:13px;font-weight:700;color:#1e293b;">{{ auth()->user()->name }}</div>
                <div style="font-size:11px;color:#94a3b8;">{{ auth()->user()->email }}</div>
            </div>
        </div>
        @php $profileRoute = auth()->user()->isAdmin() ? route('admin.profile') : route('user.profile'); @endphp
        <a href="{{ $profileRoute }}">
            <i class="ti ti-user-circle"></i> Profil Saya
        </a>
        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
            @csrf
            <button type="submit" class="mobile-logout-btn">
                <i class="ti ti-logout"></i> Logout
            </button>
        </form>
    @endauth
</div>

<style>
:root {
    --putih: #ffffff;
    --hitam: #000000;
    --blue: #1a56db;
    --blue-dark: #1341b0;
    --blue-light: #d5eeff94;
    --blue-soft: #f0f7ff;
    --biru: #035f9c;
    --biru-dark: #006bb2;
    --green: #1f6d8c;
    --green-soft: #f0f7ff;
    --text: #1e293b;
    --muted: #64748b;
    --border: #e2e8f0;
    --bg: #f0f6ff;
}

/* ── HAMBURGER ── */
.nav-hamburger {
    display: none;
    flex-direction: column;
    gap: 4px;
    cursor: pointer;
    padding: 4px;
}
.nav-hamburger span {
    width: 22px;
    height: 2px;
    background: var(--biru);
    border-radius: 2px;
    transition: background 0.2s;
}

/* ── MOBILE MENU ── */
.nav-mobile {
    display: none;
    flex-direction: column;
    background: #ffffff;
    position: fixed;
    top: 72px;
    left: 0;
    right: 0;
    padding: 12px 20px 20px;
    z-index: 9998;
    border-top: 1px solid #e2e8f0;
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
}
.nav-mobile a {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 4px;
    text-decoration: none;
    color: #1e293b;
    font-size: 14px;
    font-weight: 600;
    border-bottom: 1px solid #f1f5f9;
    font-family: 'Plus Jakarta Sans', sans-serif;
    transition: color 0.15s;
}
.nav-mobile a:last-of-type {
    border-bottom: none;
}
.nav-mobile a:hover,
.nav-mobile a.mobile-active {
    color: var(--biru);
}
.nav-mobile a i,
.nav-mobile button i {
    font-size: 16px;
    color: var(--biru);
    opacity: 0.8;
}
.mobile-logout-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%;
    padding: 12px 4px;
    border: none;
    background: none;
    color: #ef4444;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    font-family: 'Plus Jakarta Sans', sans-serif;
    text-align: left;
}
.mobile-logout-btn i {
    color: #ef4444 !important;
}
.nav-mobile.active {
    display: flex;
}

/* ── RIGHT WRAPPER ── */
.nav-right {
    display: none; /* hidden on desktop */
    align-items: center;
    gap: 10px;
}

/* "Daftar/Masuk" di mobile — hanya tampil di mobile */
.nav-login-mobile {
    display: none;
}

/* ── DESKTOP ── */
@media (min-width: 769px) {
    .nav-right { display: none; }
    .nav-login-mobile { display: none; }
}

/* ── MOBILE ── */
@media (max-width: 768px) {
    /* Sembunyikan nav links desktop */
    .nav-links {
        display: none !important;
    }

    /* Sembunyikan teks logo */
    .nav-logo div {
        display: none;
    }

    /* Tampilkan area kanan: login + hamburger */
    .nav-right {
        display: flex;
    }

    /* Tampilkan tombol login di kiri hamburger */
    .nav-login-mobile {
        display: inline-flex !important;
        padding: 7px 14px !important;
        font-size: 13px !important;
        align-items: center;
    }

    /* Tampilkan hamburger */
    .nav-hamburger {
        display: flex;
    }

    #main-nav {
        padding: 0 20px;
    }
}

@media (max-width: 1024px) {
    #main-nav { padding: 0 24px; }
    .nav-links { gap: 24px; }
}

/* ── LOGO ── */
.nav-logo-img {
    height: 40px;
    width: auto;
    object-fit: contain;
}

/* ── MAIN NAV ── */
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
    background: transparent;
    border-bottom: 1px solid transparent;
    transition: background 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
}
#main-nav.scrolled {
    background: #ffffff;
    border-bottom-color: #e2e8f0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

/* ── LOGO ── */
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
    color: var(--biru);
    line-height: 1.2;
    transition: color 0.3s;
}

/* ── NAV LINKS ── */
.nav-links {
    display: flex;
    align-items: center;
    gap: 40px;
}
.nav-links a {
    text-decoration: none;
    color: #969ca7;
    font-size: 14px;
    font-weight: 600;
    transition: color 0.2s;
    letter-spacing: 0.3px;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.nav-links.scrolled a {
    text-decoration: none;
    color: #969ca7;
    font-size: 14px;
    font-weight: 600;
    transition: color 0.2s;
    letter-spacing: 0.3px;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.nav-links a:hover,
.nav-links a.active {
    color: var(--biru);
}
#main-nav.scrolled .nav-links a { color: #969ca7;; }
#main-nav.scrolled .nav-links a:hover,
#main-nav.scrolled .nav-links a.active { color: var(--biru); }

/* ── BTN NAV ── */
.btn-nav {
    background: var(--biru) !important;
    color: #ffffff !important;
    border: 1.5px solid var(--biru) !important;
    border-radius: 10px !important;
    padding: 9px 22px !important;
    font-size: 14px !important;
    font-weight: 600 !important;
    cursor: pointer !important;
    text-decoration: none !important;
    transition: all 0.2s !important;
}
.btn-nav:hover {
    background: var(--biru-dark) !important;
    color: #ffffff !important;
}
#main-nav.scrolled .btn-nav {
    background: var(--biru) !important;
    color: #ffffff !important;
    border-color: var(--biru) !important;
}
#main-nav.scrolled .btn-nav:hover {
    background: #ffffff !important;
    border-color: var(--biru) !important;
    color: var(--biru) !important;
}

/* ── USER DROPDOWN ── */
.nav-user-wrap { position: relative; }
.nav-dropdown {
    display: none;
    position: absolute;
    top: calc(100% + 10px);
    right: 0;
    width: 220px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.10);
    z-index: 10000;
    animation: dropFade .15s ease;
}
.nav-dropdown.open { display: block; }
.nav-dropdown a:hover,
.nav-dropdown button:hover { background: #f1f5f9 !important; }

@keyframes dropFade {
    from { opacity: 0; transform: translateY(-6px); }
    to   { opacity: 1; transform: translateY(0); }
}
</style>

<script>
// Scroll effect
(function() {
    const nav = document.getElementById('main-nav');
    if (!nav) return;
    function updateNav() {
        nav.classList.toggle('scrolled', window.scrollY > 20);
    }
    window.addEventListener('scroll', updateNav, { passive: true });
    updateNav();
})();

// Desktop user dropdown
(function() {
    const btn      = document.getElementById('navUserBtn');
    const dropdown = document.getElementById('navDropdown');
    const chevron  = document.getElementById('navChevron');
    if (!btn || !dropdown) return;
    btn.addEventListener('click', function(e) {
        e.stopPropagation();
        const isOpen = dropdown.classList.toggle('open');
        if (chevron) chevron.style.transform = isOpen ? 'rotate(180deg)' : '';
    });
    document.addEventListener('click', function() {
        dropdown.classList.remove('open');
        if (chevron) chevron.style.transform = '';
    });
    dropdown.addEventListener('click', e => e.stopPropagation());
})();

// Hamburger mobile menu
(function() {
    const hamburger  = document.getElementById('navHamburger');
    const mobileMenu = document.getElementById('navMobile');
    if (!hamburger || !mobileMenu) return;
    hamburger.addEventListener('click', () => {
        mobileMenu.classList.toggle('active');
        // Animasi bar hamburger → X
        hamburger.classList.toggle('open');
    });
    // Tutup saat klik link
    mobileMenu.querySelectorAll('a').forEach(a => {
        a.addEventListener('click', () => mobileMenu.classList.remove('active'));
    });
})();
</script>