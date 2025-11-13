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
    
    Route::post('/create-order', [CashierController::class, 'createOrder'])->name('create-order');

    // Existing routes
    Route::post('/add-to-cart', [CashierController::class, 'addToCart'])->name('add-to-cart');
    Route::post('/increase-quantity/{index}', [CashierController::class, 'increaseQuantity'])->name('increase-quantity');
    Route::post('/decrease-quantity/{index}', [CashierController::class, 'decreaseQuantity'])->name('decrease-quantity');
    Route::delete('/remove-from-cart/{index}', [CashierController::class, 'removeFromCart'])->name('remove-from-cart');
    Route::delete('/clear-cart', [CashierController::class, 'clearCart'])->name('clear-cart');
});



// 🍳 Kitchen dashboard
Route::middleware(['auth', 'approved'])->get('/kitchen/dashboard', function () {
    return view('kitchen.dashboard');
})->name('kitchen.dashboard');

/// 🛠️ Admin routes (with middleware + prefix)
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard & Approvals
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/approvals', [AdminController::class, 'index'])->name('approvals');
        Route::post('/approve/{user}', [AdminController::class, 'approve'])->name('approve');
        Route::post('/reject/{user}', [AdminController::class, 'reject'])->name('reject');

        // Profile Management
        Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
        Route::put('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');
        Route::post('/update-profile-picture', [AdminController::class, 'updateProfilePicture'])->name('update-profile-picture');

        // Food Management
        Route::get('/foods', [AdminController::class, 'foods'])->name('foods');
        Route::get('/foods/create', [AdminController::class, 'createFood'])->name('foods.create');
        Route::post('/foods', [AdminController::class, 'storeFood'])->name('foods.store');
        Route::get('/foods/{id}/edit', [AdminController::class, 'editFood'])->name('foods.edit');
        Route::put('/foods/{id}', [AdminController::class, 'updateFood'])->name('foods.update');
        Route::delete('/foods/{id}', [AdminController::class, 'destroyFood'])->name('foods.destroy');

        // Table Management
        Route::get('/tables', [TableController::class, 'index'])->name('tables');
        Route::post('/tables', [TableController::class, 'store'])->name('tables.store');
        Route::get('/tables/{table}', [TableController::class, 'show'])->name('tables.show');
        Route::put('/tables/{table}', [TableController::class, 'update'])->name('tables.update');
        Route::delete('/tables/{table}', [TableController::class, 'destroy'])->name('tables.destroy');
        Route::patch('/tables/{table}/status', [TableController::class, 'updateStatus'])->name('tables.updateStatus');

        // Reservations
        Route::get('/reservations', [AdminController::class, 'reservations'])->name('reservations');

    });

// 🔓 Logout route (outside admin middleware)
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

// 🧾 API routes for POS
Route::prefix('api')
    ->middleware(['auth'])
    ->group(function () {
        Route::get('/tables/available', [TableController::class, 'getAvailableTables'])->name('api.tables.available');
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