<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User;
use App\Http\Controllers\AuthUser;
use App\Http\Controllers\RouteController;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-flash', function (Request $request) {
    $request->session()->flash('welcome', 'This is a test flash!');
    return redirect('/admin/dashboard');
});


Route::get('/login', [User::class, 'loginView'])->name('login');
Route::get('/register', [User::class, 'regView'])->name('register');
Route::post('/register', [User::class, 'store'])->name('user.store');
Route::post('/login', [AuthUser::class, 'auth'])->name('user.login');

Route::middleware('auth')->group(function () {
    Route::middleware('user_Role:staff,admin')->group(function () {
        Route::get('/admin/dashboard', [RouteController::class, 'adminView'])->name('admin.dashboard');

    });

    Route::middleware('user_Role:member')->group(function () {
        Route::get('/member/dashboard', [User::class, 'memberView'])->name('member.dashboard');
    });
});

