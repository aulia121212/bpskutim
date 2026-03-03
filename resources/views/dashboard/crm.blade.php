@extends('layouts.app')

@section('title', 'CRM Dashboard')

@section('content')
<div class="space-y-8 pb-12">
    
    {{-- Header CRM --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">CRM Dashboard</h1>
            <p class="text-gray-500 dark:text-gray-400 font-medium text-sm">Kelola relasi pelanggan, pantau deal, dan optimalkan pipeline penjualan.</p>
        </div>
        
        <div class="flex items-center gap-3">
            <x-button variant="secondary" icon="filter">Filter</x-button>
            <x-button variant="primary" icon="plus">Tambah Deal</x-button>
        </div>
    </div>

    {{-- Stats Grid CRM dengan Custom Background --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $crmStats = [
                [
                    'label' => 'Total Pendapatan', 
                    'value' => 'Rp 842M', 
                    'growth' => '+24%', 
                    'icon' => 'ti-report-money', 
                    'bg' => 'from-emerald-500/20 via-emerald-500/5 to-transparent',
                    'color' => 'emerald'
                ],
                [
                    'label' => 'Deal Aktif', 
                    'value' => '156', 
                    'growth' => '+8', 
                    'icon' => 'ti-briefcase', 
                    'bg' => 'from-indigo-500/20 via-indigo-500/5 to-transparent',
                    'color' => 'indigo'
                ],
                [
                    'label' => 'Konversi Lead', 
                    'value' => '12.4%', 
                    'growth' => '+2.1%', 
                    'icon' => 'ti-target-arrow', 
                    'bg' => 'from-rose-500/20 via-rose-500/5 to-transparent',
                    'color' => 'rose'
                ],
                [
                    'label' => 'Kepuasan CSAT', 
                    'value' => '4.9/5', 
                    'growth' => '+0.2', 
                    'icon' => 'ti-stars', 
                    'bg' => 'from-amber-500/20 via-amber-500/5 to-transparent',
                    'color' => 'amber'
                ],
            ];
        @endphp

        @foreach($crmStats as $stat)
        <x-card class="group relative overflow-hidden border-none shadow-none bg-white dark:bg-gray-900 hover:scale-[1.02] transition-all duration-500">
            {{-- Custom Gradient Background Layer --}}
            <div class="absolute inset-0 bg-gradient-to-br {{ $stat['bg'] }} opacity-50 group-hover:opacity-80 transition-opacity"></div>
            
            {{-- Decorative Pattern --}}
            <div class="absolute -right-4 -bottom-4 opacity-[0.05] dark:opacity-[0.1] group-hover:scale-125 transition-transform duration-700">
                <i class="ti {{ $stat['icon'] }} text-8xl"></i>
            </div>

            <div class="relative z-10 flex flex-col gap-4">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-2xl bg-white dark:bg-gray-800 shadow-sm flex items-center justify-center text-{{ $stat['color'] }}-500 transition-transform group-hover:rotate-12">
                        <i class="ti {{ $stat['icon'] }} text-2xl"></i>
                    </div>
                    <span class="text-[10px] font-black px-2 py-1 rounded-lg bg-{{ $stat['color'] }}-500/10 text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400 uppercase tracking-tighter">
                        {{ $stat['growth'] }}
                    </span>
                </div>
                
                <div>
                    <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-1">
                        {{ $stat['label'] }}
                    </p>
                    <h3 class="text-3xl font-black text-gray-900 dark:text-white tracking-tighter">
                        {{ $stat['value'] }}
                    </h3>
                </div>
            </div>
        </x-card>
        @endforeach
    </div>

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Sales Pipeline --}}
        <x-card class="lg:col-span-2" title="Pipeline Penjualan Tahunan">
            <div class="relative h-[350px] mt-4">
                <canvas id="pipelineChart"></canvas>
            </div>
        </x-card>

        {{-- Recent Customers --}}
        <x-card title="Pelanggan Terbaru">
            <div class="space-y-6 mt-4">
                @foreach([
                    ['name' => 'Alex Rivera', 'email' => 'alex@company.com', 'deal' => 'Rp 12.5M', 'status' => 'Closing', 'color' => 'emerald'],
                    ['name' => 'Sarah Johnson', 'email' => 'sarah@startup.io', 'deal' => 'Rp 8.2M', 'status' => 'Negotiation', 'color' => 'indigo'],
                    ['name' => 'Michael Chen', 'email' => 'm.chen@tech.com', 'deal' => 'Rp 45.0M', 'status' => 'Proposal', 'color' => 'amber'],
                    ['name' => 'Jessica Wong', 'email' => 'jess@design.co', 'deal' => 'Rp 3.5M', 'status' => 'Initial Contact', 'color' => 'rose'],
                ] as $customer)
                <div class="flex items-center justify-between group cursor-pointer p-2 -mx-2 rounded-2xl hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all">
                    <div class="flex items-center gap-3">
                        <img src="https://i.pravatar.cc/150?u={{ $customer['email'] }}" class="w-10 h-10 rounded-xl object-cover ring-2 ring-transparent group-hover:ring-indigo-500/20 transition-all">
                        <div>
                            <p class="text-sm font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 transition-colors">{{ $customer['name'] }}</p>
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-tight">{{ $customer['email'] }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-black text-gray-900 dark:text-white">{{ $customer['deal'] }}</p>
                        <p class="text-[9px] font-black text-{{ $customer['color'] }}-500 uppercase tracking-widest">{{ $customer['status'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            <x-slot:footer>
                <x-button variant="secondary" class="w-full text-xs font-bold py-3">Lihat Semua Pelanggan</x-button>
            </x-slot:footer>
        </x-card>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctxPipeline = document.getElementById('pipelineChart').getContext('2d');
        const barGradient = ctxPipeline.createLinearGradient(0, 0, 0, 400);
        barGradient.addColorStop(0, '#4f46e5');
        barGradient.addColorStop(1, '#818cf8');

        new Chart(ctxPipeline, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    data: [45, 52, 48, 70, 65, 85, 80, 95, 110, 105, 130, 125],
                    backgroundColor: barGradient,
                    borderRadius: 12,
                    barThickness: 18
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { grid: { color: 'rgba(156, 163, 175, 0.05)', drawBorder: false }, ticks: { color: '#9ca3af' } },
                    x: { grid: { display: false }, ticks: { color: '#9ca3af' } }
                }
            }
        });
    });
</script>
@endpush