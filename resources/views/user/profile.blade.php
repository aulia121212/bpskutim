<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profil - BPS Kabupaten Kutai Timur</title>
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

</head>
<body>

@include('partials.navbar')

@php
$user = auth()->user();

$initials = collect(explode(' ', $user->name))
->map(fn($x) => strtoupper(substr($x,0,1)))
->take(2)
->implode('');
@endphp

<div class="page-wrap">

<div class="tab-bar">
<a href="#profil" class="tab-btn active" onclick="switchTab(event,'profil',this)">Profil</a>
<a href="#reservasi" class="tab-btn" onclick="switchTab(event,'reservasi',this)">Reservasi Konsultasi</a>
<a href="#riwayat" class="tab-btn" onclick="switchTab(event,'riwayat',this)">Riwayat Konsultasi</a>
</div>

{{-- PROFIL --}}
<div id="tab-profil" class="tab-content active">

<form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">
@csrf
@method('PATCH')

<div class="profile-grid">

<div class="profile-photo-card">

<div class="profile-avatar" id="avatarWrap">
@if($user->foto_profil)
<img src="{{ asset($user->foto_profil) }}?v={{ time() }}">
@else
<span class="avatar-initials">{{ $initials }}</span>
@endif
</div>

{{-- Form foto terpisah — POST ke updatePhoto, auto-submit --}}
<form method="POST" action="{{ route('user.profile.photo') }}"
      enctype="multipart/form-data" id="fotoForm">
    @csrf
    <input type="file" hidden id="fotoInput" name="foto" accept="image/*"
           onchange="document.getElementById('fotoForm').submit()">
</form>

<button type="button" class="profile-edit-btn"
        onclick="document.getElementById('fotoInput').click()">
    <i class="ti ti-pencil"></i> Edit Foto Profil
</button>

</div>

<div class="profile-form-card">

@if(session('success'))
<div style="background:#d1fae5;padding:12px;border-radius:10px;margin-bottom:15px;color:#065f46;font-size:13px;">
{{ session('success') }}
</div>
@endif

@if($errors->any())
<div style="background:#fee2e2;padding:12px;border-radius:10px;margin-bottom:15px;color:#991b1b;font-size:13px;">
@foreach($errors->all() as $err)
<div>{{ $err }}</div>
@endforeach
</div>
@endif

<div class="form-group">
<label class="form-label">Nama Lengkap <span>*</span></label>
<input type="text" name="name" class="form-input" value="{{ old('name',$user->name) }}">
</div>

<div class="form-row">
<div class="form-group">
<label class="form-label">Whatsapp</label>
<input type="text" name="no_whatsapp" class="form-input" value="{{ old('no_whatsapp',$user->no_whatsapp) }}">
</div>

<div class="form-group">
<label class="form-label">Email <span>*</span></label>
<input type="email" name="email" class="form-input" value="{{ old('email',$user->email) }}">
</div>
</div>

<div class="form-row">
<div class="form-group" id="current-password-wrap" style="display:none">
<label class="form-label">Password Saat Ini <span>*</span></label>
<div style="position:relative">
    <input type="password" name="current_password" id="current_password" class="form-input" placeholder="Masukkan password saat ini">
    <button type="button" onclick="togglePw('current_password','eye-current')" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#94a3b8">
        <i class="ti ti-eye" id="eye-current"></i>
    </button>
</div>
</div>

<div class="form-group">
<label class="form-label">Password Baru</label>
<div style="position:relative">
    <input type="password" name="new_password" id="new_password" class="form-input" placeholder="Kosongkan jika tidak ingin mengubah"
           oninput="toggleCurrentPwField(this)">
    <button type="button" onclick="togglePw('new_password','eye-new')" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#94a3b8">
        <i class="ti ti-eye" id="eye-new"></i>
    </button>
</div>
</div>

<div class="form-group">
<label class="form-label">Instansi</label>
<input type="text" name="instansi" class="form-input" value="{{ old('instansi',$user->instansi) }}">
</div>
</div>

<div class="form-group">
<label class="form-label">Alamat</label>
<input type="text" name="alamat" class="form-input" value="{{ old('alamat',$user->alamat) }}">
</div>

<div class="form-actions">
<button type="reset" class="btn-secondary">Batal</button>
<button type="submit" class="btn-primary">Simpan</button>
</div>

</div>
</div>
</form>
</div>

{{-- RESERVASI --}}
<div id="tab-reservasi" class="tab-content">
<h2 class="section-title-sm">Reservasi Konsultasi</h2>

@if($reservasi->isEmpty())
<div class="empty-state">
<i class="ti ti-calendar-off"></i>
<p>Belum ada reservasi.</p>
</div>
@else
<table class="konsultasi-table">
<thead>
<tr>
<th>Tanggal Konsultasi</th>
<th>Petugas</th>
<th>Status</th>
<th>Aksi</th>
</tr>
</thead>
<tbody>
@foreach($reservasi as $r)
@php $statusR = $r->riwayatTerbaru?->status_pengajuan ?? 'diajukan'; @endphp
<tr>
<td>{{ $r->tanggal_konsultasi ? \Carbon\Carbon::parse($r->tanggal_konsultasi)->format('d-m-Y') : '-' }}</td>
<td>{{ $r->petugas->nama_lengkap ?? '-' }}</td>
<td>
    <span class="badge badge-{{ $statusR }}">
        @if($statusR === 'diajukan') Menunggu Konfirmasi
        @elseif($statusR === 'dijadwalkan') Dijadwalkan
        @else {{ ucfirst($statusR) }}
        @endif
    </span>
</td>
<td>
<a href="{{ route('user.reservasi.detail',$r->id_reservasi) }}" class="btn-detail">Detail</a>
</td>
</tr>
@endforeach
</tbody>
</table>
@endif
</div>

{{-- RIWAYAT --}}
<div id="tab-riwayat" class="tab-content">
<h2 class="section-title-sm">Riwayat Konsultasi</h2>

@if($riwayat->isEmpty())
<div class="empty-state">
<i class="ti ti-history"></i>
<p>Belum ada riwayat.</p>
</div>
@else
<table class="konsultasi-table">
<thead>
<tr>
<th>Tanggal Konsultasi</th>
<th>Petugas</th>
<th>Status</th>
<th>Alasan / Catatan</th>
<th>Aksi</th>
</tr>
</thead>
<tbody>
@foreach($riwayat as $r)
@php $statusR = $r->riwayatTerbaru?->status_pengajuan ?? 'diajukan'; @endphp
<tr>
<td>{{ $r->tanggal_konsultasi ? \Carbon\Carbon::parse($r->tanggal_konsultasi)->format('d-m-Y') : '-' }}</td>
<td>{{ $r->petugas->nama_lengkap ?? '-' }}</td>
<td><span class="badge badge-{{ $statusR }}">{{ ucfirst($statusR) }}</span></td>
<td style="font-size:12px;color:#64748b;max-width:220px">
    @if($statusR === 'dibatalkan' && $r->riwayatTerbaru?->alasan_pembatalan)
        <span style="color:#dc2626"><i class="ti ti-circle-x" style="font-size:11px"></i>
        {{ \Illuminate\Support\Str::limit($r->riwayatTerbaru->alasan_pembatalan, 80) }}</span>
    @elseif($r->riwayatTerbaru?->catatan_konsultasi)
        {{ \Illuminate\Support\Str::limit($r->riwayatTerbaru->catatan_konsultasi, 80) }}
    @else
        -
    @endif
</td>
<td>
<a href="{{ route('user.reservasi.detail',$r->id_reservasi) }}" class="btn-detail">Detail</a>
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
function switchTab(event,name,el){
event.preventDefault();

document.querySelectorAll('.tab-content').forEach(x=>x.classList.remove('active'));
document.querySelectorAll('.tab-btn').forEach(x=>x.classList.remove('active'));

document.getElementById('tab-'+name).classList.add('active');
el.classList.add('active');
}

function toggleCurrentPwField(input) {
    const wrap = document.getElementById('current-password-wrap');
    if (input.value.length > 0) {
        wrap.style.display = 'block';
        wrap.querySelector('input').required = true;
    } else {
        wrap.style.display = 'none';
        wrap.querySelector('input').required = false;
        wrap.querySelector('input').value = '';
    }
}

function togglePw(fieldId, eyeId) {
    const field = document.getElementById(fieldId);
    const eye   = document.getElementById(eyeId);
    if (field.type === 'password') {
        field.type = 'text';
        eye.className = 'ti ti-eye-off';
    } else {
        field.type = 'password';
        eye.className = 'ti ti-eye';
    }
}

const hash = window.location.hash.replace('#','');
if(hash){
const btn = document.querySelector('.tab-btn[href="#'+hash+'"]');
if(btn){
switchTab(new Event('click'),hash,btn);
}
}
</script>

</body>
</html>