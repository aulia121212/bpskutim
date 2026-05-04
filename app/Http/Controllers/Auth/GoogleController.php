<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect ke Google
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->stateless()
            ->redirect();
    }

    /**
     * Callback Google Login/Register
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')
                ->stateless()
                ->user();

            $email = $googleUser->getEmail();

            if (!$email) {
                return redirect()->route('login')
                    ->with('error', 'Email Google tidak ditemukan.');
            }

            // Cari user berdasarkan email
            $user = User::where('email', $email)->first();

            // Jika belum ada = register otomatis
            if (!$user) {
                $user = User::create([
                    'name'         => $googleUser->getName() ?: 'User Google',
                    'email'        => $email,
                    'no_whatsapp'  => null,
                    'password'     => Hash::make(uniqid()),
                    'role'         => User::ROLE_USER,
                    'is_active'    => true,
                    'email_verified_at' => now(),
                ]);
            }

            // Jika akun nonaktif
            if (!$user->is_active) {
                return redirect()->route('login')
                    ->with('error', 'Akun Anda dinonaktifkan.');
            }

            Auth::login($user, true);
            request()->session()->regenerate();

            return redirect()->intended($user->dashboardRoute())
                ->with('success', 'Selamat datang, '.$user->name.'!');

        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Login Google gagal. Periksa konfigurasi Google.');
        }
    }
}