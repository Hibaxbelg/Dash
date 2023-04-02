<?php

use App\Http\Controllers\BonDeCommandeController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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


    Route::resource('/orders', OrderController::class);
    Route::resource('/contract', ContractController::class);
    Route::resource('/contract', ContractController::class);
    Route::get('/bon-de-commande/{id}', [BonDeCommandeController::class, 'download'])->name('bon-de-commande');
    Route::resource('/products', ProductController::class);
    Route::resource('/users', UserController::class)->middleware('super_admin');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update']);
});
