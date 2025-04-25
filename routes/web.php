<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Models\Product;

Route::get('/', function () {
    //return view('welcome');
    return redirect('/login');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::resource('categories', CategoryController::class)->names('categories');

    Route::resource('products', ProductController::class)->names('products');

    Route::resource('vendors', VendorController::class)->names('vendors');

    Route::resource('entries', EntryController::class)->names('entries');

    Route::resource('customers', CustomerController::class)->names('customers');
 
    Route::resource('users', UserController::class)->names('users');

    Route::resource('invoices', InvoiceController::class)->names('invoices');

    Route::get('/api/categories/search', [CategoryController::class, 'search'])->name('categories.search');

    Route::get('/api/vendors/search', [VendorController::class, 'search'])->name('vendors.search');

    Route::get('/api/products/search', [ProductController::class, 'search'])->name('products.search');

    Route::get('/api/customers/search', [CustomerController::class, 'search'])->name('customers.search');

    Route::get('/api/products/search2', [ProductController::class, 'search2'])->name('products.search2');


    Route::get('reports/index', [ReportController::class, 'index'])->name('reports.index');

    // 1. Current stock report
    Route::get('reports/stock', [ReportController::class, 'stock'])->name('reports.stock');

    // 2. Low stock report
    Route::get('/low-stock', [ReportController::class, 'lowStock'])->name('reports.lowStock');

    // 3. Inventory movements (entries & exits)
    Route::get('/movements', [ReportController::class, 'inventoryMovements'])->name('reports.inventoryMovements');

    // 4. Sales report (by date)
    Route::get('/sales', [ReportController::class, 'sales'])->name('reports.sales');

    // 5. Top-selling products
    Route::get('/top-products', [ReportController::class, 'topProducts'])->name('reports.topProducts');

    // 7. Product history (individual product log)
    Route::get('/product-history/{id}', [ReportController::class, 'productHistory'])->name('reports.productHistory');

    // 8. Purchase report
    Route::get('/purchases', [ReportController::class, 'purchases'])->name('reports.purchases');
});

require __DIR__.'/auth.php';
