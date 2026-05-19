@extends('layouts.app')

@section('content')
<div class="p-6 max-w-3xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('pelayanan.reservasi.index', $reservasi->id_reservasi) }}"
           class="text-gray-400 hover:text-gray-600 transition">
            <i class="ti ti-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Reservasi</h1>
            <p class="text-sm text-gray-400 mt-0.5">
                {{ $reservasi->user->name ?? '-' }} &mdash;
                {{ $reservasi->tanggal_konsultasi
                    ? \Carbon\Carbon::parse($reservasi->tanggal_konsultasi)->format('d M Y')
                    : 'Tanggal belum ditentukan' }}
            </p>
        </div>
    </div>

    {{-- Error --}}
    @if($errors->any())
    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-xl space-y-1">
        @foreach($errors->all() as $e)
        <div class="flex items-center gap-2 text-sm"><i class="ti ti-alert-circle"></i> {{ $e }}</div>
        @endforeach
    </div>
    @endif

    @php
        $riwayatTerbaru = $reservasi->riwayatTerbaru;
        $status         = $riwayatTerbaru->status_pengajuan ?? 'diajukan';

        $tglKonsultasi = $reservasi->tanggal_konsultasi
            ? \Carbon\Carbon::parse($reservasi->tanggal_konsultasi)->startOfDay()
            : null;
        $sudahLewat = $tglKonsultasi && now()->startOfDay()->gt($tglKonsultasi);

        $statusDisplay = ($status === 'dijadwalkan' && $sudahLewat) ? 'selesai' : $status;
    @endphp

    <form method="POST" action="{{ route('pelayanan.reservasi.update', $reservasi->id_reservasi) }}">
        @csrf
        @method('PUT')

        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm p-6 space-y-6">

            {{-- ── READ-ONLY INFO ── --}}
            <div>
                <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-4">Informasi (Tidak Dapat Diubah)</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="block text-xs text-gray-400 mb-1">Nama Pemohon</label>
                        <input type="text" value="{{ $reservasi->user->name ?? '-' }}" disabled
                            class="w-full border border-gray-100 rounded-xl px-3 py-2 text-sm bg-gray-50 text-gray-500 cursor-not-allowed">
                    </div>

                    <div>
                        <label class="block text-xs text-gray-400 mb-1">No. WhatsApp</label>
                        <input type="text" value="{{ $reservasi->user->no_whatsapp ?? '-' }}" disabled
                            class="w-full border border-gray-100 rounded-xl px-3 py-2 text-sm bg-gray-50 text-gray-500 cursor-not-allowed">
                    </div>

                    <div>
                        <label class="block text-xs text-gray-400 mb-1">Tanggal Konsultasi</label>
                        <input type="text"
                            value="{{ $reservasi->tanggal_konsultasi ? \Carbon\Carbon::parse($reservasi->tanggal_konsultasi)->format('d-m-Y') : '-' }}"
                            disabled class="w-full border border-gray-100 rounded-xl px-3 py-2 text-sm bg-gray-50 text-gray-500 cursor-not-allowed">
                    </div>

                    <div>
                        <label class="block text-xs text-gray-400 mb-1">Waktu Konsultasi</label>
                        <input type="text" value="{{ $reservasi->waktu_konsultasi ?? '-' }}" disabled
                            class="w-full border border-gray-100 rounded-xl px-3 py-2 text-sm bg-gray-50 text-gray-500 cursor-not-allowed">
                    </div>

                    <div>
                        <label class="block text-xs text-gray-400 mb-1">Jenis Konsultasi</label>
                        <input type="text" value="{{ ucfirst($reservasi->jenis_konsultasi ?? '-') }}" disabled
                            class="w-full border border-gray-100 rounded-xl px-3 py-2 text-sm bg-gray-50 text-gray-500 cursor-not-allowed">
                    </div>

                    <div>
                        <label class="block text-xs text-gray-400 mb-1">Topik Diskusi</label>
                        <input type="text" value="{{ $reservasi->topik_diskusi ?? '-' }}" disabled
                            class="w-full border border-gray-100 rounded-xl px-3 py-2 text-sm bg-gray-50 text-gray-500 cursor-not-allowed">
                    </div>

                </div>
            </div>

            <hr class="border-gray-100 dark:border-gray-800">

            {{-- ── EDITABLE FIELDS ── --}}
            <div>
                <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-4">Yang Dapat Diubah</h2>
                <div class="space-y-5">

                    {{-- Status --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                            Status <span class="text-red-400">*</span>
                        </label>
                        <select name="status" id="statusSelect"
                            class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#035f9c]"
                            onchange="handleStatusChange(this.value)">
                            <option value="diajukan"    {{ $statusDisplay === 'diajukan'    ? 'selected' : '' }}>Diajukan</option>
                            <option value="dijadwalkan" {{ $statusDisplay === 'dijadwalkan' ? 'selected' : '' }}>Dijadwalkan</option>
                            <option value="selesai"     {{ $statusDisplay === 'selesai'     ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan"  {{ $statusDisplay === 'dibatalkan'  ? 'selected' : '' }}>Dibatalkan</option>
                        </select>

                        @if($status === 'dijadwalkan' && $sudahLewat)
                        <p class="text-xs text-[#035f9c] mt-1 flex items-center gap-1">
                            <i class="ti ti-info-circle"></i>
                            Otomatis <strong>Selesai</strong> karena tanggal sudah lewat. Bisa diubah ke Dibatalkan jika perlu.
                        </p>
                        @endif
                    </div>

                    {{-- Lokasi Konsultasi --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                            Lokasi Konsultasi
                        </label>
                        <input type="text" name="lokasi_konsultasi"
                            value="{{ old('lokasi_konsultasi', $reservasi->lokasi_konsultasi ?? '') }}"
                            placeholder="Contoh: Ruang PST Lt. 1"
                            class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#035f9c]">
                    </div>

                    {{-- Catatan Konsultasi --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                            Catatan Konsultasi
                        </label>
                        <textarea name="catatan_konsultasi" rows="3"
                            placeholder="Catatan untuk user setelah konsultasi..."
                            class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#035f9c]">{{ old('catatan_konsultasi', $riwayatTerbaru->catatan_konsultasi ?? '') }}</textarea>
                    </div>

                    {{-- Alasan Pembatalan — tampil saat status dibatalkan --}}
                    <div id="alasanWrap" class="{{ $statusDisplay !== 'dibatalkan' ? 'hidden' : '' }}">
                        <label class="block text-sm font-semibold text-red-600 mb-2">
                            <i class="ti ti-alert-triangle"></i> Alasan Pembatalan <span class="text-red-400">*</span>
                        </label>

                        <div class="space-y-2 mb-3">
                            @php
                            $opsiAlasan = [
                                'Pengguna tidak hadir tanpa konfirmasi'       => 'Pengguna tidak hadir tanpa konfirmasi sebelumnya.',
                                'Topik konsultasi tidak sesuai layanan'       => 'Topik yang diajukan di luar cakupan layanan BPS.',
                                'Petugas tidak tersedia pada waktu tersebut'  => 'Terjadi perubahan ketersediaan petugas.',
                                'Permintaan pembatalan dari pengguna'         => 'Pengguna mengajukan pembatalan secara langsung.',
                                'Jadwal konsultasi perlu diubah'              => 'Diperlukan penjadwalan ulang.',
                            ];
                            $alasanTersimpan = $riwayatTerbaru->alasan_pembatalan ?? '';
                            @endphp

                            @foreach($opsiAlasan as $val => $desc)
                            <label class="flex items-start gap-2 cursor-pointer">
                                <input type="checkbox" name="alasan_check[]" value="{{ $val }}"
                                       class="mt-1 accent-red-500"
                                       {{ str_contains($alasanTersimpan, $val) ? 'checked' : '' }}
                                       onchange="syncAlasan()">
                                <span class="text-sm text-gray-700">
                                    {{ $val }}
                                    <span class="block text-xs text-gray-400">{{ $desc }}</span>
                                </span>
                            </label>
                            @endforeach

                            <label class="flex items-start gap-2 cursor-pointer">
                                <input type="checkbox" name="alasan_check[]" value="__other__"
                                       class="mt-1 accent-red-500" id="otherCheckAdmin"
                                       onchange="toggleOtherAdmin(this)">
                                <span class="text-sm text-gray-700">
                                    Lainnya
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
                    </div>

                </div>
            </div>

            {{-- Actions --}}
            <div class="flex justify-end gap-3 pt-2 border-t border-gray-100 dark:border-gray-800">
                <a href="{{ route('pelayanan.reservasi.index', $reservasi->id_reservasi) }}"
                    class="px-5 py-2 border border-gray-200 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2 bg-[#035f9c] text-white rounded-xl text-sm font-semibold hover:text-[#035f9c] hover:bg-gray-100 transition">
                    <i class="ti ti-device-floppy"></i> Simpan Perubahan
                </button>
            </div>

        </div>
    </form>
</div>

<script>
function handleStatusChange(val) {
    const alasanWrap = document.getElementById('alasanWrap');
    alasanWrap.classList.toggle('hidden', val !== 'dibatalkan');
}

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

document.querySelector('form')?.addEventListener('submit', function(e) {
    const status = document.getElementById('statusSelect')?.value;
    if (status === 'dibatalkan') {
        const alasan = document.getElementById('alasanPembatalanInput')?.value?.trim();
        if (!alasan) {
            e.preventDefault();
            alert('Pilih minimal satu alasan pembatalan.');
        }
    }
});
</script>
@endsection