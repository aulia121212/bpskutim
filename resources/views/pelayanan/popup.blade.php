@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Pop Up Overlay</h1>
        <button onclick="document.getElementById('modal-popup').classList.remove('hidden')"
            class="inline-flex items-center gap-2 bg-[#035f9c] text-white hover:bg-white hover:text-[#035f9c] text-sm font-semibold px-4 py-2 rounded-xl transition">
            <i class="ti ti-plus"></i> TAMBAH POP UP OVERLAY
        </button>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl px-4 py-3 mb-4">
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 mb-4 space-y-1">
        @foreach($errors->all() as $error)
            <p class="flex items-center gap-2"><i class="ti ti-alert-circle"></i> {{ $error }}</p>
        @endforeach
    </div>
    @endif

    {{-- Info periode aktif --}}
    @php
        $today   = \Carbon\Carbon::today();
        $aktif   = $popups->filter(fn($p) => $today->between(\Carbon\Carbon::parse($p->tanggal_mulai), \Carbon\Carbon::parse($p->tanggal_akhir)))->first();
    @endphp
    @if($aktif)
    <div class="bg-blue-50 border border-blue-200 text-blue-700 text-sm rounded-xl px-4 py-3 mb-4 flex items-center gap-2">
        <i class="ti ti-eye text-base"></i>
        Pop up <strong>sedang aktif ditampilkan</strong> di website hingga
        {{ \Carbon\Carbon::parse($aktif->tanggal_akhir)->translatedFormat('d F Y') }}.
    </div>
    @endif

    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left px-6 py-4 font-semibold text-[#035f9c]">Foto Pop Up</th>
                    <th class="text-left px-6 py-4 font-semibold text-[#035f9c]">Tanggal Mulai Display</th>
                    <th class="text-left px-6 py-4 font-semibold text-[#035f9c]">Tanggal Akhir Display</th>
                    <th class="text-left px-6 py-4 font-semibold text-[#035f9c]">Status</th>
                    <th class="text-left px-6 py-4 font-semibold text-[#035f9c]">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($popups as $p)
                @php
                    $mulai  = \Carbon\Carbon::parse($p->tanggal_mulai);
                    $akhir  = \Carbon\Carbon::parse($p->tanggal_akhir);
                    $isAktif = $today->between($mulai, $akhir);
                    $isAkan  = $mulai->isFuture();
                    $isSeles = $akhir->isPast();
                @endphp
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <img src="{{ asset($p->foto) }}" class="w-48 h-28 object-cover rounded-xl border border-gray-100">
                    </td>
                    <td class="px-6 py-4 text-gray-700">
                        {{ $mulai->translatedFormat('d F Y') }}
                    </td>
                    <td class="px-6 py-4 text-gray-700">
                        {{ $akhir->translatedFormat('d F Y') }}
                    </td>
                    <td class="px-6 py-4">
                        @if($isAktif)
                            <span class="inline-flex items-center gap-1 text-xs font-semibold bg-green-100 text-green-700 px-3 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span> Aktif
                            </span>
                        @elseif($isAkan)
                            <span class="inline-flex items-center gap-1 text-xs font-semibold bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-400 inline-block"></span> Terjadwal
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-xs font-semibold bg-gray-100 text-gray-500 px-3 py-1 rounded-full">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400 inline-block"></span> Selesai
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">


                            <!-- <form method="POST" action="{{ route('pelayanan.popup.destroy', $p->id) }}"
                                onsubmit="return confirm('Hapus popup ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-1.5 text-gray-400 hover:text-red-500 transition">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </form> -->

                            <button 
    type="button"
    onclick="openDeletePopupModal('{{ route('pelayanan.popup.destroy', $p->id) }}')"
    class="p-1.5 text-gray-400 hover:text-red-500 transition"
>
    <i class="ti ti-trash"></i>
</button>

<!-- Modal Hapus Popup -->
<div 
    id="deletePopupModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm"
>
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 animate-fadeIn">

        <div class="flex items-center gap-3 mb-4">
            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                <i class="ti ti-trash text-red-500 text-xl"></i>
            </div>

            <div>
                <h3 class="text-lg font-bold text-gray-800">
                    Hapus Popup
                </h3>

                <p class="text-sm text-gray-500">
                    Popup yang dihapus tidak dapat dikembalikan.
                </p>
            </div>
        </div>

        <p class="text-sm text-gray-600 mb-6">
            Apakah Anda yakin ingin menghapus popup ini?
        </p>

        <div class="flex justify-end gap-3">

            <button
                type="button"
                onclick="closeDeletePopupModal()"
                class="px-4 py-2 rounded-xl border border-gray-300 text-gray-600 hover:bg-gray-100 transition"
            >
                Batal
            </button>

            <form id="deletePopupForm" method="POST">
                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="px-4 py-2 rounded-xl bg-red-500 text-white hover:bg-red-600 transition"
                >
                    Ya, Hapus
                </button>
            </form>

        </div>
    </div>
</div>

                            <button onclick="previewPopup('{{ asset($p->foto) }}')"
                                class="inline-flex items-center gap-1 border border-blue-300 text-[#035f9c] text-xs font-semibold px-3 py-1.5 rounded-lg hover:bg-blue-50 transition">
                                Preview <i class="ti ti-chevrons-right text-sm"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                        <i class="ti ti-photo-off text-3xl block mb-2"></i>Belum ada pop up overlay
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ── Modal Tambah ── --}}
<div id="modal-popup" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
    <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Tambah Pop Up Overlay</h3>
            <button onclick="document.getElementById('modal-popup').classList.add('hidden')"
                class="text-gray-400 hover:text-gray-600"><i class="ti ti-x text-xl"></i></button>
        </div>

        {{-- Info periode yang sudah ada untuk referensi user --}}
        @if($popups->where('tanggal_akhir', '>=', now()->toDateString())->count())
        <div class="bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 mb-4 text-xs text-amber-700 space-y-1">
            <p class="font-semibold flex items-center gap-1"><i class="ti ti-calendar-event"></i> Periode yang sudah terdaftar:</p>
            @foreach($popups->where('tanggal_akhir', '>=', now()->toDateString()) as $existing)
            <p class="pl-4">
                {{ \Carbon\Carbon::parse($existing->tanggal_mulai)->format('d M Y') }} –
                {{ \Carbon\Carbon::parse($existing->tanggal_akhir)->format('d M Y') }}
            </p>
            @endforeach
            <p class="pt-1">Pilih tanggal di luar periode di atas.</p>
        </div>
        @endif

        <form method="POST" action="{{ route('pelayanan.popup.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-[#035f9c] mb-1">Foto Pop Up</label>
                    <input type="file" name="foto" accept="image/*" required
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#035f9c]">
                    <p class="text-xs text-gray-400 mt-1">Format: JPG, JPEG, PNG (maks 2MB)</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-[#035f9c] mb-1">Tanggal Mulai Display</label>
                    <input type="date" name="tanggal_mulai" id="inp-mulai" required
                        min="{{ now()->toDateString() }}"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#035f9c]">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-[#035f9c] mb-1">Tanggal Akhir Display</label>
                    <input type="date" name="tanggal_akhir" id="inp-akhir" required
                        min="{{ now()->toDateString() }}"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#035f9c]">
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="document.getElementById('modal-popup').classList.add('hidden')"
                    class="px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit"
                    class="px-5 py-2.5 rounded-xl bg-[#035f9c] hover:text-[#035f9c] hover:bg-gray-100 text-white text-sm font-semibold">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ── Modal Preview ── --}}
<div id="modal-preview" class="hidden fixed inset-0 z-50 flex items-center justify-center"
     onclick="closePreview(event)">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
    <div class="relative z-10 flex flex-col items-center gap-3" onclick="event.stopPropagation()">
        <div class="flex items-center gap-2 bg-white/10 backdrop-blur text-white text-xs font-semibold px-3 py-1.5 rounded-full border border-white/20">
            <i class="ti ti-device-desktop"></i> Simulasi tampilan di website
        </div>
        <div class="relative bg-white rounded-2xl shadow-2xl overflow-hidden" style="max-width:min(480px,90vw)">
            <img id="preview-img" src="" alt="Preview" class="w-full block" style="max-height:70vh;object-fit:contain">
            <button onclick="closePreviewBtn()"
                class="absolute top-3 right-3 w-8 h-8 flex items-center justify-center bg-white/90 hover:bg-white rounded-full shadow-md text-gray-600 hover:text-gray-900 transition">
                <i class="ti ti-x text-sm"></i>
            </button>
            <!-- <div class="px-5 py-3 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                <span class="text-xs text-gray-400">BPS Kabupaten Kutai Timur</span>
                <button onclick="closePreviewBtn()" class="text-xs font-semibold text-blue-600 hover:text-blue-700">Tutup</button>
            </div> -->
        </div>
        <p class="text-white/50 text-xs">Klik di luar untuk menutup</p>
    </div>
</div>

<script>
// Buka kembali modal jika ada error validasi
@if($errors->any())
document.getElementById('modal-popup').classList.remove('hidden');
@endif

// Tanggal akhir min = tanggal mulai
document.getElementById('inp-mulai')?.addEventListener('change', function() {
    const akhir = document.getElementById('inp-akhir');
    akhir.min = this.value;
    if (akhir.value && akhir.value < this.value) akhir.value = this.value;
});

function previewPopup(url) {
    document.getElementById('preview-img').src = url;
    document.getElementById('modal-preview').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function closePreviewBtn() {
    document.getElementById('modal-preview').classList.add('hidden');
    document.body.style.overflow = '';
}
function closePreview(e) {
    if (e.target === document.getElementById('modal-preview') || e.target.classList.contains('absolute')) closePreviewBtn();
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closePreviewBtn(); });
</script>

<script id="x192js">
    function openDeletePopupModal(actionUrl) {
        document.getElementById('deletePopupForm').action = actionUrl;

        const modal = document.getElementById('deletePopupModal');

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDeletePopupModal() {
        const modal = document.getElementById('deletePopupModal');

        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }
</script>

@endsection