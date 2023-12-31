<?php

use App\Http\Controllers\Api\EditMarkController;
use Illuminate\Support\Facades\Route;

//Route::post('/editMark', [EditMarkController::class, 'store']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/editMark', [EditMarkController::class, 'store']);
    Route::get('/teachers', [EditMarkController::class, 'teachers']);
    Route::get('/subjects', [EditMarkController::class, 'subjects']);
});
