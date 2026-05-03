<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Detail Reservasi - BPS Kabupaten Kutai Timur</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Plus Jakarta Sans',sans-serif;background:#f8fafc;color:#1e293b}

.page-wrap{padding-top:72px;min-height:100vh}

.page-content{
    max-width:800px;
    margin:0 auto;
    padding:40px 24px;
}

/* BREADCRUMB */
.breadcrumb{
    display:flex;
    align-items:center;
    gap:8px;
    font-size:13px;
    color:#94a3b8;
    margin-bottom:24px;
}
.breadcrumb a{
    color:#035f9c;
    text-decoration:none;
    font-weight:600;
}
.breadcrumb a:hover{text-decoration:underline}
.breadcrumb i{font-size:12px}

/* HEADER CARD */
.header-card{
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:20px;
    padding:28px;
    margin-bottom:20px;
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:16px;
}

.header-left{
    display:flex;
    flex-direction:column;
    gap:8px;
}

.header-label{
    font-size:12px;
    font-weight:700;
    color:#94a3b8;
    text-transform:uppercase;
    letter-spacing:0.5px;
}

.header-id{
    font-family:'Playfair Display',serif;
    font-size:22px;
    font-weight:800;
    color:#1e293b;
}

.header-date{
    font-size:13px;
    color:#64748b;
    display:flex;
    align-items:center;
    gap:6px;
}

/* BADGE */
.badge{
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:8px 16px;
    border-radius:999px;
    font-size:12px;
    font-weight:700;
    flex-shrink:0;
}
.badge i{font-size:14px}
.badge-diajukan{background:#e8f0fe;color:#1a56db}
.badge-dijadwalkan{background:#d1fae5;color:#065f46}
.badge-dibatalkan{background:#fee2e2;color:#dc2626}
.badge-selesai{background:#d1fae5;color:#065f46}
.badge-menunggu{background:#fef9c3;color:#854d0e}

/* INFO GRID */
.info-card{
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:20px;
    padding:28px;
    margin-bottom:20px;
}

.info-card-title{
    font-size:13px;
    font-weight:700;
    color:#94a3b8;
    text-transform:uppercase;
    letter-spacing:0.5px;
    margin-bottom:18px;
    display:flex;
    align-items:center;
    gap:8px;
}

.info-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:16px;
}

.info-item{}

.info-item-label{
    font-size:11px;
    font-weight:700;
    color:#94a3b8;
    text-transform:uppercase;
    letter-spacing:0.4px;
    margin-bottom:4px;
}

.info-item-value{
    font-size:14px;
    font-weight:600;
    color:#1e293b;
}

.info-item-value.muted{
    color:#64748b;
    font-weight:400;
}

/* PETUGAS CARD */
.petugas-wrap{
    display:flex;
    align-items:center;
    gap:14px;
}

.petugas-avatar{
    width:48px;
    height:48px;
    border-radius:50%;
    background:#e8f0fe;
    border:2px solid #035f9c;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:16px;
    font-weight:800;
    color:#035f9c;
    flex-shrink:0;
    overflow:hidden;
}

.petugas-avatar img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.petugas-name{
    font-size:15px;
    font-weight:700;
    color:#1e293b;
}

.petugas-role{
    font-size:12px;
    color:#64748b;
    margin-top:2px;
}

/* RIWAYAT TIMELINE */
.timeline{
    display:flex;
    flex-direction:column;
    gap:0;
}

.timeline-item{
    display:flex;
    gap:16px;
    position:relative;
}

.timeline-line{
    display:flex;
    flex-direction:column;
    align-items:center;
    flex-shrink:0;
    width:32px;
}

.timeline-dot{
    width:12px;
    height:12px;
    border-radius:50%;
    background:#035f9c;
    border:2px solid #fff;
    box-shadow:0 0 0 2px #035f9c;
    flex-shrink:0;
    margin-top:3px;
}

.timeline-dot.done{background:#10b981;box-shadow:0 0 0 2px #10b981}
.timeline-dot.cancel{background:#ef4444;box-shadow:0 0 0 2px #ef4444}
.timeline-dot.pending{background:#f59e0b;box-shadow:0 0 0 2px #f59e0b}

.timeline-connector{
    width:2px;
    flex:1;
    background:#e2e8f0;
    margin:4px 0;
    min-height:24px;
}

.timeline-body{
    padding-bottom:24px;
    flex:1;
}

.timeline-item:last-child .timeline-body{
    padding-bottom:0;
}

.timeline-status{
    font-size:13px;
    font-weight:700;
    color:#1e293b;
    margin-bottom:3px;
}

.timeline-date{
    font-size:12px;
    color:#94a3b8;
    display:flex;
    align-items:center;
    gap:4px;
}

.timeline-catatan{
    margin-top:8px;
    background:#f8fafc;
    border:1px solid #e2e8f0;
    border-radius:10px;
    padding:10px 14px;
    font-size:13px;
    color:#475569;
    line-height:1.5;
}

/* KELUHAN */
.keluhan-box{
    background:#f8fafc;
    border:1px solid #e2e8f0;
    border-radius:12px;
    padding:16px;
    font-size:14px;
    color:#475569;
    line-height:1.6;
}

/* EMPTY */
.empty-riwayat{
    text-align:center;
    padding:32px;
    color:#94a3b8;
    font-size:13px;
}

/* ACTION */
.action-wrap{
    display:flex;
    justify-content:flex-start;
    margin-top:8px;
}

.btn-back{
    display:inline-flex;
    align-items:center;
    gap:8px;
    background:#fff;
    border:1.5px solid #e2e8f0;
    color:#1e293b;
    padding:10px 20px;
    border-radius:10px;
    font-size:13px;
    font-weight:700;
    text-decoration:none;
    transition:all .2s;
}

.btn-back:hover{
    border-color:#035f9c;
    color:#035f9c;
}

/* BATALKAN */
.batalkan-card{background:#fff;border:1.5px solid #fecaca;border-radius:20px;padding:28px;margin-bottom:20px}
.batalkan-title{font-size:14px;font-weight:700;color:#dc2626;margin-bottom:16px;display:flex;align-items:center;gap:8px}
.checkbox-list{display:flex;flex-direction:column;gap:10px;margin-bottom:16px}
.checkbox-item{display:flex;align-items:flex-start;gap:10px;cursor:pointer}
.checkbox-item input[type=checkbox]{width:16px;height:16px;margin-top:2px;accent-color:#dc2626;flex-shrink:0;cursor:pointer}
.checkbox-item-label{font-size:13px;color:#374151;font-weight:500;line-height:1.4}
.checkbox-item-label small{display:block;font-size:11px;color:#94a3b8;font-weight:400;margin-top:1px}
.other-input{width:100%;border:1.5px solid #fecaca;border-radius:10px;padding:10px 14px;font-size:13px;font-family:'Plus Jakarta Sans',sans-serif;resize:none;outline:none;margin-top:8px;display:none}
.other-input:focus{border-color:#dc2626}
.btn-batalkan{width:100%;background:#dc2626;color:#fff;border:none;padding:12px;border-radius:12px;font-size:14px;font-weight:700;cursor:pointer;transition:.2s;display:flex;align-items:center;justify-content:center;gap:8px;font-family:'Plus Jakarta Sans',sans-serif;margin-top:12px}
.btn-batalkan:hover{background:#b91c1c}
.btn-batalkan:disabled{background:#fca5a5;cursor:not-allowed}

@media(max-width:640px){
    .info-grid{grid-template-columns:1fr}
    .header-card{flex-direction:column}
    .page-content{padding:24px 16px}
}
</style>
</head>
<body>

@include('partials.navbar')

<div class="page-wrap">
<div class="page-content">

    {{-- BREADCRUMB --}}
    <div class="breadcrumb">
        <a href="{{ route('user.profile') }}">Profil</a>
        <i class="ti ti-chevron-right"></i>
        <span>Detail Reservasi</span>
    </div>

    {{-- HEADER --}}
    <div class="header-card">
        <div class="header-left">
            <span class="header-label">Reservasi Konsultasi</span>
            <span class="header-id">#{{ str_pad($reservasi->id_reservasi, 4, '0', STR_PAD_LEFT) }}</span>
            <span class="header-date">
                <i class="ti ti-calendar"></i>
                {{ \Carbon\Carbon::parse($reservasi->tanggal)->translatedFormat('l, d F Y') }}
            </span>
        </div>

        @php
            $latestStatus   = $statusTerbaru;
            $riwayatTerbaru = $reservasi->riwayat->sortByDesc(fn($r) => $r->getKey())->first();
        @endphp

        <span class="badge badge-{{ $latestStatus }}">
            @if($latestStatus === 'diajukan')       <i class="ti ti-clock"></i> Diajukan
            @elseif($latestStatus === 'dijadwalkan') <i class="ti ti-calendar-check"></i> Dijadwalkan
            @elseif($latestStatus === 'selesai')     <i class="ti ti-circle-check"></i> Selesai
            @elseif($latestStatus === 'dibatalkan')  <i class="ti ti-circle-x"></i> Dibatalkan
            @else                                    <i class="ti ti-info-circle"></i> {{ ucfirst($latestStatus) }}
            @endif
        </span>
    </div>

    {{-- INFO RESERVASI --}}
    <div class="info-card">
        <div class="info-card-title">
            <i class="ti ti-info-circle" style="color:#035f9c"></i>
            Informasi Reservasi
        </div>

        <div class="info-grid">
            <div class="info-item">
                <div class="info-item-label">Tanggal Reservasi</div>
                <div class="info-item-value">
                    {{ \Carbon\Carbon::parse($reservasi->tanggal)->translatedFormat('d F Y') }}
                </div>
            </div>

            @if($reservasi->jam ?? $reservasi->waktu ?? null)
            <div class="info-item">
                <div class="info-item-label">Waktu</div>
                <div class="info-item-value">
                    {{ $reservasi->jam ?? $reservasi->waktu }}
                </div>
            </div>
            @endif

            @if($reservasi->lokasi_konsultasi)
<div class="info-item">
    <div class="info-item-label">Lokasi Konsultasi</div>
    <div class="info-item-value">
        {{ $reservasi->lokasi_konsultasi }}
    </div>
</div>
@endif

           @if(
    $reservasi->topik_diskusi 
    ?? $reservasi->topik_konsultasi 
    ?? $reservasi->topik 
    ?? null
)
<div class="info-item">
    <div class="info-item-label">Topik Konsultasi</div>
    <div class="info-item-value">
        {{ 
            $reservasi->topik_diskusi 
            ?? $reservasi->topik_konsultasi 
            ?? $reservasi->topik 
        }}
    </div>
</div>
@endif

            <div class="info-item">
                <div class="info-item-label">Tanggal Pengajuan</div>
                <div class="info-item-value muted">
                    {{ \Carbon\Carbon::parse($reservasi->created_at)->translatedFormat('d F Y, H:i') }}
                </div>
            </div>
        </div>

        {{-- Keluhan / Pertanyaan --}}
        @if($reservasi->keluhan ?? $reservasi->pertanyaan ?? $reservasi->deskripsi ?? null)
        <div style="margin-top:20px">
            <div class="info-item-label" style="margin-bottom:8px">Keluhan / Pertanyaan</div>
            <div class="keluhan-box">
                {{ $reservasi->keluhan ?? $reservasi->pertanyaan ?? $reservasi->deskripsi }}
            </div>
        </div>
        @endif
    </div>

    {{-- PETUGAS --}}
    <div class="info-card">
        <div class="info-card-title">
            <i class="ti ti-user-check" style="color:#035f9c"></i>
            Petugas Konsultasi
        </div>

        @if($reservasi->petugas)
        <div class="petugas-wrap">
            <div class="petugas-avatar">
                @if($reservasi->petugas->foto ?? null)
                    <img src="{{ asset($reservasi->petugas->foto) }}">
                @else
                    {{ strtoupper(substr($reservasi->petugas->nama_lengkap ?? 'P', 0, 1)) }}
                @endif
            </div>
            <div>
                <div class="petugas-name">{{ $reservasi->petugas->nama_lengkap ?? '-' }}</div>
                @if($reservasi->petugas->jabatan ?? null)
                <div class="petugas-role">{{ $reservasi->petugas->jabatan }}</div>
                @endif
                @if($reservasi->petugas->no_hp ?? null)
                <div class="petugas-role" style="margin-top:4px">
                    <i class="ti ti-phone" style="font-size:11px"></i>
                    {{ $reservasi->petugas->no_hp }}
                </div>
                @endif
            </div>
        </div>
        @else
        <p style="font-size:13px;color:#94a3b8">Petugas belum ditentukan.</p>
        @endif
    </div>

    {{-- RIWAYAT STATUS --}}
    <div class="info-card">
        <div class="info-card-title">
            <i class="ti ti-history" style="color:#035f9c"></i>
            Riwayat Status
        </div>

        @if($reservasi->riwayat && $reservasi->riwayat->count() > 0)
        <div class="timeline">
            @foreach($reservasi->riwayat->sortBy(fn($r) => $r->getKey()) as $r)
            @php
                $status = $r->status_pengajuan ?? $r->status ?? '';
                $dotClass = match($status) {
                    'selesai'     => 'done',
                    'dibatalkan'  => 'cancel',
                    'dijadwalkan' => 'done',
                    'diajukan'    => 'pending',
                    default       => ''
                };
                $isLast = $loop->last;
            @endphp
            <div class="timeline-item">
                <div class="timeline-line">
                    <div class="timeline-dot {{ $dotClass }}"></div>
                    @if(!$isLast)
                    <div class="timeline-connector"></div>
                    @endif
                </div>
                <div class="timeline-body">
                    <div class="timeline-status">
                        @if($status === 'diajukan')       Reservasi Diajukan
                        @elseif($status === 'dijadwalkan') Dijadwalkan
                        @elseif($status === 'selesai')     Konsultasi Selesai
                        @elseif($status === 'dibatalkan')  Dibatalkan
                        @else {{ ucfirst($status) }}
                        @endif
                    </div>
                    <div class="timeline-date">
                        <i class="ti ti-clock"></i>
                        {{ $r->updated_at ? \Carbon\Carbon::parse($r->updated_at)->translatedFormat('d F Y, H:i') : '-' }}
                    </div>
                    @if($r->catatan_konsultasi ?? null)
                    <div class="timeline-catatan">
                        <i class="ti ti-notes" style="margin-right:4px;opacity:.6"></i>{{ $r->catatan_konsultasi }}
                    </div>
                    @endif
                    @if($status === 'dibatalkan' && ($r->alasan_pembatalan ?? null))
                    <div class="timeline-catatan" style="border-color:#fecaca;background:#fff9f9;color:#991b1b;margin-top:6px">
                        <i class="ti ti-alert-circle" style="margin-right:4px"></i><strong>Alasan:</strong> {{ $r->alasan_pembatalan }}
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-riwayat">
            <i class="ti ti-history" style="font-size:32px;display:block;margin-bottom:8px"></i>
            Belum ada riwayat status.
        </div>
        @endif
    </div>

    {{-- ALASAN PEMBATALAN DARI ADMIN --}}
    @if($latestStatus === 'dibatalkan' && $riwayatTerbaru?->alasan_pembatalan)
    <div class="info-card" style="border-color:#fecaca">
        <div class="info-card-title" style="color:#dc2626">
            <i class="ti ti-circle-x"></i> Alasan Pembatalan
        </div>
        <div style="background:#fff9f9;border:1px solid #fecaca;border-radius:12px;padding:14px 16px;font-size:14px;color:#991b1b;line-height:1.6;white-space:pre-line">{{ $riwayatTerbaru->alasan_pembatalan }}</div>
    </div>
    @endif

    {{-- BATALKAN — hanya jika controller bilang bisa --}}
    @if($bisaBatalkan)
    <div class="batalkan-card">
        <div class="batalkan-title">
            <i class="ti ti-alert-triangle"></i> Batalkan Reservasi
        </div>

        <form method="POST" action="{{ route('user.reservasi.batalkan', $reservasi->id_reservasi) }}" id="batalkanForm">
            @csrf
            @method('PATCH')
            <input type="hidden" name="alasan_pembatalan" id="alasanFinal">

            <p style="font-size:13px;color:#64748b;margin-bottom:14px">Pilih alasan pembatalan:</p>

            <div class="checkbox-list">
                @foreach([
                    ['val' => 'Jadwal bentrok dengan kegiatan lain',     'desc' => 'Saya memiliki kegiatan lain yang tidak bisa ditinggalkan.'],
                    ['val' => 'Data atau informasi belum siap',          'desc' => 'Saya belum memiliki data atau dokumen yang diperlukan.'],
                    ['val' => 'Pertanyaan sudah terjawab',               'desc' => 'Saya telah menemukan jawaban dari sumber atau layanan lain.'],
                    ['val' => 'Kondisi kesehatan tidak memungkinkan',    'desc' => 'Saya atau anggota keluarga sedang sakit sehingga tidak dapat hadir.'],
                    ['val' => 'Ingin mengubah jadwal',                   'desc' => 'Saya ingin membuat reservasi baru dengan waktu yang lebih sesuai.'],
                ] as $opsi)
                <label class="checkbox-item">
                    <input type="checkbox" name="alasan_check" value="{{ $opsi['val'] }}" onchange="updateBtnState()">
                    <span class="checkbox-item-label">{{ $opsi['val'] }}
                        <small>{{ $opsi['desc'] }}</small>
                    </span>
                </label>
                @endforeach

                <label class="checkbox-item">
                    <input type="checkbox" name="alasan_check" value="__other__" id="otherCheck" onchange="toggleOther(this)">
                    <span class="checkbox-item-label">Alasan lainnya
                        <small>Tuliskan alasan Anda secara spesifik.</small>
                    </span>
                </label>
            </div>

            <textarea id="otherText" class="other-input" rows="3"
                placeholder="Tuliskan alasan pembatalan Anda..." oninput="updateBtnState()"></textarea>

            @if($errors->has('alasan_pembatalan'))
            <p style="color:#dc2626;font-size:12px;margin-top:6px">{{ $errors->first('alasan_pembatalan') }}</p>
            @endif

            <button type="button" class="btn-batalkan" id="btnBatalkan" disabled onclick="submitBatalkan()">
                <i class="ti ti-circle-x"></i> Konfirmasi Pembatalan
            </button>
        </form>
    </div>
    @endif

    {{-- BACK --}}
    <div class="action-wrap">
        <a href="{{ route('user.profile') }}#{{ in_array($latestStatus, ['selesai','dibatalkan']) ? 'riwayat' : 'reservasi' }}"
           class="btn-back">
            <i class="ti ti-arrow-left"></i> Kembali ke Profil
        </a>
    </div>

</div>
</div>

@include('partials.footer')

<script>
function updateBtnState() {
    const checks = [...document.querySelectorAll('input[name="alasan_check"]:checked')];
    const otherCb  = document.getElementById('otherCheck');
    const otherTxt = document.getElementById('otherText');
    let valid = checks.some(cb => cb.value !== '__other__');
    if (otherCb?.checked && otherTxt?.value.trim()) valid = true;
    document.getElementById('btnBatalkan').disabled = !valid;
}

function toggleOther(cb) {
    const txt = document.getElementById('otherText');
    txt.style.display = cb.checked ? 'block' : 'none';
    if (!cb.checked) txt.value = '';
    updateBtnState();
}

function submitBatalkan() {
    const checks = [...document.querySelectorAll('input[name="alasan_check"]:checked')];
    if (!checks.length) return;

    let list = checks
        .filter(cb => cb.value !== '__other__')
        .map(cb => '• ' + cb.value);

    const otherCb  = document.getElementById('otherCheck');
    const otherTxt = document.getElementById('otherText').value.trim();
    if (otherCb?.checked) {
        if (!otherTxt) {
            document.getElementById('otherText').style.borderColor = '#dc2626';
            document.getElementById('otherText').focus();
            return;
        }
        list.push('• ' + otherTxt);
    }

    const alasan = list.join('\n');
    if (!confirm('Yakin ingin membatalkan reservasi ini?\n\nAlasan:\n' + alasan)) return;

    document.getElementById('alasanFinal').value = alasan;
    document.getElementById('batalkanForm').submit();
}
</script>

</body>
</html>