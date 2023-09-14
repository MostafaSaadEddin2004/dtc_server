<?php

use App\Http\Controllers\Api\PostController;
use Illuminate\Support\Facades\Route;

Route::apiResource('post', PostController::class)->only(['index']);
Route::middleware('auth:sanctum', 'userType:teacher')->group(function () {
    Route::apiResource('post', PostController::class)->except(['show', 'index']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/post/{post}/like', [PostController::class, 'like']);
    Route::post('/post/{post}/save', [PostController::class, 'save']);
});
