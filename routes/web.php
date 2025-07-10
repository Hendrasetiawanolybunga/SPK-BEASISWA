<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlternativeController;
use App\Http\Controllers\CriteriaController;

// Redirect root ke halaman alternatif
Route::get('/', fn() => redirect('/alternatives'));

// Alternatif
Route::resource('alternatives', AlternativeController::class)
     ->parameters(['alternative' => 'alternative'])
     ->except(['show']);

// Metode-metode hasil perhitungan
Route::prefix('alternatives')->name('alternatives.')->group(function () {
     Route::get('/result-bayes', [AlternativeController::class, 'result_bayes'])->name('result-bayes');
     Route::get('/result-moora', [AlternativeController::class, 'result_moora'])->name('result-moora');
     Route::get('/result-mairca', [AlternativeController::class, 'result_mairca'])->name('result-mairca');
});

// Kriteria
Route::resource('criteria', CriteriaController::class)
     ->parameters(['criteria' => 'criteria'])
     ->except(['show']);
