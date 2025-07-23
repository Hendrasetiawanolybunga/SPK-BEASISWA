<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlternativeController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\Auth\LoginController; 


    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

  
    Route::middleware(['auth:admin'])->group(function () {

        // Rute Dashboard
        Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

        // Rute Sumber Daya Alternatif
        Route::resource('alternatives', AlternativeController::class)
            ->parameters(['alternative' => 'alternative'])
            ->except(['show']);

        // Rute Khusus untuk Hasil Perhitungan Alternatif
        Route::prefix('alternatives')->name('alternatives.')->group(function () {
            Route::get('/result-bayes', [AlternativeController::class, 'result_bayes'])->name('result-bayes');
            Route::get('/result-moora', [AlternativeController::class, 'result_moora'])->name('result-moora');
            Route::get('/result-mairca', [AlternativeController::class, 'result_mairca'])->name('result-mairca');
        });

        // Rute Sumber Daya Kriteria
        Route::resource('criteria', CriteriaController::class)
            ->parameters(['criteria' => 'criteria'])
            ->except(['show']);

        // Tambahkan rute untuk mengubah profil/password admin 
        Route::get('/admin/profile', [AdminProfileController::class, 'showChangePasswordForm'])->name('admin.profile');
        Route::post('/admin/profile', [AdminProfileController::class, 'changePassword'])->name('admin.password.update');

     //    Tambahkan rute untuk lupa password 
        Route::prefix('admin/password')->name('admin.password.')->group(function () {
            Route::get('/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('request');
            Route::post('/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('email');
            Route::get('/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('reset');
            Route::post('/reset', 'Auth\ResetPasswordController@reset')->name('update');
        });
    });
    