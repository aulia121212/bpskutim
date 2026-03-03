<header
    class="sticky top-0 z-[50] w-full border-b border-gray-100 bg-white transition-all duration-300 ease-in-out dark:border-gray-900 dark:bg-gray-950"
    x-data="{ 
        searchOpen: false, 
        searchQuery: '',
        searchItems: @js($searchItems),
        get filteredResults() {
            if (this.searchQuery === '') return [];
            return this.searchItems.filter(item => 
                item.title.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                item.category.toLowerCase().includes(this.searchQuery.toLowerCase())
            );
        }
    }" 
    @keydown.window.escape="searchOpen = false"
    @keydown.window.slash.prevent="searchOpen = true"
    x-cloak>

    <div class="flex items-center justify-between px-4 py-3 sm:px-6">

        {{-- LEFT AREA: Toggler & Search Trigger --}}
        <div class="flex items-center gap-4">
            {{-- Desktop Toggler --}}
            <button @click="$store.sidebar.toggleExpanded()"
                class="hidden h-10 w-10 items-center justify-center rounded-xl border border-gray-100 bg-white text-gray-500 transition-all hover:bg-gray-50 hover:text-indigo-600 active:scale-95 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 xl:flex">
                <i class="ti text-xl transition-transform duration-500"
                    :class="$store.sidebar.isExpanded ? 'ti-layout-sidebar-left-collapse' : 'ti-layout-sidebar-right-collapse rotate-180'">
                </i>
            </button>

            {{-- Mobile Toggler --}}
            <button @click="$store.sidebar.toggleMobileOpen()"
                class="flex h-10 w-10 items-center justify-center rounded-xl border border-gray-100 bg-white text-gray-500 transition-all hover:bg-gray-50 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 xl:hidden">
                <i class="ti ti-menu-2 text-xl"></i>
            </button>

            {{-- SEARCH TRIGGER BUTTON --}}
            <button @click="searchOpen = true" 
                class="hidden md:flex items-center gap-3 px-4 h-10 w-64 rounded-xl bg-gray-50 dark:bg-gray-900 text-gray-400 border border-transparent hover:border-indigo-500/20 transition-all group">
                <i class="ti ti-search text-lg group-hover:text-indigo-600 transition-colors"></i>
                <span class="text-sm font-medium">Cari sesuatu...</span>
                <span class="ml-auto text-[10px] font-bold bg-white dark:bg-gray-800 px-1.5 py-0.5 rounded border dark:border-gray-700 shadow-sm">/</span>
            </button>
        </div>

        {{-- RIGHT AREA: Actions & Profile --}}
        <div class="flex items-center gap-1.5 sm:gap-3">

            {{-- THEME SWITCHER --}}
            <button @click="$store.theme.toggle()"
                class="relative h-10 w-10 flex items-center justify-center rounded-xl text-gray-500 transition-all duration-300 hover:bg-gray-100 active:scale-90 dark:text-gray-400 dark:hover:bg-gray-900"
                title="Ganti Tema">
                <i class="ti ti-moon text-xl absolute transition-all duration-500" x-show="$store.theme.theme === 'light'" x-transition></i>
                <i class="ti ti-sun text-xl absolute transition-all duration-500 text-amber-400" x-show="$store.theme.theme === 'dark'" x-transition></i>
            </button>

            {{-- CART DROPDOWN --}}
            <div class="relative" x-data="{ cartOpen: false }">
                <button @click="cartOpen = !cartOpen"
                    class="relative h-10 w-10 flex items-center justify-center rounded-xl text-gray-500 transition-all hover:bg-gray-100 active:scale-95 dark:text-gray-400 dark:hover:bg-gray-900">
                    <i class="ti ti-shopping-bag text-xl"></i>
                    @if ($cartItems->count() > 0)
                        <span class="absolute -right-1 -top-1 flex h-4 w-4 items-center justify-center rounded-full bg-indigo-600 text-[10px] font-bold text-white shadow-sm shadow-indigo-500/40">
                            {{ $cartItems->count() }}
                        </span>
                    @endif
                </button>

                {{-- Dropdown Card --}}
                <div x-show="cartOpen" @click.outside="cartOpen = false" 
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    class="absolute right-0 mt-3 w-80 sm:w-96 origin-top-right rounded-3xl border border-gray-100 bg-white shadow-2xl shadow-indigo-100 dark:border-gray-800 dark:bg-gray-950 dark:shadow-none"
                    x-cloak>

                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50 dark:border-gray-900">
                        <h3 class="text-sm font-bold  text-gray-400">Keranjang</h3>
                        <span class="text-xs font-bold text-indigo-600 dark:text-indigo-400 ">
                            {{ $cartItems->count() }} Items
                        </span>
                    </div>

                   <div class="max-h-[350px] overflow-y-auto py-2 custom-scrollbar">

    @forelse ($cartItems as $item)
        <div
            class="
                group flex items-center gap-4
                px-5 py-4 mx-2 rounded-2xl
                transition-all duration-200
                hover:bg-gray-50
                dark:hover:bg-gray-900/60
            "
        >
            {{-- Thumbnail --}}
            <div
                class="
                    h-12 w-12 rounded-xl overflow-hidden
                    bg-gray-100 dark:bg-gray-800
                    border border-gray-200 dark:border-gray-700
                    shrink-0
                "
            >
                <img
                    src="{{ $item->image }}"
                    alt="{{ $item->name }}"
                    class="h-full w-full object-cover"
                >
            </div>

            {{-- Info --}}
            <div class="flex-1 min-w-0 space-y-0.5">
                <p
                    class="
                        truncate text-sm font-bold
                        text-gray-900 dark:text-white
                    "
                >
                    {{ $item->name }}
                </p>

                <p
                    class="
                        text-[11px] font-bold uppercase tracking-tight
                        text-gray-400
                    "
                >
                    {{ $item->qty }} ×
                    <span class="text-indigo-600 dark:text-indigo-400 font-black">
                        {{ number_format($item->price, 0, ',', '.') }}
                    </span>
                </p>
            </div>

            {{-- Action --}}
            <button
                class="
                    opacity-0 group-hover:opacity-100
                    p-2 rounded-xl
                    text-gray-300
                    hover:text-rose-500
                    hover:bg-rose-50
                    dark:hover:bg-rose-500/10
                    transition-all
                "
                title="Hapus"
            >
                <i class="ti ti-trash text-lg"></i>
            </button>
        </div>
    @empty
        {{-- Empty State --}}
        <div class="py-14 flex flex-col items-center text-center">
            <div
                class="
                    w-16 h-16 rounded-2xl
                    bg-gray-100 dark:bg-gray-800
                    flex items-center justify-center
                    mb-4
                "
            >
                <i class="ti ti-shopping-cart-off text-3xl text-gray-400 dark:text-gray-600"></i>
            </div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                Keranjang Kosong
            </p>
        </div>
    @endforelse

</div>

                    @if($cartItems->isNotEmpty())
                        <div class="p-6 border-t border-gray-50 dark:border-gray-900 bg-gray-50/50 dark:bg-gray-900/50 rounded-b-3xl">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-xs font-bold text-gray-400">Subtotal</span>
                                <span class="text-lg font-black text-gray-900 dark:text-white">Rp.{{ number_format($cartTotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <a href="#" class="flex items-center justify-center py-3 rounded-xl border border-gray-200 dark:border-gray-800 text-[10px] font-black uppercase tracking-widest text-gray-500 hover:bg-white dark:hover:bg-gray-800 transition-all">
                                    Review
                                </a>
                                <a href="#" class="flex items-center justify-center py-3 rounded-xl bg-indigo-600 text-white text-[10px] font-black uppercase tracking-widest shadow-lg shadow-indigo-600/20 hover:bg-indigo-700 transition-all">
                                    Checkout
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- NOTIFICATIONS --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                    class="relative h-10 w-10 flex items-center justify-center rounded-xl text-gray-500 transition-all hover:bg-gray-100 active:scale-95 dark:text-gray-400 dark:hover:bg-gray-900">
                    <i class="ti ti-bell text-xl"></i>
                    @if ($unreadCount > 0)
                        <span class="absolute right-2.5 top-2.5 flex h-2 w-2">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-rose-400 opacity-75"></span>
                            <span class="relative inline-flex h-2 w-2 rounded-full bg-rose-500"></span>
                        </span>
                    @endif
                </button>

                <div x-show="open" @click.outside="open = false" 
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    class="absolute right-0 mt-3 w-[22rem] sm:w-[26rem] origin-top-right rounded-3xl border border-gray-100 bg-white shadow-2xl shadow-indigo-100 dark:border-gray-800 dark:bg-gray-950 dark:shadow-none"
                    x-cloak>

                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50 dark:border-gray-900">
                        <h3 class="text-sm font-bold   text-gray-400">Notifikasi</h3>
                        <span class="rounded-full bg-indigo-50 px-3 py-1 text-[10px] font-bold text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400">{{ $unreadCount }} Baru</span>
                    </div>

                    <div class="max-h-[400px] overflow-y-auto py-2 custom-scrollbar">
                        @foreach ($latestNotifications as $notif)
                            <a href="{{ $notif->data['url'] }}" class="flex items-start gap-4 px-6 py-4 transition-all duration-200 hover:bg-indigo-50/50 dark:hover:bg-indigo-500/5 group border-b border-gray-50/50 dark:border-gray-900/50 last:border-none">
                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-gray-50 text-gray-400 transition-colors group-hover:bg-white group-hover:text-indigo-600 dark:bg-gray-900 dark:group-hover:bg-gray-800">
                                    <i class="ti {{ $notif->data['icon'] }} text-xl"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start mb-0.5">
                                        <p class="text-sm font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 transition-colors truncate">{{ $notif->data['title'] }}</p>
                                        @if(!$notif->read_at)<span class="h-1.5 w-1.5 rounded-full bg-indigo-500 shadow-[0_0_8px_rgba(79,70,229,0.6)]"></span>@endif
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 leading-relaxed">{{ $notif->data['message'] }}</p>
                                    <p class="mt-2 text-[10px] font-bold text-gray-400 ">{{ $notif->created_at->diffForHumans() }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="border-t border-gray-50 p-4 dark:border-gray-900">
                        <x-button variant="secondary" class="w-full py-2.5 text-xs font-bold ">Tandai Semua Terbaca</x-button>
                    </div>
                </div>
            </div>

            <div class="mx-1 h-6 w-px bg-gray-200 dark:bg-gray-800"></div>

            {{-- PROFILE DROPDOWN --}}
            <div class="relative" x-data="{ userOpen: false }">
                <button @click="userOpen = !userOpen" class="flex items-center gap-3 rounded-2xl p-1 group">
                    <div class="hidden md:flex flex-col items-end">
                        <p class="text-sm font-bold text-gray-900 dark:text-white leading-none mb-1 group-hover:text-indigo-600 transition-colors truncate">{{ $user->name }}</p>
                        <p class="text-xs font-bold text-gray-400 truncate ">{{ $user->role }}</p>
                    </div>
                    <x-avatar :src="$user->avatar ?? null" :name="$user->name" size="sm" shape="xl" status="online" />
                </button>

                <div x-show="userOpen" @click.outside="userOpen = false"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    class="absolute right-0 mt-3 w-64 origin-top-right rounded-3xl border border-gray-100 bg-white p-2 dark:border-gray-900 dark:bg-gray-950 z-50"
                    x-cloak>

                    <div class="flex items-center gap-3 px-4 py-4 border-b border-gray-50 dark:border-gray-900 mb-2">
                        <x-avatar :src="$user->avatar ?? null" :name="$user->name" size="md" shape="xl" />
                        <div class="flex-1 overflow-hidden">
                            <p class="truncate text-sm font-bold text-gray-900 dark:text-white leading-none mb-1">{{ $user->name }}</p>
                            <p class="truncate text-[10px] font-medium text-gray-400">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <a href="#" class="flex items-center gap-3 rounded-2xl px-4 py-2.5 text-sm font-semibold text-gray-600 transition-colors hover:bg-indigo-50 hover:text-indigo-600 dark:text-gray-400 dark:hover:bg-indigo-500/10 dark:hover:text-indigo-400">
                            <i class="ti ti-user-circle text-lg text-indigo-500"></i> Profil Saya
                        </a>
                        <a href="#" class="flex items-center gap-3 rounded-2xl px-4 py-2.5 text-sm font-semibold text-gray-600 transition-colors hover:bg-indigo-50 hover:text-indigo-600 dark:text-gray-400 dark:hover:bg-indigo-500/10 dark:hover:text-indigo-400">
                            <i class="ti ti-settings text-lg text-indigo-500"></i> Pengaturan
                        </a>
                        <hr class="mx-4 my-2 border-gray-50 dark:border-gray-900">
                        <button class="flex w-full items-center gap-3 rounded-2xl px-4 py-2.5 text-sm font-bold text-rose-600 transition-colors hover:bg-rose-50 dark:text-rose-400 dark:hover:bg-rose-500/10">
                            <i class="ti ti-logout-2 text-lg"></i> Keluar Sistem
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SEARCH MODAL OVERLAY --}}
    <template x-teleport="body">
        <div x-show="searchOpen" class="fixed inset-0 z-[10001] flex items-start justify-center p-4 md:p-12" x-cloak>
            {{-- Backdrop --}}
            <div x-show="searchOpen" x-transition.opacity @click="searchOpen = false" class="fixed inset-0 bg-gray-900/60 backdrop-blur-md"></div>
            
            {{-- Modal Content --}}
            <div x-show="searchOpen" 
                 x-transition:enter="transition duration-300 ease-out" 
                 x-transition:enter-start="opacity-0 -translate-y-8 scale-95" 
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition duration-200 ease-in" 
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100" 
                 x-transition:leave-end="opacity-0 -translate-y-8 scale-95"
                 class="relative w-full max-w-2xl bg-white dark:bg-gray-950 rounded-[2.5rem] border border-gray-100 dark:border-gray-800 shadow-2xl overflow-hidden mt-10 flex flex-col">
                
                {{-- Search Input Area --}}
                <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex items-center gap-4">
                    <i class="ti ti-search text-2xl text-indigo-600"></i>
                    <input type="text" 
                           x-model="searchQuery"
                           class="flex-1 bg-transparent border-none outline-none text-lg font-medium dark:text-white placeholder-gray-400" 
                           placeholder="Mencari file, produk, atau halaman..." 
                           x-init="$watch('searchOpen', value => { if(value) { setTimeout(() => $el.focus(), 100); searchQuery = ''; } })"
                           @keydown.escape="searchOpen = false">
                    <button @click="searchOpen = false" class="text-[10px] font-bold text-gray-400 px-2 py-1 bg-gray-50 dark:bg-gray-900 rounded-lg border dark:border-gray-800">ESC</button>
                </div>

                {{-- Results Area --}}
                <div class="max-h-[400px] overflow-y-auto custom-scrollbar">
                    <div x-show="searchQuery === ''" class="p-12 text-center">
                        <div class="w-16 h-16 bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="ti ti-command text-3xl"></i>
                        </div>
                        <p class="text-sm font-bold text-gray-900 dark:text-white mb-1">Pencarian Cepat</p>
                        <p class="text-xs text-gray-400">Ketik nama halaman atau produk untuk navigasi instan.</p>
                    </div>

                    <div x-show="searchQuery !== '' && filteredResults.length > 0" class="p-4 space-y-1">
                        <template x-for="item in filteredResults" :key="item.title">
                            <a :href="item.url" class="flex items-center gap-4 p-4 rounded-2xl hover:bg-indigo-50 dark:hover:bg-indigo-500/10 group transition-all">
                                <div class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-gray-900 flex items-center justify-center text-gray-400 group-hover:text-indigo-600 transition-colors">
                                    <i class="ti" :class="item.icon"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-gray-900 dark:text-white" x-text="item.title"></p>
                                    <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest" x-text="item.category"></p>
                                </div>
                                <i class="ti ti-arrow-right text-indigo-500 opacity-0 group-hover:opacity-100 transition-all translate-x-[-10px] group-hover:translate-x-0"></i>
                            </a>
                        </template>
                    </div>

                    <div x-show="searchQuery !== '' && filteredResults.length === 0" class="p-12 text-center">
                        <i class="ti ti-search-off text-4xl text-gray-300 mb-4 block"></i>
                        <p class="text-sm font-bold text-gray-400">Tidak ada hasil untuk "<span x-text="searchQuery"></span>"</p>
                    </div>
                </div>

                {{-- Footer Info --}}
                <div class="p-4 bg-gray-50/50 dark:bg-gray-900/50 border-t border-gray-100 dark:border-gray-800 flex items-center justify-center gap-6">
                    <div class="flex items-center gap-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                        <span class="px-1.5 py-0.5 rounded border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm text-[8px]">ENTER</span> Pilih
                    </div>
                    <div class="flex items-center gap-2 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                        <span class="px-1.5 py-0.5 rounded border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm text-[8px]">ESC</span> Tutup
                    </div>
                </div>
            </div>
        </div>
    </template>
</header>