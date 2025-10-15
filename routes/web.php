<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', [User::class, 'login'])->name('login');
Route::get('/register', [User::class, 'register'])->name('register');

