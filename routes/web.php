<?php

use App\Http\Controllers\AvatarController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use OpenAI\Laravel\Facades\OpenAI;


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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('avatar', [AvatarController::class, 'add']);
    //  Avatar routes    
    // Route::get('/profile', [AvatarController::class, 'update']);
    // Route::post('profile', [AvatarController::class, 'add']);
});

// Route::post('avatar', [AvatarController::class, 'add']);

require __DIR__.'/auth.php';

Route::get('/OpenAI', function () {
    $result = OpenAI::completions()->create([
        'model' => 'text-davinci-003',
        'prompt' => 'PHP is',
    ]);
    echo $result['choices'][0]['text']; // an open-source, widely-used, server-side scripting language.
});
