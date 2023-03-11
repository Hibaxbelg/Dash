<?php

use App\Http\Controllers\OrderController;
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
    return view('auth.login');
});

Route::get('/test', function () {
    return view('test');
})->name('clients.commandes');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// user has been authenticated to access these pages
Route::middleware('auth')->group(function () {
    Route::get('/doctors', 'App\Http\Controllers\DoctorController@index')
        ->name('doctors.index');

    Route::delete('/doctors/{RECORD_ID}', 'App\Http\Controllers\DoctorController@destroy')
        ->name('doctors.destroy');

    Route::patch('/doctors/{RECORD_ID}/edit', 'App\Http\Controllers\DoctorController@update')
        ->name('doctors.update');

    Route::post('/doctors', 'App\Http\Controllers\DoctorController@store')
        ->name('doctors.store');
});

Route::resource('/orders', OrderController::class);
