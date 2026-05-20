<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BorrowingController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/search/results', [SearchController::class, 'search'])->name('search.results');
Route::get('/resources/{resource}', [ResourceController::class, 'show'])->name('resource.show');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Borrow/Return Transactions
    Route::post('/resources/{resource}/borrow', [BorrowingController::class, 'borrow'])->name('resources.borrow');
    Route::post('/borrowings/{borrowing}/return', [BorrowingController::class, 'returnResource'])->name('borrowings.return');
});

// Admin-Only Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/resources', [AdminController::class, 'storeResource'])->name('admin.resources.store');
});

// Fallback 404
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
