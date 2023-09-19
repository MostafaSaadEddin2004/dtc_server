<?php

use App\Http\Controllers\Api\AcademicRegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('certificate-type', [AcademicRegistrationController::class, 'certificateType']);
Route::get('certificate-type/{certificateType}/department', [AcademicRegistrationController::class, 'departmentsByCertificateType']);
Route::middleware('auth:sanctum')->apiResource('academic-registration', AcademicRegistrationController::class)->only(['store']);
