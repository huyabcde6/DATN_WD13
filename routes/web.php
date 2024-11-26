<?php

use App\Http\Controllers\Admin\CategoryProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\NewController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\CommentController;


Route::group(['middleware' => 'auth'], function () {




    Route::resource('permission', App\Http\Controllers\PermissionControler::class);
    Route::get('permission/{permissionId}/delete', [App\Http\Controllers\PermissionControler::class, 'destroy']);

    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::get('roles/{roleId}/delete', [App\Http\Controllers\RoleController::class, 'destroy']);
    Route::get('roles/{roleId}/give-permission', [App\Http\Controllers\RoleController::class, 'addPermissionToRole']);
    Route::put('roles/{roleId}/give-permission', [App\Http\Controllers\RoleController::class, 'givePermissionToRole']);


    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::get('user/{userId}/delete', [App\Http\Controllers\UserController::class, 'destroy']);
});




Route::get('/', [HomeController::class, 'index']);


Route::resource('users', UserController::class);

Route::get('/shop', [ProductController::class, 'index'])->name('shop.index');
Route::get('/san-pham/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::delete('/cart/remove/{productDetailId}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/total', [CartController::class, 'getTotal'])->name('cart.total');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');


// Route::get('/login', [UserController::class, 'login'])->name('login');
// Route::post('/login', [UserController::class, 'postLogin']);
// Route::get('/register', [UserController::class, 'register'])->name('register');
// Route::post('/register', [UserController::class, 'postRegister']);


Route::get('/admin', function () {
    return view('layouts.admin');
});

Route::resource('users', UserController::class);
Route::prefix('orders')->middleware('auth')->as('orders.')->group(function () {
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

Route::prefix('admin')->middleware('auth')->as('admin.')->group(function () {
    // Các route cho quản lý sản phẩm
    Route::resource('products', AdminProductController::class);

    Route::resource('orders', AdminOrderController::class);
    // Quản lý kích thước
    Route::resource('sizes', SizeController::class);

    // Quản lý màu sắc
    Route::resource('colors', ColorController::class);


    // Route::resource('users', UserController::class);
});


require __DIR__ . '/auth.php';


Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::prefix('categories')
            ->name('categories.')
            ->controller(CategoryProductController::class)
            ->group(function () {
                Route::get('index', 'index')->name('index');
                Route::get('create', 'create')->name('create');
                Route::post('store', 'store')->name('store');
                Route::get('{id}/edit', 'edit')->name('edit');
                Route::post('{id}/update', 'update')->name('update');
                Route::delete('{id}/delete', 'delete')->name('delete');
            });
    });

// Tin tức
Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::prefix('new')
            ->name('new.')
            ->controller(NewController::class)
            ->group(function () {
                Route::get('/admNew', 'index')->name('index');
                Route::get('/addNew', 'store')->name('store');
                Route::post('/postNew', 'create')->name('postnew');
                Route::delete('/dlNew{id}', 'destroy')->name('destroy');
                Route::get('/edit{id}', 'show')->name('show');
                Route::post('/update{id}', 'update')->name('update');
            });
    });

Route::middleware(['auth'])->group(function () {
    Route::post('/san-pham/{slug}/comment', [CommentController::class, 'store'])->name('product.comment');
});
Route::get('/san-pham/{slug}', [ProductController::class, 'show'])->name('product.show');
