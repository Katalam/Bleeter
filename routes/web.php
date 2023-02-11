<?php

use App\Http\Controllers\FollowController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::group(['middleware' => ['auth']], static function () {
    Route::get('/home', HomepageController::class)->name('home');

    // Toggling likes on posts
    Route::post('/like', LikeController::class)->name('like');
    // Toggling follows on users
    Route::post('/follow', FollowController::class)->name('follow');

    Route::controller(ProfileController::class)
        ->as('profile.')
        ->prefix('profile')
        ->group(function () {
            Route::get('/', 'edit')->name('edit');
            Route::patch('/', 'update')->name('update');
            Route::delete('/', 'destroy')->name('destroy');
        });

    Route::controller(PostController::class)
        ->as('post.')
        ->prefix('post')
        ->group(function () {
            Route::post('/', 'store')->name('store');
            Route::patch('/{post}', 'update')->name('update');
            Route::delete('/{post}', 'destroy')->name('destroy');
        });
});

require __DIR__ . '/auth.php';
