<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ecommerce\ProductController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\StatisticTitleController;
use App\Http\Controllers\PelayananController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublikasiController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Homepage untuk user (public)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Dashboard admin
Route::get('/dashboard', fn() => view('dashboard.index'))->name('dashboard.index');

// Data statistik public
Route::get('/data-statistik', [HomeController::class, 'dataStatistik'])->name('data-statistik');

// ── Auth routes ──────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Google Login
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/google', [GoogleController::class, 'redirectToGoogle'])->name('google');
    Route::get('/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');
});

// Profile route
// Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
// Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

// // Tambahkan alias untuk 'profile' jika diperlukan
// Route::get('/profile', [ProfileController::class, 'index'])->name('profile'); // Alias

// ═════════════════════════════════════════════════════════════════════
// AUTHENTICATED ROUTES
// ═════════════════════════════════════════════════════════════════════
Route::middleware('auth')->group(function () {
    // Profile - dengan kedua nama route
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index'); // untuk yang sudah ada
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile'); // ALIAS untuk sidebar
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // ── SUPER ADMIN ──────────────────────────────────────────────
    Route::middleware('role:super_admin')->prefix('super-admin')->name('superadmin.')->group(function () {
        // Dashboard super admin
        Route::get('/dashboard', fn() => view('dashboard.index'))->name('dashboard');
        
        // Kelola admin data statistik
        Route::resource('admin-data-statistik', App\Http\Controllers\SuperAdmin\AdminDataStatistikController::class);
        
        // Kelola admin pelayanan
        Route::resource('admin-pelayanan', App\Http\Controllers\SuperAdmin\AdminPelayananController::class);
        
        // Kelola admins (jika ada)
        Route::resource('admins', App\Http\Controllers\AdminController::class);
        
        // Statistik titles
        Route::resource('statistic-titles', App\Http\Controllers\StatisticTitleController::class);
    });

    // ── Admin Data Statistik ─────────────────────────────────────
    Route::middleware('role:admin_statistik,super_admin')->group(function () {
        Route::resource('statistics', App\Http\Controllers\StatisticController::class)->except(['index', 'show']);
        Route::resource('statistic-titles', App\Http\Controllers\StatisticTitleController::class)->except(['index', 'show']);
        Route::get('/statistics/preview/{id}', [App\Http\Controllers\StatisticController::class, 'preview'])->name('statistics.preview');
    });

    // ── User biasa ───────────────────────────────────────────────
    Route::get('/home', fn() => view('home'))->name('home');
});

// ═════════════════════════════════════════════════════════════════════
// PUBLIC ROUTES (tanpa auth)
// ═════════════════════════════════════════════════════════════════════

// Dashboard variants (public - untuk demo)
Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/analytics', fn() => view('dashboard.analytics'))->name('analytics');
    Route::get('/crm',       fn() => view('dashboard.crm'))->name('crm');
    Route::get('/ecommerce', fn() => view('dashboard.ecommerce'))->name('ecommerce');
});

// Pelayanan routes
Route::prefix('pelayanan')->name('pelayanan.')->group(function () {
    Route::get('/', fn() => view('pelayanan.index'))->name('index');

    // Petugas
    Route::get('/petugas',         [PelayananController::class, 'petugas'])->name('petugas.index');
    Route::get('/petugas/create',  [PelayananController::class, 'petugasCreate'])->name('petugas.create');
    Route::post('/petugas',        [PelayananController::class, 'petugasStore'])->name('petugas.store');
    Route::delete('/petugas/{id}', [PelayananController::class, 'petugasDestroy'])->name('petugas.destroy');
    Route::get('/petugas/{id}',    [PelayananController::class, 'petugasShow'])->name('petugas.show');
    Route::get('/petugas/{id}/edit', [PelayananController::class, 'petugasEdit'])->name('petugas.edit');
    
    // Jadwal
    Route::get('/jadwal', [PelayananController::class, 'jadwal'])->name('jadwal.index');
    Route::post('/jadwal', [PelayananController::class, 'jadwalStore'])->name('jadwal.store');
    
    // Reservasi
    Route::get('/reservasi', [PelayananController::class, 'reservasi'])->name('reservasi.index');

    // Pop Up
    Route::get('/popup', [PelayananController::class, 'popup'])->name('popup.index');
    Route::post('/popup', [PelayananController::class, 'popupStore'])->name('popup.store');
    Route::delete('/popup/{id}', [PelayananController::class, 'popupDestroy'])->name('popup.destroy');
    
    // User
    Route::get('/user', [PelayananController::class, 'user'])->name('user.index');
});

// Statistics routes (public)
Route::prefix('statistics')->name('statistics.')->group(function () {
    Route::get('/', [StatisticController::class, 'index'])->name('index');
    Route::get('/grafik', [StatisticController::class, 'grafik'])->name('grafik');
    Route::get('/preview/{id}', [StatisticController::class, 'preview'])->name('preview');
});

// Statistic titles routes (public)
Route::prefix('statistic-titles')->name('statistic-titles.')->group(function () {
    Route::get('/', [StatisticTitleController::class, 'index'])->name('index');
    Route::get('/{statisticTitle}/interpretasi', [StatisticTitleController::class, 'getInterpretasi'])->name('interpretasi');
});

// Publikasi
Route::resource('publikasi', PublikasiController::class);

// UI Components (public - untuk demo)
Route::prefix('pages/components')->name('components.')->group(function () {
    Route::get('/buttons',    fn() => view('pages.components.buttons'))->name('buttons');
    Route::get('/alerts',     fn() => view('pages.components.alerts'))->name('alerts');
    Route::get('/toasts',     fn() => view('pages.components.toasts'))->name('toasts');
    Route::get('/modals',     fn() => view('pages.components.modals'))->name('modals');
    Route::get('/cards',      fn() => view('pages.components.cards'))->name('cards');
    Route::get('/badges',     fn() => view('pages.components.badges'))->name('badges');
    Route::get('/inputs',     fn() => view('pages.components.inputs'))->name('inputs');
    Route::get('/widgets',    fn() => view('pages.components.widgets'))->name('widgets');
    Route::get('/tables',     fn() => view('pages.components.tables'))->name('tables');
    Route::get('/datatables', fn() => view('pages.components.datatables'))->name('datatables');

    Route::prefix('forms')->name('forms.')->group(function () {
        Route::get('/elements', fn() => view('pages.components.forms.elements'))->name('elements');
        Route::get('/layouts',  fn() => view('pages.components.forms.layouts'))->name('layouts');
    });
});

// Auth pages (public - untuk demo)
Route::prefix('pages/auth')->name('auth.')->group(function () {
    Route::get('/login-cover',    fn() => view('pages.auth.login-cover'))->name('login.cover');
    Route::get('/login-basic',    fn() => view('pages.auth.login-basic'))->name('login.basic');
    Route::get('/register-basic', fn() => view('pages.auth.register-basic'))->name('register.basic');
    Route::get('/register-cover', fn() => view('pages.auth.register-cover'))->name('register.cover');
});

// Pages
Route::prefix('pages')->group(function () {
    Route::get('/blank',     fn() => view('pages.blank'))->name('pages.blank');
    Route::get('/apps/pos',  fn() => view('pages.apps.pos'))->name('pages.apps.pos');
    Route::get('/apps/chat', fn() => view('pages.apps.chat'))->name('pages.apps.chat');
});

// Laravel users (public - untuk demo)
Route::prefix('laravel')->name('laravel.')->group(function () {
    Route::resource('users', App\Http\Controllers\Apps\Laravel\UserController::class);
});