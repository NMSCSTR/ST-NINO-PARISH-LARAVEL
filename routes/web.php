<?php

use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\PriestController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\SacramentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [AuthUserController::class, 'index'])->name('welcome');
Route::get('/events/data', [EventController::class, 'fetchEvents'])->name('events.welcome');

Route::get('/login', fn() => view('login'))->name('login');
Route::get('/register', fn() => view('register'))->name('register');

Route::post('/register', [UserController::class, 'store'])->name('user.store');
Route::post('/login', [AuthUserController::class, 'auth'])->name('user.login');
Route::post('/logout', [AuthUserController::class, 'destroy'])->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->middleware('user_role:staff,admin')->name('admin.')->group(function () {

        Route::get('/dashboard', [RouteController::class, 'admin'])->name('dashboard');

        // Users
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::post('/users', [UserController::class, 'addUser'])->name('users.add');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

        // Reservations
        Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations');
        Route::post('/reservations/{id}/approve', [ReservationController::class, 'approve'])->name('reservations.approve');
        Route::get('/reservations/{id}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
        Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
        Route::put('/reservations/{id}', [ReservationController::class, 'update'])->name('reservations.update');

        // Members, Events, Payments, Documents
        Route::get('/members', [MemberController::class, 'index'])->name('members');
        Route::get('/members', [MemberController::class, 'adminMemberView'])->name('admin.members');
        Route::get('/members', [MemberController::class, 'memberList'])->name('member.lists');
        Route::get('/members/{id}', [MemberController::class, 'showMore'])->name('admin.members.show');


        Route::get('/events', [EventController::class, 'index'])->name('events');
        Route::get('/payments', [PaymentController::class, 'index'])->name('payments');
        Route::get('/documents', [RouteController::class, 'documents'])->name('documents');
        Route::get('/reservations/{reservation}/documents',
            [ReservationController::class, 'getDocuments']);

        Route::post('/payments/{reservation}/pay-now', [PaymentController::class, 'adminPayNow'])
            ->name('admin.payNow');
        Route::get('/reservations/{id}/payments', [ReservationController::class, 'fetchPayments']);

        Route::get('/priest', [PriestController::class, 'index'])->name('priest');

        // Sacrament Routes
        Route::prefix('sacraments')->name('sacraments.')->group(function () {
            Route::get('/', [SacramentController::class, 'index'])->name('index');
            Route::get('/create', [SacramentController::class, 'create'])->name('create');
            Route::post('/', [SacramentController::class, 'store'])->name('store');
            Route::get('/{sacrament}', [SacramentController::class, 'show'])->name('show');
            Route::get('/{sacrament}/edit', [SacramentController::class, 'edit'])->name('edit');
            Route::put('/{sacrament}', [SacramentController::class, 'update'])->name('update');
            Route::delete('/{sacrament}', [SacramentController::class, 'destroy'])->name('destroy');
        });

    });

    /*
    |--------------------------------------------------------------------------
    | Member Routes
    |--------------------------------------------------------------------------
    */
    Route::prefix('member')->middleware('user_role:member')->name('member.')->group(function () {

        Route::get('/dashboard', [MemberController::class, 'index'])->name('dashboard');
        Route::get('/reservation', [MemberController::class, 'reservation'])->name('reservation');
        Route::post('/reservation', [ReservationController::class, 'makeReservation'])->name('makeReservation');
        Route::get('/member/reservations/history', [ReservationController::class, 'memberReservations'])->name('reservations.history');


        Route::get('/events', fn() => view('member.events'))->name('events.page');
        Route::get('/events/data', [EventController::class, 'fetchEventsData'])->name('events.data');

        Route::post('/member/pay-now/{payment}', [PaymentController::class, 'payNow'])->name('member.pay_now');

        Route::get('/payments', [PaymentController::class, 'showPaymentMember'])->name('member.payments');
        Route::post('/payments/{payment}/pay-now', [PaymentController::class, 'payNow'])->name('member.payNow');

        Route::get('/profile', [MemberController::class, 'profile'])->name('profile');
        Route::post('/member/profile/update', [MemberController::class, 'updateProfile'])->name('profile.update');
        Route::post('/member/profile/change-password', [MemberController::class, 'changePassword'])->name('profile.changePassword');

    });

    Route::prefix('priest')->middleware('user_role:priest')->name('priest.')->group(function () {
        Route::get('/dashboard', [PriestController::class, 'index'])->name('dashboard');
    });
});
