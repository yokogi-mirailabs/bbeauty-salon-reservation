<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\PasswordController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PaymentHistoryController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\ShopController;
use App\Http\Controllers\Admin\StylistController;
use App\Http\Controllers\Admin\AnalyzeController;
use App\Http\Controllers\Admin\MessageHistoryController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Foundation\Application;

Route::get('/', function () {
    return redirect(route('admin.login'));
});

Route::get('/dashboard', function () {
    return Inertia::render('Admin/Dashboard');
})->middleware(['auth:admin, verified'])->name('admin.dashboard');

Route::middleware('guest:admin')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('admin.register');

    Route::post('register', [RegisteredUserController::class, 'store']);

});
Route::get('login', [AuthenticatedSessionController::class, 'create'])
            ->name('admin.login');

Route::post('login', [AuthenticatedSessionController::class, 'store']);

Route::middleware('auth:admin')->name('admin.')->group(function () {

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');

    // 追加ルートがある場合は上に定義する
    Route::resource('shops', ShopController::class);
    Route::prefix('shops/{shop}')->group(function () {
        Route::resource('menus', MenuController::class);
        Route::resource('stylists', StylistController::class);
        Route::resource('payment_histories', PaymentHistoryController::class);
        Route::resource('reservations', ReservationController::class);
        Route::post('/analyze', [AnalyzeController::class, 'analyze'])->name('analyze');
        Route::get('/analyze', [AnalyzeController::class, 'index'])->name('analyze.index');
        Route::get('/message_histories', [MessageHistoryController::class, 'index'])->name('message_histories.index');
    });
});
