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
        Route::get('/admin/dashboard', [RouteController::class, 'adminView'])->name('admin.dashboard');

    });

    Route::middleware('user_Role:member')->group(function () {
        Route::get('/member/dashboard', [User::class, 'memberView'])->name('member.dashboard');
    });
});

