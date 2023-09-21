<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->post('/auth/teacher', [AuthController::class, 'teacherInfo']);
