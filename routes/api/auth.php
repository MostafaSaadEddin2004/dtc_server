<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('auth/{role}', 'login')
        ->whereIn('role', ['student', 'teacher', 'student_browser', 'teacher_browser']);
    Route::post('auth/{role}/register', 'register')
        ->whereIn('role', ['student', 'teacher', 'student_browser', 'teacher_browser']);
});
