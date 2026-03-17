<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // ══════════════════════════════════════════════════════════════════════
    // LOGIN
    // ══════════════════════════════════════════════════════════════════════

    public function showLogin()
    {
        if (Auth::check()) {
            return redirect(Auth::user()->dashboardRoute());
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        // Cek user tidak ditemukan
        if (!$user) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email tidak terdaftar.']);
        }

        // Cek akun nonaktif
        if (!$user->is_active) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Akun Anda telah dinonaktifkan. Hubungi administrator.']);
        }

        // Cek password
        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['password' => 'Kata sandi salah.']);
        }

        $request->session()->regenerate();

        return redirect()->intended($user->dashboardRoute())
            ->with('success', 'Selamat datang, ' . $user->name . '!');
    }

    // ══════════════════════════════════════════════════════════════════════
    // REGISTER
    // ══════════════════════════════════════════════════════════════════════

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect(Auth::user()->dashboardRoute());
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'no_whatsapp'  => ['required', 'string', 'max:20'],
            'email'        => ['required', 'email', 'unique:users,email'],
            'password'     => ['required', 'confirmed', Password::min(8)],
        ], [
            'name.required'        => 'Nama lengkap wajib diisi.',
            'no_whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'email.required'       => 'Email wajib diisi.',
            'email.unique'         => 'Email sudah terdaftar.',
            'password.required'    => 'Kata sandi wajib diisi.',
            'password.confirmed'   => 'Konfirmasi kata sandi tidak cocok.',
            'password.min'         => 'Kata sandi minimal 8 karakter.',
        ]);

        $user = User::create([
            'name'        => $validated['name'],
            'no_whatsapp' => $validated['no_whatsapp'],
            'email'       => $validated['email'],
            'password'    => Hash::make($validated['password']),
            'role'        => User::ROLE_USER, // default role
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect($user->dashboardRoute())
            ->with('success', 'Akun berhasil dibuat. Selamat datang, ' . $user->name . '!');
    }

    // ══════════════════════════════════════════════════════════════════════
    // LOGOUT
    // ══════════════════════════════════════════════════════════════════════

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Berhasil keluar.');
    }
}
