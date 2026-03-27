<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - BPS Kabupaten Kutai Timur</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Plus Jakarta Sans',sans-serif;background:#f8fafc;color:#1e293b}

        .page-wrap{padding-top:72px;min-height:100vh}

        /* TAB BAR */
        .tab-bar{background:#fff;border-bottom:1px solid #e2e8f0;padding:0 48px;display:flex;gap:4px;position:sticky;top:72px;z-index:100}
        .tab-btn{padding:18px 24px;font-size:14px;font-weight:600;color:#64748b;border:none;background:none;cursor:pointer;border-bottom:2px solid transparent;transition:all .2s;text-decoration:none;display:inline-block}
        .tab-btn:hover{color:#1a56db}
        .tab-btn.active{color:#1a56db;border-bottom-color:#1a56db}

        /* TAB CONTENT */
        .tab-content{display:none;padding:40px 48px;max-width:1100px;margin:0 auto}
        .tab-content.active{display:block}

        /* PROFIL TAB */
        .profile-grid{display:grid;grid-template-columns:280px 1fr;gap:24px;align-items:start}

        .profile-photo-card{background:#fff;border:1px solid #e2e8f0;border-radius:20px;padding:28px;text-align:center}
        .profile-avatar{width:90px;height:90px;border-radius:50%;background:linear-gradient(135deg,#dbeafe,#93c5fd);display:flex;align-items:center;justify-content:center;margin:0 auto 12px;overflow:hidden;font-size:40px}
        .profile-avatar img{width:100%;height:100%;object-fit:cover}
        .profile-edit-btn{display:inline-flex;align-items:center;gap:6px;font-size:12px;font-weight:600;color:#1a56db;cursor:pointer;background:none;border:none;margin-top:4px}

        .profile-form-card{background:#fff;border:1px solid #e2e8f0;border-radius:20px;padding:28px}
        .form-group{margin-bottom:16px}
        .form-label{display:block;font-size:12.5px;font-weight:700;color:#334155;margin-bottom:6px}
        .form-label span{color:#ef4444}
        .form-input{width:100%;border:1.5px solid #e2e8f0;border-radius:10px;padding:10px 14px;font-size:13px;color:#1e293b;font-family:'Plus Jakarta Sans',sans-serif;outline:none;transition:border-color .2s,box-shadow .2s;background:#f8fafc}
        .form-input:focus{border-color:#1a56db;box-shadow:0 0 0 3px rgba(26,86,219,.1);background:#fff}
        .form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px}

        .btn-primary{background:#1a56db;color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;padding:10px 24px;border-radius:10px;border:none;cursor:pointer;transition:all .2s}
        .btn-primary:hover{background:#1341b0}
        .btn-secondary{background:#fff;color:#1e293b;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:13px;padding:10px 24px;border-radius:10px;border:1.5px solid #e2e8f0;cursor:pointer;transition:all .2s}
        .btn-secondary:hover{border-color:#1a56db;color:#1a56db}
        .form-actions{display:flex;gap:10px;justify-content:flex-end;margin-top:20px}

        /* RESERVASI & RIWAYAT TAB */
        .konsultasi-table{width:100%;border-collapse:collapse;background:#fff;border-radius:16px;overflow:hidden;border:1px solid #e2e8f0}
        .konsultasi-table th{background:#f8fafc;padding:14px 20px;font-size:12px;font-weight:700;color:#64748b;text-align:left;border-bottom:1px solid #e2e8f0}
        .konsultasi-table td{padding:14px 20px;font-size:13px;color:#1e293b;border-bottom:1px solid #f1f5f9}
        .konsultasi-table tr:last-child td{border-bottom:none}
        .konsultasi-table tr:hover td{background:#f8fafc}

        .badge{display:inline-flex;align-items:center;padding:4px 12px;border-radius:999px;font-size:11px;font-weight:700}
        .badge-diajukan{background:#e8f0fe;color:#1a56db}
        .badge-dijadwalkan{background:#d1fae5;color:#065f46}
        .badge-dibatalkan{background:#fee2e2;color:#dc2626}
        .badge-selesai{background:#d1fae5;color:#065f46}

        .btn-detail{background:#f1f5f9;color:#64748b;border:none;border-radius:8px;padding:6px 14px;font-size:12px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-block;transition:all .2s}
        .btn-detail:hover{background:#e8f0fe;color:#1a56db}

        .section-title-sm{font-family:'Playfair Display',serif;font-size:24px;font-weight:800;color:#1e293b;margin-bottom:20px}

        .empty-state{text-align:center;padding:60px 20px;color:#94a3b8}
        .empty-state i{font-size:48px;display:block;margin-bottom:12px}
        .empty-state p{font-size:14px}
    </style>
</head>
<body>

@include('partials.navbar')

<div class="page-wrap">

    {{-- TAB BAR --}}
    <div class="tab-bar">
        <a href="#profil"     class="tab-btn active"  onclick="switchTab('profil',this)">Profil</a>
        <a href="#reservasi"  class="tab-btn"         onclick="switchTab('reservasi',this)">Reservasi Konsultasi</a>
        <a href="#riwayat"    class="tab-btn"         onclick="switchTab('riwayat',this)">Riwayat Konsultasi</a>
    </div>

    {{-- ── TAB PROFIL ── --}}
    <div id="tab-profil" class="tab-content active">
        <div class="profile-grid">

            {{-- Foto --}}
            <div class="profile-photo-card">
                <div class="profile-avatar">
                    @if(auth()->user()->foto)
                        <img src="{{ asset(auth()->user()->foto) }}" alt="Foto Profil">
                    @else
                        🧑‍💼
                    @endif
                </div>
                <form method="POST" action="{{ route('user.profile.photo') }}" enctype="multipart/form-data" id="photoForm">
                    @csrf @method('PATCH')
                    <input type="file" name="foto" id="fotoInput" accept="image/*" style="display:none" onchange="document.getElementById('photoForm').submit()">
                    <button type="button" class="profile-edit-btn" onclick="document.getElementById('fotoInput').click()">
                        <i class="ti ti-pencil"></i> Edit Foto Profil
                    </button>
                </form>
            </div>

            {{-- Form --}}
            <div class="profile-form-card">
                @if(session('success'))
                <div style="background:#d1fae5;border:1px solid #6ee7b7;border-radius:10px;padding:10px 14px;margin-bottom:16px;font-size:13px;color:#065f46;display:flex;align-items:center;gap:8px;">
                    <i class="ti ti-circle-check"></i> {{ session('success') }}
                </div>
                @endif

                <form method="POST" action="{{ route('user.profile.update') }}">
                    @csrf @method('PATCH')

                    <div class="form-group">
                        <label class="form-label">Nama Lengkap <span>*</span></label>
                        <input type="text" name="name" class="form-input" value="{{ old('name', auth()->user()->name) }}">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Nomor Whatsapp <span>*</span></label>
                            <input type="text" name="no_whatsapp" class="form-input" value="{{ old('no_whatsapp', auth()->user()->no_whatsapp) }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">E-Mail <span>*</span></label>
                            <input type="email" name="email" class="form-input" value="{{ old('email', auth()->user()->email) }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Kata Sandi <span>*</span></label>
                        <input type="password" name="password" class="form-input" placeholder="Kosongkan jika tidak ingin mengubah">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Asal Instansi</label>
                            <input type="text" name="instansi" class="form-input" value="{{ old('instansi', auth()->user()->instansi) }}">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Alamat</label>
                            <input type="text" name="alamat" class="form-input" value="{{ old('alamat', auth()->user()->alamat) }}">
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="reset" class="btn-secondary">Batal</button>
                        <button type="submit" class="btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ── TAB RESERVASI ── --}}
    <div id="tab-reservasi" class="tab-content">
        <h2 class="section-title-sm">Reservasi Konsultasi</h2>

        @if($reservasi->isEmpty())
        <div class="empty-state">
            <i class="ti ti-calendar-off"></i>
            <p>Belum ada reservasi konsultasi.</p>
        </div>
        @else
        <table class="konsultasi-table">
            <thead>
                <tr>
                    <th>Tanggal Reservasi</th>
                    <th>Nama Petugas</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservasi as $r)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($r->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $r->petugas->nama_lengkap ?? '-' }}</td>
                    <td>
                        <span class="badge badge-{{ $r->status }}">
                            {{ ucfirst($r->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('user.reservasi.detail', $r->id) }}" class="btn-detail">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- ── TAB RIWAYAT ── --}}
    <div id="tab-riwayat" class="tab-content">
        <h2 class="section-title-sm">Riwayat Konsultasi</h2>

        @if($riwayat->isEmpty())
        <div class="empty-state">
            <i class="ti ti-history"></i>
            <p>Belum ada riwayat konsultasi.</p>
        </div>
        @else
        <table class="konsultasi-table">
            <thead>
                <tr>
                    <th>Tanggal Reservasi</th>
                    <th>Nama Petugas</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($riwayat as $r)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($r->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $r->petugas->nama_lengkap ?? '-' }}</td>
                    <td>
                        <span class="badge badge-{{ $r->status }}">
                            {{ ucfirst($r->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('user.reservasi.detail', $r->id) }}" class="btn-detail">Detail</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

</div>

@include('partials.footer')

<script>
function switchTab(name, el) {
    event.preventDefault();
    document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + name).classList.add('active');
    el.classList.add('active');
}

// Auto-switch tab dari URL hash
const hash = window.location.hash.replace('#','');
if (hash) {
    const btn = document.querySelector(`.tab-btn[href="#${hash}"]`);
    if (btn) switchTab(hash, btn);
}
</script>
</body>
</html>