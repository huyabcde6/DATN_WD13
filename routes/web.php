<?php
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('product.show');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::delete('/cart/remove/{productDetailId}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/total', [CartController::class, 'getTotal'])->name('cart.total');

Route::get('/', function () {
    return view('layouts.admin');
});

Route::resource('users', UserController::class);

Route::prefix('orders')->middleware('auth')->as('orders.')->group(function(){
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('/show/{id}', [OrderController::class, 'show'])->name('show');
    Route::get('/create', [OrderController::class, 'create'])->name('create');
    Route::post('/store', [OrderController::class, 'store'])->name('store');
    Route::post('/{id}/update', [OrderController::class, 'update'])->name('update');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin/orders')->middleware('auth')->group(function () {
    Route::get('/', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/{id}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::post('/{id}', [AdminOrderController::class, 'update'])->name('admin.orders.update');
});


require __DIR__.'/auth.php';

