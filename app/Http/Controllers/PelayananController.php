<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\ReservasiKonsultasi;
use App\Models\RiwayatKonsultasi;
use Carbon\Carbon;
use App\Models\Petugas;
use Illuminate\Support\Facades\File;


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
        // 'instansi'        => $request->instansi,
        'jabatan'         => $request->jabatan,
        'bidang_keahlian' => $request->bidang_keahlian,
        'foto'            => $foto,
    ]);

    return redirect()->route('pelayanan.petugas.index')->with('success', 'Petugas berhasil ditambahkan.');
}

public function petugasEdit($id)
{
    $petugas = Petugas::findOrFail($id);

    return view('pelayanan.petugas.edit', compact('petugas'));
}

 public function petugasUpdate(Request $request, $id)
{
    $petugas = Petugas::findOrFail($id);

    $request->validate([
        'nama_lengkap'    => 'required|string|max:255',
        'nomor_wa'        => 'nullable|digits_between:1,13',
        // 'instansi'        => 'nullable|string|max:255',
        'jabatan'         => 'required|string|max:255',
        'bidang_keahlian' => 'required|array|min:1',
        'foto'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // upload foto baru
    if ($request->hasFile('foto')) {

        // hapus foto lama
        if ($petugas->foto && File::exists(public_path($petugas->foto))) {
            File::delete(public_path($petugas->foto));
        }

        $file = $request->file('foto');
        $filename = time() . '_' . $file->getClientOriginalName();

        $file->move(public_path('uploads/petugas'), $filename);

        $petugas->foto = 'uploads/petugas/' . $filename;
    }

    // update data
    $petugas->nama_lengkap = $request->nama_lengkap;
    $petugas->nomor_wa = $request->nomor_wa;
    // $petugas->instansi = $request->instansi;
    $petugas->jabatan = $request->jabatan;
    $petugas->bidang_keahlian = $request->bidang_keahlian;

    $petugas->save();

    return redirect()
        ->route('pelayanan.petugas.index')
        ->with('success', 'Petugas berhasil diperbarui.');
}

public function petugasShow($id)
{
    $petugas = Petugas::findOrFail($id);

    return view('pelayanan.petugas.show', compact('petugas'));
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

// public function reservasiShow($id)
// {
//     $reservasi = ReservasiKonsultasi::with(['user', 'petugas', 'riwayatTerbaru'])
//         ->findOrFail($id);

//     return view('pelayanan.reservasi.show', compact('reservasi'));
// }

    public function popup()
{
    $popups = \App\Models\PopupOverlay::latest()->get();
    return view('pelayanan.popup', compact('popups'));
}

// public function reservasiUpdate(Request $request, $id)
// {
//     $reservasi = ReservasiKonsultasi::findOrFail($id);

//     $request->validate([
//         'status' => 'required|in:diajukan,dijadwalkan,dibatalkan',
//         'lokasi_konsultasi' => 'nullable|string',
//         'catatan_konsultasi' => 'nullable|string',
//         'alasan_pembatalan' => 'nullable|string',
//     ]);

//     // update field utama
//     $reservasi->update([
//         'lokasi_konsultasi' => $request->lokasi_konsultasi,
//     ]);

//     // simpan ke riwayat (status + catatan)
//     RiwayatKonsultasi::create([
//         'id_reservasi' => $reservasi->id_reservasi,
//         'status_pengajuan' => $request->status,
//         'catatan_konsultasi' => $request->catatan_konsultasi,
//         'alasan_pembatalan' => $request->alasan_pembatalan,
//

//     return back()->with('success', 'Reservasi berhasil diperbarui');
// }

public function popupStore(Request $request)
{
    $request->validate([
        'foto'          => 'required|image|mimes:jpg,jpeg,png|max:2048',
        'tanggal_mulai' => 'required|date|after_or_equal:today',
        'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
    ], [
        'tanggal_mulai.after_or_equal' => 'Tanggal mulai tidak boleh sebelum hari ini.',
        'tanggal_akhir.after_or_equal' => 'Tanggal akhir tidak boleh sebelum tanggal mulai.',
    ]);
 
    // ── Cek overlap dengan periode yang sudah ada ──────────────────
    $mulai  = \Carbon\Carbon::parse($request->tanggal_mulai);
    $akhir  = \Carbon\Carbon::parse($request->tanggal_akhir);
 
    $overlap = \App\Models\PopupOverlay::where(function ($q) use ($mulai, $akhir) {
        // overlap terjadi jika: existing.mulai <= baru.akhir AND existing.akhir >= baru.mulai
        $q->where('tanggal_mulai', '<=', $akhir->toDateString())
          ->where('tanggal_akhir', '>=', $mulai->toDateString());
    })->first();
 
    if ($overlap) {
        return back()
            ->withErrors([
                'tanggal_mulai' => 'Periode ' . $mulai->format('d M Y') . ' – ' . $akhir->format('d M Y') .
                    ' bertabrakan dengan pop up yang sudah ada (' .
                    \Carbon\Carbon::parse($overlap->tanggal_mulai)->format('d M Y') . ' – ' .
                    \Carbon\Carbon::parse($overlap->tanggal_akhir)->format('d M Y') . ').',
            ])
            ->withInput();
    }
 
    // ── Upload foto ────────────────────────────────────────────────
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

public function reservasiShow($id)
{
    $reservasi = ReservasiKonsultasi::with([
        'user', 'petugas', 'riwayatTerbaru'
    ])->findOrFail($id);

    // Auto-tandai selesai jika dijadwalkan dan tanggal sudah lewat
    $riwayatTerbaru = $reservasi->riwayatTerbaru;
    if (
        $riwayatTerbaru?->status_pengajuan === 'dijadwalkan' &&
        $reservasi->tanggal_konsultasi &&
        now()->startOfDay()->gt(Carbon::parse($reservasi->tanggal_konsultasi)->startOfDay())
    ) {
        $sudahAdaSelesai = $reservasi->riwayat()
            ->where('status_pengajuan', 'selesai')
            ->exists();

        if (!$sudahAdaSelesai) {
            RiwayatKonsultasi::create([
                'id_reservasi'       => $reservasi->id_reservasi,
                'status_pengajuan'   => 'selesai',
                'catatan_konsultasi' => 'Konsultasi selesai secara otomatis.',
                'updated_at'         => now(),
            ]);
        }

        $reservasi->load('riwayatTerbaru');
    }

    // Hitung $bisaEdit
    $riwayatTerbaru = $reservasi->riwayatTerbaru;
    $status         = $riwayatTerbaru?->status_pengajuan ?? 'diajukan';
    $tglKonsultasi  = $reservasi->tanggal_konsultasi
        ? Carbon::parse($reservasi->tanggal_konsultasi)->startOfDay()
        : null;
    $sudahLewat    = $tglKonsultasi && now()->startOfDay()->gt($tglKonsultasi);
    $statusDisplay = ($status === 'dijadwalkan' && $sudahLewat) ? 'selesai' : $status;
    $bisaEdit      = !in_array($statusDisplay, ['dibatalkan']);

    return view('pelayanan.reservasi.show', compact('reservasi', 'bisaEdit'));
}

public function reservasiDestroy($id)
{
    $reservasi = ReservasiKonsultasi::findOrFail($id);
    $reservasi->riwayat()->delete(); // hapus riwayat dulu (foreign key)
    $reservasi->delete();

    return redirect()->route('pelayanan.reservasi.index')
        ->with('success', 'Reservasi berhasil dihapus.');
}
public function reservasiEdit($id)
{
    $reservasi = ReservasiKonsultasi::with([
        'user', 'petugas', 'riwayatTerbaru'
    ])->findOrFail($id);
 
    // Cegah akses edit jika sudah dibatalkan
    $status = $reservasi->riwayatTerbaru?->status_pengajuan ?? 'diajukan';
    if ($status === 'dibatalkan') {
        return redirect()
            ->route('pelayanan.reservasi.show', $id)
            ->with('error', 'Reservasi yang dibatalkan tidak dapat diedit.');
    }
 
    return view('pelayanan.reservasi.edit', compact('reservasi'));
}

public function reservasiUpdate(Request $request, $id)
{
    $request->validate([
        'status'             => 'required|in:diajukan,dijadwalkan,selesai,dibatalkan',
        'lokasi_konsultasi'  => 'nullable|string|max:255',
        'catatan_konsultasi' => 'nullable|string|max:2000',
        'alasan_pembatalan'  => 'nullable|string|max:2000',
    ]);
 
    $reservasi = ReservasiKonsultasi::findOrFail($id);
 
    // Update lokasi
    $reservasi->lokasi_konsultasi = $request->lokasi_konsultasi;
    $reservasi->save();
 
    // Validasi alasan wajib jika dibatalkan
    if ($request->status === 'dibatalkan' && empty(trim($request->alasan_pembatalan ?? ''))) {
        return back()->withInput()
            ->withErrors(['alasan_pembatalan' => 'Alasan pembatalan wajib diisi.']);
    }
 
    // Catat riwayat jika ada perubahan
    $riwayatTerbaru = $reservasi->riwayatTerbaru;
    $statusSekarang = $riwayatTerbaru?->status_pengajuan ?? 'diajukan';
    $statusBerubah  = $statusSekarang !== $request->status;
    $adaUpdateData  = $request->filled('catatan_konsultasi') || $request->filled('alasan_pembatalan');
 
    if ($statusBerubah || $adaUpdateData) {
        RiwayatKonsultasi::create([
            'id_reservasi'       => $reservasi->id_reservasi,
            'status_pengajuan'   => $request->status,
            'catatan_konsultasi' => $request->catatan_konsultasi,
            'alasan_pembatalan'  => $request->status === 'dibatalkan'
                                        ? $request->alasan_pembatalan
                                        : null,
            'updated_at'         => now(),
        ]);
    }
 
    // ✅ Redirect ke halaman DETAIL (show), bukan index
    return redirect()
        ->route('pelayanan.reservasi.show', $id)
        ->with('success', 'Reservasi berhasil diperbarui.');
}
}