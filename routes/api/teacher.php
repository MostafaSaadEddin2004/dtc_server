<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'userType:teacher_browser | teacher'])->post('/auth/teacher', [AuthController::class, 'teacherInfo']);
