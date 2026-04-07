<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi Konsultasi - BPS Kabupaten Kutai Timur</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/konsultasi.css') }}">
</head>
<body>

@include('partials.navbar')

<section style="margin-top:72px; padding:60px 80px; min-height:80vh; background:#f8fafc; display:flex; align-items:center; justify-content:center;">

    <div style="background:#fff; border-radius:20px; border:1.5px solid #e2e8f0; padding:40px; width:100%; max-width:660px; box-shadow:0 8px 32px rgba(26,86,219,.08);">

        {{-- Header --}}
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:28px;">
            <h1 style="font-size:24px; font-weight:800; color:#1a56db;">Formulir Reservasi Konsultasi</h1>
<a href="{{ url('/konsultasi') }}">                 <i class="ti ti-x"></i>
            </a>
        </div>

        {{-- Info Cards --}}
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:28px;">

            {{-- Data Petugas --}}
            <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:14px; padding:16px;">
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px;font-size:13px;font-weight:700;color:#1e293b;">
                    <i class="ti ti-user" style="color:#1a56db"></i> Data Petugas :
                </div>
                <div style="font-size:14px;font-weight:700;color:#1e293b;margin-bottom:2px;">{{ $petugas->nama_lengkap }}</div>
                <div style="font-size:12px;color:#64748b;margin-bottom:10px;">BPS Kutai Timur</div>
                <div style="display:flex;gap:6px;flex-wrap:wrap;">
                    @foreach(explode(',', $petugas->topik ?? '') as $tag)
                        <span style="background:#e8f0fe;color:#1a56db;font-size:11px;font-weight:600;padding:3px 10px;border-radius:8px;">{{ trim($tag) }}</span>
                    @endforeach
                </div>
            </div>

            {{-- Data Pengguna --}}
            <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:14px; padding:16px;">
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px;font-size:13px;font-weight:700;color:#1e293b;">
                    <i class="ti ti-user-circle" style="color:#1a56db"></i> Data Pengguna :
                </div>
                <div style="font-size:14px;font-weight:700;color:#1e293b;margin-bottom:2px;">{{ auth()->user()->name }}</div>
                <div style="font-size:12px;color:#64748b;margin-bottom:10px;">{{ auth()->user()->no_whatsapp ?? '-' }}</div>
                <div style="display:flex;align-items:flex-start;gap:6px;font-size:12px;color:#64748b;">
                    <i class="ti ti-info-circle" style="margin-top:1px;flex-shrink:0"></i>
                    Pastikan nomor WhatsApp aktif untuk menerima konfirmasi jadwal.
                </div>
            </div>
        </div>

        {{-- Flash errors --}}
        @if($errors->any())
        <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:12px;padding:12px 16px;margin-bottom:20px;">
            @foreach($errors->all() as $error)
            <p style="font-size:12px;color:#dc2626;display:flex;align-items:center;gap:6px;margin:0;">
                <i class="ti ti-alert-circle"></i> {{ $error }}
            </p>
            @endforeach
        </div>
        @endif

        {{-- Form --}}
        <form method="POST" action="{{ route('konsultasi.reservasi.store', $petugas->id) }}">
            @csrf

            {{-- Tanggal --}}
            <div style="display:flex;align-items:center;gap:16px;margin-bottom:18px;">
    <label style="width:160px;font-size:14px;font-weight:700;color:#1e293b;flex-shrink:0;">
        Tanggal :
    </label>

    <div style="position:relative;flex:1;">
        <input type="date" name="tanggal" min="{{ date('Y-m-d') }}" id="tanggal" value="{{ old('tanggal') }}"
            style="width:100%;border:1.5px solid #e2e8f0;border-radius:12px;padding:11px 40px 11px 14px;font-size:13px;color:#1e293b;font-family:'Plus Jakarta Sans',sans-serif;outline:none;background:#f8fafc;">

        <i class="ti ti-calendar"
            style="position:absolute;right:14px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:16px;"></i>

        {{-- 🔴 NOTIF VALIDASI TANGGAL --}}
        <p id="tanggal-error"
           style="font-size:12px;color:#dc2626;margin-top:6px;font-weight:bold;display:none;">
        </p>
    </div>
</div>

            {{-- Jam --}}
          <div style="display:flex;align-items:center;gap:16px;margin-bottom:18px;">
    <label style="width:160px;font-size:14px;font-weight:700;color:#1e293b;flex-shrink:0;">
        Jam :
    </label>

    <div style="position:relative;flex:1;">
        <input type="time" name="jam" id="jam" value="{{ old('jam') }}"
    min="08:00" max="15:30"
    style="width:100%;border:1.5px solid #e2e8f0;border-radius:12px;
    padding:11px 40px 11px 14px;font-size:13px;color:#1e293b;
    background:#f8fafc;font-family:'Plus Jakarta Sans',sans-serif;">
            
        <i class="ti ti-clock"
            style="position:absolute;right:14px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:16px;"></i>

        {{-- 🔴 NOTIF VALIDASI --}}
        <p id="jam-error"
           style="font-size:12px;color:#dc2626;margin-top:6px;font-weight:bold;display:none;">
            Jam yang dipilih tidak valid. Pilih jam antara 08.00-15.30 WITA
        </p>
    </div>
</div>

            {{-- Jenis Konsultasi --}}
            <div style="display:flex;align-items:center;gap:16px;margin-bottom:18px;">
                <label style="width:160px;font-size:14px;font-weight:700;color:#1e293b;flex-shrink:0;">Jenis Konsultasi :</label>
                <div style="position:relative;flex:1;">
                    <select name="jenis_konsultasi"
                        style="width:100%;border:1.5px solid #e2e8f0;border-radius:12px;padding:11px 40px 11px 14px;font-size:13px;color:#1e293b;font-family:'Plus Jakarta Sans',sans-serif;outline:none;background:#f8fafc;appearance:none;">
                        <option value="" disabled selected>online/offline</option>
                        <option value="online"  {{ old('jenis_konsultasi') == 'online'  ? 'selected' : '' }}>Online</option>
                        <option value="offline" {{ old('jenis_konsultasi') == 'offline' ? 'selected' : '' }}>Offline</option>
                    </select>
                    <i class="ti ti-chevron-down" style="position:absolute;right:14px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:16px;pointer-events:none;"></i>
                </div>
            </div>

            {{-- Topik Konsultasi --}}
            <div style="display:flex;align-items:flex-start;gap:16px;margin-bottom:28px;">
                <label style="width:160px;font-size:14px;font-weight:700;color:#1e293b;flex-shrink:0;padding-top:4px;">Topik Konsultasi :</label>
                <textarea name="topik_konsultasi" rows="5"
                    placeholder="Tuliskan topik atau pertanyaan yang ingin dikonsultasikan..."
                    style="flex:1;border:1.5px solid #e2e8f0;border-radius:12px;padding:12px 14px;font-size:13px;color:#1e293b;font-family:'Plus Jakarta Sans',sans-serif;outline:none;background:#f8fafc;resize:vertical;">{{ old('topik_konsultasi') }}</textarea>
            </div>

            {{-- Submit --}}
            <div style="text-align:center;">
                <button type="submit"
                    style="background:#1a56db;color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:14px;letter-spacing:.05em;padding:13px 48px;border-radius:12px;border:none;cursor:pointer;box-shadow:0 4px 16px rgba(26,86,219,.3);display:inline-flex;align-items:center;gap:8px;transition:all .2s;">
                    KIRIM <i class="ti ti-send"></i>
                </button>
            </div>
        </form>

    </div>
</section>

@include('partials.footer')

<script>
const blockedDates = @json($jadwalMap ?? []);
const tanggalInput = document.getElementById('tanggal');
const tanggalError = document.getElementById('tanggal-error');

tanggalInput.addEventListener('change', function() {
    const value = this.value;

    if (!value) {
        tanggalError.style.display = 'none';
        return;
    }

    const selected = new Date(value);
    const day = selected.getDay(); // 0 = Minggu, 6 = Sabtu

    // ❌ WEEKEND
    if (day === 0 || day === 6) {
        tanggalError.innerText = 'Hari yang dipilih tidak valid. Pilih hari kerja untuk reservasi konsultasi.';
        tanggalError.style.display = 'block';
        return;
    }

    // ❌ CEK DARI SISTEM
    if (blockedDates[value]) {
        const alasan = blockedDates[value].alasan;

        let pesan = '';

        if (alasan === 'Libur Nasional') {
            pesan = 'Hari yang dipilih tidak valid/hari libur nasional. Pilih hari kerja untuk reservasi konsultasi.';
        } else if (alasan === 'Cuti Bersama') {
            pesan = 'Tanggal ini tidak tersedia karena cuti bersama.';
        } else if (alasan === 'Cuti Pribadi') {
            pesan = 'Tanggal ini tidak tersedia karena petugas sedang cuti pribadi.';
        } else {
            pesan = 'Tanggal tidak tersedia untuk konsultasi.';
        }

        tanggalError.innerText = pesan;
        tanggalError.style.display = 'block';
        return;
    }

    // ✅ VALID
    tanggalError.style.display = 'none';
});


const jamInput = document.getElementById('jam');
const jamError = document.getElementById('jam-error');

jamInput.addEventListener('input', function () {
    const jam = this.value;

    if (!jam) {
        jamError.style.display = 'none';
        return;
    }

    if (jam < '08:00' || jam > '15:30') {
        jamError.style.display = 'block';
    } else {
        jamError.style.display = 'none';
    }
});
</script>
</body>
</html>