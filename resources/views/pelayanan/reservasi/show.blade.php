@extends('layouts.app')

@section('content')
<div class="p-6 max-w-3xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('pelayanan.reservasi.index') }}"
               class="text-gray-400 hover:text-gray-600 transition">
                <i class="ti ti-arrow-left text-xl"></i>
            </a>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Detail Reservasi</h1>
        </div>

        @if($bisaEdit)
        <a href="{{ route('pelayanan.reservasi.edit', $reservasi->id_reservasi) }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-[#035f9c] text-white text-sm font-semibold rounded-xl hover:text-[#035f9c] hover:bg-gray-100 transition">
            <i class="ti ti-pencil"></i> Edit
        </a>
        @endif
    </div>

    {{-- Alert sukses --}}
    @if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-xl flex items-center gap-2">
        <i class="ti ti-circle-check"></i> {{ session('success') }}
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

        $statusClass = match($statusDisplay) {
            'dijadwalkan' => 'bg-[#035f9c] text-white',
            'selesai'     => 'bg-green-500 text-white',
            'dibatalkan'  => 'bg-red-500 text-white',
            default       => 'bg-gray-400 text-white',
        };

        $statusLabel = match($statusDisplay) {
            'dijadwalkan' => 'Dijadwalkan',
            'selesai'     => 'Selesai',
            'dibatalkan'  => 'Dibatalkan',
            default       => 'Diajukan',
        };
    @endphp

    {{-- Kartu utama --}}
    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm divide-y divide-gray-50 dark:divide-gray-800">

        {{-- Status bar --}}
        <div class="px-6 py-4 flex items-center justify-between">
            <span class="text-sm font-semibold text-gray-500">Status</span>
            <span class="inline-block text-xs font-semibold px-3 py-1.5 rounded-full {{ $statusClass }}">
                {{ $statusLabel }}
            </span>
        </div>

        {{-- Info otomatis selesai --}}
        @if($status === 'dijadwalkan' && $sudahLewat)
        <div class="px-6 py-3 bg-blue-50 border-b border-blue-100">
            <div class="flex items-start gap-2 text-sm text-blue-700">
                <i class="ti ti-info-circle mt-0.5 flex-shrink-0"></i>
                <span>Status otomatis berubah ke <strong>Selesai</strong> karena tanggal konsultasi sudah lewat.</span>
            </div>
        </div>
        @endif

        {{-- Data pemohon --}}
        <div class="px-6 py-5">
            <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-4">Data Pemohon</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Nama</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $reservasi->user->name ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-xs text-gray-400 mb-0.5">No. WhatsApp</p>
                    <div class="flex items-center gap-2">
                        <p class="text-sm font-semibold text-gray-800" id="no_wa_display">
                            {{ $reservasi->user->no_whatsapp ?? '-' }}
                        </p>
                        @if($reservasi->user?->no_whatsapp)
                        <button type="button" onclick="kirimWA()"
                            class="flex items-center gap-1 px-2 py-1 bg-green-500 hover:bg-green-600 text-white rounded-lg text-xs font-semibold transition">
                            <i class="ti ti-brand-whatsapp"></i> WA
                        </button>
                        @endif
                    </div>
                </div>

                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Petugas</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $reservasi->petugas->nama_lengkap ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Tanggal Pengajuan</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $reservasi->created_at?->format('d-m-Y H:i') ?? '-' }}</p>
                </div>

            </div>
        </div>

        {{-- Detail konsultasi --}}
        <div class="px-6 py-5">
            <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-4">Detail Konsultasi</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Tanggal Konsultasi</p>
                    <p class="text-sm font-semibold text-gray-800">
                        {{ $reservasi->tanggal_konsultasi
                            ? \Carbon\Carbon::parse($reservasi->tanggal_konsultasi)->format('d-m-Y')
                            : '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Waktu Konsultasi</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $reservasi->waktu_konsultasi ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Jenis Konsultasi</p>
                    <p class="text-sm font-semibold text-gray-800">{{ ucfirst($reservasi->jenis_konsultasi ?? '-') }}</p>
                </div>

                <div>
                    <p class="text-xs text-gray-400 mb-0.5">Lokasi Konsultasi</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $reservasi->lokasi_konsultasi ?? '-' }}</p>
                </div>

                <div class="md:col-span-2">
                    <p class="text-xs text-gray-400 mb-0.5">Topik Diskusi</p>
                    <p class="text-sm font-semibold text-gray-800">{{ $reservasi->topik_diskusi ?? '-' }}</p>
                </div>

            </div>
        </div>

        {{-- Catatan & alasan pembatalan --}}
        @if($riwayatTerbaru?->catatan_konsultasi || $statusDisplay === 'dibatalkan')
        <div class="px-6 py-5">
            <h2 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-4">Catatan</h2>

            @if($riwayatTerbaru?->catatan_konsultasi)
            <div class="mb-4">
                <p class="text-xs text-gray-400 mb-1">Catatan Konsultasi</p>
                <div class="bg-gray-50 rounded-xl px-4 py-3 text-sm text-gray-700 whitespace-pre-line">
                    {{ $riwayatTerbaru->catatan_konsultasi }}
                </div>
            </div>
            @endif

            @if($statusDisplay === 'dibatalkan' && $riwayatTerbaru?->alasan_pembatalan)
            <div>
                <p class="text-xs text-red-400 mb-1">Alasan Pembatalan</p>
                <div class="bg-red-50 border border-red-100 rounded-xl px-4 py-3 text-sm text-red-700 whitespace-pre-line">
                    {{ $riwayatTerbaru->alasan_pembatalan }}
                </div>
            </div>
            @endif
        </div>
        @endif

        {{-- Footer aksi --}}
        <!-- <div class="px-6 py-4 flex items-center justify-between bg-gray-50 dark:bg-gray-800 rounded-b-2xl">
            <a href="{{ route('pelayanan.reservasi.index') }}"
               class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-gray-700 transition font-semibold">
                <i class="ti ti-arrow-left"></i> Kembali ke Daftar
            </a>

            @if($bisaEdit)
            <a href="{{ route('pelayanan.reservasi.edit', $reservasi->id_reservasi) }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-[#035f9c] text-white text-sm font-semibold rounded-xl hover:text-[#035f9c] hover:bg-gray-100 transition">
                <i class="ti ti-pencil"></i> Edit Reservasi
            </a>
            @endif
        </div> -->

    </div>
</div>

<script>
function kirimWA() {
    const no = '{{ $reservasi->user->no_whatsapp ?? '' }}'
        .replace(/^0/, '62')
        .replace(/\D/g, '');

    const nama    = @json($reservasi->user->name ?? '-');
    const tanggal = @json($reservasi->tanggal_konsultasi ? \Carbon\Carbon::parse($reservasi->tanggal_konsultasi)->format('d-m-Y') : '-');
    const jam     = @json($reservasi->waktu_konsultasi ?? '-');
    const jenisRaw= @json($reservasi->jenis_konsultasi ?? '-');
    const lokasi  = @json($reservasi->lokasi_konsultasi ?? '-');

    let jenis = jenisRaw;
    if (jenisRaw.toLowerCase() === 'offline') jenis = 'Offline (Luring)';
    else if (jenisRaw.toLowerCase() === 'online') jenis = 'Online (Daring)';

    const pesan = `Halo ${nama}\n\nBerikut adalah jadwal konsultasi Anda:\n\n📅 Tanggal : ${tanggal}\n⏰ Jam     : ${jam}\n💻 Jenis   : ${jenis}\n📍 Lokasi  : ${lokasi}\n\nMohon hadir tepat waktu.\nTerima kasih 🙏\n\nBPS Kabupaten Kutai Timur`.trim();

    window.open(`https://api.whatsapp.com/send?${new URLSearchParams({ phone: no, text: pesan }).toString()}`, '_blank');
}
</script>
@endsection