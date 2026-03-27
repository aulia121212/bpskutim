<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\StatisticTitleController;
use App\Http\Controllers\PelayananController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublikasiController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\UserProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ── PUBLIC ────────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/data-statistik', [HomeController::class, 'dataStatistik'])->name('data-statistik');

// ── AUTH ──────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',    [AuthController::class, 'login']);
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/google',          [GoogleController::class, 'redirectToGoogle'])->name('google');
    Route::get('/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');
});

// ── AUTHENTICATED ─────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // User Profile (satu group, tidak duplikat)
    Route::get('/profile',         [UserProfileController::class, 'index'])->name('user.profile');
    Route::patch('/profile/update',[UserProfileController::class, 'update'])->name('user.profile.update');
    Route::patch('/profile/photo', [UserProfileController::class, 'updatePhoto'])->name('user.profile.photo');
    Route::get('/reservasi/{id}',  [UserProfileController::class, 'detailReservasi'])->name('user.reservasi.detail');

    // ── SUPER ADMIN ──────────────────────────────────────────────
    Route::middleware('role:super_admin')
        ->prefix('super-admin')
        ->name('superadmin.')
        ->group(function () {
            Route::get('/dashboard', fn() => view('dashboard.index'))->name('dashboard');
            Route::resource('admin-data-statistik', App\Http\Controllers\SuperAdmin\AdminDataStatistikController::class);
            Route::resource('admin-pelayanan',       App\Http\Controllers\SuperAdmin\AdminPelayananController::class);
            Route::resource('admins',                App\Http\Controllers\AdminController::class);
            Route::resource('statistic-titles',      App\Http\Controllers\StatisticTitleController::class);
        });

    // ── ADMIN STATISTIK ──────────────────────────────────────────
    Route::middleware('role:admin_statistik,super_admin')->group(function () {
        Route::resource('statistics',       App\Http\Controllers\StatisticController::class)->except(['index', 'show']);
        Route::resource('statistic-titles', App\Http\Controllers\StatisticTitleController::class)->except(['index', 'show']);
        Route::get('/statistics/preview/{id}', [App\Http\Controllers\StatisticController::class, 'preview'])->name('statistics.preview');
    });
});

// ── KONSULTASI (PUBLIC) ───────────────────────────────────────────────
Route::get('/konsultasi', [App\Http\Controllers\KonsultasiController::class, 'index'])->name('konsultasi');
Route::get('/konsultasi/reservasi/{id}',  [App\Http\Controllers\KonsultasiController::class, 'reservasi'])->name('konsultasi.reservasi');
Route::post('/konsultasi/reservasi/{id}', [App\Http\Controllers\KonsultasiController::class, 'storeReservasi'])->name('konsultasi.reservasi.store');

// ── PELAYANAN ─────────────────────────────────────────────────────────
Route::prefix('pelayanan')->name('pelayanan.')->group(function () {
    Route::get('/', fn() => view('pelayanan.index'))->name('index');

    Route::get('/petugas',           [PelayananController::class, 'petugas'])->name('petugas.index');
    Route::get('/petugas/create',    [PelayananController::class, 'petugasCreate'])->name('petugas.create');
    Route::post('/petugas',          [PelayananController::class, 'petugasStore'])->name('petugas.store');
    Route::delete('/petugas/{id}',   [PelayananController::class, 'petugasDestroy'])->name('petugas.destroy');
    Route::get('/petugas/{id}',      [PelayananController::class, 'petugasShow'])->name('petugas.show');
    Route::get('/petugas/{id}/edit', [PelayananController::class, 'petugasEdit'])->name('petugas.edit');

    Route::get('/jadwal',  [PelayananController::class, 'jadwal'])->name('jadwal.index');
    Route::post('/jadwal', [PelayananController::class, 'jadwalStore'])->name('jadwal.store');

    Route::get('/reservasi', [PelayananController::class, 'reservasi'])->name('reservasi.index');

    Route::get('/popup',        [PelayananController::class, 'popup'])->name('popup.index');
    Route::post('/popup',       [PelayananController::class, 'popupStore'])->name('popup.store');
    Route::delete('/popup/{id}',[PelayananController::class, 'popupDestroy'])->name('popup.destroy');

    Route::get('/user', [PelayananController::class, 'user'])->name('user.index');
});

// ── STATISTICS (PUBLIC) ───────────────────────────────────────────────
Route::prefix('statistics')->name('statistics.')->group(function () {
    Route::get('/',            [StatisticController::class, 'index'])->name('index');
    Route::get('/grafik',      [StatisticController::class, 'grafik'])->name('grafik');
    Route::get('/preview/{id}',[StatisticController::class, 'preview'])->name('preview');
});

Route::prefix('statistic-titles')->name('statistic-titles.')->group(function () {
    Route::get('/', [StatisticTitleController::class, 'index'])->name('index');
    Route::get('/{statisticTitle}/interpretasi', [StatisticTitleController::class, 'getInterpretasi'])->name('interpretasi');
});

// ── PUBLIKASI ─────────────────────────────────────────────────────────
Route::resource('publikasi', PublikasiController::class);

// ── DASHBOARD ─────────────────────────────────────────────────────────
Route::get('/dashboard', fn() => view('dashboard.index'))->name('dashboard.index');
Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/analytics', fn() => view('dashboard.analytics'))->name('analytics');
});

// ── UI COMPONENTS (demo) ──────────────────────────────────────────────
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

Route::prefix('pages/auth')->name('auth.')->group(function () {
    Route::get('/login-cover',    fn() => view('pages.auth.login-cover'))->name('login.cover');
    Route::get('/login-basic',    fn() => view('pages.auth.login-basic'))->name('login.basic');
    Route::get('/register-basic', fn() => view('pages.auth.register-basic'))->name('register.basic');
    Route::get('/register-cover', fn() => view('pages.auth.register-cover'))->name('register.cover');
});

Route::prefix('pages')->group(function () {
    Route::get('/blank',     fn() => view('pages.blank'))->name('pages.blank');
    Route::get('/apps/pos',  fn() => view('pages.apps.pos'))->name('pages.apps.pos');
    Route::get('/apps/chat', fn() => view('pages.apps.chat'))->name('pages.apps.chat');
});

Route::prefix('laravel')->name('laravel.')->group(function () {
    Route::resource('users', App\Http\Controllers\Apps\Laravel\UserController::class);
});