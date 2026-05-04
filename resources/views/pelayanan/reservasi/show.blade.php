@extends('layouts.app')

@section('content')
<div class="p-6 max-w-3xl mx-auto">

    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('pelayanan.reservasi.index') }}"
           class="text-gray-400 hover:text-gray-600 transition">
            <i class="ti ti-arrow-left text-xl"></i>
        </a>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Detail Reservasi</h1>
    </div>

    @if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-xl flex items-center gap-2">
        <i class="ti ti-circle-check"></i> {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-xl">
        @foreach($errors->all() as $e)
        <div class="flex items-center gap-2"><i class="ti ti-alert-circle"></i> {{ $e }}</div>
        @endforeach
    </div>
    @endif

    @php
        $riwayatTerbaru = $reservasi->riwayatTerbaru;
        $status         = $riwayatTerbaru->status_pengajuan ?? 'diajukan';

        // Auto-selesai: dijadwalkan + tanggal konsultasi sudah lewat
        $tglKonsultasi = $reservasi->tanggal_konsultasi
            ? \Carbon\Carbon::parse($reservasi->tanggal_konsultasi)->startOfDay()
            : null;
        $sudahLewat = $tglKonsultasi && now()->startOfDay()->gt($tglKonsultasi);

        $statusDisplay = ($status === 'dijadwalkan' && $sudahLewat) ? 'selesai' : $status;

        // Admin masih bisa edit (override jadi dibatalkan) walau sudah selesai-otomatis
        $bisaEdit = !in_array($statusDisplay, ['dibatalkan']);
    @endphp

    <form method="POST" action="{{ route('pelayanan.reservasi.update', $reservasi->id_reservasi) }}">
        @csrf
        @method('PUT')

    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm p-6 space-y-5">

        {{-- ── STATUS ── --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Status</label>

            @if($bisaEdit)
            <select name="status" id="statusSelect"
                class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                onchange="handleStatusChange(this.value)">
                <option value="diajukan"    {{ $statusDisplay === 'diajukan'    ? 'selected' : '' }}>Diajukan</option>
                <option value="dijadwalkan" {{ $statusDisplay === 'dijadwalkan' ? 'selected' : '' }}>Dijadwalkan</option>
                <option value="selesai"     {{ $statusDisplay === 'selesai'     ? 'selected' : '' }}>Selesai</option>
                <option value="dibatalkan"  {{ $statusDisplay === 'dibatalkan'  ? 'selected' : '' }}>Dibatalkan</option>
            </select>
            @else
            {{-- Status dibatalkan — read only --}}
            <input type="hidden" name="status" value="dibatalkan">
            <div class="w-full border border-red-200 bg-red-50 rounded-xl px-3 py-2 text-sm text-red-700 font-semibold">
                <i class="ti ti-circle-x"></i> Dibatalkan
                <span class="text-xs font-normal text-red-400 ml-1">(tidak dapat diubah)</span>
            </div>
            @endif
        </div>

        {{-- INFO OTOMATIS SELESAI --}}
        @if($status === 'dijadwalkan' && $sudahLewat)
        <div class="bg-blue-50 border border-blue-200 rounded-xl px-4 py-3 text-sm text-blue-700 flex items-start gap-2">
            <i class="ti ti-info-circle mt-0.5 flex-shrink-0"></i>
            <span>Status ini otomatis berubah ke <strong>Selesai</strong> karena tanggal konsultasi sudah lewat.
            Anda tetap dapat mengubahnya ke <strong>Dibatalkan</strong> jika diperlukan.</span>
        </div>
        @endif

        {{-- ── DATA READ-ONLY ── --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama</label>
                <input type="text" value="{{ $reservasi->user->name ?? '-' }}" disabled
                    class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm bg-gray-50 text-gray-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">No. WhatsApp</label>
                <div class="flex gap-2">
                    <input type="text" id="no_wa" value="{{ $reservasi->user->no_whatsapp ?? '-' }}" disabled
                        class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm bg-gray-50 text-gray-500">
                    <button type="button" onclick="kirimWA()"
                        class="flex items-center gap-1 px-3 py-2 bg-green-500 hover:bg-green-600 text-white rounded-xl text-sm font-semibold transition flex-shrink-0">
                        <i class="ti ti-brand-whatsapp"></i> WA
                    </button>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Pengajuan</label>
                <input type="text" value="{{ $reservasi->created_at?->format('d-m-Y H:i') ?? '-' }}" disabled
                    class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm bg-gray-50 text-gray-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Konsultasi</label>
                <input type="text" value="{{ $reservasi->tanggal_konsultasi ? \Carbon\Carbon::parse($reservasi->tanggal_konsultasi)->format('d-m-Y') : '-' }}" disabled
                    class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm bg-gray-50 text-gray-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Waktu Konsultasi</label>
                <input type="text" value="{{ $reservasi->waktu_konsultasi ?? '-' }}" disabled
                    class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm bg-gray-50 text-gray-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Jenis Konsultasi</label>
                <input type="text" value="{{ ucfirst($reservasi->jenis_konsultasi ?? '-') }}" disabled
                    class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm bg-gray-50 text-gray-500">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Topik Diskusi</label>
                <input type="text" value="{{ $reservasi->topik_diskusi ?? '-' }}" disabled
                    class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm bg-gray-50 text-gray-500">
            </div>

            {{-- Lokasi — editable kecuali dibatalkan --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Lokasi Konsultasi</label>
                @if($bisaEdit)
                <input type="text" name="lokasi_konsultasi"
                    value="{{ old('lokasi_konsultasi', $reservasi->lokasi_konsultasi ?? '') }}"
                    placeholder="Contoh: Ruang PST Lt. 1"
                    class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @else
                <input type="text" value="{{ $reservasi->lokasi_konsultasi ?? '-' }}" disabled
                    class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm bg-gray-50 text-gray-500">
                @endif
            </div>

        </div>

        {{-- Catatan konsultasi --}}
        <div id="catatanWrap">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Catatan Konsultasi</label>
            @if($bisaEdit)
            <textarea name="catatan_konsultasi" rows="3"
                placeholder="Catatan untuk user setelah konsultasi..."
                class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('catatan_konsultasi', $riwayatTerbaru->catatan_konsultasi ?? '') }}</textarea>
            @else
            <div class="w-full border border-gray-200 bg-gray-50 rounded-xl px-3 py-2 text-sm text-gray-500 min-h-[80px]">
                {{ $riwayatTerbaru->catatan_konsultasi ?? '-' }}
            </div>
            @endif
        </div>

        {{-- Alasan pembatalan — muncul saat status dibatalkan --}}
        <div id="alasanWrap" class="{{ $statusDisplay !== 'dibatalkan' ? 'hidden' : '' }}">
            <label class="block text-sm font-semibold text-red-600 mb-2">
                <i class="ti ti-alert-triangle"></i> Alasan Pembatalan
            </label>

            @if($bisaEdit)
            {{-- Checkbox pilihan alasan --}}
            <div class="space-y-2 mb-3" id="alasanCheckboxes">
                @php
                $opsiAlasan = [
                    'Pengguna tidak hadir tanpa konfirmasi'    => 'Pengguna tidak hadir tanpa konfirmasi sebelumnya.',
                    'Topik konsultasi tidak sesuai layanan'   => 'Topik yang diajukan di luar cakupan layanan BPS.',
                    'Petugas tidak tersedia pada waktu tersebut' => 'Terjadi perubahan ketersediaan petugas.',
                    'Permintaan pembatalan dari pengguna'     => 'Pengguna mengajukan pembatalan secara langsung.',
                    'Jadwal konsultasi perlu diubah'          => 'Diperlukan penjadwalan ulang.',
                ];
                $alasanTersimpan = $riwayatTerbaru->alasan_pembatalan ?? '';
                @endphp

                @foreach($opsiAlasan as $val => $desc)
                <label class="flex items-start gap-2 cursor-pointer">
                    <input type="checkbox" name="alasan_check[]" value="{{ $val }}"
                           class="mt-1 accent-red-500"
                           {{ str_contains($alasanTersimpan, $val) ? 'checked' : '' }}
                           onchange="syncAlasan()">
                    <span class="text-sm text-gray-700">{{ $val }}
                        <span class="block text-xs text-gray-400">{{ $desc }}</span>
                    </span>
                </label>
                @endforeach

                <label class="flex items-start gap-2 cursor-pointer">
                    <input type="checkbox" name="alasan_check[]" value="__other__"
                           class="mt-1 accent-red-500" id="otherCheckAdmin"
                           onchange="toggleOtherAdmin(this); syncAlasan()">
                    <span class="text-sm text-gray-700">Lainnya
                        <span class="block text-xs text-gray-400">Tuliskan alasan spesifik.</span>
                    </span>
                </label>
                <textarea id="otherTextAdmin" rows="2"
                    placeholder="Tulis alasan lainnya..."
                    class="w-full border border-red-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-red-400 hidden"
                    oninput="syncAlasan()"></textarea>
            </div>

            <input type="hidden" name="alasan_pembatalan" id="alasanPembatalanInput"
                   value="{{ old('alasan_pembatalan', $alasanTersimpan) }}">
            @else
            <div class="w-full border border-red-200 bg-red-50 rounded-xl px-3 py-2 text-sm text-red-700 min-h-[60px]">
                {{ $riwayatTerbaru->alasan_pembatalan ?? '-' }}
            </div>
            @endif
        </div>

        {{-- Actions --}}
        @if($bisaEdit)
        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('pelayanan.reservasi.index') }}"
                class="px-5 py-2 border border-gray-200 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                Kembali
            </a>
            <button type="submit"
                class="border border-transparent px-6 py-2 bg-[#035f9c] text-white hover:bg-white hover:text-[#035f9c] hover:border-[#035f9c] rounded-xl text-sm font-semibold transition">
                Simpan Perubahan
            </button>
        </div>
        @else
        <div class="flex justify-start pt-2">
            <a href="{{ route('pelayanan.reservasi.index') }}"
                class="px-5 py-2 border border-gray-200 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                <i class="ti ti-arrow-left"></i> Kembali
            </a>
        </div>
        @endif

    </div>
    </form>
</div>

<script>
// Tampil/sembunyikan alasanWrap berdasar pilihan status
function handleStatusChange(val) {
    const alasanWrap = document.getElementById('alasanWrap');
    if (val === 'dibatalkan') {
        alasanWrap.classList.remove('hidden');
    } else {
        alasanWrap.classList.add('hidden');
    }
}

// Sync checkbox ke hidden input
function syncAlasan() {
    const checked = [...document.querySelectorAll('input[name="alasan_check[]"]:checked')]
        .filter(cb => cb.value !== '__other__')
        .map(cb => '• ' + cb.value);

    const otherCb  = document.getElementById('otherCheckAdmin');
    const otherTxt = document.getElementById('otherTextAdmin');
    if (otherCb?.checked && otherTxt?.value.trim()) {
        checked.push('• ' + otherTxt.value.trim());
    }

    const hidden = document.getElementById('alasanPembatalanInput');
    if (hidden) hidden.value = checked.join('\n');
}

function toggleOtherAdmin(cb) {
    const txt = document.getElementById('otherTextAdmin');
    txt.classList.toggle('hidden', !cb.checked);
    if (!cb.checked) txt.value = '';
    syncAlasan();
}

// Validasi sebelum submit
document.querySelector('form')?.addEventListener('submit', function(e) {
    const status = document.getElementById('statusSelect')?.value;
    if (status === 'dibatalkan') {
        const alasan = document.getElementById('alasanPembatalanInput')?.value?.trim();
        if (!alasan) {
            e.preventDefault();
            alert('Pilih minimal satu alasan pembatalan.');
            return;
        }
    }
});

// Kirim WA
function kirimWA() {
    const no      = document.getElementById('no_wa').value.replace(/^0/, '62').replace(/\D/g,'');
    const nama    = @json($reservasi->user->name ?? '-');
    const tanggal = @json($reservasi->tanggal_konsultasi ? \Carbon\Carbon::parse($reservasi->tanggal_konsultasi)->format('d-m-Y') : '-');
    const jam     = @json($reservasi->waktu_konsultasi ?? '-');
    const jenis   = @json($reservasi->jenis_konsultasi ?? '-');
    const lokasi  = document.querySelector('input[name="lokasi_konsultasi"]')?.value || '-';

    const pesan = `Halo ${nama},\n\nBerikut adalah jadwal konsultasi Anda:\n\n📅 Tanggal : ${tanggal}\n⏰ Jam     : ${jam}\n💻 Jenis   : ${jenis}\n📍 Lokasi  : ${lokasi}\n\nMohon hadir tepat waktu. Terima kasih 🙏\nBPS Kabupaten Kutai Timur`;
    window.open(`https://wa.me/${no}?text=${encodeURIComponent(pesan)}`, '_blank');
}
</script>
@endsection