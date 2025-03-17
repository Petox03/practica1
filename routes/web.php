<?php

use App\Http\Controllers\DrugController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DrugController::class, 'index'])->name('index');

Route::prefix('drug')->group(function () {

    Route::get('/show/{id}', [DrugController::class, 'show'])->name('drug.show');

    Route::get('/create', [DrugController::class, 'create'])->name('drug.create');

    Route::get('/edit/{id}', [DrugController::class, 'edit'])->name('drug.edit');

});
