@extends('layouts.app')

@section('title', 'Buttons UI Kit')

@section('content')
    <div class="space-y-16 pb-24">

        <header class="space-y-2">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">
                Buttons
            </h1>
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400 max-w-2xl">
                UI Kit tombol modern berbasis Laravel Blade Components.
                Mendukung variant, size, icon, posisi icon, disabled, loading spinner, dan mode link.
            </p>
        </header>

        <section class="space-y-4" x-data="{ showCode: false }">
            <div class="flex justify-between items-center">
                <h3 class="ui-title">Button Variants</h3>
                <x-code-toggle />
            </div>

            <x-card>
                <div class="p-8 flex flex-wrap gap-4">
                    <x-button>Primary</x-button>
                    <x-button variant="secondary">Secondary</x-button>
                    <x-button variant="success">Success</x-button>
                    <x-button variant="danger">Danger</x-button>
                    <x-button variant="ghost">Ghost</x-button>
                </div>

                <x-code>
                    &lt;x-button&gt;Primary&lt;/x-button&gt;
                    &lt;x-button variant="secondary"&gt;Secondary&lt;/x-button&gt;
                    &lt;x-button variant="success"&gt;Success&lt;/x-button&gt;
                    &lt;x-button variant="danger"&gt;Danger&lt;/x-button&gt;
                    &lt;x-button variant="ghost"&gt;Ghost&lt;/x-button&gt;
                </x-code>
            </x-card>
        </section>

        {{-- ================================================= --}}
        {{-- Icons --}}
        {{-- ================================================= --}}
        <section class="space-y-4" x-data="{ showCode: false }">
            <div class="flex justify-between items-center">
                <h3 class="ui-title">With Icons</h3>
                <x-code-toggle />
            </div>

            <x-card>
                <div class="p-8 flex gap-4 flex-wrap">
                    <x-button icon="plus">Tambah</x-button>
                    <x-button icon="device-floppy" variant="success">Simpan</x-button>
                    <x-button icon="bell" variant="secondary" class="p-3" />
                </div>

                <x-code>
                    &lt;x-button icon="plus"&gt;Tambah&lt;/x-button&gt;
                    &lt;x-button icon="device-floppy" variant="success"&gt;Simpan&lt;/x-button&gt;
                    &lt;x-button icon="bell" variant="secondary" class="p-3" /&gt;
                </x-code>
            </x-card>
        </section>

        {{-- ================================================= --}}
        {{-- Icon Positions --}}
        {{-- ================================================= --}}
        <section class="space-y-4" x-data="{ showCode: false }">
            <div class="flex justify-between items-center">
                <h3 class="ui-title">Icon Positions</h3>
                <x-code-toggle />
            </div>

            <x-card>
                <div class="p-8 flex flex-wrap gap-6 items-center">
                    <x-button icon="arrow-left">Left</x-button>
                    <x-button icon="arrow-right" iconPosition="right">Right</x-button>
                    <x-button icon="upload" iconPosition="top">Upload</x-button>
                    <x-button icon="chevron-down" iconPosition="bottom">More</x-button>
                </div>

                <x-code>
                  <div class="p-8 flex flex-wrap gap-6 items-center">
                    <x-button icon="arrow-left">Left</x-button>
                    <x-button icon="arrow-right" iconPosition="right">Right</x-button>
                    <x-button icon="upload" iconPosition="top">Upload</x-button>
                    <x-button icon="chevron-down" iconPosition="bottom">More</x-button>
                </div>
                </x-code>
            </x-card>
        </section>

        {{-- ================================================= --}}
        {{-- Sizes --}}
        {{-- ================================================= --}}
        <section class="space-y-4">
            <h3 class="ui-title">Button Sizes</h3>

            <x-card>
                <div class="p-8 flex items-center gap-4">
                    <x-button size="sm">Small</x-button>
                    <x-button size="md">Medium</x-button>
                    <x-button size="lg">Large</x-button>
                </div>
            </x-card>
        </section>

        {{-- ================================================= --}}
        {{-- Disabled --}}
        {{-- ================================================= --}}
        <section class="space-y-4">
            <h3 class="ui-title">Disabled State</h3>

            <x-card>
                <div class="p-8 flex gap-4 flex-wrap">
                    <x-button disabled>Disabled</x-button>
                    <x-button variant="secondary" disabled>Disabled</x-button>
                    <x-button icon="lock" disabled>Locked</x-button>
                </div>
            </x-card>
        </section>

        {{-- ================================================= --}}
        {{-- Loading / Spinner --}}
        {{-- ================================================= --}}
        <section class="space-y-4" x-data="{ showCode: false }">
            <div class="flex justify-between items-center">
                <h3 class="ui-title">Loading / Spinner</h3>
                <x-code-toggle />
            </div>

            <x-card>
                <div class="p-8 flex gap-4 flex-wrap items-center">
                    <x-button loading>
                        Loading
                    </x-button>

                    <x-button loading icon="device-floppy">
                        Saving
                    </x-button>

                    <x-button loading variant="secondary" class="p-3" />

                    <x-button loading size="sm">
                        Small
                    </x-button>

                    <x-button loading size="lg">
                        Large
                    </x-button>

                    <x-button loading disabled>
                        Disabled Loading
                    </x-button>

                    <x-button loading href="#">
                        Redirecting
                    </x-button>
                </div>

                <x-code>
      <x-button loading>
                        Loading
                    </x-button>

                    <x-button loading icon="device-floppy">
                        Saving
                    </x-button>

                    <x-button loading variant="secondary" class="p-3" />

                    <x-button loading size="sm">
                        Small
                    </x-button>

                    <x-button loading size="lg">
                        Large
                    </x-button>

                    <x-button loading disabled>
                        Disabled Loading
                    </x-button>

                    <x-button loading href="#">
                        Redirecting
                    </x-button>
                </x-code>
            </x-card>
        </section>


        {{-- ================================================= --}}
        {{-- Full Width --}}
        {{-- ================================================= --}}
        <section class="space-y-4">
            <h3 class="ui-title">Full Width</h3>

            <x-card>
                <div class="p-8 space-y-3 max-w-sm">
                    <x-button class="w-full">Submit</x-button>
                    <x-button class="w-full" variant="secondary">Cancel</x-button>
                </div>
            </x-card>
        </section>

        {{-- ================================================= --}}
        {{-- Button as Link --}}
        {{-- ================================================= --}}
        <section class="space-y-4">
            <h3 class="ui-title">Button as Link</h3>

            <x-card>
                <div class="p-8 flex gap-4 flex-wrap">
                    <x-button href="https://example.com" target="_blank">
                        External Link
                    </x-button>

                    <x-button href="/dashboard" variant="secondary" icon="arrow-right">
                        Dashboard
                    </x-button>
                </div>
            </x-card>
        </section>

    </div>
@endsection