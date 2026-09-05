<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminNewsController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PublicNewsController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [PublicNewsController::class, 'index'])->name('home');
Route::get('/news/{news:slug}', [PublicNewsController::class, 'show'])->name('news.show');

// Directly serve public storage files reliably across all environments
Route::get('/storage/{path}', function (string $path) {
    $filePath = storage_path('app/public/' . $path);
    if (!file_exists($filePath)) {
        abort(404);
    }
    return response()->file($filePath);
})->where('path', '.*')->name('storage.file');

// Serve font files with proper headers for zero-error font loading
Route::get('/fonts/{file}', function (string $file) {
    $path = public_path('fonts/' . $file);
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->file($path, [
        'Content-Type' => 'font/woff2',
        'Access-Control-Allow-Origin' => '*',
    ]);
})->where('file', '.*');

Route::get('/build/fonts/{file}', function (string $file) {
    $path = public_path('fonts/' . $file);
    if (!file_exists($path)) {
        abort(404);
    }
    return response()->file($path, [
        'Content-Type' => 'font/woff2',
        'Access-Control-Allow-Origin' => '*',
    ]);
})->where('file', '.*');

// Admin routes
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->name('dashboard');

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    Route::get('news/slug-suggestions', [AdminNewsController::class, 'slugSuggestions'])->name('news.slug-suggestions');
    Route::resource('news', AdminNewsController::class);
    Route::post('news/{news}/submit', [AdminNewsController::class, 'submit'])->name('news.submit');
    Route::get('news/{news}/preview', [AdminNewsController::class, 'preview'])->name('news.preview');
    Route::post('news/{news}/review', [ReviewController::class, 'review'])->name('news.review');

    // Admin exclusive CRUD routes
    Route::resource('categories', App\Http\Controllers\CategoryController::class)->except(['show']);
    Route::resource('users', App\Http\Controllers\UserController::class)->except(['show']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
