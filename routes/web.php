<?php

use App\Models\User;
use App\Notifications\FcmNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', function () {
    Notification::send(User::find(72), new FcmNotification('test', 'test test', []));
    return view('welcome');
});
