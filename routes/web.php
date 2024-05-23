<?php

use App\Http\Controllers\Admin\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Users\SignInController;
use App\Http\Controllers\Admin\Users\SignUpController;
use App\Http\Controllers\Admin\Users\SignOutController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\Admin\CheckOutController;
use App\Http\Controllers\Admin\DetailController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\Author\CategoryController;
use App\Http\Controllers\Admin\Author\ProductAdminController;
use App\Http\Controllers\Admin\Author\ManageController;
use App\Http\Controllers\Admin\Author\SliderController;
use App\Http\Controllers\Admin\Author\VoucheradminController;
use App\Http\Controllers\Admin\Author\UserAdminController;
use App\Http\Controllers\Admin\PasswordController;
use App\Http\Controllers\Admin\PurchaseController;
use App\Http\Controllers\Admin\Users\ForgotPasswordController;


Route::get('/signin', [SignInController::class, 'index'])->name('users.signin');
Route::post('/signin', [SignInController::class, 'store'])->name(('users.signin'));
Route::get('/signup', [SignUpController::class, 'index'])->name('users.signup');
Route::post('/signup/send', [SignUpController::class, 'sendCreateLinkEmail'])->name('signup.send');
Route::get('/signup_verify/verify', [SignUpController::class, 'showVerifyOTPForm'])->name('signup_verify.verify');
Route::post('/signup_verify/verify', [SignUpController::class, 'verifyOtp'])->name('users.signup_verify');
Route::get('/signup_create_password', [SignUpController::class, 'showCreateForm'])->name('users.signup_create_password');
Route::post('/signup_create_password', [SignUpController::class, 'createPassword'])->name('signup_create_password');
Route::get('/signout', [SignOutController::class, 'index'])->name('signout');
Route::get('/forgot_password', [ForgotPasswordController::class, 'index'])->name('users.forgot_password');
Route::post('/forgot_password/send', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('forgot_password.send');
Route::get('/forgot_password_verify', [ForgotPasswordController::class, 'showVerifyOTPForm'])->name('forgot_password_verify.verify');
Route::post('/forgot_password_verify', [ForgotPasswordController::class, 'verifyOtp'])->name('users.forgot_password_verify');
Route::get('/reset_password', [ForgotPasswordController::class, 'showResetForm'])->name('users.reset_password');
Route::post('/reset_password', [ForgotPasswordController::class, 'resetPassword'])->name('reset_password');

// Guest
Route::get('/', [HomeController::class, 'guest'])->name('guest.home');
Route::get('/product', [ProductController::class, 'guest'])->name('guest.product');
Route::get('/product/category/{category}', [ProductController::class, 'guestProductsByCategory'])->name('guest.products.by.category');
Route::get('/detail/{id}', [DetailController::class, 'guest'])->name('guest.detail');
Route::get('/search_results', [ProductController::class, 'guestSearch'])->name('guest.product.search');


Route::middleware(['auth'])->group(function () {
    Route::middleware('role:1')->group(function () {
        Route::prefix('user')->group(function () {
            Route::get('/home', [HomeController::class, 'index'])->name('user.home');
            Route::get('/product', [ProductController::class, 'index'])->name('user.product');
            Route::get('/product/category/{category}', [ProductController::class, 'productsByCategory'])->name('products.by.category');
            Route::get('/search_results', [ProductController::class, 'search'])->name('product.search');
            Route::get('/all-products', [ProductController::class, 'allProducts'])->name('user.all-products');
            Route::get('/cart', [CartController::class, 'index'])->name('user.cart');
            Route::post('/cart', [CartController::class, 'store'])->name('user.cart.store');
            Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('user.cart.clear');
            Route::post('/cart/update/{cartId}', [CartController::class, 'updateCart'])->name('user.cart.update');
            Route::post('/cart/remove/{cartId}', [CartController::class, 'removeItem'])->name('user.cart.remove');
            Route::get('/checkout', [CheckOutController::class, 'index'])->name('user.checkout');
            Route::post('/checkout', [CheckOutController::class, 'index'])->name('user.checkout');
            Route::post('/checkout/vnpay', [CheckOutController::class, 'vnpay'])->name('user.checkout.vnpay');
            Route::get('/checkout/return', [CheckOutController::class, 'vnpayReturn'])->name('user.checkout.return');
            Route::get('/purchase', [CheckOutController::class, 'allOrders'])->name('user.purchase');
            Route::get('/order/{order}', [CheckOutController::class, 'orderSummary'])->name('user.order');
            Route::get('/profile/{id}', [ProfileController::class, 'index'])->name('user.profile');
            Route::post('/profile/{id}', [ProfileController::class, 'update'])->name('user.profile');
            Route::get('/voucher', [VoucherController::class, 'index'])->name('user.voucher');
            Route::post('/password/{id}', [PasswordController::class, 'changePassword'])->name('user.password');
            Route::get('/password/{id}', [PasswordController::class, 'index'])->name('user.password');
            Route::get('/detail/{id}', [DetailController::class, 'detail'])->name('user.detail');
            Route::post('/detail/toggleFavorite/{id}', [DetailController::class, 'toggleFavorite'])->name('user.toggleFavorite');
            Route::post('/products/{product}/comments', [CommentController::class, 'poComment'])->name('products.comments');
            Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
            Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.delete');
            Route::get('/vouchers', [ProfileController::class, 'showVouchers'])->name('user.vouchers');
        });
    });

    Route::middleware('role:2')->group(function () {
        Route::prefix('admin')->group(function () {
            Route::get('/', [ManageController::class, 'index'])->name('admin.home');
            Route::get('/profile', [ManageController::class, 'user'])->name('admin.profile');
            Route::post('/profile/update-information', [ManageController::class, 'updateInformation'])->name('admin.profile/updateInformation');
            Route::get('/statistics', [ManageController::class, 'statistics'])->name('admin.statistics');
            Route::get('/users', [UserAdminController::class, 'index'])->name('admin.users.index');
            Route::patch('/admin/customers/{id}/lock', [UserAdminController::class, 'lock'])->name('admin.customers.lock');
            Route::patch('/admin/customers/{id}/unlock', [UserAdminController::class, 'unlock'])->name('admin.customers.unlock');
            
            


            Route::prefix('/category')->group(function () {
                Route::get('/listcategory', [CategoryController::class, 'index'])->name('admin.category.index');
                Route::get('/create', [CategoryController::class, 'create'])->name('admin.category.create');
                Route::post('/store', [CategoryController::class, 'store'])->name('admin.category.store');
                Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('admin.category.edit');
                Route::post('/update/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
                Route::get('/delete/{id}', [CategoryController::class, 'delete'])->name('admin.category.delete');
            });
            Route::prefix('/product')->group(function () {
                Route::get('/listproduct', [ProductAdminController::class, 'index'])->name('admin.product.index');
                Route::get('/create', [ProductAdminController::class, 'create'])->name('admin.product.create');
                Route::post('/store', [ProductAdminController::class, 'store'])->name('admin.product.store');
                Route::get('/edit/{id}', [ProductAdminController::class, 'edit'])->name('admin.product.edit');
                Route::post('/update/{id}', [ProductAdminController::class, 'update'])->name('admin.product.update');
                Route::get('/delete/{id}', [ProductAdminController::class, 'delete'])->name('admin.product.delete');
            });
            Route::prefix('/slider')->group(function () {
                Route::get('/index', [SliderController::class, 'index'])->name('admin.slider.index');
                Route::get('/create', [SliderController::class, 'create'])->name('admin.slider.create');
                Route::post('/store', [SliderController::class, 'store'])->name('admin.slider.store');
                Route::get('/edit/{id}', [SliderController::class, 'edit'])->name('admin.slider.edit');
                Route::post('/update/{id}', [SliderController::class, 'update'])->name('admin.slider.update');
                Route::get('/delete/{id}', [SliderController::class, 'delete'])->name('admin.slider.delete');
            });
            Route::prefix('/voucher')->group(function () {
                Route::get('/listvoucher', [VoucheradminController::class, 'index'])->name('admin.vouchers.index');
                Route::get('/create', [VoucheradminController::class, 'create'])->name('admin.vouchers.create');
                Route::post('/store', [VoucheradminController::class, 'store'])->name('admin.vouchers.store');
                Route::get('/edit/{voucher}', [VoucheradminController::class, 'edit'])->name('admin.vouchers.edit');
                Route::put('/update/{voucher}', [VoucheradminController::class, 'update'])->name('admin.vouchers.update');
                Route::delete('/delete/{voucher}', [VoucheradminController::class, 'destroy'])->name('admin.vouchers.delete');
            });
        });
    });

    // Kiểm tra xem người dùng nhập link khác sẽ chuyển về trang login
    Route::get('/{any}', function () {
        return redirect()->route('user.home');
    })->where('any', '.*');
});
