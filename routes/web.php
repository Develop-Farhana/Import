<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Admin login routes
Route::get('admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AuthController::class, 'login']);
Route::post('admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Admin dashboard routes
Route::middleware(['auth:admin'])->group(function () {
    Route::get('admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

// Route::middleware('auth:admin')->group(function() {
//     Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
//     Route::post('categories/import', [CategoryController::class, 'import'])->name('categories.import');
//     Route::get('products', [ProductController::class, 'index'])->name('products.index');
//     // Add other routes that need to be secured
// });

Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
Route::post('categories/import', [CategoryController::class, 'import'])->name('categories.import');
Route::get('categories/get-categories', [CategoryController::class, 'getCategories'])->name('categories.getCategories');
Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');


// Products routes
Route::get('products/get-products', [ProductController::class, 'getProducts'])->name('products.getProducts');
Route::get('products', [ProductController::class, 'index'])->name('products.index');
Route::post('products', [ProductController::class, 'store'])->name('products.store');
Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::get('products/get-products', [ProductController::class, 'getProducts'])->name('products.getProducts');
Route::get('products/get-products', [ProductController::class, 'getProducts'])->name('products.getProducts');