<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('dashboard.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $user->id,
            'no_whatsapp' => 'nullable|string|max:20',
            'instansi'    => 'nullable|string|max:255',
            'jabatan'     => 'nullable|string|max:255',
            'tim'         => 'nullable|string|max:255',
            'alamat'      => 'nullable|string|max:500',
            'password'    => 'nullable|string|min:8|confirmed',
        ]);

        $user->name        = $request->name;
        $user->email       = $request->email;
        $user->no_whatsapp = $request->no_whatsapp;
        $user->instansi    = $request->instansi;
        $user->jabatan     = $request->jabatan;
        $user->tim         = $request->tim;
        $user->alamat      = $request->alamat;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.profile')
                         ->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'foto_profil' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = auth()->user();

        // Hapus foto lama jika ada
        if ($user->foto_profil && file_exists(public_path($user->foto_profil))) {
            unlink(public_path($user->foto_profil));
        }

        if (!is_dir(public_path('images/admins'))) {
            mkdir(public_path('images/admins'), 0755, true);
        }

        $file     = $request->file('foto_profil');
        $filename = 'admin_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images/admins'), $filename);

        $user->foto_profil = 'images/admins/' . $filename;
        $user->save();

        return redirect()->route('admin.profile')
                         ->with('success', 'Foto profil berhasil diperbarui.');
    }
}