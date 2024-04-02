<?php

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/makeBook', [App\Http\Controllers\BookingController::class, 'makeBook'])->name('makeBook');
Route::get('/booking/{id}', [App\Http\Controllers\BookingController::class, 'booking'])->name('booking');
Route::get('/slots/{id}', [App\Http\Controllers\BookingController::class, 'slots'])->name('slots');
Route::post('/makeBook', [App\Http\Controllers\BookingController::class, 'saveBook'])->name('makeBookPost');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/makemap/{id}', [App\Http\Controllers\AdminController::class, 'makemap'])->name('makemap');

    Route::post('/saveTable', [App\Http\Controllers\TableController::class, 'saveTable'])->name('saveTable');
    Route::delete('/deleteTable', [App\Http\Controllers\TableController::class, 'deleteTable'])->name('deleteTable');
});
