<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Dashboard' }} | BPS Kutai Timur</title>

    {{-- Fonts & Icons --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tabler-icons/3.35.0/tabler-icons.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Custom scrollbar untuk sidebar */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>

    {{-- Theme Initializer: Mencegah efek putih sesaat (flicker) --}}
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    {{-- Alpine Stores --}}
    <script>
        document.addEventListener('alpine:init', () => {
            // Theme Store (Hanya Light & Dark)
            Alpine.store('theme', {
                theme: localStorage.getItem('theme') || 'light',

                toggle() {
                    this.theme = this.theme === 'light' ? 'dark' : 'light';
                    localStorage.setItem('theme', this.theme);
                    this.updateTheme();
                },

                updateTheme() {
                    if (this.theme === 'dark') {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                }
            });

            // Sidebar Store
            Alpine.store('sidebar', {
                isExpanded: window.innerWidth >= 1280,
                isMobileOpen: false,
                isHovered: false,

                toggleExpanded() {
                    this.isExpanded = !this.isExpanded;
                },

                toggleMobileOpen() {
                    this.isMobileOpen = !this.isMobileOpen;
                },

                setHovered(val) {
                    if (window.innerWidth >= 1280 && !this.isExpanded) {
                        this.isHovered = val;
                    }
                }
            });
        });
    </script>
</head>

<body
    class="h-full bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 transition-colors duration-300 antialiased"
    x-data @resize.window="if (window.innerWidth < 1280) { $store.sidebar.isExpanded = false; }">

    <div class="min-h-screen flex">

        {{-- Mobile Overlay (Backdrop) --}}
        <div x-show="$store.sidebar.isMobileOpen" x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="$store.sidebar.toggleMobileOpen()"
            class="fixed inset-0 z-[55] bg-gray-900/50 backdrop-blur-sm xl:hidden">
        </div>

        <x-sidebar />

        {{-- Main Area --}}
        <div class="flex-1 flex flex-col min-h-screen transition-all duration-300 ease-in-out"
            :class="{
                'xl:ml-[290px]': $store.sidebar.isExpanded || $store.sidebar.isHovered,
                'xl:ml-[80px]': !$store.sidebar.isExpanded && !$store.sidebar.isHovered,
            }">

            {{-- Header Include --}}
            <x-header />

            {{-- Page Content --}}
            <main class="flex-1 p-4 md:p-8">
                <div class="max-w-screen-2xl mx-auto">
                    @yield('content')
                </div>
            </main>

            {{-- Footer  --}}
            <footer class="p-6 text-center text-xs text-gray-400 font-medium">
                
            </footer>
        </div>
    </div>
    <x-toast />

    @stack('scripts')
</body>

</html>