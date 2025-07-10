<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/account/register', [AccountController::class, 'register'])->name('account.register');
Route::post('/account/process-register', [AccountController::class, 'processRegister'])->name('account.processRegister');

Route::get('/account/login', [AccountController::class, 'login'])->name('account.login');