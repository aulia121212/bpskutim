<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\ReservasiKonsultasi;
use App\Models\RiwayatKonsultasi;



use Illuminate\Http\Request;

class PelayananController extends Controller
{
    public function petugas() {
    $petugas = \App\Models\Petugas::all();
    return view('pelayanan.petugas.index', compact('petugas'));
}

public function petugasCreate() {
    return view('pelayanan.petugas.create');
}

public function petugasStore(Request $request) {
    $request->validate([
        'nama_lengkap'    => 'required',
        'jabatan'         => 'required',
        'bidang_keahlian' => 'required|array|min:1',
    ]);

    // ✅ Pastikan pakai cara ini, bukan ->store()
    $foto = null;
    if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/petugas'), $filename);
        $foto = 'uploads/petugas/' . $filename;
    }

    \App\Models\Petugas::create([
        'nama_lengkap'    => $request->nama_lengkap,
        'nomor_wa'        => $request->nomor_wa,
        'instansi'        => $request->instansi,
        'jabatan'         => $request->jabatan,
        'bidang_keahlian' => $request->bidang_keahlian,
        'foto'            => $foto,
    ]);

    return redirect()->route('pelayanan.petugas.index')->with('success', 'Petugas berhasil ditambahkan.');
}
public function petugasDestroy($id) {
    \App\Models\Petugas::findOrFail($id)->delete();
    return redirect()->route('pelayanan.petugas.index')->with('success', 'Petugas berhasil dihapus.');
}

    
    // PelayananController.php
public function jadwal()
{
    $petugas = \App\Models\Petugas::all();
    $jadwal  = \App\Models\JadwalTidakTersedia::all();
    
    $jadwalMap = $jadwal->keyBy('tanggal')->map(fn($j) => [
        'judul'   => $j->judul,
        'alasan'  => $j->alasan,
        'petugas' => $j->petugas,
    ]);

    return view('pelayanan.jadwal', compact('petugas', 'jadwalMap'));
}

public function jadwalStore(Request $request)
{
    \App\Models\JadwalTidakTersedia::updateOrCreate(
        ['tanggal' => $request->tanggal],
        [
            'judul'   => $request->judul,
            'alasan'  => $request->alasan,
            'petugas' => $request->petugas,
        ]
    );
    return redirect()->route('pelayanan.jadwal.index');
}

    public function reservasi()
{
    $reservasi = ReservasiKonsultasi::with(['user', 'petugas', 'riwayatTerbaru'])
        ->latest('created_at')
        ->get();

    return view('pelayanan.reservasi.index', compact('reservasi'));
}

public function reservasiShow($id)
{
    $reservasi = ReservasiKonsultasi::with(['user', 'petugas', 'riwayatTerbaru'])
        ->findOrFail($id);

    return view('pelayanan.reservasi.show', compact('reservasi'));
}

    public function popup()
{
    $popups = \App\Models\PopupOverlay::latest()->get();
    return view('pelayanan.popup', compact('popups'));
}

public function reservasiUpdate(Request $request, $id)
{
    $reservasi = ReservasiKonsultasi::findOrFail($id);

    $request->validate([
        'status' => 'required|in:diajukan,dijadwalkan,dibatalkan',
        'lokasi_konsultasi' => 'nullable|string',
        'catatan_konsultasi' => 'nullable|string',
        'alasan_pembatalan' => 'nullable|string',
    ]);

    // update field utama
    $reservasi->update([
        'lokasi_konsultasi' => $request->lokasi_konsultasi,
    ]);

    // simpan ke riwayat (status + catatan)
    RiwayatKonsultasi::create([
        'id_reservasi' => $reservasi->id_reservasi,
        'status_pengajuan' => $request->status,
        'catatan_konsultasi' => $request->catatan_konsultasi,
        'alasan_pembatalan' => $request->alasan_pembatalan,
    ]);

    return back()->with('success', 'Reservasi berhasil diperbarui');
}

public function popupStore(Request $request)
{
    $request->validate([
        'foto'          => 'required|image|mimes:jpg,jpeg,png|max:2048',
        'tanggal_mulai' => 'required|date',
        'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
    ]);

    $foto = null;
    if ($request->hasFile('foto')) {
        $file     = $request->file('foto');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/popup'), $filename);
        $foto = 'uploads/popup/' . $filename;
    }

    \App\Models\PopupOverlay::create([
        'foto'          => $foto,
        'tanggal_mulai' => $request->tanggal_mulai,
        'tanggal_akhir' => $request->tanggal_akhir,
    ]);

    return redirect()->route('pelayanan.popup.index')->with('success', 'Pop up berhasil ditambahkan.');
}

public function popupDestroy($id)
{
    \App\Models\PopupOverlay::findOrFail($id)->delete();
    return redirect()->route('pelayanan.popup.index')->with('success', 'Pop up berhasil dihapus.');
}

   public function user()
{
    $users = User::where('role', User::ROLE_USER)->latest()->get();

    return view('pelayanan.user.index', compact('users'));
}

public function userShow($id)
{
    $user = User::findOrFail($id);

    return view('pelayanan.user.show', compact('user'));
}

public function userDestroy($id)
{
    $user = User::findOrFail($id);

    // Optional: cegah hapus super admin
    if ($user->role === 'super_admin') {
        return back()->with('error', 'Tidak bisa menghapus super admin');
    }

    $user->delete();

    return back()->with('success', 'User berhasil dihapus');
}
}