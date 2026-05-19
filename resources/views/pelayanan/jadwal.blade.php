@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Jadwal Tidak Tersedia</h1>

    <div class="flex gap-6">

        {{-- Left: List Keterangan --}}
        <div class="w-80 flex-shrink-0">
            <h3 class="text-sm font-bold text-gray-700 mb-3">Keterangan</h3>
            <div id="keterangan-list" class="space-y-3">
                <p id="empty-keterangan" class="text-sm text-gray-400 text-center py-6">Belum ada jadwal tidak tersedia</p>
            </div>
        </div>

        {{-- Right: Calendar + Form --}}
        <div class="flex-1 bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm p-6 relative">

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

            {{-- Add Form Panel --}}
            <div id="add-form" class="hidden absolute inset-4 bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 shadow-xl p-6 overflow-y-auto">
                <div class="flex justify-between items-center mb-4">
                    <input type="text" id="form-judul" placeholder="Tambah Judul Kegiatan"
                        class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#035f9c] mr-3">
                    <button onclick="closeForm()" class="p-1.5 bg-blue-600 hover:bg-blue-700 rounded-lg text-white transition">
                        <i class="ti ti-x text-base"></i>
                    </button>
                </div>

                <div class="mb-5">
                    <span class="text-sm font-semibold text-[#035f9c]">Tanggal :</span>
                    <span id="form-tanggal-label" class="text-sm font-semibold text-[#035f9c] ml-2"></span>
                </div>

                <div class="mb-5">
                    <p class="text-sm font-semibold text-[#035f9c] mb-3">Alasan :</p>
                    <div class="bg-gray-50 rounded-xl px-4 py-3 space-y-3">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="alasan" value="Cuti Pribadi" class="text-blue-600">
                            <span class="text-sm text-gray-700">Cuti Pribadi</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="alasan" value="Cuti Bersama" class="text-blue-600">
                            <span class="text-sm text-gray-700">Cuti Bersama</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="radio" name="alasan" value="Libur Nasional" class="text-blue-600">
                            <span class="text-sm text-gray-700">Libur Nasional</span>
                        </label>
                    </div>
                </div>

                <div class="mb-6">
                    <p class="text-sm font-semibold text-[#035f9c] mb-3">Nama Petugas :</p>
                    <div class="bg-gray-50 rounded-xl px-4 py-3 space-y-3">

    {{-- Semua Petugas --}}
    <label class="flex items-center gap-3 cursor-pointer">
        <input type="checkbox" id="all-petugas" value="Semua Petugas" class="text-blue-600">
        <span class="text-sm font-semibold text-gray-700">Semua Petugas</span>
    </label>

    <!-- <hr> -->

    {{-- List Petugas --}}
    @forelse($petugas as $p)
    <label class="flex items-center gap-3 cursor-pointer">
        <input type="checkbox" name="petugas" value="{{ $p->nama_lengkap }}" class="petugas-checkbox text-blue-600">
        <span class="text-sm text-gray-700">{{ $p->nama_lengkap }}</span>
    </label>
    @empty
    <p class="text-xs text-gray-400">Belum ada petugas terdaftar</p>
    @endforelse

</div>

                </div>

                <div class="flex justify-end">
                    <button onclick="saveJadwal()" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<form id="jadwal-form" method="POST" action="{{ route('pelayanan.jadwal.store') }}" class="hidden">
    @csrf
    <input type="hidden" name="tanggal" id="input-tanggal">
    <input type="hidden" name="judul" id="input-judul">
    <input type="hidden" name="alasan" id="input-alasan">
    <input type="hidden" name="petugas" id="input-petugas">
</form>

<script>
const MONTHS = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
const DAYS_ID = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
let current = new Date();
let selectedDate = null;
let blockedMap = @json($jadwalMap ?? []);

function pad(n) { return String(n).padStart(2, '0'); }
function formatDateID(dateStr) {
    const d = new Date(dateStr + 'T00:00:00');
    return `${DAYS_ID[d.getDay()]}, ${d.getDate()} ${MONTHS[d.getMonth()]} ${d.getFullYear()}`;
}

function renderCalendar() {
    const year = current.getFullYear();
    const month = current.getMonth();
    document.getElementById('calendar-title').textContent = MONTHS[month] + ' ' + year;
    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const today = new Date();
    let html = '';
    for (let i = 0; i < firstDay; i++) html += `<div class="h-16"></div>`;
    for (let d = 1; d <= daysInMonth; d++) {
        const key = `${year}-${pad(month+1)}-${pad(d)}`;
        const isToday = d === today.getDate() && month === today.getMonth() && year === today.getFullYear();
        const isSelected = selectedDate === key;
        const entry = blockedMap[key];
        const colorMap = { 'Libur Nasional':'bg-red-100 text-red-600', 'Cuti Bersama':'bg-orange-100 text-orange-600', 'Cuti Pribadi':'bg-blue-100 text-blue-600' };
        const badgeClass = entry ? (colorMap[entry.alasan] || 'bg-gray-100 text-gray-600') : '';
        html += `<div onclick="selectDate('${key}')" class="h-16 rounded-lg p-1 cursor-pointer transition relative
            ${isSelected ? 'bg-blue-600' : isToday ? 'bg-blue-50 border border-blue-200' : 'hover:bg-gray-50'}">
            <span class="text-xs font-semibold block text-center ${isSelected ? 'text-white' : isToday ? 'text-blue-600' : 'text-gray-600'}">${d}</span>
            ${entry ? `<div class="absolute bottom-1 left-0.5 right-0.5 text-[9px] font-semibold px-1 py-0.5 rounded text-center truncate ${badgeClass}">${entry.petugas ?? entry.alasan}</div>` : ''}
        </div>`;
    }
    document.getElementById('calendar-grid').innerHTML = html;
}

function selectDate(key) {
    selectedDate = key;
    renderCalendar();
    document.getElementById('add-form').classList.remove('hidden');
    document.getElementById('form-tanggal-label').textContent = formatDateID(key);
    document.getElementById('form-judul').value = '';
    document.querySelectorAll('input[name="alasan"]').forEach(r => r.checked = false);
    
    
// reset semua checkbox
document.getElementById('all-petugas').checked = false;
document.querySelectorAll('.petugas-checkbox').forEach(cb => cb.checked = false);

    const entry = blockedMap[key];
    if (entry) {
        document.getElementById('form-judul').value = entry.judul ?? '';
        document.querySelectorAll('input[name="alasan"]').forEach(r => { if (r.value === entry.alasan) r.checked = true; });
    }
}

function closeForm() {
    document.getElementById('add-form').classList.add('hidden');
    selectedDate = null;
    renderCalendar();
}

function saveJadwal() {
    const alasan = document.querySelector('input[name="alasan"]:checked')?.value;
    if (!alasan) { alert('Pilih alasan terlebih dahulu'); return; }
    document.getElementById('input-tanggal').value = selectedDate;
    document.getElementById('input-judul').value   = document.getElementById('form-judul').value;
    document.getElementById('input-alasan').value  = alasan;
   
   const selectedPetugas = [];

// cek apakah semua dipilih
if (allPetugasCheckbox.checked) {
    selectedPetugas.push('Semua Petugas');
} else {
    document.querySelectorAll('.petugas-checkbox:checked').forEach(cb => {
        selectedPetugas.push(cb.value);
    });
}

document.getElementById('input-petugas').value = selectedPetugas.join(', ');
    document.getElementById('jadwal-form').submit();

    if (!allPetugasCheckbox.checked && selectedPetugas.length === 0) {
    alert('Pilih minimal 1 petugas');
    return;
}
}

function renderKeterangan() {
    const list = document.getElementById('keterangan-list');
    const empty = document.getElementById('empty-keterangan');
    const entries = Object.entries(blockedMap).sort((a,b) => a[0].localeCompare(b[0]));
    if (!entries.length) { empty.classList.remove('hidden'); return; }
    empty.classList.add('hidden');
    const colorMap = { 'Libur Nasional':['bg-red-100 text-red-600'], 'Cuti Bersama':['bg-orange-100 text-orange-600'], 'Cuti Pribadi':['bg-blue-100 text-blue-600'] };
    list.innerHTML = entries.map(([date, entry]) => {
        const cls = (colorMap[entry.alasan] ?? ['bg-gray-100 text-gray-600'])[0];
        return `<div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm">
            <div class="flex items-start justify-between gap-2">
                <div>
                    <p class="text-sm font-semibold text-gray-800">${entry.judul || entry.alasan}</p>
                    <p class="text-xs text-gray-400 mt-0.5">${entry.petugas ?? 'Semua Petugas'}</p>
                    <div class="flex items-center gap-1 mt-2 text-xs text-gray-500">
                        <i class="ti ti-calendar text-[#035f9c]"></i> ${formatDateID(date)}
                    </div>
                </div>
                <span class="shrink-0 text-xs font-semibold px-2 py-0.5 rounded-full ${cls}">${entry.alasan}</span>
            </div>
        </div>`;
    }).join('');
}

document.getElementById('prev-month').addEventListener('click', () => { current.setMonth(current.getMonth()-1); renderCalendar(); });
document.getElementById('next-month').addEventListener('click', () => { current.setMonth(current.getMonth()+1); renderCalendar(); });
renderCalendar();
renderKeterangan();

// Ambil semua checkbox petugas
const allPetugasCheckbox = document.getElementById('all-petugas');

function getPetugasCheckboxes() {
    return document.querySelectorAll('.petugas-checkbox');
}

// Jika klik "Semua Petugas"
allPetugasCheckbox?.addEventListener('change', function() {
    const checkboxes = getPetugasCheckboxes();
    checkboxes.forEach(cb => cb.checked = this.checked); cb.disabled = this.checked;
});

// Jika pilih alasan tertentu → auto semua petugas
document.querySelectorAll('input[name="alasan"]').forEach(radio => {
    radio.addEventListener('change', function() {
        if (this.value === 'Libur Nasional' || this.value === 'Cuti Bersama') {
            allPetugasCheckbox.checked = true;
            getPetugasCheckboxes().forEach(cb => cb.checked = true); cb.disabled = true;
        }
    });
});
</script>
@endsection