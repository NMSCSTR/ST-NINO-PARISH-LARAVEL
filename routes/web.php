<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User;
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\RouteController;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
})->name('register');


Route::post('/register', [User::class, 'store'])->name('user.store');
Route::post('/login', [AuthUserController::class, 'auth'])->name('user.login');
Route::post('/logout', [AuthUserController::class, 'destroy'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::middleware('user_Role:staff,admin')->group(function () {
        Route::get('/admin/dashboard', [RouteController::class, 'admin'])->name('admin.dashboard');
        Route::get('/admin/users', [RouteController::class, 'users'])->name('admin.users');
        Route::get('/admin/reservations', [RouteController::class, 'reservations'])->name('admin.reservations');
        Route::get('/admin/members', [RouteController::class, 'members'])->name('admin.members');
        Route::get('/admin/events', [RouteController::class, 'events'])->name('admin.events');
        Route::get('/admin/payments', [RouteController::class, 'payments'])->name('admin.payments');
        Route::get('/admin/documents', [RouteController::class, 'documents'])->name('admin.documents');
    });

    Route::middleware('user_Role:member')->group(function () {
        Route::get('/member/dashboard', [User::class, 'memberView'])->name('member.dashboard');
    });
});

