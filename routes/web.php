<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobsController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jobs', [JobsController::class, 'index'])->name('jobs');
Route::get('/jobs/detail/{id}', [JobsController::class, 'detail'])->name('jobDetail');
Route::get('/account/register', [AccountController::class, 'register'])->name('account.register');
Route::post('/account/process-register', [AccountController::class, 'processRegister'])->name('account.processRegister');
Route::get('/account/login', [AccountController::class, 'login'])->name('account.login');
Route::get('/login', [AccountController::class, 'login'])->name('login');
Route::post('/account/authenticate', [AccountController::class, 'authenticate'])->name('account.authenticate');

Route::middleware('auth')->group(function () {
    Route::get('/account/profile', [AccountController::class, 'profile'])->name('account.profile');
    Route::post('/account/update-profile', [AccountController::class, 'updateProfile'])->name('account.updateProfile');
    Route::post('/account/update-profile-picture', [AccountController::class, 'updateProfilePicture'])->name('account.updateProfilePicture');
    Route::get('/account/logout', [AccountController::class, 'logout'])->name('account.logout');
    Route::get('/create-job', [AccountController::class, 'createJob'])->name('account.createJob');
    Route::post('/save-job', [AccountController::class, 'saveJob'])->name('account.saveJob');
    Route::get('/my-jobs', [AccountController::class, 'myJobs'])->name('account.myJobs');
    Route::get('/my-jobs/edit/{jobId}', [AccountController::class, 'editJob'])->name('account.editJob');
    Route::post('/update-job/{jobId}', [AccountController::class, 'updateJob'])->name('account.updateJob');
    Route::post('/delete-job', [AccountController::class, 'deleteJob'])->name('account.deleteJob');
});

Route::get('/job/{id}', [HomeController::class, 'jobDetails'])->name('job.details');
