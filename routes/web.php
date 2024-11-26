<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\GithubController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LotteryController;
use App\Http\Controllers\UserLotteryController;
use App\Http\Middleware\VerifyRoleMiddleware;

// Home Route
Route::get('/', function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
});

// Google Authentication Routes
Route::prefix('auth/google')->group(function () {
    Route::get('/', [GoogleController::class, 'login'])->name('auth.google');
    Route::get('/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');
});

// Github Authentication Routes
Route::prefix('auth/github')->group(function () {
    Route::get('/', [GithubController::class, 'login'])->name('github.login');
    Route::get('/callback', [GithubController::class, 'callback'])->name('auth.github.callback');
});

// User Routes
Route::resource('usuarios', UserController::class);

// Authenticated Routes (Protected by Auth Middleware)
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::post('logout', [GoogleController::class, 'logout'])->name('logout');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard'); 
    Route::get('twofactor', function () { return view('auth.auth-plantilla.two-factor'); })->name('auth.twofactor'); 
    
    // Admin Routes (Protected by Role Middleware)
    Route::middleware(['role:admin'])->group(function () {
        Route::get('usuarios/eliminados', [UserController::class, 'trashed'])->name('usuarios.trashed');
        Route::post('usuarios/{id}/restaurar', [UserController::class, 'restore'])->name('usuarios.restore');
        
    });
});


// Password Reset Routes
Route::get('reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('auth.reset');
Route::post('reset', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('new-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('new-password', [ResetPasswordController::class, 'reset'])->name('password.update');


// Registration Routes
Route::get('registro', function () { return view('auth.register'); })->name('registro');
Route::post('registro', [AuthController::class, 'registro'])->name('registro.submit');