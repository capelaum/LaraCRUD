<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/product', [ProductController::class, 'show'])->name('product.show');

// Admin
Route::get('/admin/products', [AdminController::class, 'index'])->name('admin.index');
Route::get('/admin/products/edit', [AdminController::class, 'edit'])->name('admin.product_edit');
