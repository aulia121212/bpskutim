<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\ReservasiKonsultasi;
use App\Models\RiwayatKonsultasi;
use Carbon\Carbon;

class UserProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Ambil semua reservasi user, pisah berdasar status terbaru
        $semua = ReservasiKonsultasi::with(['petugas', 'riwayatTerbaru'])
            ->where('id_user', $user->id)
            ->orderByDesc('id_reservasi')
            ->get();

        // Reservasi aktif: diajukan atau dijadwalkan
        $reservasi = $semua->filter(fn($r) =>
            in_array($r->riwayatTerbaru?->status_pengajuan ?? 'diajukan', ['diajukan', 'dijadwalkan'])
        )->values();

        // Riwayat: selesai atau dibatalkan
        $riwayat = $semua->filter(fn($r) =>
            in_array($r->riwayatTerbaru?->status_pengajuan ?? 'diajukan', ['selesai', 'dibatalkan'])
        )->values();

        return view('user.profile', compact('reservasi', 'riwayat'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|unique:users,email,' . $user->id,
            'no_whatsapp'      => 'required|string|max:20',
            'current_password' => 'required_with:new_password|nullable|string',
            'new_password'     => 'nullable|string|min:8',
            'instansi'         => 'nullable|string|max:255',
            'alamat'           => 'nullable|string|max:500',
        ]);

        $user->name        = $request->name;
        $user->email       = $request->email;
        $user->no_whatsapp = $request->no_whatsapp;
        $user->instansi    = $request->instansi;
        $user->alamat      = $request->alamat;

        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withInput()
                    ->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
            }
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return redirect()->route('user.profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = auth()->user();

        if ($user->foto_profil && file_exists(public_path($user->foto_profil))) {
            unlink(public_path($user->foto_profil));
        }

        if (!is_dir(public_path('images/users'))) {
            mkdir(public_path('images/users'), 0755, true);
        }

        $file     = $request->file('foto');
        $filename = 'foto_user_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images/users'), $filename);

        $user->foto_profil = 'images/users/' . $filename;
        $user->save();

        return redirect()->route('user.profile')
            ->with('success', 'Foto profil berhasil diperbarui.');
    }

    public function detailReservasi($id)
    {
        $reservasi = ReservasiKonsultasi::with(['petugas', 'riwayat', 'riwayatTerbaru'])
            ->where('id_user', auth()->id())
            ->where('id_reservasi', $id)
            ->firstOrFail();

        // Ambil status terbaru (primary key tertinggi = paling baru)
        $riwayatTerbaru = $reservasi->riwayat->sortByDesc(fn($r) => $r->getKey())->first();
        $statusTerbaru  = $riwayatTerbaru?->status_pengajuan ?? 'diajukan';

        // Auto-tandai selesai jika dijadwalkan dan tanggal sudah lewat
        $tglKonsultasi = $reservasi->tanggal_konsultasi
            ? Carbon::parse($reservasi->tanggal_konsultasi)->startOfDay()
            : null;
        $sudahLewat = $tglKonsultasi && now()->startOfDay()->gt($tglKonsultasi);

        if ($statusTerbaru === 'dijadwalkan' && $sudahLewat) {
            $sudahAdaSelesai = $reservasi->riwayat->where('status_pengajuan', 'selesai')->count() > 0;

            if (!$sudahAdaSelesai) {
                RiwayatKonsultasi::create([
                    'id_reservasi'       => $reservasi->id_reservasi,
                    'status_pengajuan'   => 'selesai',
                    'catatan_konsultasi' => 'Konsultasi selesai secara otomatis.',
                ]);
            }

            // Reload & recalculate setelah insert
            $reservasi->load(['petugas', 'riwayat']);
            $riwayatTerbaru = $reservasi->riwayat->sortByDesc(fn($r) => $r->getKey())->first();
            $statusTerbaru  = $riwayatTerbaru?->status_pengajuan ?? 'selesai';
        }

        // Hitung di controller agar blade tidak bisa salah kalkulasi
        $bisaBatalkan = in_array($statusTerbaru, ['diajukan', 'dijadwalkan'])
                        && !($statusTerbaru === 'dijadwalkan' && $sudahLewat);

        return view('user.reservasi-detail', compact('reservasi', 'statusTerbaru', 'bisaBatalkan'));
    }

    /**
     * User membatalkan reservasi — hanya jika belum dibatalkan admin/selesai
     */
    public function batalkanReservasi(Request $request, $id)
    {
        $request->validate([
            'alasan_pembatalan' => 'required|string|max:1000',
        ]);

        $reservasi = ReservasiKonsultasi::with(['riwayat'])
            ->where('id_user', auth()->id())
            ->where('id_reservasi', $id)
            ->firstOrFail();

        // Cek status terbaru dari DB (bukan kalkulasi blade)
        $riwayatTerbaru = $reservasi->riwayat->sortByDesc(fn($r) => $r->getKey())->first();
        $status = $riwayatTerbaru?->status_pengajuan ?? 'diajukan';

        // Sudah selesai otomatis? cek tanggal
        $tglKonsultasi = $reservasi->tanggal_konsultasi
            ? Carbon::parse($reservasi->tanggal_konsultasi)->startOfDay()
            : null;
        $sudahSelesai = $status === 'dijadwalkan' && $tglKonsultasi && now()->startOfDay()->gt($tglKonsultasi);

        // Tidak bisa batalkan jika sudah dibatalkan atau sudah selesai
        if (in_array($status, ['dibatalkan', 'selesai']) || $sudahSelesai) {
            return back()->withErrors(['error' => 'Reservasi ini tidak dapat dibatalkan.']);
        }

        if (!in_array($status, ['diajukan', 'dijadwalkan'])) {
            return back()->withErrors(['error' => 'Status reservasi tidak memungkinkan pembatalan.']);
        }

        RiwayatKonsultasi::create([
            'id_reservasi'      => $reservasi->id_reservasi,
            'status_pengajuan'  => 'dibatalkan',
            'alasan_pembatalan' => $request->alasan_pembatalan,
        ]);

        return redirect()->route('user.profile')
            ->with('success', 'Reservasi berhasil dibatalkan.');
    }
}