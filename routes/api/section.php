<?php

use App\Http\Controllers\Api\SectionController;
use Illuminate\Support\Facades\Route;

Route::get('/sections', [SectionController::class,'seeAllSection']);
