@extends('layouts.app')

@section('title', 'Tables UI Kit')

@section('content')
<div class="space-y-10 pb-20">
    
    <div class="flex flex-col gap-2">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Tables</h1>
        <p class="text-gray-500 dark:text-gray-400 font-medium text-sm">Komponen tabel dengan seleksi checkbox kustom yang modern.</p>
    </div>

    <section class="space-y-4" x-data="{ showCode: false }">
        <div class="flex items-center justify-between">
            <h3 class="text-xs font-bold uppercase text-indigo-600 dark:text-indigo-400">Basic Data Table</h3>
            <button @click="showCode = !showCode" class="text-[10px] font-bold uppercase text-gray-400 hover:text-indigo-600 transition-colors flex items-center gap-1 font-mono">
                <i class="ti" :class="showCode ? 'ti-eye-off' : 'ti-code'"></i>
                <span x-text="showCode ? 'Hide Code' : 'Show Code'"></span>
            </button>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-200 dark:border-gray-800 overflow-hidden transition-all ">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800 font-mono">
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Customer</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Status</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800 font-mono">
                        @foreach([
                            ['name' => 'Alex Rivera', 'email' => 'alex@example.com', 'status' => 'Paid', 'color' => 'emerald'],
                            ['name' => 'Sarah Chen', 'email' => 'sarah@example.com', 'status' => 'Pending', 'color' => 'amber'],
                            ['name' => 'Mike Ross', 'email' => 'mike@example.com', 'status' => 'Failed', 'color' => 'rose']
                        ] as $row)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 font-bold text-[10px]">
                                        {{ substr($row['name'], 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold dark:text-white">{{ $row['name'] }}</p>
                                        <p class="text-xs text-gray-500">{{ $row['email'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-[10px] font-bold rounded-full bg-{{ $row['color'] }}-50 dark:bg-{{ $row['color'] }}-500/10 text-{{ $row['color'] }}-600 uppercase">
                                    {{ $row['status'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button class="p-2 hover:bg-white dark:hover:bg-gray-700 rounded-xl transition-all border border-transparent hover:border-gray-200 dark:hover:border-gray-600 text-gray-400">
                                    <i class="ti ti-edit"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div x-show="showCode" x-collapse x-cloak>
                <div class="bg-gray-50 dark:bg-gray-950 border-t border-gray-100 dark:border-gray-800 p-6 font-mono">
                    <pre class="text-[11px] text-gray-600 dark:text-gray-400 overflow-x-auto leading-relaxed"><code>&lt;!-- Basic Table --&gt;
&lt;table class="w-full text-left"&gt;
    &lt;thead class="bg-gray-50 dark:bg-gray-800/50"&gt;...&lt;/thead&gt;
    &lt;tbody class="divide-y divide-gray-100"&gt;...&lt;/tbody&gt;
&lt;/table&gt;</code></pre>
                </div>
            </div>
        </div>
    </section>

    <section class="space-y-4" x-data="{ selected: [], showCode: false }">
        <div class="flex items-center justify-between">
            <h3 class="text-xs font-bold uppercase text-indigo-600 dark:text-indigo-400">Checkbox Selection</h3>
            <div class="flex items-center gap-3">
                <span x-show="selected.length" class="text-xs font-bold text-indigo-600 animate-pulse" x-text="selected.length + ' Item selected'"></span>
                <button @click="showCode = !showCode" class="text-[10px] font-bold uppercase text-gray-400 hover:text-indigo-600 transition-colors flex items-center gap-1 font-mono">
                    <i class="ti" :class="showCode ? 'ti-eye-off' : 'ti-code'"></i>
                    <span x-text="showCode ? 'Hide Code' : 'Show Code'"></span>
                </button>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-200 dark:border-gray-800 overflow-hidden transition-all ">
            <table class="w-full text-left border-collapse font-mono">
                <thead class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800">
                    <tr>
                        <th class="px-6 py-4 w-12 text-center">
                            <label class="relative flex items-center justify-center cursor-pointer">
                                <input type="checkbox" @change="selected = $event.target.checked ? [1,2,3] : []" class="peer sr-only">
                                <div class="w-5 h-5 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-lg peer-checked:bg-indigo-600 peer-checked:border-indigo-600 transition-all duration-200"></div>
                                <i class="ti ti-check absolute text-white text-xs scale-0 peer-checked:scale-100 transition-transform duration-200"></i>
                            </label>
                        </th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Inventory</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Stock</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach(['Macbook Pro M3', 'iPad Pro 12.9', 'iPhone 15 Pro Max'] as $index => $item)
                    <tr class="transition-colors" :class="selected.includes({{ $index+1 }}) ? 'bg-indigo-50/50 dark:bg-indigo-900/10' : 'hover:bg-gray-50 dark:hover:bg-gray-800/40'">
                        <td class="px-6 py-4 text-center">
                            <label class="relative flex items-center justify-center cursor-pointer">
                                <input type="checkbox" value="{{ $index+1 }}" x-model="selected" class="peer sr-only">
                                <div class="w-5 h-5 bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-lg peer-checked:bg-indigo-600 peer-checked:border-indigo-600 transition-all duration-200"></div>
                                <i class="ti ti-check absolute text-white text-xs scale-0 peer-checked:scale-100 transition-transform duration-200"></i>
                            </label>
                        </td>
                        <td class="px-6 py-4 text-sm font-bold dark:text-white">{{ $item }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500 font-medium">124 Units</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div x-show="showCode" x-collapse x-cloak>
                <div class="bg-gray-50 dark:bg-gray-950 border-t border-gray-100 dark:border-gray-800 p-6 font-mono">
                    <pre class="text-[11px] text-gray-600 dark:text-gray-400 overflow-x-auto leading-relaxed"><code>&lt;!-- Beautiful Custom Checkbox UI --&gt;
&lt;label class="relative flex items-center cursor-pointer"&gt;
    &lt;input type="checkbox" class="peer sr-only"&gt;
    &lt;div class="w-5 h-5 border-2 rounded-lg peer-checked:bg-indigo-600 peer-checked:border-indigo-600 transition-all"&gt;&lt;/div&gt;
    &lt;i class="ti ti-check absolute text-white text-xs scale-0 peer-checked:scale-100"&gt;&lt;/i&gt;
&lt;/label&gt;</code></pre>
                </div>
            </div>
        </div>
    </section>

    <section class="space-y-4">
        <h3 class="text-xs font-bold uppercase text-indigo-600 dark:text-indigo-400">Advanced Table</h3>
        <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-200 dark:border-gray-800 overflow-hidden ">
            <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex flex-col sm:flex-row justify-between gap-4 font-mono">
                <div class="relative w-full sm:max-w-xs">
                    <i class="ti ti-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-2xl pl-11 pr-4 py-2.5 text-xs font-bold outline-none focus:ring-2 focus:ring-indigo-500 dark:text-white" placeholder="Cari transaksi...">
                </div>
                <div class="flex items-center gap-2">
                    <button class="px-4 py-2.5 bg-gray-50 dark:bg-gray-800 text-gray-500 dark:text-gray-300 text-xs font-bold rounded-xl flex items-center gap-2 hover:bg-gray-100 transition-all">
                        <i class="ti ti-filter"></i> Filter
                    </button>
                    <button class="px-4 py-2.5 bg-indigo-600 text-white text-xs font-bold rounded-xl  active:scale-95 transition-all">
                        Export CSV
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse font-mono">
                    <thead class="bg-gray-50/50 dark:bg-gray-800/30">
                        <tr>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Order ID</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Amount</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Date</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-sm">
                        @foreach([1, 2, 3] as $order)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                            <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">#TRX-99{{ $order }}</td>
                            <td class="px-6 py-4 font-medium text-gray-600 dark:text-gray-400">Rp 12.500.000</td>
                            <td class="px-6 py-4 text-gray-500">12 Jan 2024</td>
                            <td class="px-6 py-4 text-right">
                                <span class="px-3 py-1 text-[10px] font-bold rounded-full bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 uppercase">Processing</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-6 border-t border-gray-100 dark:border-gray-800 flex items-center justify-between font-mono">
                <p class="text-[10px] font-bold text-gray-400 uppercase">Showing 1-10 of 240</p>
                <div class="flex items-center gap-1">
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-400 hover:text-indigo-600 transition-colors"><i class="ti ti-chevron-left"></i></button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-indigo-600 text-white text-xs font-bold ">1</button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-500 text-xs font-bold hover:bg-gray-100">2</button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-400 hover:text-indigo-600 transition-colors"><i class="ti ti-chevron-right"></i></button>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection