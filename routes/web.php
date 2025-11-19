<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\WarrantyController;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/test', function() {
    return view('test');
})->name('test');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/product/{slug}', [HomeController::class, 'showProduct'])->name('product.show');
Route::post('/cart/add/{productId}', [HomeController::class, 'addToCart'])->name('cart.add');
Route::post('/product/buy/{productId}', [HomeController::class, 'buyProduct'])->name('product.buy');
Route::get('/search', [HomeController::class, 'search'])->name('search');

// Warranty routes
Route::get('/warranty/check', [WarrantyController::class, 'check'])->name('warranty.check');
Route::post('/warranty/search', [WarrantyController::class, 'search'])->name('warranty.search');
Route::post('/warranty/claim', [WarrantyController::class, 'claim'])->name('warranty.claim');

// Route group cho admin - TẤT CẢ route admin đều được bảo vệ bởi middleware admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Product management
    Route::get('products/export-excel', [App\Http\Controllers\Admin\ProductController::class, 'exportExcel'])->name('products.exportExcel');
    Route::post('products/import-excel', [App\Http\Controllers\Admin\ProductController::class, 'importExcel'])->name('products.importExcel');
    Route::post('products/{product}/delete-image', [App\Http\Controllers\Admin\ProductController::class, 'deleteAdditionalImage'])->name('products.deleteImage');
    Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
    
    // Category management
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);

    // Warranty management
    Route::get('warranties/claims', [App\Http\Controllers\Admin\WarrantyController::class, 'claims'])->name('warranties.claims');
    Route::patch('warranties/claims/{claim}/status', [App\Http\Controllers\Admin\WarrantyController::class, 'updateClaimStatus'])->name('warranties.claims.update-status');
    // Đặt export/import TRƯỚC resource để tránh bị nuốt bởi {warranty}
    Route::get('warranties/export-excel', [App\Http\Controllers\Admin\WarrantyController::class, 'exportExcel'])->name('warranties.exportExcel');
    Route::post('warranties/import-excel', [App\Http\Controllers\Admin\WarrantyController::class, 'importExcel'])->name('warranties.importExcel');
    Route::post('warranties/destroy-all', [App\Http\Controllers\Admin\WarrantyController::class, 'destroyAll'])->name('warranties.destroyAll');
    Route::resource('warranties', App\Http\Controllers\Admin\WarrantyController::class);

    // Repair Forms Routes
    Route::resource('repair-forms', App\Http\Controllers\Admin\RepairFormController::class);
    Route::get('repair-forms/{repairForm}/export-word', [App\Http\Controllers\Admin\RepairFormController::class, 'exportWord'])->name('repair-forms.exportWord');
    Route::get('warranties/{warranty}/create-repair-form', [App\Http\Controllers\Admin\RepairFormController::class, 'createFromWarranty'])->name('repair-forms.createFromWarranty');
    Route::get('warranty-claims/{warrantyClaim}/create-repair-form', [App\Http\Controllers\Admin\RepairFormController::class, 'createFromClaim'])->name('repair-forms.createFromClaim');

    // Order management
    Route::get('orders', [\App\Http\Controllers\Admin\OrderAdminController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [\App\Http\Controllers\Admin\OrderAdminController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}', [\App\Http\Controllers\Admin\OrderAdminController::class, 'update'])->name('orders.update');
    Route::delete('orders/{order}', [\App\Http\Controllers\Admin\OrderAdminController::class, 'destroy'])->name('orders.destroy');

    // Banners management
    Route::resource('banners', \App\Http\Controllers\Admin\BannerController::class);
    // Có thể thêm resource khác: users...
});

Route::middleware('auth')->group(function () {
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'viewCart'])->name('cart.view');
    Route::post('/cart/add/{productId}', [\App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/update/{itemId}', [\App\Http\Controllers\CartController::class, 'updateCart'])->name('cart.update');
    Route::post('/cart/remove/{itemId}', [\App\Http\Controllers\CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::get('/checkout', [\App\Http\Controllers\CartController::class, 'showCheckout'])->name('checkout.show');
    Route::post('/checkout/info', [\App\Http\Controllers\CartController::class, 'postCheckoutInfo'])->name('checkout.info');
    Route::post('/checkout/confirm', [\App\Http\Controllers\CartController::class, 'confirmOrder'])->name('checkout.confirm');
    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [\App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
    

});

Route::get('/dashboard', function () {
    return view('welcome'); // hoặc trả về view dashboard riêng nếu có
})->name('dashboard');

require __DIR__.'/auth.php';
