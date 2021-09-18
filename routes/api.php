<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
 //////////////////// ----------Authentication module----------  ////////////////////

 Route::post('auth/login', [AuthController::class, 'login'])->name('api.auth.login');
 Route::post('auth/logout', [AuthController::class, 'logout'])->name('api.auth.logout');
 Route::post('auth/register', [AuthController::class, 'register'])->name('api.auth.register');
 //Send reset password link
 Route::post('auth/password-reset',[AuthController::class, 'sendResetLink']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
