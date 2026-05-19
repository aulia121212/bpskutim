<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profile
     */
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    /**
     * Update profile
     */
    public function update(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'no_whatsapp' => 'nullable|string|max:20',

        'current_password' => 'nullable|required_with:new_password',

        // PERBAIKAN
        'new_password' => 'nullable|min:8|confirmed',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;
    $user->no_whatsapp = $request->no_whatsapp;

    // Update password jika diisi
    if ($request->filled('new_password')) {

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'Password saat ini salah'
            ]);
        }

        $user->password = Hash::make($request->new_password);
    }

    $user->save();

    return back()->with('success', 'Profile berhasil diperbarui');
}

}