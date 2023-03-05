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
    return view('auth.login');
});

Route::get('/test', function () {
    return view('test');
})->name('clients.commandes');



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// user has been authenticated to access these pages
Route::middleware('auth')->group(function () {
    Route::get('/clients', 'App\Http\Controllers\ClientsController@index')
        ->name('clients.index');

    Route::delete('/clients/{RECORD_ID}', 'App\Http\Controllers\ClientsController@destroy')
        ->name('clients.destroy');

    Route::patch('/clients/{RECORD_ID}/edit', 'App\Http\Controllers\ClientsController@update')
        ->name('clients.update');

    Route::post('/clients', 'App\Http\Controllers\ClientsController@store')
        ->name('clients.store');
});


Route::get('/commandes', 'App\Http\Controllers\CommandController@index')
    ->name('clients.commandes.index');


Route::post('/clients/{RECORD_ID}/commandes', 'App\Http\Controllers\CommandController@create')
    ->name('clients.commandes.store');
