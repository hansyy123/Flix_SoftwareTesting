<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PendingReservationsController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $user = auth()->user();

    if (! $user) {
        return redirect()->route('login');
    }

    if (($user->role ?? 'user') === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
    Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');

    Route::post('/rooms/{room}/reservations', [ReservationController::class, 'store'])->name('rooms.reservations.store');
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', AdminDashboardController::class)->name('dashboard');

    Route::resource('/rooms', AdminRoomController::class)->except(['show']);

    Route::get('/reservations/pending', [PendingReservationsController::class, 'index'])->name('reservations.pending');
    Route::post('/reservations/{reservation}/approve', [PendingReservationsController::class, 'approve'])->name('reservations.approve');
    Route::post('/reservations/{reservation}/reject', [PendingReservationsController::class, 'reject'])->name('reservations.reject');
});

require __DIR__.'/auth.php';
