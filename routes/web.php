<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
//     //return redirect()->route('login');
// });

// Landing Page and visitor Route
Route::get('/', [LandingPageController::class, 'index'])->name('home');
Route::get('/product/{id}', [LandingPageController::class, 'show'])->name('product.details');
Route::get('/products', [LandingPageController::class, 'showProducts'])->name('products.visitor');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');


// Cart Routes
Route::get('/cart', [CartController::class, 'show']);
Route::post('/add-to-cart', [CartController::class, 'addToCart']);
Route::post('/update-cart', [CartController::class, 'updateCart']);
Route::post('/remove-cart', [CartController::class, 'removeCart']);
Route::post('/place-order', [CartController::class, 'checkout']);


Route::get('/admin/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


// ********************    step 7 pdf file    ************************
// Middleware order matters
// admin middleware

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // product route
    Route::get('/admin/add-product', [ProductController::class, 'create'])->name('products.create');
    Route::post('/admin/add-product', [ProductController::class, 'store'])->name('products.store');
    Route::get('/admin/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/admin/update-product/{id}', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/admin/update-product/{id}', [ProductController::class, 'updated'])->name('product.updated');
    Route::delete('/admin/delete-product/{id}', [ProductController::class, 'destroy']);
    Route::get('/admin/manage-user', [AdminController::class, 'create'])->name('admin.users');
    Route::put('/admin/user-status/{id}', [UserController::class, 'updateStatus']);

    // Suppliers Route
    Route::get('/admin/suppliers', [SupplierController::class, 'index'])->name('admin.supplier');
    Route::get('/admin/add-supplier', [SupplierController::class, 'create']);
    Route::post('/admin/suppliers/store', [SupplierController::class, 'store']);
    Route::get('/admin/suppliers/edit/{id}', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::put('/admin/suppliers/update/{id}', [SupplierController::class, 'update'])->name('supplier.update');
    Route::delete('/admin/suppliers/delete/{id}', [SupplierController::class, 'destroy'])->name('supplier.delete');

    // Purchases Routes
    Route::get('/admin/purchases', [PurchaseController::class, 'index'])->name('purchase.index');
    Route::get('/admin/add-purchase', [PurchaseController::class, 'create'])->name('purchase.create');
    Route::post('/admin/add-purchase-store', [PurchaseController::class, 'store'])->name('purchase.store');
    Route::get('/admin/edit-purchase/{id}', [PurchaseController::class, 'edit'])->name('purchase.edit');
    Route::put('/admin/update-purchase/{id}', [PurchaseController::class, 'update'])->name('purchase.update');
    Route::delete('/admin/delete-purchase/{id}', [PurchaseController::class, 'destroy'])->name('purchase.delete');
    Route::get('/admin/purchase/{id}', [PurchaseController::class, 'show'])->name('purchase.show');

    // Customers Route
    Route::get('/admin/customers', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('/admin/add-customer', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('/admin/customers/store', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('/admin/customers/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::put('/admin/customers/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
    Route::delete('/admin/customer/delete/{id}', [CustomerController::class, 'destroy'])->name('customer.delete');

    // Sales Routes
    Route::get('/admin/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('/admin/add-sale', [SaleController::class, 'create'])->name('sale.create');
    Route::get('/admin/sale/{id}', [SaleController::class, 'show'])->name('sale.show');
    Route::post('/admin/sales/store', [SaleController::class, 'store'])->name('sale.store');
    Route::get('/admin/edit-sale/{id}', [SaleController::class, 'edit'])->name('sale.edit');
    Route::put('/admin/update-sale/{id}', [SaleController::class, 'update'])->name('sale.update');
    Route::delete('/admin/delete-sale/{id}', [SaleController::class, 'destroy'])->name('sale.delete');

    // Orders
    Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::post('/admin/orders/update-status/{id}',[OrderController::class, 'updateStatus']);
});

// user middleware
Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
});
