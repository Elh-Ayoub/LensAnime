<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminAuthController;
use App\Http\Controllers\Admin\VerifyEmailController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
 //////////////////// ----------Authentication module----------  ////////////////////
 Route::group([
    'middleware' => 'AuthCheck',
    'prefix' => 'admin',
], function () {
    Route::get('/auth/register', function () {
        return view('admin.Auth.register');
    })->name('register');
    Route::get('/auth/login', function () {
        return view('admin.Auth.login');
    })->name('login');
    Route::post('auth/register', [AdminAuthController::class, 'register'])->name('admin.auth.register');
    Route::post('auth/login', [AdminAuthController::class, 'login'])->name('admin.auth.login');
    Route::get('auth/logout', [AdminAuthController::class, 'logout'])->name('admin.auth.logout');
});
//  ---------Forget password----------
Route::get('auth/forgot-password', function(){
    return view('Admin.Auth.forgot-password');
})->name('password.forgot');
Route::get('/reset-password/{token}/{email}', function ($token, $email) {
    return view('Admin.Auth.reset-password', ['token' => $token, 'email' => $email]);
})->middleware('guest')->name('password.reset');
Route::patch('auth/reset-password', [AdminAuthController::class, 'resetPassword'])->middleware('guest')->name('password.update');
Route::post('auth/forgot-password',[AdminAuthController::class, 'sendResetLink'])->middleware('guest')->name('password.send');
//  ---------Email verification----------
Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
->middleware(['signed', 'throttle:6,1'])
->name('verification.verify');
Route::post('/email/verify/resend', [VerifyEmailController::class, 'resendVerification'] )->name('verification.send');
Route::get('/email/verify', function(){
    return view('Admin.Auth.verifyEmail');
})->name('verification.resend');
Route::get('/email/verify/success', function(){
    return redirect('admin/auth/login')->with('success', 'Email verified successfully!');
});
Route::get('/email/verify/already-success', function(){
    return redirect('admin/auth/login')->with('success', 'Email already verified! Thank you.');
});
