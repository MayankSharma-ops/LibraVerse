<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\DashboardController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/search/results', [SearchController::class, 'search'])->name('search.results');
Route::get('/resources/{resource}', [ResourceController::class, 'show'])->name('resource.show');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Fallback 404
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
