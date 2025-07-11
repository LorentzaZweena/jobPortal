<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication routes
Route::get('/account/register', [AccountController::class, 'register'])->name('account.register');
Route::post('/account/process-register', [AccountController::class, 'processRegister'])->name('account.processRegister');
Route::get('/account/login', [AccountController::class, 'login'])->name('account.login');
Route::get('/login', [AccountController::class, 'login'])->name('login');

Route::post('/account/authenticate', [AccountController::class, 'authenticate'])->name('account.authenticate');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/account/profile', [AccountController::class, 'profile'])->name('account.profile');
    Route::post('/account/update-profile', [AccountController::class, 'updateProfile'])->name('account.updateProfile');
    Route::post('/account/update-profile-picture', [AccountController::class, 'updateProfilePicture'])->name('account.updateProfilePicture');
    Route::get('/account/logout', [AccountController::class, 'logout'])->name('account.logout');
    Route::get('/create-job', [AccountController::class, 'createJob'])->name('account.createJob');
    Route::post('/save-job', [AccountController::class, 'saveJob'])->name('account.saveJob');
    Route::get('/my-jobs', [AccountController::class, 'myJobs'])->name('account.myJobs');
});
