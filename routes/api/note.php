<?php

use App\Http\Controllers\Api\NoteController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('note', NoteController::class);

    Route::get('user/note-categories', [NoteController::class, 'categories']);
});
