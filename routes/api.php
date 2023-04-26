<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\StatisticController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

Route::post('installation', [ApiController::class, 'store']);

Route::get('/statistics/orders', [StatisticController::class, 'orders'])->name('statistics.orders');
Route::get('/statistics/reclamations', [StatisticController::class, 'reclamations'])->name('statistics.reclamations');
