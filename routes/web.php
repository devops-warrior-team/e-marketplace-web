<?php

use App\Http\Controllers\Auth\UserRegistrationController;
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
    return view('welcome');
});

Route::prefix('user')->name('user')->group(function () {

    Route::get('register', [UserRegistrationController::class, 'index']);
    Route::post('register', [UserRegistrationController::class, 'store']);
});
