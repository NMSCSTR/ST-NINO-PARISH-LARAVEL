<?php
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\SacramentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthUserController::class, 'index'])->name('welcome');
Route::get('/events/data', [EventController::class, 'fetchEvents'])->name('events.welcome');

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', [UserController::class, 'store'])->name('user.store');
Route::post('/login', [AuthUserController::class, 'auth'])->name('user.login');
Route::post('/logout', [AuthUserController::class, 'destroy'])->name('logout');

Route::middleware('auth')->group(function () {

    Route::prefix('admin')->middleware('user_role:staff,admin')->group(function () {
        Route::get('/dashboard', [RouteController::class, 'admin'])->name('admin.dashboard');

        Route::get('/users', [UserController::class, 'index'])->name('admin.users');
        Route::post('/users', [UserController::class, 'addUser'])->name('users.addUsers');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

        Route::get('/reservations', [ReservationController::class, 'index'])->name('admin.reservations');
        Route::post('/reservations/{id}/approve', [ReservationController::class, 'approve'])->name('reservations.approve');
        Route::get('/reservations/{id}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
        Route::put('/reservations/{id}', [ReservationController::class, 'update'])->name('reservations.update');
        Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

        Route::get('/members', [MemberController::class, 'index'])->name('admin.members');
        Route::get('/events', [EventController::class, 'index'])->name('admin.events');
        Route::get('/payments', [PaymentController::class, 'index'])->name('admin.payments');
        Route::get('/documents', [RouteController::class, 'documents'])->name('admin.documents');


        Route::get('/sacraments', [SacramentController::class, 'index'])->name('admin.sacraments.index');
        Route::get('/sacraments/create', [SacramentController::class, 'create'])->name('admin.sacraments.create');
        Route::post('/sacraments', [SacramentController::class, 'store'])->name('admin.sacraments.store');
        Route::get('/sacraments/{sacrament}', [SacramentController::class, 'show'])->name('admin.sacraments.show');
        Route::get('/sacraments/{sacrament}/edit', [SacramentController::class, 'edit'])->name('admin.sacraments.edit');
        Route::put('/sacraments/{sacrament}', [SacramentController::class, 'update'])->name('admin.sacraments.update');
        Route::delete('/sacraments/{sacrament}', [SacramentController::class, 'destroy'])->name('admin.sacraments.destroy');


    });

    Route::prefix('member')->middleware('user_role:member')->group(function () {
        Route::get('/dashboard', [MemberController::class, 'index'])->name('member.dashboard');
        Route::get('/reservation', [MemberController::class, 'reservation'])->name('member.reservation');
        Route::post('/reservation', [ReservationController::class, 'makeReservation'])->name('member.makeReservation');

        // Route::get('/events', [EventController::class, 'fecthEvents'])->name('member.events');
        Route::get('/events', function () {
            return view('member.events');
        })->name('events.page');
        Route::get('/events/data', [EventController::class, 'fetchEventsData'])->name('events.data');

    });
});

// Laravel Task Scheduler
// Accessors And Mutators
// Tinker
// Event and Listeners
//Facade
