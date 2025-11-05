<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CashierController;


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

Route::middleware(['auth'])->group(function () {
    Route::get('/cashier/dashboard', [CashierController::class, 'index'])
        ->name('cashier.dashboard');
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
        Route::get('/cashier', [CashierController::class, 'index'])->name('cashier.dashboard');
    });
});

// 🧍 Profile management
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
