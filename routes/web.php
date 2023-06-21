<?php

use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\ProfileController;
use Laravel\Socialite\Facades\Socialite;
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

// Dashboard or homepage
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authentication
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('avatar', [AvatarController::class, 'add']);
    Route::post('openai_new', [AvatarController::class, 'generate_image']);
});
require __DIR__ . '/auth.php';

// Login with github
Route::post('githubRedirect', [SocialLoginController::class, 'githubLogin'])->name('login.github');
Route::get('githubCallback', [SocialLoginController::class, 'githubCallback']);

// Login with facebook
Route::post('facebookRedirect', [SocialLoginController::class, 'facebookLogin'])->name('login.facebook');    
Route::get('facebookCallback', [SocialLoginController::class, 'facebookCallback']);