<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{product:slug}', [ProductController::class, 'show'])->name('product');

// Admin
Route::prefix('admin/products')->group(function () {
    Route::get('', [AdminController::class, 'index'])->name('admin.products');

    Route::get('/create', [AdminController::class, 'create'])->name('admin.product.create');
    Route::post('', [AdminController::class, 'store'])->name('admin.product.store');

    Route::get('/{product}/edit', [AdminController::class, 'edit'])->name('admin.product.edit');
    Route::put('/{product}', [AdminController::class, 'update'])->name('admin.product.update');

    Route::delete('/{product}', [AdminController::class, 'destroy'])->name('admin.product.destroy');

    Route::get('/{product}/delete-image', [AdminController::class, 'destroyImage'])->name('admin.product.destroyImage');
});
