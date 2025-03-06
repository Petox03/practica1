<?php

use App\Http\Controllers\DrugController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DrugController::class, 'index'])->name('index');

Route::prefix('drug')->group(function () {

    Route::get('/show/{id}', [DrugController::class, 'show'])->name('drug.show');

    Route::get('/create', [DrugController::class, 'create'])->name('store');
    Route::post('/store', [DrugController::class, 'store'])->name('drug.store');

    Route::get('/edit/{id}', [DrugController::class, 'edit'])->name('drug.edit');
    Route::put('/update/{id}', [DrugController::class, 'update'])->name('drug.update');

    Route::delete('/destroy/{id}', [DrugController::class, 'destroy'])->name('drug.destroy');

    Route::get('/search', [DrugController::class, 'search'])->name('drug.search');
});
