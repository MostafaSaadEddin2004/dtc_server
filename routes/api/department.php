<?php

use App\Http\Controllers\Api\DepartmentController;
use Illuminate\Support\Facades\Route;

Route::get('section/{sectionId}/departments/', [DepartmentController::class,'seeDepartmentFromSection']);
