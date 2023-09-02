<?php

use App\Http\Controllers\Api\EditMarkController;
use Illuminate\Support\Facades\Route;

//Route::post('/editMark', [EditMarkController::class, 'store']);
Route::middleware('auth:sanctum','userType:student')->group(function () {
    Route::post('/editMark', [EditMarkController::class, 'store']);
});
