<?php

use App\Http\Controllers\Api\MoveController;
use Illuminate\Support\Facades\Route;

//Route::post('/move', [MoveController::class, 'store']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/move', [MoveController::class, 'store']);
});
