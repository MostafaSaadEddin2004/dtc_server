<?php

use App\Http\Controllers\Api\PostController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum', 'userType:teacher')->group(function () {
    Route::apiResource('post', PostController::class)->except(['show', 'index']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('post', PostController::class)->only(['index']);
    Route::get('saved-posts', [PostController::class, 'saves']);
    Route::post('/post/{post}/like', [PostController::class, 'like']);
    Route::post('/post/{post}/save', [PostController::class, 'save']);
    Route::post('/post/{post}/dislike', [PostController::class, 'dislike']);
    Route::post('/post/{post}/unsave', [PostController::class, 'unsave']);
});