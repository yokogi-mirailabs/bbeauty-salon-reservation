<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\MessageHistoryController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PointCardController;
use App\Http\Controllers\NotificationController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/health_check', function () {
    return response()->json(200);
});
Route::get('/build/{any}', function ($any) {
    $extensions = substr($any, strrpos($any, '.') + 1);
    $mine_type=[
        "css"=>"text/css",
        "js"=>"application/javascript"
    ];
    if(!array_key_exists($extensions,$mine_type)){
        return \App::abort(404);
    }
    if(!file_exists(public_path() . '/build/'.$any)){
        return \App::abort(404);
    }
    return response(\File::get(public_path() . '/build/'.$any))->header('Content-Type',$mine_type[$extensions]);
})->where('any', '.*');
Route::get('/', function () {
    return redirect(route('login'));
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('shops', ShopController::class);
    Route::prefix('shops/{shop}')->group(function () {
        Route::get('/reservations/calendar', [ReservationController::class, 'calendar'])->name('reservations.calendar');
        Route::get('/reservations/thanks', [ReservationController::class, 'thanks'])->name('reservations.thanks');
        Route::resource('reservations', ReservationController::class);
        Route::resource('reviews', ReviewController::class);
        Route::get('/message_histories', [MessageHistoryController::class, 'index'])->name('message_histories.index');
        Route::get('/point_cards', [PointCardController::class, 'index'])->name('point_cards.index');
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    });
});

require __DIR__.'/auth.php';
