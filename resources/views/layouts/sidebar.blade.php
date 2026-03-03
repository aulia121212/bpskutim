<aside id="sidebar"
    class="fixed top-0 left-0 z-[9999] h-screen bg-white dark:bg-gray-950 text-gray-900 transition-all duration-500 border-r border-gray-200 dark:border-gray-800 flex flex-col"
    x-data="{
        openSubmenus: {},
        tooltipText: '',
        tooltipVisible: false,
        tooltipTop: 0,
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
    @mouseleave="tooltipVisible = false">

    {{-- Tooltip --}}
    <div x-show="tooltipVisible && !expanded"
        class="fixed left-[90px] z-[10000] px-4 py-2 bg-gray-900 text-white text-xs font-semibold rounded-xl shadow-xl"
        :style="`top: ${tooltipTop}px; transform: translateY(-50%);`"
        x-cloak>
        <span x-text="tooltipText"></span>
    </div>

    {{-- Logo --}}
    <div class="h-18 flex items-center p-4 border-b border-gray-100 dark:border-gray-800">
        <a href="{{ route('dashboard.index') }}" class="flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center shadow-md">
                <span class="text-white font-bold text-lg">B</span>
            </div>

            <div x-show="expanded" x-transition class="flex flex-col leading-none">
                <span class="font-bold text-base dark:text-white">
                    BPS Kutai Timur
                </span>
                <span class="text-xs text-gray-400">
                    Super Admin 
                </span>
            </div>
        </a>
    </div>

    {{-- Navigation --}}
    <div class="flex-1 overflow-y-auto py-4 px-4">
        <nav class="space-y-6">
            @foreach ($menuGroups as $gIdx => $group)
                <div>
                    <h2 class="px-4 text-[11px] font-semibold text-gray-400 tracking-wider"
                        x-show="expanded" x-cloak>
                        {{ $group['title'] }}
                    </h2>

                    <ul class="space-y-1 mt-2">
                        @foreach ($group['items'] as $iIdx => $item)

    @php
        $isActive = isset($item['activePattern']) 
            ? request()->routeIs($item['activePattern']) 
            : false;
    @endphp

    <li>

        {{-- ================= DROPDOWN ================= --}}
        @if(isset($item['children']))

            <button
                @click="toggleSubmenu('{{ $item['name'] }}')"
                @mouseenter="showTooltip($event, '{{ $item['name'] }}')"
                class="w-full flex items-center py-2.5 rounded-xl transition-all duration-300"
                :class="[
                    {{ $isActive ? 'true' : 'false' }}
                        ? 'bg-blue-600 text-white'
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

            {{-- CHILD MENU --}}
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
                           {{ $childActive ? 'bg-blue-100 text-blue-600' : 'text-gray-500 hover:bg-gray-50' }}">
                            {{ $child['name'] }}
                        </a>
                    </li>
                @endforeach

            </ul>

        {{-- ================= NORMAL ITEM ================= --}}
        @else

            <a href="{{ route($item['route']) }}"
               @mouseenter="showTooltip($event, '{{ $item['name'] }}')"
               class="flex items-center py-2.5 rounded-xl transition-all duration-300"
               :class="[
                    {{ $isActive ? 'true' : 'false' }}
                        ? 'bg-blue-600 text-white'
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

    {{-- Bottom Profile --}}
    <div class="p-4 border-t border-gray-100 dark:border-gray-800">

        <div class="bg-gray-50 dark:bg-gray-900 rounded-2xl p-3 cursor-pointer">
            <div class="flex items-center gap-3" :class="expanded ? '' : 'justify-center'">
                <img src="https://ui-avatars.com/api/?name=BPS&background=2563eb&color=fff"
                     class="w-9 h-9 rounded-xl" alt="User">

                <div x-show="expanded" x-cloak>
                    <p class="text-xs font-bold text-gray-900 dark:text-white">
                        BPS
                    </p>
                    <p class="text-[10px] text-gray-400">
                        Super Admin
                    </p>
                </div>
            </div>
        </div>

    </div>
</aside>