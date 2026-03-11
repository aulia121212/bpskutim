<?php

namespace App\Http\Controllers;

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
        return view('pelayanan.reservasi');
    }

    public function popup()
{
    $popups = \App\Models\PopupOverlay::latest()->get();
    return view('pelayanan.popup', compact('popups'));
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
        return view('pelayanan.user');
    }
}