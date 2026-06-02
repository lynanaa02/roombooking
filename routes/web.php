<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RuanganController;
use App\Http\Controllers\Admin\OrganisasiController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\PreferensiController;
use App\Http\Controllers\AjaxSearchController;
use Illuminate\Support\Facades\Route;


// ==========================================
// ROUTE HEALTHCHECK (UNTUK RAILWAY)
// ==========================================
Route::get('/up', function () {
    return response()->json(['status' => 'ok'], 200);
});

// Halaman root redirect ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Route Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ROUTE LUPA PASSWORD
// Halaman lupa password (form input email)
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
    ->name('password.request');
// Proses kirim link reset password ke email
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');
// Halaman reset password (form input password baru)
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
    ->name('password.reset');
// Proses reset password (update password di database)
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
    ->name('password.update');

// Route untuk Admin
Route::middleware(['auth'])->prefix('admin')->name('admin.')->middleware('checkRole:admin')->group(function () {

    // route search
    Route::get('/organisasi/search', [AjaxSearchController::class, 'searchOrganisasi'])->name('organisasi.search');
    Route::get('/ruangan/search', [AjaxSearchController::class, 'searchRuangan'])->name('ruangan.search');
    Route::get('/admin/organisasi/search', [AjaxSearchController::class, 'searchOrganisasi'])->name('admin.organisasi.search');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/visit/reset', [DashboardController::class, 'resetVisit'])->name('visit.reset');

    // Kelola Ruangan
    Route::resource('ruangan', RuanganController::class);
    Route::get('/ruangan/{ruangan}/detail', [RuanganController::class, 'getDetail'])->name('ruangan.detail');

    // Kelola Organisasi
    Route::resource('organisasi', OrganisasiController::class);
    Route::resource('admin/organisasi', OrganisasiController::class);
    Route::get('/organisasi/{organisasi}', [OrganisasiController::class, 'show'])->name('organisasi.show');

    // Peminjaman
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/{peminjaman}', [PeminjamanController::class, 'show'])->name('peminjaman.show');
    Route::get('/peminjaman/{peminjaman}/json', [PeminjamanController::class, 'getJson'])->name('peminjaman.json');
    Route::post('/peminjaman/{peminjaman}/approve', [PeminjamanController::class, 'approve'])->name('peminjaman.approve');
    Route::post('/peminjaman/{peminjaman}/reject', [PeminjamanController::class, 'reject'])->name('peminjaman.reject');
    Route::get('/file/{path}', function ($path) {
    $fullPath = public_path($path);
        if (!file_exists($fullPath)) {
            abort(404);
        }
        return response()->file($fullPath);
    })->name('file.show')->where('path', '.*');

    // Profile Admin
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});


// Route untuk Organisasi
Route::middleware(['auth'])->prefix('organisasi')->name('organisasi.')->middleware('checkRole:organisasi')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Organisasi\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/ruangan', [App\Http\Controllers\Organisasi\DashboardController::class, 'ruanganIndex'])->name('ruangan.index');
    Route::get('/prosedur', function () {
        return view('organisasi.prosedur');
    })->name('prosedur');

    // AJAX Search untuk organisasi
    Route::get('/search-organisasi', [AjaxSearchController::class, 'searchOrganisasi'])->name('search.organisasi');
    Route::get('/search-ruangan', [AjaxSearchController::class, 'searchRuangan'])->name('search.ruangan');

    // Riwayat Booking
    Route::get('/riwayat', [App\Http\Controllers\Organisasi\RiwayatController::class, 'index'])->name('riwayat.index');

    // Booking routes
    Route::get('/booking/create/{ruangan?}', [App\Http\Controllers\Organisasi\BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [App\Http\Controllers\Organisasi\BookingController::class, 'store'])->name('booking.store');
    Route::post('/booking/check', [App\Http\Controllers\Organisasi\BookingController::class, 'cekKetersediaan'])->name('booking.check');
    Route::get('/booking/{booking}', [App\Http\Controllers\Organisasi\BookingController::class, 'show'])->name('booking.show');
    Route::get('/booking/{booking}/json', [App\Http\Controllers\Organisasi\BookingController::class, 'getJson'])->name('booking.json');
    Route::delete('/booking/{booking}/cancel', [App\Http\Controllers\Organisasi\BookingController::class, 'cancel'])->name('booking.cancel');

     //ROUTE PROFILE ORGANISASI
    Route::get('/profile', [App\Http\Controllers\Organisasi\ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [App\Http\Controllers\Organisasi\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [App\Http\Controllers\Organisasi\ProfileController::class, 'updatePassword'])->name('profile.password');

});
