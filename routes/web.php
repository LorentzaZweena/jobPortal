<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/account/register', [AccountController::class, 'register'])->name('account.register');
Route::post('/account/process-register', [AccountController::class, 'processRegister'])->name('account.processRegister');
Route::get('/account/login', [AccountController::class, 'login'])->name('account.login');

Route::post('/account/authenticate', [AccountController::class, 'authenticate'])->name('account.authenticate');
Route::get('/account/profile', [AccountController::class, 'profile'])->name('account.profile');
Route::put('/account/update-profile', [AccountController::class, 'updateProfile'])->name('account.updateProfile');
Route::get('/account/logout', [AccountController::class, 'logout'])->name('account.logout');