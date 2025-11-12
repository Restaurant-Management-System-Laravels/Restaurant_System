<?php

use App\Http\Controllers\CashierController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🏠 Public Route
Route::get('/', function () {
    return view('welcome');
});

// 🕓 Waiting for approval page
Route::view('/pending', 'auth.pending')->name('pending');

// ✅ Role-based dashboard route
Route::middleware(['auth', 'approved'])->get('/dashboard', function () {
    $user = auth()->user();

    // Redirect each role to its dashboard
    return match ($user->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'cashier' => redirect()->route('cashier.dashboard'),
        'kitchen' => redirect()->route('kitchen.dashboard'),
        default => redirect()->route('user.dashboard'),
    };
})->name('dashboard');

// 👤 Customer/User dashboard
Route::middleware(['auth', 'approved'])->get('/user/dashboard', function () {
    return view('user.dashboard');
})->name('user.dashboard');



// 💰 Cashier dashboard
Route::middleware(['auth', 'approved'])->get('/cashier/dashboard', function () {
    return view('cashier.dashboard');
})->name('cashier.dashboard');

Route::prefix('cashier')->name('cashier.')->group(function () {
    
    // Main Dashboard
    Route::get('/dashboard', [CashierController::class, 'dashboard'])->name('dashboard');
    
    
    // Navigation Routes
    Route::get('/orders', [CashierController::class, 'orders'])->name('orders');
    Route::get('/order-details', [CashierController::class, 'orderDetails'])->name('order-details');
    Route::get('/business-centre', [CashierController::class, 'businessCentre'])->name('business-centre');
    Route::get('/day-closing', [CashierController::class, 'dayClosing'])->name('day-closing');
    Route::get('/reservations', [CashierController::class, 'reservations'])->name('reservations');
    Route::get('/reports', [CashierController::class, 'reports'])->name('reports');
    Route::get('/about', [CashierController::class, 'about'])->name('about');
    
    // Cart Operations
    Route::post('/add-to-cart', [CashierController::class, 'addToCart'])->name('add-to-cart');
    Route::post('/increase-quantity/{index}', [CashierController::class, 'increaseQuantity'])->name('increase-quantity');
    Route::post('/decrease-quantity/{index}', [CashierController::class, 'decreaseQuantity'])->name('decrease-quantity');
    Route::delete('/remove-from-cart/{index}', [CashierController::class, 'removeFromCart'])->name('remove-from-cart');
    Route::delete('/clear-cart', [CashierController::class, 'clearCart'])->name('clear-cart');
    
    // Order Creation
    Route::post('/create-order', [CashierController::class, 'createOrder'])->name('create-order');
    Route::get('/cashier/order-receipt/{id}', [CashierController::class, 'showReceipt'])
    ->name('cashier.order-receipt');
});





// 🍳 Kitchen dashboard
Route::middleware(['auth', 'approved'])->get('/kitchen/dashboard', function () {
    return view('kitchen.dashboard');
})->name('kitchen.dashboard');

// 🛠️ Admin routes for user approval

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/approve/{user}', [AdminController::class, 'approve'])->name('admin.approve');
    Route::post('/admin/reject/{user}', [AdminController::class, 'reject'])->name('admin.reject');
});

// POS Route for Cashier and Kitchen

Route::middleware(['auth'])->group(function () {

    Route::middleware('role:cashier,kitchen')->group(function () {
        Route::get('/cashier', [CashierController::class, 'dashboard'])->name('cashier.dashboard');
    });
});

// 🧍 Profile management
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';