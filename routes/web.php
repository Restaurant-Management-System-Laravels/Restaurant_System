<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'my_home'])->name('my_home');
Route::get('/home/dashboard', [HomeController::class, 'dashboard'])->name('home.dashboard');

Route::get('/reservation', [HomeController::class, 'index'])->name('reservation');
Route::post('/reservation', [HomeController::class, 'store'])->name('reservation.store');

// Approval waiting page
Route::view('/pending', 'auth.pending')->name('pending');

// ROLE-BASED DASHBOARD
Route::middleware(['auth', 'approved'])->get('/dashboard', function () {
    $user = auth()->user();

    return match ($user->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'cashier' => redirect()->route('cashier.dashboard'),
        'kitchen' => redirect()->route('kitchen.dashboard'),
        default => redirect()->route('home.dashboard'),
    };
})->name('dashboard');


// ---------------------------
// CASHIER ROUTES
// ---------------------------
Route::middleware(['auth', 'approved', 'role:cashier'])->prefix('cashier')->name('cashier.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [CashierController::class, 'dashboard'])->name('dashboard');

    // Profile
    Route::get('/profile', [CashierController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [CashierController::class, 'updateProfile'])->name('profile.update');
    Route::put('/password/update', [CashierController::class, 'updatePassword'])->name('password.update');

    // POS & Cart
    Route::post('/add-to-cart', [CashierController::class, 'addToCart'])->name('add-to-cart');
    Route::post('/increase-quantity/{index}', [CashierController::class, 'increaseQuantity'])->name('increase-quantity');
    Route::post('/decrease-quantity/{index}', [CashierController::class, 'decreaseQuantity'])->name('decrease-quantity');
    Route::delete('/remove-from-cart/{index}', [CashierController::class, 'removeFromCart'])->name('remove-from-cart');
    Route::delete('/clear-cart', [CashierController::class, 'clearCart'])->name('clear-cart');

    Route::post('/apply-discount', [CashierController::class, 'applyDiscount'])->name('apply-discount');
    Route::post('/apply-extra-charge', [CashierController::class, 'applyExtraCharge'])->name('apply-extra-charge');

    Route::post('/create-order', [CashierController::class, 'createOrder'])->name('create-order');
    Route::get('/receipt/{id}', [CashierController::class, 'showReceipt'])->name('receipt');
});


// ---------------------------
// ADMIN ROUTES
// ---------------------------
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard & Approvals
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/approvals', [AdminController::class, 'index'])->name('approvals');
    Route::post('/approve/{user}', [AdminController::class, 'approve'])->name('approve');
    Route::post('/reject/{user}', [AdminController::class, 'reject'])->name('reject');

    // Profile
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::put('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');
    Route::post('/update-profile-picture', [AdminController::class, 'updateProfilePicture'])->name('update-profile-picture');

    // Foods
    Route::get('/foods', [AdminController::class, 'foods'])->name('foods');
    Route::get('/foods/create', [AdminController::class, 'createFood'])->name('foods.create');
    Route::post('/foods', [AdminController::class, 'storeFood'])->name('foods.store');
    Route::get('/foods/{id}/edit', [AdminController::class, 'editFood'])->name('foods.edit');
    Route::put('/foods/{id}', [AdminController::class, 'updateFood'])->name('foods.update');
    Route::delete('/foods/{id}', [AdminController::class, 'destroyFood'])->name('foods.destroy');

    // Tables
    Route::get('/tables', [TableController::class, 'index'])->name('tables');
    Route::post('/tables', [TableController::class, 'store'])->name('tables.store');
    Route::get('/tables/{table}', [TableController::class, 'show'])->name('tables.show');
    Route::put('/tables/{table}', [TableController::class, 'update'])->name('tables.update');
    Route::delete('/tables/{table}', [TableController::class, 'destroy'])->name('tables.destroy');
    Route::patch('/tables/{table}/status', [TableController::class, 'updateStatus'])->name('tables.updateStatus');

    // Orders
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/orders/{id}', [AdminController::class, 'orderDetails'])->name('admin.order.details');
    Route::put('/orders/{id}/status', [AdminController::class, 'updateOrderStatus'])->name('order.status');
    Route::put('/orders/{id}/payment', [AdminController::class, 'updatePaymentStatus'])->name('order.payment');
    Route::delete('/orders/{id}', [AdminController::class, 'deleteOrder'])->name('order.delete');

    // Reservations
    Route::get('/reservations', [AdminController::class, 'reservations'])->name('reservations');
});

// Logout
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

// API ROUTES
Route::prefix('api')->middleware(['auth'])->group(function () {
    Route::get('/tables/available', [TableController::class, 'getAvailableTables'])->name('api.tables.available');
});

require __DIR__.'/auth.php';
