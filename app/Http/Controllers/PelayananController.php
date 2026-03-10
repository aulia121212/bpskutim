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
    $petugas = \App\Models\Petugas::all(); // sesuaikan model
    $jadwal  = \App\Models\JadwalTidakTersedia::all();
    
    // Convert ke map { 'YYYY-MM-DD': { judul, alasan, petugas } }
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
        return view('pelayanan.popup');
    }

    public function popupStore(Request $request)
    {
        // implementasi store popup
    }

    public function user()
    {
        return view('pelayanan.user');
    }
}