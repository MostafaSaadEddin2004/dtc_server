<?php

use App\Http\Controllers\Api\PostController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('post', PostController::class)->except(['show']);

    Route::post('/post/{post}/like', [PostController::class, 'like']);

    Route::post('/post/{post}/save', [PostController::class, 'save']);
});