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
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Models\Product;

Route::get('/', function () {
    return view('welcome');
})->name('home');

/* Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard'); */

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
});

require __DIR__.'/auth.php';
