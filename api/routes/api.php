<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\MessageHistoryController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/shops/{shop}/reservation', [ReservationController::class, 'index'])->name('api.reservations.index');
Route::get('/shops/{shop}/message_histories', [MessageHistoryController::class, 'index'])->name('api.message_histories.index');
Route::post('/shops/{shop}/message_histories', [MessageHistoryController::class, 'store'])->name('api.message_histories.store');
