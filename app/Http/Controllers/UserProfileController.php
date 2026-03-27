<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\ReservasiKonsultasi;
use App\Models\RiwayatKonsultasi;

class UserProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Reservasi aktif: status diajukan atau dijadwalkan
        $reservasi = ReservasiKonsultasi::with(['petugas', 'riwayatTerbaru'])
            ->where('id_user', $user->id)
            ->whereHas('riwayatTerbaru', fn($q) =>
                $q->whereIn('status_pengajuan', ['diajukan', 'dijadwalkan'])
            )
            ->latest('created_at')
            ->get();

        // Riwayat: status selesai atau dibatalkan
        $riwayat = ReservasiKonsultasi::with(['petugas', 'riwayatTerbaru'])
            ->where('id_user', $user->id)
            ->whereHas('riwayatTerbaru', fn($q) =>
                $q->whereIn('status_pengajuan', ['selesai', 'dibatalkan'])
            )
            ->latest('created_at')
            ->get();

        return view('user.profile', compact('reservasi', 'riwayat'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email,' . $user->id,
            'no_whatsapp'           => 'required|string|max:20',
            'password'              => 'nullable|string|min:8|confirmed',
            'instansi'              => 'nullable|string|max:255',
            'alamat'                => 'nullable|string|max:500',
        ]);

        $user->name        = $request->name;
        $user->email       = $request->email;
        $user->no_whatsapp = $request->no_whatsapp;
        $user->instansi    = $request->instansi;
        $user->alamat      = $request->alamat;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
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

        // Hapus foto lama
        if ($user->foto && file_exists(public_path($user->foto))) {
            unlink(public_path($user->foto));
        }

        // Simpan foto baru ke public/images/users/
        if (!is_dir(public_path('images/users'))) {
            mkdir(public_path('images/users'), 0755, true);
        }

        $file     = $request->file('foto');
        $filename = 'foto_user_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images/users'), $filename);

        $user->foto = 'images/users/' . $filename;
        $user->save();

        return redirect()->route('user.profile')
                         ->with('success', 'Foto profil berhasil diperbarui.');
    }

    public function detailReservasi($id)
    {
        $reservasi = ReservasiKonsultasi::with(['petugas', 'riwayat'])
            ->where('id_user', auth()->id())
            ->where('id_reservasi', $id)
            ->firstOrFail();

        return view('user.reservasi-detail', compact('reservasi'));
    }
}