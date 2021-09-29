<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminAuthController;
use App\Http\Controllers\Admin\VerifyEmailController;
use App\Http\Controllers\admin\AdminUserController;
use App\Http\Controllers\admin\AdminAnimeController;
use App\Http\Controllers\admin\AdminEpisodeController;
use App\Http\Controllers\admin\AdminCategoryController;
use App\Http\Controllers\admin\AdminCommentController;
use App\Models\User;
use App\Models\Anime;
use App\Models\Episode;

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
    return redirect('admin/auth/login');
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
 //////////////////// ----------User module----------  ////////////////////
 Route::group([
    'middleware' => 'AuthCheck',
    'prefix' => 'admin',
], function () {
    Route::get('/profile', [AdminAuthController::class, 'AuthUserProfile'])->name('admin.profile');
    Route::get('/home', function () {
        $users = count(User::where('role', 'user')->get());
        $admins = count(User::where('role', 'admin')->get());
        $animes = count(Anime::all());
        $episodes = count(Episode::all());
        return view('Admin.home', ['users' => $users, 'admins' => $admins, 'animes' => $animes, 'episodes' => $episodes]);
    })->name('admin.dashboard');
    Route::post('user/create', [AdminUserController::class, 'create'])->name('create.user');
    Route::patch('profile/update/{id}', [AdminUserController::class, 'UpdateAdmin'])->name('admin.update');
    Route::patch('password/update/', [AdminUserController::class, 'UpdateAdminPassword'])->name('admin.password');
    Route::patch('avatar/update', [AdminUserController::class, 'UpdateAvatar'])->name('admin.update.avatar');
    Route::delete('avatar/delete', [AdminUserController::class, 'setDefaultAvatar'])->name('admin.delete.avatar');
    Route::get('/users', function(){return view('Admin.Users.list', ['users' => User::all()]);})->name('users.list');
    Route::patch('users/update/{id}',[AdminUserController::class, 'UpdateAdmin'])->name('users.update');
    Route::delete('users/delete/{id}',[AdminUserController::class, 'destroy'])->name('users.delete');
});

 //////////////////// ----------Anime module----------  ////////////////////
 Route::group([
    'middleware' => 'AuthCheck',
    'prefix' => 'admin',
], function () {
    Route::get('/animes', [AdminAnimeController::class, 'index'])->name('animes.list');
    Route::get('/animes/create', [AdminAnimeController::class, 'create'])->name('animes.create.view');
    Route::get('/animes/{id}', [AdminAnimeController::class, 'show'])->name('animes.details');
    Route::post('/animes/create', [AdminAnimeController::class, 'store'])->name('animes.create');
    Route::get('/animes/edit/{id}', [AdminAnimeController::class, 'edit'])->name('animes.edit.view');
    Route::patch('/animes/update/{id}', [AdminAnimeController::class, 'update'])->name('animes.update');
    Route::delete('/animes/delete/{id}', [AdminAnimeController::class, 'destroy'])->name('animes.delete');
});
 //////////////////// ----------Episode module----------  ////////////////////
 Route::group([
    'middleware' => 'AuthCheck',
    'prefix' => 'admin',
], function () {
    Route::post('/animes/episode/create', [AdminEpisodeController::class, 'store'])->name('episode.create');
    Route::get('/animes/episode/{id}', [AdminEpisodeController::class, 'show'])->name('episode.details');
    Route::patch('/animes/episode/{id}', [AdminEpisodeController::class, 'update'])->name('episode.update');
    Route::delete('/animes/episode/{id}', [AdminEpisodeController::class, 'destroy'])->name('episode.delete');
});
 //////////////////// ----------Categories module----------  ////////////////////
 Route::group([
    'middleware' => 'AuthCheck',
    'prefix' => 'admin',
], function () {
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.list');
    Route::post('/categories/create', [AdminCategoryController::class, 'store'])->name('categories.create');
    Route::patch('categories/update/{id}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/delete/{id}', [AdminCategoryController::class, 'destroy'])->name('categories.delete');
    Route::get('/categories/{id}/animes', [AdminCategoryController::class, 'getAnimes'])->name('category.animes');
});
 //////////////////// ----------Comments module----------  ////////////////////
 Route::group([
    'middleware' => 'AuthCheck',
    'prefix' => 'admin',
], function () {
    Route::post('animes/{id}/comments', [AdminCommentController::class, 'store4anime'])->name('anime.comments.create');
});