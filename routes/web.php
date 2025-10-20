<?php
use App\Http\Controllers\AuthUserController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\User;
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

        Route::get('/reservations', [RouteController::class, 'reservations'])->name('admin.reservations');
        Route::get('/members', [RouteController::class, 'members'])->name('admin.members');
        Route::get('/events', [RouteController::class, 'events'])->name('admin.events');
        Route::get('/payments', [RouteController::class, 'payments'])->name('admin.payments');
        Route::get('/documents', [RouteController::class, 'documents'])->name('admin.documents');
    });

    
    Route::prefix('member')->middleware('user_Role:member')->group(function () {
        Route::get('/dashboard', [User::class, 'memberView'])->name('member.dashboard');
    });
});

