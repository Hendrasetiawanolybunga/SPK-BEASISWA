<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlternativeController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\DashboardController;

// Rute untuk Login dan Logout (tidak memerlukan otentikasi)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rute yang dilindungi oleh middleware 'auth:admin'
Route::middleware(['auth:admin'])->group(function () {

    // Rute Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute Sumber Daya Alternatif
    Route::resource('alternatives', AlternativeController::class)
        ->parameters(['alternative' => 'alternative'])
        ->except(['show']);

    // Rute Khusus untuk Hasil Perhitungan Alternatif
    Route::prefix('alternatives')->name('alternatives.')->group(function () {
        // Rute lama untuk Bayes dan MOORA akan dihapus atau tidak digunakan di navbar
        // Route::get('/result-bayes', [AlternativeController::class, 'result_bayes'])->name('result-bayes');
        // Route::get('/result-moora', [AlternativeController::class, 'result-moora'])->name('result-moora');
        // Route::get('/result-mairca', [AlternativeController::class, 'result_mairca'])->name('result-mairca');

        // Rute BARU untuk Hasil Kombinasi Bayes-MOORA
        Route::get('/result-bayes-moora', [AlternativeController::class, 'result_bayes_moora'])->name('result-bayes-moora');
        // Rute BARU untuk Hasil Kombinasi Bayes-MAIRCA
        Route::get('/result-bayes-mairca', [AlternativeController::class, 'result_bayes_mairca'])->name('result-bayes-mairca');
    });

    // Rute Sumber Daya Kriteria
    Route::resource('criteria', CriteriaController::class)
        ->parameters(['criteria' => 'criteria'])
        ->except(['show']);

    // Rute untuk Mengelola Profil Admin (Username & Email)
    Route::get('/admin/profile', [AdminProfileController::class, 'showProfileForm'])->name('admin.profile.edit');
    Route::post('/admin/profile', [AdminProfileController::class, 'updateProfile'])->name('admin.profile.update');

    // Rute untuk Mengubah Password Admin
    Route::get('/admin/password/change', [AdminProfileController::class, 'showChangePasswordForm'])->name('admin.password.change.form');
    Route::post('/admin/password/change', [AdminProfileController::class, 'updatePassword'])->name('admin.password.update');
});
