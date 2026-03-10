@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Jadwal Tidak Tersedia</h1>

    <div class="flex gap-6">

        {{-- Left: List Keterangan --}}
        <div class="w-80 space-y-3">
            <h3 class="text-sm font-bold text-gray-700 mb-3">Keterangan</h3>

            @forelse($jadwal ?? [] as $j)
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 p-4 shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-800">{{ $j->keterangan }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $j->petugas ?? 'Semua Petugas' }}</p>
                        <div class="flex items-center gap-1 mt-2 text-xs text-gray-500">
                            <i class="ti ti-calendar text-blue-500"></i>
                            {{ \Carbon\Carbon::parse($j->tanggal)->translatedFormat('l, j F Y') }}
                        </div>
                    </div>
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full
                        {{ $j->tipe === 'Libur Nasional' ? 'bg-red-100 text-red-600' :
                           ($j->tipe === 'Cuti Bersama' ? 'bg-orange-100 text-orange-600' : 'bg-blue-100 text-blue-600') }}">
                        {{ $j->tipe }}
                    </span>
                </div>
            </div>
            @empty
            {{-- Dummy data tampilan --}}
            @foreach([
                ['Tahun Baru 2026', 'Semua Petugas', 'Jumat, 1 Januari 2026', 'Cuti Bersama', 'orange'],
                ['Cuti Pribadi', 'Nama Petugas', 'Selasa, 5 Januari 2026', 'Cuti Pribadi', 'blue'],
                ['Cuti Pribadi', 'Nama Petugas', 'Rabu, 6 Januari 2026', 'Cuti Pribadi', 'blue'],
                ['Cuti Pribadi', 'Nama Petugas', 'Kamis, 7 Januari 2026', 'Cuti Pribadi', 'blue'],
                ['Isra Mikraj Nabi Muhammad SAW', 'Semua Petugas', 'Kamis, 28 Januari 2026', 'Libur Nasional', 'red'],
            ] as $item)
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-100 p-4 shadow-sm">
                <div class="flex items-start justify-between gap-2">
                    <div>
                        <p class="text-sm font-semibold text-gray-800">{{ $item[0] }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $item[1] }}</p>
                        <div class="flex items-center gap-1 mt-2 text-xs text-gray-500">
                            <i class="ti ti-calendar text-blue-500"></i> {{ $item[2] }}
                        </div>
                    </div>
                    <span class="shrink-0 text-xs font-semibold px-2 py-0.5 rounded-full
                        {{ $item[3] === 'Libur Nasional' ? 'bg-red-100 text-red-600' :
                           ($item[3] === 'Cuti Bersama' ? 'bg-orange-100 text-orange-600' : 'bg-blue-100 text-blue-600') }}">
                        {{ $item[3] }}
                    </span>
                </div>
            </div>
            @endforeach
            @endforelse
        </div>

        {{-- Right: Calendar --}}
        <div class="flex-1 bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm p-6">

            {{-- Calendar Header --}}
            <div class="flex items-center justify-between mb-6">
                <button id="prev-month" class="p-1.5 rounded-lg hover:bg-gray-100 transition text-gray-500">
                    <i class="ti ti-chevron-left text-lg"></i>
                </button>
                <h2 id="calendar-title" class="text-sm font-bold text-gray-700"></h2>
                <button id="next-month" class="p-1.5 rounded-lg hover:bg-gray-100 transition text-gray-500">
                    <i class="ti ti-chevron-right text-lg"></i>
                </button>
            </div>

            {{-- Day Labels --}}
            <div class="grid grid-cols-7 mb-2">
                @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $day)
                <div class="text-center text-xs font-semibold text-gray-400 py-2">{{ $day }}</div>
                @endforeach
            </div>

            {{-- Calendar Grid --}}
            <div id="calendar-grid" class="grid grid-cols-7 gap-1"></div>

        </div>
    </div>
</div>

<script>
const MONTHS = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
let current = new Date();

// Blocked dates (example - connect to backend)
const blocked = {
    '2026-01-01': { label: 'Cuti Bersama', color: 'orange' },
    '2026-01-05': { label: 'Nama Petugas', color: 'blue' },
    '2026-01-06': { label: 'Nama Petugas', color: 'blue' },
    '2026-01-07': { label: 'Nama Petugas', color: 'blue' },
    '2026-01-28': { label: 'Libur Nasional', color: 'red' },
    '2026-01-29': { label: 'Libur Nasional', color: 'red' },
};

function pad(n) { return String(n).padStart(2, '0'); }

function renderCalendar() {
    const year = current.getFullYear();
    const month = current.getMonth();
    document.getElementById('calendar-title').textContent = MONTHS[month] + ' ' + year;

    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const today = new Date();

    let html = '';

    // Empty cells before first day
    for (let i = 0; i < firstDay; i++) {
        const prevDate = new Date(year, month, -firstDay + i + 1);
        html += `<div class="h-16 rounded-lg p-1 text-center">
            <span class="text-xs text-gray-300">${prevDate.getDate()}</span>
        </div>`;
    }

    for (let d = 1; d <= daysInMonth; d++) {
        const key = `${year}-${pad(month+1)}-${pad(d)}`;
        const isToday = d === today.getDate() && month === today.getMonth() && year === today.getFullYear();
        const blocked_entry = blocked[key];

        html += `<div class="h-16 rounded-lg p-1 ${isToday ? 'bg-blue-50 border border-blue-200' : 'hover:bg-gray-50'} transition relative">
            <span class="text-xs font-semibold ${isToday ? 'text-blue-600' : 'text-gray-600'} block text-center">${d}</span>
            ${blocked_entry ? `
            <div class="absolute bottom-1 left-1 right-1 text-[9px] font-semibold px-1 py-0.5 rounded text-center truncate
                ${blocked_entry.color === 'red' ? 'bg-red-100 text-red-600' :
                  blocked_entry.color === 'orange' ? 'bg-orange-100 text-orange-600' : 'bg-blue-100 text-blue-600'}">
                ${blocked_entry.label}
            </div>` : ''}
        </div>`;
    }

    document.getElementById('calendar-grid').innerHTML = html;
}

document.getElementById('prev-month').addEventListener('click', () => {
    current.setMonth(current.getMonth() - 1);
    renderCalendar();
});
document.getElementById('next-month').addEventListener('click', () => {
    current.setMonth(current.getMonth() + 1);
    renderCalendar();
});

renderCalendar();
</script>
@endsection