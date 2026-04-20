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
                            <img src="{{ asset(auth()->user()->foto_profil) }}" style="width:100%;height:100%;object-fit:cover;">
                        @else
                            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:bold;color:#1a56db;background:#fff;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                        @endif
                    </div>
                    <div style="display:flex;flex-direction:column;align-items:flex-start;line-height:1.2;">
                        {{-- Menggunakan Nama User --}}
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
                        {{-- Route profil disesuaikan dengan sidebar.blade.php --}}
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
    color: #1e3a6e;   /* biru tua — kontras di atas bg biru muda */
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
    color: #1e3a6e;
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

.nav-user-wrap {
    position: relative;
}

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

.nav-dropdown.open {
    display: block;
}

.nav-dropdown a:hover,
.nav-dropdown button:hover {
    background: #f1f5f9 !important;
}

@keyframes dropFade {
    from { opacity: 0; transform: translateY(-6px); }
    to   { opacity: 1; transform: translateY(0); }
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
    updateNav();
})(); // Penutup fungsi updateNav

// Dropdown user
(function() {
    const btn      = document.getElementById('navUserBtn');
    const dropdown = document.getElementById('navDropdown');
    const chevron  = document.getElementById('navChevron');
    if (!btn || !dropdown) return;

    btn.addEventListener('click', function(e) {
        e.stopPropagation();
        const isOpen = dropdown.classList.toggle('open');
        if (chevron) chevron.style.transform = isOpen ? 'rotate(180deg)' : 'rotate(0deg)';
    });

    document.addEventListener('click', function() {
        dropdown.classList.remove('open');
        if (chevron) chevron.style.transform = 'rotate(0deg)';
    });

    dropdown.addEventListener('click', function(e) {
        e.stopPropagation();
    });
})();
</script>