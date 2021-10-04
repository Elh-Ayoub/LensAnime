<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\admin\VerifyEmailController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AnimeController;
use App\Http\Controllers\Api\EpisodeController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\LikeController;
use App\Models\User;
use App\Models\Anime;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Episode;
use App\Models\Like;
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
 //Send email verification link
 Route::post('email/verify/resend', [VerifyEmailController::class, 'resendVerification'] )->name('api.verification.send');
 //////////////////// ----------User module----------  ////////////////////
 Route::get('users', [UserController::class, 'index'])->name('api.users');
 Route::post('users', [UserController::class, 'create'])->name('api.users.create');
 Route::get('users/{id}', [UserController::class, 'show'])->name('api.users.id');
 Route::post('users/{id}/avatar', [UserController::class, 'updateAvatar'])->name('api.users.update.avatar');
 Route::patch('users/{id}', [UserController::class, 'update'])->name('api.users.update');//without password !!!!!!!!!!
 Route::patch('users/{id}/password/update/', [UserController::class, 'UpdatePassword'])->name('api.users.update.password');
 Route::delete('users/{id}/avatar/delete', [UserController::class, 'setDefaultAvatar'])->name('api.users.delete.avatar');
 Route::delete('users/{id}', [UserController::class, 'destroy'])->name('api.users.delete');
  //////////////////// ----------Anime module----------  ////////////////////
  Route::get('/animes', [AnimeController::class, 'index'])->name('api.animes.list');
  Route::post('/animes', [AnimeController::class, 'store'])->name('api.animes.create');
  Route::get('/animes/{id}', [AnimeController::class, 'show'])->name('api.animes.id');
  Route::patch('/animes/{id}', [AnimeController::class, 'update'])->name('api.animes.update');
  Route::delete('/animes/{id}', [AnimeController::class, 'destroy'])->name('api.animes.delete');

  //////////////////// ----------Episode module----------  ////////////////////
  Route::get('/animes/{id}/episodes', [EpisodeController::class, 'getAnimesEpisodes'])->name('api.animes.episodes');
  Route::post('/animes/{id}/episodes', [EpisodeController::class, 'store'])->name('api.episodes.create');
  Route::get('/animes/episodes/{id}', [EpisodeController::class, 'show'])->name('api.episodes.show');
  Route::patch('/animes/episodes/{id}', [EpisodeController::class, 'update'])->name('api.episode.update');
  Route::delete('/animes/episodes/{id}', [EpisodeController::class, 'destroy'])->name('api.episode.delete');

  //////////////////// ----------Categories module----------  ////////////////////
  Route::get('/categories', [CategoryController::class, 'index'])->name('api.categories.list');
  Route::post('/categories', [CategoryController::class, 'store'])->name('api.categories.create');
  Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('api.categories.show');
  Route::patch('/categories/{id}', [CategoryController::class, 'update'])->name('api.categories.update');
  Route::get('/categories/{id}/animes', [CategoryController::class, 'getAnimes'])->name('api.categories.getAnimes');
  Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('api.categories.delete');

   //////////////////// ----------Comments module----------  ////////////////////
   Route::get('animes/{id}/comments', [CommentController::class, 'getAnimeComments'])->name('api.anime.comments');
   Route::post('animes/{id}/comments', [CommentController::class, 'store4anime'])->name('api.comments.create');
   Route::get('comments/{id}/comments', [CommentController::class, 'getReplies'])->name('api.comment.reply');
   Route::post('comments/{id}/comments', [CommentController::class, 'store4comment'])->name('api.reply.create');
   Route::patch('comments/{id}', [CommentController::class, 'update'])->name('api.comments.update');
   Route::delete('comments/{id}', [CommentController::class, 'destroy'])->name('api.comments.delete');