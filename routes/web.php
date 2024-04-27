<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FrontController;
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

// general short routes
Route::get('/', function () {
    return (new FrontController())->home('en');
});
Route::get('/home', function () {
    return (new FrontController())->home('en');
});
Route::get('/places', function () {
    return (new FrontController())->place_index('en','places');
});
Route::get('/lugares', function () {
    return (new FrontController())->place_index('es','lugares');
});

// front routes with $locale slug
Route::prefix('{locale}')->group(function () {
    // set the url locale
    Route::get('/{section_slug_key}/setlocale/{new_locale}', [App\Http\Controllers\LocaleController::class, 'setLocale'])->name('setLocale');

    // front routes that automatically update app locale when visited with the $locale slug
    Route::middleware(['locale_updater'])->group(function () {

        Route::get('/', [FrontController::class, 'home'])->name('home');
        Route::get('/home', [FrontController::class, 'home'])->name('home');

        // place routes
        Route::get('/{section_slug}', [FrontController::class, 'place_index'])->name('place_index');
        Route::get('/{section_slug}/{place_slug}', [FrontController::class, 'place_view'])->name('place_view');

        // ajax place request
        Route::post('/ajax/places/request', [FrontController::class, 'ajax_place_request']);

        // logged-in user routes (redirects to login route if no user is found)
        Route::middleware(['auth'])->group(function () {
            Route::get('/user/profile', [FrontController::class, 'profile'])->name('profile');
        });

        // auth register, login, logout
        Auth::routes();

    });

});

// ajax favorite toggle
Route::post('/ajax/places/favorite', [FrontController::class, 'ajax_place_favorite']);


