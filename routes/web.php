<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlternativeController;
use App\Http\Controllers\CriteriaController;

Route::get('/', fn() => redirect('/alternatives'));

Route::get('/alternatives', [AlternativeController::class, 'index'])->name('alternatives.index');
Route::get('/alternatives/create', [AlternativeController::class, 'create'])->name('alternatives.create');
Route::post('/alternatives', [AlternativeController::class, 'store'])->name('alternatives.store');
Route::get('/alternatives/result', [AlternativeController::class, 'result'])->name('alternatives.result');

Route::resource('criteria', CriteriaController::class)
     ->parameters(['criteria' => 'criteria'])  // <-- tambahkan ini
     ->except(['show']);
