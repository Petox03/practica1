<?php

use App\Http\Controllers\API\DrugController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('drugs')->group(function () {

    Route::get('/', [DrugController::class, 'index']);
    Route::get('/{id}', [DrugController::class, 'find']);
    Route::post('/store', [DrugController::class, 'store']);
    Route::put('/update/{id}', [DrugController::class, 'update']);
    Route::put('/update-order', [DrugController::class, 'updateOrder']);
    Route::delete('/destroy/{id}', [DrugController::class, 'destroy']);
    Route::post('/search', [DrugController::class, 'search'])->name('drug.search');

    Route::get('/pdf/{id}', [DrugController::class, 'generatePdf']);

});