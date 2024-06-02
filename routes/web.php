<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\LocaleController;

use App\Http\Controllers\Front_Controller;
use App\Http\Controllers\Front_UserController;
use App\Http\Controllers\Front_PlaceController;

use App\Http\Controllers\Admin_UserController;
use App\Http\Controllers\Admin_VisitController;
use App\Http\Controllers\Admin_PlaceController;


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
// absolute routes
Route::get('/', function () {
    return (new Front_Controller())->home('en');
});
Route::get('/home', function () {
    return (new Front_Controller())->home('en');
});

// front routes with $locale slug
Route::prefix('{locale}')->middleware('visits')->group(function () {
    // set the url $locale slug
    Route::get('/{slug_key}/setlocale/{new_locale}', [LocaleController::class, 'setLocale'])->name('setLocale');

    // routes that automatically update app locale with the $locale prefix
    Route::middleware(['locale_updater'])->group(function () {
        // /en/
        Route::get('/', [Front_Controller::class,'home']);

        // /en/home
        Route::get('/home', [Front_Controller::class,'home'])->name('home');

        // /en/development
        Route::get('/development', [Front_Controller::class, 'show_development'])->name('development');

        // auth register, login, logout,
        Auth::routes();

        // $slug_key routes
        foreach (config('translatable.locales') as $locale) {
            // /{locale}/{places}
            Route::get('/'.trans('otherworlds.places_slug', [], $locale), [Front_PlaceController::class,'index']);
            // /{locale}/{places}/{place_slug}
            Route::get('/'.trans('otherworlds.places_slug', [], $locale).'/{place_slug}', [Front_PlaceController::class,'show']);

            // /{locale}/{login}
            Route::get('/'.trans('otherworlds.login_slug', [], $locale), [LoginController::class, 'show_login']);
            // /{locale}/{register}
            Route::get('/'.trans('otherworlds.register_slug', [], $locale), [RegisterController::class, 'show_register']);

            // /{locale}/{profile}/{username}
            Route::get('/'.trans('otherworlds.profile_slug', [], $locale).'/{username}', [Front_UserController::class, 'show']);
            // /{locale}/{profile}/{username}/edit
            Route::get('/'.trans('otherworlds.profile_slug', [], $locale).'/{username}/edit',
            [Front_UserController::class, 'edit'])->middleware(['auth']);
        };

        // POST / ASYNC routes
        Route::post('/login', [LoginController::class, 'handle_login'])->name('login');
        Route::post('/register', [RegisterController::class, 'handle_register'])->name('register');
        Route::post('/profile/update', [Front_UserController::class, 'update'])->name('profile_update');
        Route::get('/profile/reset_img/{user_id}', [Front_UserController::class, 'reset_img'])->name('reset_img');

        // ADMIN routes
        Route::middleware(['admin'])->group(function () { //admin middleware in kernel.php $routeMiddleware
            Route::get('/admin/users', [Admin_UserController::class, 'index'])->name('user_index');
            Route::get('/admin/users/edit/{username}', [Admin_UserController::class, 'edit'])->name('user_edit');
            Route::post('/admin/users/update', [Admin_UserController::class, 'update'])->name('user_update');
            Route::get('/admin/users/create', [Admin_UserController::class, 'create'])->name('user_create');
            Route::post('/admin/users/store', [Admin_UserController::class, 'store'])->name('user_store');
            Route::delete('/admin/users/delete', [Admin_UserController::class, 'delete'])->name('user_delete');

            Route::get('/admin/visits', [Admin_VisitController::class, 'index'])->name('visit_index');
            Route::get('/admin/places', [Admin_PlaceController::class, 'index'])->name('place_index');
            Route::get('/admin/places/create', [Admin_PlaceController::class, 'create'])->name('place_create');
            Route::post('/admin/places/store', [Admin_PlaceController::class, 'store'])->name('place_store');
        });
    });
});

// ajax favorite toggle
Route::post('/ajax/places/favorite', [Front_PlaceController::class, 'ajax_place_favorite']);
// ajax place request
Route::post('/ajax/places/request', [Front_PlaceController::class, 'ajax_place_request']);

// BACK routes for admins
Route::middleware(['admin'])->group(function () {
    // ajax toggles, single click
    Route::post('/ajax/admin/users/reset_img', [Admin_UserController::class, 'ajax_reset_img']);
    Route::post('/ajax/admin/users/toggle_ban', [Admin_UserController::class, 'ajax_toggle_ban']);

    // ajax paginated requests
    Route::post('/ajax/admin/users/request', [Admin_UserController::class, 'ajax_user_request']);
    Route::post('/ajax/admin/visits/request', [Admin_VisitController::class, 'ajax_visit_request']);
    Route::post('/ajax/admin/places/request', [Admin_PlaceController::class, 'ajax_place_request']);
    Route::post('/ajax/admin/places/create', [Admin_PlaceController::class, 'ajax_place_create']);
    Route::post('/ajax/admin/places/find', [Admin_PlaceController::class, 'ajax_place_find']);
});

Route::middleware(['owner'])->group(function () {
    Route::post('/ajax/admin/visits/delete', [Admin_VisitController::class, 'ajax_delete_visit']);
});

