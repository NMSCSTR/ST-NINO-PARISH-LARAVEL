<?php
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\User;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', [User::class, 'store'])->name('user.store');
Route::post('/login', [AuthUserController::class, 'auth'])->name('user.login');
Route::post('/logout', [AuthUserController::class, 'destroy'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::prefix('admin')->middleware('user_Role:staff,admin')->group(function () {
        Route::get('/dashboard', [RouteController::class, 'admin'])->name('admin.dashboard');

        Route::get('/users', [User::class, 'index'])->name('admin.users');
        Route::get('/users/{id}/edit', [User::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [User::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [User::class, 'destroy'])->name('users.destroy');

        Route::get('/reservations', [ReservationController::class, 'index'])->name('admin.reservations');
        Route::post('/reservations/{id}/approve', [ReservationController::class, 'approve'])->name('reservations.approve');
        Route::get('/reservations/{id}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
        Route::put('/reservations/{id}', [ReservationController::class, 'update'])->name('reservations.update');
        Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

        Route::get('/members', [MemberController::class, 'index'])->name('admin.members');
        Route::get('/events', [EventController::class, 'index'])->name('admin.events');
        Route::get('/payments', [PaymentController::class, 'index'])->name('admin.payments');
        Route::get('/documents', [RouteController::class, 'documents'])->name('admin.documents');
    });


    Route::prefix('member')->middleware('user_Role:member')->group(function () {
        Route::get('/dashboard', [MemberController::class, 'index'])->name('member.dashboard');
        Route::get('/reservation', [MemberController::class, 'reservation'])->name('member.reservation');
        Route::post('/reservation', [ReservationController::class, 'makeReservation'])->name('member.makeReservation');
    });
});

// Laravel Task Scheduler
// Accessors And Mutators
// Tinker
// Event and Listeners
//Facade
