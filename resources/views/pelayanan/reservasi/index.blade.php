@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">
        Reservasi Konsultasi
    </h1>

    <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100">
                    <th class="text-left px-6 py-4 font-semibold text-[#035f9c]">No</th>
                    <th class="text-left px-6 py-4 font-semibold text-[#035f9c]">Tanggal Konsultasi</th>
                    <th class="text-left px-6 py-4 font-semibold text-[#035f9c]">Nama</th>
                    <th class="text-left px-6 py-4 font-semibold text-[#035f9c]">Nomor WhatsApp</th>
                    <th class="text-left px-6 py-4 font-semibold text-[#035f9c]">Petugas</th>
                    <th class="text-left px-6 py-4 font-semibold text-[#035f9c]">Status</th>
                    <th class="text-left px-6 py-4 font-semibold text-[#035f9c]">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($reservasi ?? [] as $index => $r)
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition">

                    <td class="px-6 py-4 text-gray-700 font-medium">
                        {{ $index + 1 }}
                    </td>

                    <td class="px-6 py-4 text-gray-700">
                        {{ \Carbon\Carbon::parse($r->tanggal)->format('d-m-Y') }}
                    </td>

                    <td class="px-6 py-4 text-gray-700">
                        {{ $r->user->name ?? '-' }}
                    </td>

                    <td class="px-6 py-4 text-gray-700">
                        {{ $r->user->no_whatsapp ?? '-' }}
                    </td>

                    <td class="px-6 py-4 text-gray-700">
                        {{ $r->petugas->nama_lengkap ?? '-' }}
                    </td>

                    <td class="px-6 py-4">
                        @php
                            $statusClass = match($r->status) {
                                'dijadwalkan' => 'bg-[#035f9c] text-white',
                                'selesai'     => 'bg-green-500 text-white',
                                'dibatalkan'  => 'bg-red-500 text-white',
                                default       => 'bg-gray-500 text-white',
                            };

                            $statusLabel = match($r->status) {
                                'dijadwalkan' => 'Dijadwalkan',
                                'selesai'     => 'Selesai',
                                'dibatalkan'  => 'Dibatalkan',
                                default       => 'Diajukan',
                            };
                        @endphp

                        <span class="inline-block text-xs font-semibold px-3 py-1.5 rounded-full {{ $statusClass }}">
                            {{ $statusLabel }}
                        </span>
                    </td>

                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
    <a href="{{ route('pelayanan.reservasi.edit', $r->id_reservasi) }}"
       class="p-1.5 text-gray-400 hover:text-blue-600 transition">
        <i class="ti ti-pencil"></i>
    </a>

    <button 
    type="button"
    onclick="openDeleteModal('{{ route('pelayanan.reservasi.destroy', $r->id_reservasi) }}')"
    class="p-1.5 text-gray-400 hover:text-red-500 transition"
>
    <i class="ti ti-trash"></i>
</button>

<!-- Modal Hapus -->
<div 
    id="deleteModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm"
>
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 animate-fadeIn">
        
        <div class="flex items-center gap-3 mb-4">
            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                <i class="ti ti-trash text-red-500 text-xl"></i>
            </div>

            <div>
                <h3 class="text-lg font-bold text-gray-800">
                    Hapus Reservasi
                </h3>
                <p class="text-sm text-gray-500">
                    Data yang dihapus tidak dapat dikembalikan.
                </p>
            </div>
        </div>

        <p class="text-sm text-gray-600 mb-6">
            Apakah Anda yakin ingin menghapus reservasi ini?
        </p>

        <div class="flex justify-end gap-3">
            <button
                type="button"
                onclick="closeDeleteModal()"
                class="px-4 py-2 rounded-xl border border-gray-300 text-gray-600 hover:bg-gray-100 transition"
            >
                Batal
            </button>

            <form id="deleteForm" method="POST">
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

    <a href="{{ route('pelayanan.reservasi.show', $r->id_reservasi) }}"
       class="inline-flex items-center gap-1 border border-[#035f9c] text-[#035f9c] text-xs font-semibold px-3 py-1.5 rounded-lg hover:bg-blue-50 transition">
        Detail
        <i class="ti ti-chevrons-right text-sm"></i>
    </a>
</div>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                        <i class="ti ti-calendar-off text-3xl block mb-2"></i>
                        Belum ada reservasi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script id="k182js">
    function openDeleteModal(actionUrl) {
        document.getElementById('deleteForm').action = actionUrl;
        
        const modal = document.getElementById('deleteModal');

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');

        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }
</script>
@endsection