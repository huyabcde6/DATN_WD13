<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AttributeValueController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\Admin\CategoryProductController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PhoneController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\NewController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CouponsController;
use App\Models\Order;
use App\Http\Controllers\Admin\ShiftController;



Route::group(['middleware' => 'auth'], function () {

    Route::resource('permission', App\Http\Controllers\Admin\PermissionControler::class);
    Route::get('permission/{permissionId}/delete', [App\Http\Controllers\Admin\PermissionControler::class, 'destroy']);

    Route::resource('roles', App\Http\Controllers\Admin\RoleController::class);
    Route::get('roles/{roleId}/delete', [App\Http\Controllers\Admin\RoleController::class, 'destroy']);
    Route::get('roles/{roleId}/give-permission', [App\Http\Controllers\Admin\RoleController::class, 'addPermissionToRole']);
    Route::put('roles/{roleId}/give-permission', [App\Http\Controllers\Admin\RoleController::class, 'givePermissionToRole']);

    Route::get('userAdmin/{user}/edit', [AdminController::class, 'edit'])->name('userAdmin.edit');
    Route::put('userAdmin/{user}', [AdminController::class, 'update'])->name('userAdmin.update');
    Route::get('/user/{user}/assign-shift', [ShiftController::class, 'showAssignShiftForm'])->name('user.show-assign-shift');
    Route::post('/user/{user}/assign-shift', [ShiftController::class, 'assignShift'])->name('user.assign-shift');
    Route::resource('userAdmin', AdminController::class);
    Route::get('userAdmin/{userId}/delete', [App\Http\Controllers\Admin\AdminController::class, 'destroy']);
});

Route::get('/ajax/products/filter', [ProductController::class, 'filterProducts'])->name('ajax.products.filter');
Route::get('/', [HomeController::class, 'index'])->name('home.index');



Route::get('thank-you/{order}', function ($orderId) {
    $order = Order::find($orderId);
    return view('user.sanpham.thank_you', compact('order'));
})->name('thank_you');

Route::get('/shop', [ProductController::class, 'index'])->name('shop.index');
Route::get('/san-pham/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::delete('/cart/remove/{productId}/{variantId?}', [CartController::class, 'removeFromCart'])->name('cart.remove');

Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/total', [CartController::class, 'getTotal'])->name('cart.total');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
Route::post('/cart/move-to-selected', [CartController::class, 'moveToSelected'])->name('cart.move.to.selected');

Route::prefix('orders')->middleware('auth')->as('orders.')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::get('/show/{id}', [OrderController::class, 'show'])->name('show');
    Route::get('/create', [OrderController::class, 'create'])->name('create');
    Route::post('/store', [OrderController::class, 'store'])->name('store');
    Route::post('/{id}/update', [OrderController::class, 'update'])->name('update');
    Route::get('/vnp/return', [OrderController::class, 'handleVNPReturn'])->name('vnp.return');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/updateAccount', [ProfileController::class, 'updateAccount'])->name('profile.updateAccount');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->middleware(['auth'])->as('admin.')->group(function () {

    // Các route cho quản lý sản phẩm
    Route::resource('products', AdminProductController::class);
    Route::resource('shifts', ShiftController::class);
    // Quản lý đơn hàng
    Route::resource('orders', AdminOrderController::class);

    // Quản lý Banner
    Route::resource('banners', BannerController::class);

    Route::resource('invoices', InvoiceController::class);

    // Quản lý danh mục
    Route::resource('categories', CategoryProductController::class);

    Route::resource('users', UserController::class);
    Route::get('users/{id}/toggle', [UserController::class, 'toggleActivation'])->name('users.toggle');
    Route::get('/', [StatisticsController::class, 'index'])->name('statistics.index');

    Route::resource('attribute_values', AttributeValueController::class);

    Route::resource('attributes', AttributeController::class);
});


require __DIR__ . '/auth.php';


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
Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::prefix('Coupons')
            ->name('Coupons.')
            ->controller(CouponsController::class)
            ->group(function () {
                Route::get('/Coupons', 'index')->name('index');
                Route::get('/addCoupons', 'create')->name('create');
                Route::post('/postCoupons', 'store')->name('store');
                Route::delete('/dlCoupons{id}', 'destroy')->name('destroy');
                Route::get('/edit{id}', 'edit')->name('edit');
                Route::post('/update{id}', 'update')->name('update');
            });
    });

Route::get('news', [HomeController::class, 'index']);

Route::get('/tin_tuc', [NewController::class, 'index2'])->name('news.index');
Route::get('tintuc/{id}', [NewController::class, 'tintucdetail'])->name('tintucdetail');

Route::get('/lienhe', function () {
    return view('user.khac.lienhe');
})->name('contact');
Route::get('/gioithieu', function () {
    return view('user.khac.gioithieu');
})->name('introduction');

Route::middleware(['auth'])->group(function () {
    // routes/web.php
    Route::post('/comment', [CommentController::class, 'store'])->name('comment.store');
});

Route::prefix('admin')->middleware('auth')->as('admin.')->group(function () {
    Route::get('/posts/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::put('/comments/{commentId}', [CommentController::class, 'update'])->name('comments.update');
    Route::post('/comments/{commentId}/hide', [CommentController::class, 'hide'])->name('comments.hide');
});
Route::get('/san-pham/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::post('/apply-voucher', [OrderController::class, 'applyVoucher'])->name('vocher');
Route::post('/san-pham/{id}', [ProductController::class, 'locMau'])->name('product.locMau');
Route::post('/update-address', [AddressController::class, 'updateAddress'])->name('user.updateAddress');
// // Route hiển thị danh sách voucher cho user
// Route::get('/vouchers', [VoucherController::class, 'index'])->name('user.vouchers');
//thông báo
Route::get('/api/get-latest-notifications', [HomeController::class, 'getLatestNotifications']);
Route::get('/product-comments/{product}', [CommentController::class, 'fetchComments'])->name('product.comments');
Route::get('admin/comments', [CommentController::class, 'index'])->name('admin.comments.index');
Route::post('admin/comments/{comment}/hide', [CommentController::class, 'hide'])->name('admin.comments.hide');
