@extends('layouts.app')

@section('title', 'DataTables UI Kit')

@section('content')
<div class="space-y-10 pb-20" 
     x-data="dataTableComponent()" 
     x-init="initData()">
    
    <div class="flex flex-col gap-2">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">DataTables</h1>
        <p class="text-gray-500 dark:text-gray-400 font-medium text-sm">Tabel dinamis dengan fitur pencarian, filter, dan pagination menggunakan Alpine.js.</p>
    </div>

    <section class="space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="text-xs font-bold uppercase text-indigo-600 dark:text-indigo-400">Interactive Data Management</h3>
            <button @click="showCode = !showCode" class="text-[10px] font-bold uppercase text-gray-400 hover:text-indigo-600 transition-colors flex items-center gap-1 font-mono">
                <i class="ti" :class="showCode ? 'ti-eye-off' : 'ti-code'"></i>
                <span x-text="showCode ? 'Hide Code' : 'Show Code'"></span>
            </button>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-3xl border border-gray-200 dark:border-gray-800 overflow-hidden shadow-sm transition-all">
            
            <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex flex-col md:flex-row justify-between gap-4 items-center">
                <div class="flex items-center gap-4 w-full md:w-auto">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-gray-400 uppercase">Show</span>
                        <select x-model="view" class="bg-gray-50 dark:bg-gray-800 border-none rounded-xl px-3 py-2 text-xs font-bold outline-none focus:ring-2 focus:ring-indigo-500 dark:text-white appearance-none cursor-pointer transition-all">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                        </select>
                    </div>

                    <button @click="refreshData()" 
                            class="p-2.5 bg-gray-50 dark:bg-gray-800 text-gray-500 dark:text-gray-300 rounded-xl hover:bg-indigo-50 dark:hover:bg-indigo-900/30 hover:text-indigo-600 transition-all active:scale-90 flex items-center gap-2 group"
                            :disabled="isLoading">
                        <i class="ti ti-refresh text-lg transition-transform duration-500" :class="isLoading ? 'animate-spin text-indigo-600' : 'group-hover:rotate-180'"></i>
                        <span class="text-xs font-bold uppercase hidden sm:inline">Refresh</span>
                    </button>
                </div>

                <div class="relative w-full md:w-80">
                    <i class="ti ti-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" x-model="search" 
                        class="w-full bg-gray-50 dark:bg-gray-800 border-none rounded-2xl pl-11 pr-4 py-2.5 text-xs font-bold outline-none focus:ring-2 focus:ring-indigo-500 dark:text-white transition-all" 
                        placeholder="Search anything...">
                </div>
            </div>

            <div class="overflow-x-auto font-mono text-xs relative min-h-[300px]">
                <div x-show="isLoading" class="absolute inset-0 bg-white/50 dark:bg-gray-900/50 backdrop-blur-[2px] z-10 flex items-center justify-center transition-all" x-cloak>
                    <div class="flex flex-col items-center gap-2">
                        <i class="ti ti-loader-2 animate-spin text-4xl text-indigo-600"></i>
                        <span class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest">Loading Data...</span>
                    </div>
                </div>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800">
                            <th class="px-6 py-4">
                                <label class="relative flex items-center cursor-pointer">
                                    <input type="checkbox" @change="toggleSelectAll" :checked="selected.length === filteredData.length && filteredData.length > 0" class="peer sr-only">
                                    <div class="w-5 h-5 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-lg peer-checked:bg-indigo-600 peer-checked:border-indigo-600 transition-all flex items-center justify-center">
                                        <i class="ti ti-check text-white text-[10px] scale-0 peer-checked:scale-100 transition-transform"></i>
                                    </div>
                                </label>
                            </th>
                            <th class="px-6 py-4 font-bold text-gray-400 uppercase cursor-pointer hover:text-indigo-600 transition-colors" @click="sort('name')">
                                <div class="flex items-center gap-2">
                                    Member <i class="ti ti-arrows-sort opacity-50"></i>
                                </div>
                            </th>
                            <th class="px-6 py-4 font-bold text-gray-400 uppercase">Project</th>
                            <th class="px-6 py-4 font-bold text-gray-400 uppercase">Budget</th>
                            <th class="px-6 py-4 font-bold text-gray-400 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        <template x-for="item in filteredData" :key="item.id">
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors group" :class="selected.includes(item.id) ? 'bg-indigo-50/30 dark:bg-indigo-900/10' : ''">
                                <td class="px-6 py-4">
                                    <label class="relative flex items-center cursor-pointer">
                                        <input type="checkbox" :value="item.id" x-model="selected" class="peer sr-only">
                                        <div class="w-5 h-5 bg-white dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-lg peer-checked:bg-indigo-600 peer-checked:border-indigo-600 transition-all flex items-center justify-center">
                                            <i class="ti ti-check text-white text-[10px] scale-0 peer-checked:scale-100 transition-transform"></i>
                                        </div>
                                    </label>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 font-bold" x-text="item.name.substring(0,2)"></div>
                                        <div>
                                            <p class="font-bold dark:text-white" x-text="item.name"></p>
                                            <p class="text-[10px] text-gray-500 lowercase" x-text="item.email"></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-bold text-gray-600 dark:text-gray-400" x-text="item.project"></td>
                                <td class="px-6 py-4 font-bold text-indigo-600" x-text="'$'+item.budget"></td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-[9px] font-bold uppercase" 
                                        :class="item.status === 'Completed' ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600' : 'bg-amber-50 dark:bg-amber-500/10 text-amber-600'" 
                                        x-text="item.status"></span>
                                </td>
                            </tr>
                        </template>
                        <template x-if="filteredData.length === 0 && !isLoading">
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-400 font-medium">
                                    Tidak ada data yang ditemukan untuk "<span x-text="search" class="font-bold"></span>"
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <div class="p-6 border-t border-gray-100 dark:border-gray-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-[10px] font-bold text-gray-400 uppercase">Showing <span x-text="filteredData.length"></span> of <span x-text="items.length"></span> entries</p>
                
                <div class="flex items-center gap-1">
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-400 hover:text-indigo-600 transition-all"><i class="ti ti-chevron-left"></i></button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-indigo-600 text-white text-[10px] font-bold shadow-md shadow-indigo-500/20">1</button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-400 hover:text-indigo-600 transition-all"><i class="ti ti-chevron-right"></i></button>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function dataTableComponent() {
        return {
            showCode: false,
            search: '',
            view: 5,
            selected: [],
            sortColumn: '',
            sortDirection: 'asc',
            items: [],
            isLoading: false,
            
            initData() {
                this.loadItems();
            },

            loadItems() {
                this.items = [
                    { id: 1, name: 'Aulia Azizah', email: 'aulia.azizah@bpskutim.go.id', project: 'Admin Dashboard', budget: '2,500', status: 'Completed' },
                    { id: 2, name: 'Sarah Miller', email: 'sarah@design.com', project: 'Mobile App', budget: '4,200', status: 'Pending' },
                    { id: 3, name: 'Mike Johnson', email: 'mike@tech.com', project: 'E-Commerce', budget: '1,800', status: 'Completed' },
                    { id: 4, name: 'Alena Void', email: 'alena@void.com', project: 'API Integration', budget: '3,000', status: 'Pending' },
                    { id: 5, name: 'Chris Evans', email: 'chris@marvel.com', project: 'Cloud Infrastructure', budget: '8,500', status: 'Completed' },
                    { id: 6, name: 'Tony Stark', email: 'tony@stark.com', project: 'AI Module', budget: '12,000', status: 'Completed' },
                ];
            },

            refreshData() {
                this.isLoading = true;
                this.selected = [];
                // Simulasi delay network 1 detik
                setTimeout(() => {
                    this.loadItems();
                    this.isLoading = false;
                    // Bisa panggil toast global di sini
                    window.dispatchEvent(new CustomEvent('toast', { 
                        detail: { type: 'success', message: 'Data refreshed successfully!' } 
                    }));
                }, 1000);
            },

            get filteredData() {
                let data = this.items.filter(item => {
                    return item.name.toLowerCase().includes(this.search.toLowerCase()) ||
                           item.project.toLowerCase().includes(this.search.toLowerCase()) ||
                           item.email.toLowerCase().includes(this.search.toLowerCase());
                });

                if (this.sortColumn) {
                    data.sort((a, b) => {
                        let aVal = a[this.sortColumn].toString().toLowerCase();
                        let bVal = b[this.sortColumn].toString().toLowerCase();
                        let res = aVal > bVal ? 1 : -1;
                        return this.sortDirection === 'asc' ? res : -res;
                    });
                }

                return data.slice(0, this.view);
            },

            sort(column) {
                if (this.sortColumn === column) {
                    this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
                } else {
                    this.sortColumn = column;
                    this.sortDirection = 'asc';
                }
            },

            toggleSelectAll(e) {
                if (e.target.checked) {
                    this.selected = this.filteredData.map(i => i.id);
                } else {
                    this.selected = [];
                }
            }
        }
    }
</script>

@endsection