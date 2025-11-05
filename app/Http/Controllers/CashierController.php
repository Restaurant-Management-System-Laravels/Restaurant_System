<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CashierController extends Controller
{
   public function index(Request $request)
    {
        // Fetch all products for cashier view
        $products = Product::orderBy('name')->get();

        // Retrieve cart from session (or empty array)
        $cartItems = session('cart', []);

        // Compute total
        $total = collect($cartItems)->sum(function ($item) {
            return ($item['price'] ?? 0) * ($item['qty'] ?? 1);
        });

        return view('cashier.dashboard', compact('products', 'cartItems', 'total'));
    }
}
