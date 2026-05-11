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
                class="hidden h-10 w-10 items-center justify-center rounded-xl border border-gray-100 bg-white text-gray-500 transition-all hover:bg-gray-50 hover:text-[#035f9c] active:scale-95 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-400 dark:hover:bg-gray-800 xl:flex">
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
            <!-- <button @click="searchOpen = true" 
                class="hidden md:flex items-center gap-3 px-4 h-10 w-64 rounded-xl bg-gray-50 dark:bg-gray-900 text-gray-400 border border-transparent hover:border-indigo-500/20 transition-all group">
                <i class="ti ti-search text-lg group-hover:text-indigo-600 transition-colors"></i>
                <span class="text-sm font-medium">Cari sesuatu...</span>
                <span class="ml-auto text-[10px] font-bold bg-white dark:bg-gray-800 px-1.5 py-0.5 rounded border dark:border-gray-700 shadow-sm">/</span>
            </button> -->
        </div>

{{-- RIGHT AREA: SIMPLE PROFILE --}}
<div class="flex items-center gap-3">
    @php
        $user = auth()->user(); // Memastikan mengambil data user yang sedang login
    @endphp
    
    <div class="flex items-center gap-3 px-3 py-1.5 rounded-2xl">

        {{-- FOTO PROFIL --}}
        <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
            @if($user->foto_profil) 
                <img src="{{ asset($user->foto_profil) }}"
                     class="w-full h-full object-cover">
            @else
                {{-- Fallback jika tidak ada foto: Inisial Nama --}}
                <div class="w-full h-full flex items-center justify-center text-sm font-bold text-[#035f9c] bg-blue-50 dark:bg-blue-900/30">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
            @endif
        </div>

        {{-- INFO USER --}}
        <div class="flex flex-col leading-tight max-w-[180px]">
            <p class="text-sm font-bold text-gray-900 dark:text-white truncate">
                {{ $user->name }}
            </p>
            {{-- Menampilkan Role Label sesuai data profil --}}
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                {{ $user->role_label }}


                
            </p>
            <p class="text-[10px] text-gray-400 truncate">
                {{ $user->email }}
            </p>
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