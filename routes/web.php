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
    Route::get('user', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
    Route::get('user/create', [App\Http\Controllers\UserController::class, 'create'])->name('user.create');
    Route::get('user/edit/{user}', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
    Route::delete('user/delete/{user}', [App\Http\Controllers\UserController::class, 'delete'])->name('user.delete');
    Route::post('user/store', [App\Http\Controllers\UserController::class, 'store'])->name('user.store');
    Route::put('user/update', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
    Route::get('/makemap', [App\Http\Controllers\AdminController::class, 'makemap'])->name('makemap');

    Route::get('/allBookings', [App\Http\Controllers\BookingController::class, 'allBookings'])->name('allBookings');
    Route::get('/settings', [App\Http\Controllers\AdminController::class, 'settings'])->name('settings');
    Route::put('/setupSettings', [App\Http\Controllers\AdminController::class, 'setupSettings'])->name('setupSettings');

    Route::post('/saveTable', [App\Http\Controllers\TableController::class, 'saveTable'])->name('saveTable');
    Route::delete('/deleteTable', [App\Http\Controllers\TableController::class, 'deleteTable'])->name('deleteTable');
});
