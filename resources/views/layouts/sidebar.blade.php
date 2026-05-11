<aside id="sidebar"
    class="fixed top-0 left-0 z-[9999] h-screen bg-white dark:bg-gray-950 text-gray-900 transition-all duration-500 border-r border-gray-200 dark:border-gray-800 flex flex-col"

    x-data="{
        openSubmenus: {},
        tooltipText: '',
        tooltipVisible: false,
        tooltipTop: 0,
        logoutConfirm: false,

        get expanded() {
            if (window.innerWidth < 1280) return true;
            return $store.sidebar.isExpanded;
        },

        toggleSubmenu(key) { 
            if(!this.expanded) {
                $store.sidebar.toggleExpanded();
                setTimeout(() => { this.openSubmenus[key] = true; }, 100);
            } else {
                this.openSubmenus[key] = !this.openSubmenus[key]; 
            }
        },

        showTooltip(e, text) {
            if(!this.expanded) {
                this.tooltipText = text;
                this.tooltipVisible = true;
                this.tooltipTop = e.currentTarget.getBoundingClientRect().top + (e.currentTarget.offsetHeight / 2);
            }
        }
    }"

    :class="{
        'w-72': expanded,
        'w-20': !expanded,
        '-translate-x-full xl:translate-x-0': !$store.sidebar.isMobileOpen,
        'translate-x-0': $store.sidebar.isMobileOpen,
    }"

    @mouseleave="tooltipVisible = false"
>

    {{-- TOOLTIP --}}
    <div x-show="tooltipVisible && !expanded"
        class="fixed left-[90px] z-[10000] px-4 py-2 bg-gray-900 text-white text-xs font-semibold rounded-xl shadow-xl"
        :style="`top: ${tooltipTop}px; transform: translateY(-50%);`"
        x-cloak>
        <span x-text="tooltipText"></span>
    </div>

    {{-- LOGO --}}
    {{--
        Link logo diarahkan ke dashboard sesuai role masing-masing.
        - super_admin      → route('superadmin.dashboard')
        - admin_pelayanan  → route('dashboard.index')   (nanti bisa diganti route khusus)
        - admin_statistik  → route('dashboard.index')   (nanti bisa diganti route khusus)
        - user             → route('home')
    --}}
    <div class="h-[72px] flex items-center px-4 border-b border-gray-100 dark:border-gray-800">
        <a href="{{ auth()->user()->dashboardRoute() }}" class="flex items-center gap-3 w-full">
            <img src="{{ asset('images/bpslogo.svg') }}"
                 alt="BPS"
                 class="nav-logo-img shrink-0">

            <div x-show="expanded" x-transition class="leading-tight">
                <div class="nav-logo-title">BADAN PUSAT STATISTIK</div>
                <div class="nav-logo-title">KABUPATEN KUTAI TIMUR</div>
            </div>
        </a>
    </div>

    {{-- MENU --}}
    {{--
        $menuGroups di-inject oleh SidebarMenuComposer (app/View/Composers/SidebarMenuComposer.php)
        dan sudah difilter sesuai role user yang sedang login.
        Tidak perlu ada @if role di sini — semua sudah ditangani di composer.
    --}}
    <div class="flex-1 overflow-y-auto py-4 px-4">
        <nav class="space-y-6">

            @foreach ($menuGroups as $group)
                <div>
                    <h2 class="px-4 text-[11px] font-semibold text-gray-400 tracking-wider"
                        x-show="expanded" x-cloak>
                        {{ $group['title'] }}
                    </h2>

                    <ul class="space-y-1 mt-2">
                        @foreach ($group['items'] as $item)

                        @php
                            $isActive = isset($item['activePattern'])
                                ? request()->routeIs($item['activePattern'])
                                : false;
                        @endphp

                        <li>

                            {{-- DROPDOWN --}}
                            @if(isset($item['children']))
                                <button
                                    @click="toggleSubmenu('{{ $item['name'] }}')"
                                    @mouseenter="showTooltip($event, '{{ $item['name'] }}')"
                                    class="w-full flex items-center py-2.5 rounded-xl transition-all duration-300"
                                    :class="[
                                        {{ $isActive ? 'true' : 'false' }}
                                            ? 'bg-[#035f9c] text-white'
                                            : 'text-gray-500 hover:bg-gray-50',
                                        expanded ? 'px-4 justify-between' : 'justify-center'
                                    ]">

                                    <div class="flex items-center gap-3">
                                        <i class="ti ti-{{ $item['icon'] }} text-xl"></i>
                                        <span x-show="expanded" class="text-sm font-semibold">
                                            {{ $item['name'] }}
                                        </span>
                                    </div>

                                    <i x-show="expanded"
                                       class="ti"
                                       :class="openSubmenus['{{ $item['name'] }}']
                                            ? 'ti-chevron-up'
                                            : 'ti-chevron-down'">
                                    </i>
                                </button>

                                <ul x-show="openSubmenus['{{ $item['name'] }}']"
                                    x-collapse
                                    class="ml-8 mt-2 space-y-1">

                                    @foreach($item['children'] as $child)
                                        @php
                                            $childActive = request()->routeIs($child['activePattern']);
                                        @endphp

                                        <li>
                                            <a href="{{ route($child['route']) }}"
                                               class="block px-3 py-2 rounded-lg text-sm transition
                                               {{ $childActive ? 'bg-[#035f9c] text-blue-600' : 'text-gray-500 hover:bg-gray-50' }}">
                                                {{ $child['name'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>

                            {{-- NORMAL --}}
                            @else
                                <a href="{{ route($item['route']) }}"
                                   @mouseenter="showTooltip($event, '{{ $item['name'] }}')"
                                   class="flex items-center py-2.5 rounded-xl transition-all duration-300"
                                   :class="[
                                        {{ $isActive ? 'true' : 'false' }}
                                            ? 'bg-[#035f9c] text-white'
                                            : 'text-gray-500 hover:bg-gray-50',
                                        expanded ? 'px-4' : 'justify-center'
                                   ]">

                                    <i class="ti ti-{{ $item['icon'] }} text-xl"></i>

                                    <span x-show="expanded"
                                          class="ml-3 font-semibold text-sm">
                                        {{ $item['name'] }}
                                    </span>
                                </a>
                            @endif

                        </li>

                        @endforeach
                    </ul>
                </div>
            @endforeach

        </nav>
    </div>

    {{-- BOTTOM MENU --}}
    <div class="p-4 border-t border-gray-100 dark:border-gray-800 space-y-2">

        {{-- Role Badge — tampilkan role user yang sedang login --}}
        <div x-show="expanded" x-cloak
             class="px-3 py-1.5 mb-1 rounded-lg bg-gray-50 dark:bg-gray-900 flex items-center gap-2">
            <i class="ti ti-shield-check text-sm text-blue-500"></i>
            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">
                {{ auth()->user()->role_label }}
            </span>
        </div>

        {{-- Profil — admin ke admin.profile, user biasa ke user.profile --}}
        @php
            $profileRoute = auth()->user()->isAdmin()
                ? route('admin.profile')
                : route('user.profile');
        @endphp
        <a href="{{ $profileRoute }}"
            class="flex items-center py-2.5 rounded-xl transition-all duration-300 text-gray-500 hover:bg-gray-50"
            @mouseenter="showTooltip($event, 'Profil Akun')">

            <i class="ti ti-user text-xl"></i>
            <span x-show="expanded" class="ml-3 font-semibold text-sm">
                Profil Akun
            </span>
        </a>

        {{-- Logout --}}
        <button type="button"
@click="$store.sidebar.logoutConfirm = true"            class="w-full flex items-center py-2.5 rounded-xl transition-all duration-300 text-red-500 hover:bg-red-50"
            @mouseenter="showTooltip($event, 'Logout')">

            <i class="ti ti-logout text-xl"></i>
            <span x-show="expanded" class="ml-3 font-semibold text-sm">
                Logout
            </span>
        </button>

    </div>

    {{-- LOGOUT MODAL --}}
    <!-- <div x-show="logoutConfirm"
     x-cloak
     x-transition
     class="fixed inset-0 z-[99999] flex items-center justify-center">
        {{-- Overlay --}}
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"
             @click="logoutConfirm = false"></div>

        {{-- Modal --}}
        <div
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
            class="relative bg-white dark:bg-gray-900 rounded-2xl shadow-xl w-[90%] max-w-sm p-6 text-center">

            <i class="ti ti-alert-circle text-red-500 text-4xl mb-4"></i>

            <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-2">
                Konfirmasi Logout
            </h2>

            <p class="text-sm text-gray-500 mb-6">
                Apakah kamu yakin ingin keluar dari akun?
            </p>

            <div class="flex justify-center gap-3">
                <button @click="logoutConfirm = false"
                    class="px-4 py-2 text-sm rounded-xl border hover:bg-gray-100">
                    Batal
                </button>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 text-sm rounded-xl bg-red-500 text-white hover:bg-red-600">
                        Ya, Logout
                    </button>
                </form>
            </div>

        </div>
    </div> -->

    <style>

        :root {
    --putih: #ffffff;
    --hitam: #000000;
    --blue: #1a56db;
    --blue-dark: #1341b0;
    --blue-light: #d5eeff94;
    --blue-soft: #f0f7ff;
    /* --biru: #385d8d; */
    /* --biru: #669dc1; */
    --biru: #035f9c;
    --biru-dark: #006bb2;
    /* --biru: #5692ba; */
    --green: #1f6d8c;
    --green-soft: #f0f7ff;
    --text: #1e293b;
    --muted: #64748b;
    --border: #e2e8f0;
    --bg: #f0f6ff;
}

[x-cloak] { display: none !important; }
    .nav-logo-img {
        height: 40px;
        width: auto;
        object-fit: contain;
    }

    .nav-logo-title {
        font-family: 'Nunito Sans', sans-serif;
        font-size: 14px;
        font-weight: 800;
        font-style: italic;
        color: #035f9c;
        line-height: 1.2;
        transition: color 0.3s;
    }

    .nav-logo-subtitle {
        font-family: 'Nunito Sans', sans-serif;
        font-size: 11px;
        color: #035f9c;
        transition: color 0.3s;
    }
    </style>

</aside>