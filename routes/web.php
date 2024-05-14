<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\FrontUserController;
use App\Http\Controllers\AdminUserController;
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
    // set the url $locale slug
    Route::get('/{section_slug_key}/setlocale/{new_locale}', [App\Http\Controllers\LocaleController::class, 'setLocale'])->name('setLocale');

    // routes that automatically update app locale with the $locale prefix
    Route::middleware(['locale_updater'])->group(function () {

        // BACK routes for admins
        Route::middleware(['admin'])->group(function () { //admin middleware in kernel.php $routeMiddleware
            Route::get('/admin/users', [AdminUserController::class, 'index'])->name('user_index');
            Route::get('/admin/users/edit/{username}', [AdminUserController::class, 'edit'])->name('user_edit');
            Route::post('/admin/users/update', [AdminUserController::class, 'update'])->name('user_update');
            Route::get('/admin/users/create', [AdminUserController::class, 'create'])->name('user_create');
            Route::post('/admin/users/store', [AdminUserController::class, 'store'])->name('user_store');

        });

        // FRONT routes for logged users
        Route::middleware(['auth'])->group(function () {
            Route::get('/profile/edit', [FrontUserController::class, 'edit'])->name('profile_edit');
            Route::post('/profile/update', [FrontUserController::class, 'update'])->name('profile_update');
            Route::get('/profile/reset_img/{user_id}', [FrontUserController::class, 'reset_img'])->name('reset_img');
        });

        // FRONT public routes:

        // search for a user's profile
        Route::get('/profile/{username}', [FrontUserController::class, 'show'])->name('user_show');

        // auth register, login, logout,
        Auth::routes();

        // auth routes overrides
        Route::get('/login', [LoginController::class, 'show_login'])->name('show_login');
        Route::post('/login', [LoginController::class, 'handle_login'])->name('login');

        Route::get('/register', [RegisterController::class, 'show_register'])->name('show_register');
        Route::post('/register', [RegisterController::class, 'handle_register'])->name('register');

        // home
        Route::get('/', [FrontController::class, 'home'])->name('home');
        Route::get('/home', [FrontController::class, 'home'])->name('home');

        // general
        Route::get('/development', [FrontController::class, 'show_development'])->name('development');

        // place routes
        Route::get('/{section_slug}/{place_slug}', [FrontController::class, 'place_view'])->name('place_view');
        Route::get('/{section_slug}', [FrontController::class, 'place_index'])->name('place_index');

    });

});

// ajax favorite toggle
Route::post('/ajax/places/favorite', [FrontController::class, 'ajax_place_favorite']);
// ajax place request
Route::post('/ajax/places/request', [FrontController::class, 'ajax_place_request']);


// ajax user reset img
Route::post('/ajax/admin/users/reset_img', [AdminUserController::class, 'ajax_reset_img']);
// ajax user toggle active
Route::post('/ajax/admin/users/toggle_ban', [AdminUserController::class, 'ajax_toggle_ban']);
// ajax user request
Route::post('/ajax/admin/users/request', [AdminUserController::class, 'ajax_user_request']);


