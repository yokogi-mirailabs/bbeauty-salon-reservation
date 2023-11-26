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
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Foundation\Application;

Route::get('/', function () {
    return Inertia::render('Admin/Welcome', [
        'canLogin' => Route::has('admin.login'),
        'canRegister' => Route::has('admin.register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Admin/Dashboard');
})->middleware(['auth:admin, verified'])->name('admin.dashboard');

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('admin.register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('admin.login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth:admin')->name('admin.')->group(function () {

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');

    // 追加ルートがある場合は上に定義する
    Route::resource('shop', ShopController::class);
    Route::resource('menus', MenuController::class);
    Route::resource('stylist', StylistController::class);
    Route::resource('payment_history', PaymentHistoryController::class);
    Route::resource('reservation', ReservationController::class);
});
