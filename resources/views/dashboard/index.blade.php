@extends('layouts.app')

@section('title', 'Dashboard Super Admin')

@section('content')

{{-- HEADER --}}
<div class="mb-6">
    <h1 class="text-xl font-bold text-gray-800 dark:text-white">Dashboard Super Admin</h1>
    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
        Selamat datang, {{ auth()->user()->name }}. Berikut ringkasan seluruh sistem.
    </p>
</div>

{{-- ── STAT CARDS ROW 1: USER & ADMIN ─────────────────────────────── --}}
<div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-6 gap-4 mb-4">

    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-5 col-span-1">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Admin</span>
            <div class="w-8 h-8 rounded-xl bg-purple-50 flex items-center justify-center">
                <i class="ti ti-shield-check text-purple-500 text-base"></i>
            </div>
        </div>
        <div class="text-3xl font-bold text-gray-800 dark:text-white">{{ $totalAdmin }}</div>
        <p class="text-xs text-gray-400 mt-1">Total admin sistem</p>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Petugas</span>
            <div class="w-8 h-8 rounded-xl bg-blue-50 flex items-center justify-center">
                <i class="ti ti-headset text-[#035f9c] text-base"></i>
            </div>
        </div>
        <div class="text-3xl font-bold text-gray-800 dark:text-white">{{ $totalPetugas }}</div>
        <p class="text-xs text-gray-400 mt-1">Petugas konsultasi</p>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Pengguna</span>
            <div class="w-8 h-8 rounded-xl bg-teal-50 flex items-center justify-center">
                <i class="ti ti-users text-teal-500 text-base"></i>
            </div>
        </div>
        <div class="text-3xl font-bold text-gray-800 dark:text-white">{{ $totalUser }}</div>
        <p class="text-xs text-gray-400 mt-1">Pengguna terdaftar</p>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Reservasi</span>
            <div class="w-8 h-8 rounded-xl bg-amber-50 flex items-center justify-center">
                <i class="ti ti-clipboard-list text-amber-500 text-base"></i>
            </div>
        </div>
        <div class="text-3xl font-bold text-gray-800 dark:text-white">{{ $totalReservasi }}</div>
        <p class="text-xs text-gray-400 mt-1">Total reservasi</p>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Data Statistik</span>
            <div class="w-8 h-8 rounded-xl bg-green-50 flex items-center justify-center">
                <i class="ti ti-chart-bar text-green-500 text-base"></i>
            </div>
        </div>
        <div class="text-3xl font-bold text-gray-800 dark:text-white">{{ $totalStatistik }}</div>
        <p class="text-xs text-gray-400 mt-1">Entri data statistik</p>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Perlu Ditangani</span>
            <div class="w-8 h-8 rounded-xl bg-red-50 flex items-center justify-center">
                <i class="ti ti-alert-circle text-red-500 text-base"></i>
            </div>
        </div>
        <div class="text-3xl font-bold text-red-500">{{ $menunggu }}</div>
        <p class="text-xs text-red-400 mt-1 font-medium">Reservasi menunggu</p>
    </div>

</div>

{{-- ── GRAFIK ROW ───────────────────────────────────────────────────── --}}
<div class="grid grid-cols-1 xl:grid-cols-2 gap-4 mb-4">

    {{-- Grafik Reservasi --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-5">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-sm font-bold text-gray-700 dark:text-white">Tren Reservasi</h2>
                <p class="text-xs text-gray-400 mt-0.5">12 bulan terakhir</p>
            </div>
            <a href="{{ route('pelayanan.reservasi.index') }}"
               class="text-xs text-[#035f9c] hover:underline font-semibold">Lihat semua →</a>
        </div>
        <canvas id="grafikReservasi" height="140"></canvas>
    </div>

    {{-- Grafik Statistik --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-5">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-sm font-bold text-gray-700 dark:text-white">Tren Data Statistik</h2>
                <p class="text-xs text-gray-400 mt-0.5">12 bulan terakhir</p>
            </div>
            <a href="{{ route('statistics.index') }}"
               class="text-xs text-teal-600 hover:underline font-semibold">Lihat semua →</a>
        </div>
        <canvas id="grafikStatistik" height="140"></canvas>
    </div>

</div>

{{-- ── TABEL + STATUS ───────────────────────────────────────────────── --}}
<div class="grid grid-cols-1 xl:grid-cols-3 gap-4">

    {{-- Reservasi Terbaru --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-5 xl:col-span-2">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-bold text-gray-700 dark:text-white">Reservasi Terbaru</h2>
            <a href="{{ route('pelayanan.reservasi.index') }}"
               class="text-xs text-[#035f9c] hover:underline font-semibold">Lihat semua →</a>
        </div>

        <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-800">
                    <th class="text-left pb-2 text-xs font-semibold text-gray-400">Nama</th>
                    <th class="text-left pb-2 text-xs font-semibold text-gray-400">Petugas</th>
                    <th class="text-left pb-2 text-xs font-semibold text-gray-400">Tanggal</th>
                    <th class="text-left pb-2 text-xs font-semibold text-gray-400">Status</th>
                    <th class="pb-2"></th>
                </tr>
            </thead>
            <tbody>
            @forelse($reservasiTerbaru as $r)
            @php
                $st = $r->riwayatTerbaru?->status_pengajuan ?? 'diajukan';
                $stClass = match($st) {
                    'diajukan'    => 'bg-amber-100 text-amber-700',
                    'dijadwalkan' => 'bg-blue-100 text-blue-700',
                    'selesai'     => 'bg-green-100 text-green-700',
                    'dibatalkan'  => 'bg-red-100 text-red-600',
                    default       => 'bg-gray-100 text-gray-500',
                };
                $stLabel = match($st) {
                    'diajukan'    => 'Menunggu',
                    'dijadwalkan' => 'Dijadwalkan',
                    'selesai'     => 'Selesai',
                    'dibatalkan'  => 'Dibatalkan',
                    default       => ucfirst($st),
                };
            @endphp
            <tr class="border-b border-gray-50 dark:border-gray-800 last:border-0 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                <td class="py-3 font-semibold text-gray-800 dark:text-white max-w-[140px] truncate">
                    {{ $r->user->name ?? '-' }}
                </td>
                <td class="py-3 text-gray-500 dark:text-gray-400 text-xs">
                    {{ $r->petugas->nama_lengkap ?? '-' }}
                </td>
                <td class="py-3 text-gray-500 dark:text-gray-400 text-xs whitespace-nowrap">
                    {{ $r->tanggal_konsultasi ? \Carbon\Carbon::parse($r->tanggal_konsultasi)->format('d M Y') : '-' }}
                </td>
                <td class="py-3">
                    <span class="text-[11px] font-semibold px-2.5 py-1 rounded-full {{ $stClass }}">
                        {{ $stLabel }}
                    </span>
                </td>
                <td class="py-3 text-right">
                    <a href="{{ route('pelayanan.reservasi.show', $r->id_reservasi) }}"
                       class="text-xs text-[#035f9c] hover:underline">Detail</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="py-8 text-center text-gray-400 text-sm">
                    <i class="ti ti-clipboard-off text-3xl block mb-2 text-gray-300"></i>
                    Belum ada reservasi
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
        </div>
    </div>

    {{-- Distribusi Status + Data Terbaru --}}
    <div class="flex flex-col gap-4">

        {{-- Distribusi Status Reservasi --}}
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-5">
            <h2 class="text-sm font-bold text-gray-700 dark:text-white mb-4">Status Reservasi</h2>

            @php
                $totalDist = array_sum($distribusiStatus) ?: 1;
                $distConfig = [
                    'diajukan'    => ['label' => 'Menunggu',    'color' => 'bg-amber-400',  'text' => 'text-amber-600'],
                    'dijadwalkan' => ['label' => 'Dijadwalkan', 'color' => 'bg-blue-400',   'text' => 'text-blue-600'],
                    'selesai'     => ['label' => 'Selesai',     'color' => 'bg-green-400',  'text' => 'text-green-600'],
                    'dibatalkan'  => ['label' => 'Dibatalkan',  'color' => 'bg-red-400',    'text' => 'text-red-500'],
                ];
            @endphp

            @foreach($distConfig as $key => $cfg)
            @php $pct = round(($distribusiStatus[$key] / $totalDist) * 100); @endphp
            <div class="mb-3 last:mb-0">
                <div class="flex justify-between items-center mb-1">
                    <span class="text-xs font-semibold text-gray-600 dark:text-gray-400">{{ $cfg['label'] }}</span>
                    <span class="text-xs font-bold {{ $cfg['text'] }}">{{ $distribusiStatus[$key] }}</span>
                </div>
                <div class="h-1.5 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
                    <div class="h-full rounded-full {{ $cfg['color'] }}" style="width:{{ $pct }}%"></div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Data Statistik Terbaru --}}
        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 p-5 flex-1">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-bold text-gray-700 dark:text-white">Data Statistik Terbaru</h2>
                <a href="{{ route('statistics.index') }}"
                   class="text-xs text-teal-600 hover:underline font-semibold">Lihat →</a>
            </div>

            @forelse($dataTerbaru as $data)
            <div class="flex items-start gap-2 py-2.5 border-b border-gray-50 dark:border-gray-800 last:border-0">
                <div class="w-2 h-2 rounded-full bg-teal-400 flex-shrink-0 mt-1.5"></div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-gray-800 dark:text-white truncate">
                        {{ $data->judul ?? $data->title ?? '-' }}
                    </p>
                    <p class="text-[11px] text-gray-400 mt-0.5">
                        {{ \Carbon\Carbon::parse($data->updated_at)->diffForHumans() }}
                        · <span class="{{ $data->is_published ? 'text-green-500' : 'text-amber-500' }} font-semibold">
                            {{ $data->is_published ? 'Publik' : 'Draft' }}
                          </span>
                    </p>
                </div>
            </div>
            @empty
            <p class="text-xs text-gray-400 text-center py-4">Belum ada data</p>
            @endforelse
        </div>

    </div>

</div>

{{-- CHARTS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const isDark = document.documentElement.classList.contains('dark');
const gridColor = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.05)';
const textColor = isDark ? '#94a3b8' : '#9ca3af';

const reservasiLabels = @json($grafikReservasi->pluck('label'));
const reservasiData   = @json($grafikReservasi->pluck('count'));
const statistikLabels = @json($grafikStatistik->pluck('label'));
const statistikData   = @json($grafikStatistik->pluck('count'));

const defaultOptions = (color) => ({
    responsive: true,
    plugins: { legend: { display: false } },
    scales: {
        x: {
            ticks: { color: textColor, font: { size: 10 } },
            grid: { color: gridColor },
        },
        y: {
            beginAtZero: true,
            ticks: { color: textColor, font: { size: 10 }, precision: 0 },
            grid: { color: gridColor },
        }
    }
});

new Chart(document.getElementById('grafikReservasi'), {
    type: 'bar',
    data: {
        labels: reservasiLabels,
        datasets: [{
            label: 'Reservasi',
            data: reservasiData,
            backgroundColor: 'rgba(59,130,246,0.7)',
            borderRadius: 6,
            borderSkipped: false,
        }]
    },
    options: defaultOptions('blue'),
});

new Chart(document.getElementById('grafikStatistik'), {
    type: 'line',
    data: {
        labels: statistikLabels,
        datasets: [{
            label: 'Data Statistik',
            data: statistikData,
            borderColor: '#14b8a6',
            backgroundColor: 'rgba(20,184,166,0.1)',
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#14b8a6',
            pointRadius: 4,
        }]
    },
    options: defaultOptions('teal'),
});
</script>

@endsection