<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profil - BPS Kabupaten Kutai Timur</title>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

<style>
*{margin:0;padding:0;box-sizing:border-box}
body{
    font-family:'Plus Jakarta Sans',sans-serif;
    background:#f8fafc;
    color:#1e293b;
}

.page-wrap{
    padding-top:72px;
    min-height:100vh;
}

/* TAB */
.tab-bar{
    background:#fff;
    border-bottom:1px solid #e2e8f0;
    display:flex;
    gap:4px;
    padding:0 48px;
    position:sticky;
    top:72px;
    z-index:100;
}

.tab-btn{
    padding:18px 24px;
    text-decoration:none;
    font-size:14px;
    font-weight:700;
    color:#64748b;
    border-bottom:2px solid transparent;
}

.tab-btn.active,
.tab-btn:hover{
    color:#1a56db;
    border-bottom-color:#1a56db;
}

.tab-content{
    display:none;
    padding:40px 48px;
    max-width:1100px;
    margin:auto;
}

.tab-content.active{
    display:block;
}

/* PROFILE */
.profile-grid{
    display:grid;
    grid-template-columns:280px 1fr;
    gap:24px;
    align-items:start;
}

.profile-photo-card{
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:20px;
    padding:28px;
    display:flex;
    flex-direction:column;
    align-items:center;
    gap:16px;
}

.profile-avatar{
    width:120px;
    height:120px;
    border-radius:50%;
    overflow:hidden;
    background:#e8f0fe;
    border:3px solid #035f9c;
    display:flex;
    align-items:center;
    justify-content:center;
}

.profile-avatar img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.avatar-initials{
    font-size:34px;
    font-weight:800;
    color:#035f9c;
}

.profile-edit-btn{
    background:#035f9c;
    color:#fff;
    border:none;
    padding:10px 16px;
    border-radius:10px;
    cursor:pointer;
    font-size:13px;
    font-weight:700;
}

.profile-edit-btn:hover{
    background:#024a7a;
}

.profile-form-card{
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:20px;
    padding:28px;
}

.form-group{margin-bottom:16px;}

.form-row{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:16px;
}

.form-label{
    display:block;
    font-size:12px;
    font-weight:700;
    margin-bottom:6px;
    color:#334155;
}

.form-label span{color:#ef4444;}

.form-input{
    width:100%;
    border:1.5px solid #e2e8f0;
    border-radius:10px;
    padding:10px 14px;
    font-size:13px;
    background:#f8fafc;
}

.form-input:focus{
    outline:none;
    border-color:#1a56db;
    background:#fff;
}

.form-actions{
    display:flex;
    justify-content:flex-end;
    gap:10px;
    margin-top:18px;
}

.btn-primary{
    background:#1a56db;
    color:#fff;
    border:none;
    padding:10px 22px;
    border-radius:10px;
    cursor:pointer;
    font-weight:700;
}

.btn-secondary{
    background:#fff;
    border:1px solid #e2e8f0;
    padding:10px 22px;
    border-radius:10px;
    cursor:pointer;
    font-weight:700;
}

/* TABLE */
.konsultasi-table{
    width:100%;
    border-collapse:collapse;
    background:#fff;
    border-radius:16px;
    overflow:hidden;
    border:1px solid #e2e8f0;
}

.konsultasi-table th{
    background:#f8fafc;
    padding:14px;
    text-align:left;
    font-size:12px;
}

.konsultasi-table td{
    padding:14px;
    border-top:1px solid #f1f5f9;
    font-size:13px;
}

.badge{
    padding:5px 12px;
    border-radius:999px;
    font-size:11px;
    font-weight:700;
}

.badge-diajukan{background:#e8f0fe;color:#1a56db;}
.badge-dijadwalkan{background:#d1fae5;color:#065f46;}
.badge-dibatalkan{background:#fee2e2;color:#dc2626;}
.badge-selesai{background:#d1fae5;color:#065f46;}

.btn-detail{
    background:#f1f5f9;
    padding:7px 12px;
    border-radius:8px;
    text-decoration:none;
    color:#1e293b;
    font-size:12px;
    font-weight:700;
}

.empty-state{
    text-align:center;
    padding:60px 20px;
    color:#94a3b8;
}

.empty-state i{
    font-size:46px;
    display:block;
    margin-bottom:10px;
}

.section-title-sm{
    font-family:'Playfair Display',serif;
    font-size:24px;
    margin-bottom:18px;
}

@media(max-width:900px){
.profile-grid{
    grid-template-columns:1fr;
}
.form-row{
    grid-template-columns:1fr;
}
.tab-bar{
    overflow:auto;
    padding:0 20px;
}
.tab-content{
    padding:30px 20px;
}
}
</style>
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
<div class="form-group">
<label class="form-label">Password Baru</label>
<input type="password" name="new_password" class="form-input">
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

{{-- Form foto di LUAR form utama — nested form tidak diizinkan browser --}}
<form method="POST" action="{{ route('user.profile.photo') }}"
      enctype="multipart/form-data" id="fotoForm" style="display:none">
    @csrf
    <input type="file" id="fotoInput" name="foto" accept="image/*"
           onchange="document.getElementById('fotoForm').submit()">
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
<th>Tanggal</th>
<th>Petugas</th>
<th>Status</th>
<th>Aksi</th>
</tr>
</thead>
<tbody>
@foreach($reservasi as $r)
<tr>
<td>{{ \Carbon\Carbon::parse($r->tanggal)->format('d-m-Y') }}</td>
<td>{{ $r->petugas->nama_lengkap ?? '-' }}</td>
<td><span class="badge badge-{{ $r->status }}">{{ ucfirst($r->status) }}</span></td>
<td>
<a href="{{ route('user.reservasi.detail',$r->id_reservasi) }}" class="btn-detail">
Detail
</a>
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
<th>Tanggal</th>
<th>Petugas</th>
<th>Status</th>
<th>Aksi</th>
</tr>
</thead>
<tbody>
@foreach($riwayat as $r)
<tr>
<td>{{ \Carbon\Carbon::parse($r->tanggal)->format('d-m-Y') }}</td>
<td>{{ $r->petugas->nama_lengkap ?? '-' }}</td>
<td><span class="badge badge-{{ $r->status }}">{{ ucfirst($r->status) }}</span></td>
<td>
<a href="{{ route('user.reservasi.detail',$r->id_reservasi) }}" class="btn-detail">
Detail
</a>
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