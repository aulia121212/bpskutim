@extends('layouts.app')

@section('content')
<div class="p-6">

    <h1 class="text-2xl font-bold mb-6">Detail Reservasi</h1>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @php
        $riwayat = $reservasi->riwayatTerbaru;
        $status  = $riwayat->status_pengajuan ?? 'diajukan';
    @endphp

    {{-- Form: method PATCH → route pakai PUT di web.php, jadi ganti @method('PUT') --}}
    <form method="POST" action="{{ route('pelayanan.reservasi.update', $reservasi->id_reservasi) }}">
        @csrf
        @method('PUT')

        <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm p-6 space-y-6">

            {{-- STATUS --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="diajukan"   {{ $status === 'diajukan'   ? 'selected' : '' }}>Diajukan</option>
                    <option value="dijadwalkan" {{ $status === 'dijadwalkan' ? 'selected' : '' }}>Dijadwalkan</option>
                    <option value="dibatalkan"  {{ $status === 'dibatalkan'  ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>

            {{-- DATA (read-only) --}}
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
            class="flex items-center gap-2 px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-xl text-sm font-semibold transition">

            <i class="ti ti-brand-whatsapp"></i>
            Kirim
        </button>
    </div>
</div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Reservasi</label>
                    <input type="text" value="{{ $reservasi->created_at?->format('d-m-Y H:i') ?? '-' }}" disabled
                        class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm bg-gray-50 text-gray-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Konsultasi</label>
                    <input type="text" value="{{ $reservasi->tanggal_konsultasi ?? '-' }}" disabled
                        class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm bg-gray-50 text-gray-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Waktu Konsultasi</label>
                    <input type="text" value="{{ $reservasi->waktu_konsultasi ?? '-' }}" disabled
                        class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm bg-gray-50 text-gray-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Jenis Konsultasi</label>
                    <input type="text" value="{{ $reservasi->jenis_konsultasi ?? '-' }}" disabled
                        class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm bg-gray-50 text-gray-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Topik Diskusi</label>
                    <input type="text" value="{{ $reservasi->topik_diskusi ?? '-' }}" disabled
                        class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm bg-gray-50 text-gray-500">
                </div>

                {{-- EDITABLE: Lokasi --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Lokasi Konsultasi</label>
                    <input type="text" name="lokasi_konsultasi"
                        value="{{ old('lokasi_konsultasi', $reservasi->lokasi_konsultasi ?? '') }}"
                        class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

            </div>

            {{-- EDITABLE: Catatan --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Catatan Konsultasi</label>
                <textarea name="catatan_konsultasi" rows="3"
                    class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('catatan_konsultasi', $riwayat->catatan_konsultasi ?? '') }}</textarea>
            </div>

            {{-- EDITABLE: Alasan --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Alasan Pembatalan</label>
                <textarea name="alasan_pembatalan" rows="3"
                    class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('alasan_pembatalan', $riwayat->alasan_pembatalan ?? '') }}</textarea>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('pelayanan.reservasi.index') }}"
                    class="px-5 py-2 border border-gray-200 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                    Kembali
                </a>
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-semibold transition">
                    Simpan Perubahan
                </button>
            </div>

        </div>
    </form>
</div>

<script>
function kirimWA() {
    const no = document.getElementById('no_wa').value.replace(/^0/, '62');

    const nama   = @json($reservasi->user->name ?? '-');
    const tanggal = @json($reservasi->tanggal_konsultasi ?? '-');
    const jam     = @json($reservasi->waktu_konsultasi ?? '-');
    const jenis   = @json($reservasi->jenis_konsultasi ?? '-');
    const lokasi  = document.querySelector('input[name="lokasi_konsultasi"]').value || '-';

    const pesan = `Halo ${nama},

Berikut adalah jadwal konsultasi Anda:

📅 Tanggal : ${tanggal}
⏰ Jam     : ${jam}
💻 Jenis   : ${jenis}
📍 Lokasi  : ${lokasi}

Mohon hadir tepat waktu. Terima kasih 🙏
BPS Kabupaten Kutai Timur`;

    const url = `https://wa.me/${no}?text=${encodeURIComponent(pesan)}`;

    window.open(url, '_blank');
}
</script>
@endsection