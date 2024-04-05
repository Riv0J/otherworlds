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

// locale
Route::get('setlocale/{locale}', [App\Http\Controllers\LocaleController::class, 'setLocale'])->name('setLocale');

// front
Route::get('/home', [FrontController::class, 'home'])->name('home');
Route::get('/', [FrontController::class, 'home'])->name('home');

Route::get('/places', [FrontController::class, 'places_index'])->name('places');
Route::get('/place/{place_name}', [FrontController::class, 'view_place'])->name('view_place');

//ajax
Route::post('/ajax/places/request', [FrontController::class, 'ajax_place_request']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
