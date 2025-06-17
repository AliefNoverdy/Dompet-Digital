<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    KategoriTransaksiController,
    TransaksiKeuanganController,
    DashboardController,
    ProfileController
};

Route::view('/', 'welcome')->name('welcome');

// guest (login & register sudah dari Breeze)
require __DIR__.'/auth.php';

// area protected
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard dan transaksi
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/update-inline/{id}', [DashboardController::class, 'updateInline']);

    // Resource
    Route::resource('transaksi', TransaksiKeuanganController::class);
    Route::resource('kategori', KategoriTransaksiController::class);
});
