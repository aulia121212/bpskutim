<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReservasiKonsultasi;
use App\Models\RiwayatKonsultasi;
use App\Models\Petugas; 
use App\Models\JadwalTidakTersedia;
class KonsultasiController extends Controller
{
    /**
     * Halaman utama konsultasi — daftar petugas.
     */
    public function index()
    {
$petugas = Petugas::paginate(6);

        return view('konsultasi.index', compact('petugas'));
    }

    /**
     * Form reservasi untuk petugas tertentu.
     * Wajib login.
     */
    public function reservasi($id)
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                             ->with('error', 'Silakan login terlebih dahulu untuk membuat reservasi.');
        }

$petugas = Petugas::findOrFail($id);

 $jadwal = JadwalTidakTersedia::all();
    $jadwalMap = $jadwal->keyBy('tanggal');

        return view('konsultasi.reservasi', compact('petugas', 'jadwalMap'));
    }

    /**
     * Simpan reservasi.
     */
    public function storeReservasi(Request $request, $id)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'tanggal'          => 'required|date|after_or_equal:today',
            'jam'              => 'required|date_format:H:i',
            'jenis_konsultasi' => 'required|in:online,offline',
            'topik_konsultasi' => 'required|string|min:10|max:1000',
        ], [
            'tanggal.after_or_equal'  => 'Tanggal tidak boleh sebelum hari ini.',
            'topik_konsultasi.min'    => 'Topik konsultasi minimal 10 karakter.',
            'jenis_konsultasi.in'     => 'Pilih jenis konsultasi yang valid.',
            'jam.required' => 'Jam wajib diisi.',
            'jam.date_format' => 'Format jam tidak valid.',

        ]);

        $tanggal = $request->tanggal;
        $jam = $request->jam;

if ($jam < '08:00' || $jam > '15:30') {
    return back()
        ->withErrors([
            'jam' => 'Jam yang dipilih tidak valid. Pilih jam antara 08.00-15.30 WITA'
        ])
        ->withInput();
}

if (in_array(date('w', strtotime($tanggal)), [0,6])) {
    return back()->withErrors(['tanggal' => 'Tidak bisa memilih hari Sabtu/Minggu']);
}

$blocked = \App\Models\JadwalTidakTersedia::where('tanggal', $tanggal)->exists();

if ($blocked) {
    return back()->withErrors(['tanggal' => 'Tanggal tidak tersedia']);
}

$petugas = Petugas::findOrFail($id);

        // Buat reservasi
        $reservasi = ReservasiKonsultasi::create([
            'id_user'            => auth()->id(),
            'id_petugas'         => $petugas->id,
            'tanggal_konsultasi' => $request->tanggal,
            'waktu_konsultasi'   => $request->jam,
            'topik_diskusi'      => $request->topik_konsultasi,
            'jenis_konsultasi'   => $request->jenis_konsultasi,
            'lokasi_konsultasi'  => $request->jenis_konsultasi === 'offline'
                                    ? 'BPS Kabupaten Kutai Timur'
                                    : null,
        ]);

        // Buat riwayat awal — status diajukan
        RiwayatKonsultasi::create([
            'id_reservasi'     => $reservasi->id_reservasi,
            'status_pengajuan' => 'diajukan',
            'catatan_petugas'  => null,
        ]);

        return redirect()->route('user.profile')
                         ->with('success', 'Reservasi berhasil diajukan! Petugas akan menghubungi Anda melalui WhatsApp.');
    }
}