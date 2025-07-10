<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlternativeController;
use App\Http\Controllers\CriteriaController;

Route::get('/', fn() => redirect('/alternatives'));

Route::get('/alternatives', [AlternativeController::class, 'index'])->name('alternatives.index');
Route::get('/alternatives/create', [AlternativeController::class, 'create'])->name('alternatives.create');
Route::post('/alternatives', [AlternativeController::class, 'store'])->name('alternatives.store');
Route::get('/alternatives/result-bayes', [AlternativeController::class, 'result_bayes'])->name('alternatives.result-bayes');
Route::get('/alternatives/result-moora', [AlternativeController::class, 'result_moora'])->name('alternatives.result-moora');
Route::get('/alternatives/result-mairca', [AlternativeController::class, 'result_mairca'])->name('alternatives.result-mairca');

Route::resource('criteria', CriteriaController::class)
     ->parameters(['criteria' => 'criteria'])  // <-- tambahkan ini
     ->except(['show']);
