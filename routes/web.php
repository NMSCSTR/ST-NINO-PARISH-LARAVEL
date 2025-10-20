<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', [User::class, 'login'])->name('login');
Route::get('/register', [User::class, 'register'])->name('register');
Route::post('/register', [User::class, 'store'])->name('user.store');

Route::middleware('auth')->group(function () {
    Route::middleware('user_Role:staff')->group(function () {
        Route::get('/admin/dashboard', [User::class, 'adminView'])->name('admin.dashboard');

    });

    Route::middleware('user_Role:member')->group(function () {
        Route::get('/member/dashboard', [User::class, 'memberView'])->name('member.dashboard');
    });
});

