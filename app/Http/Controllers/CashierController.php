<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Food;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CashierController extends Controller
{
    public function dashboard()
    {
        // Get all foods grouped by category
        $foodsByCategory = Food::all()->groupBy('category');
        
        // Count foods by category
        $foodCount = Food::count();
        $burgerCount = Food::where('category', 'burger')->count();
        $chickenCount = Food::where('category', 'chicken')->count();
        $drinksCount = Food::where('category', 'drinks')->count();
        $vegetableCount = Food::where('category', 'vegetable')->count();
        
        // Get next order number - ensure it's at least 1 if no orders exist
        $lastOrderNumber = Order::max('order_number');
        $nextOrderNumber = $lastOrderNumber ? $lastOrderNumber + 1 : 1;
        session(['next_order_number' => $nextOrderNumber]);
        
        return view('cashier.dashboard', compact(
            'foodsByCategory',
            'foodCount',
            'burgerCount',
            'chickenCount',
            'drinksCount',
            'vegetableCount'
        ));
    }

    public function addToCart(Request $request)
    {
        $cart = session()->get('cart', []);
        
        $itemName = $request->item_name;
        $itemPrice = $request->price;
        $itemImage = $request->image;
        
        // Check if item already exists in cart
        $found = false;
        foreach ($cart as $key => $item) {
            if ($item['name'] === $itemName) {
                $cart[$key]['quantity']++;
                $found = true;
                break;
            }
        }
        
        // If item not found, add new item
        if (!$found) {
            $cart[] = [
                'name' => $itemName,
                'price' => $itemPrice,
                'image' => $itemImage,
                'quantity' => 1
            ];
        }
        
        session()->put('cart', $cart);
        $this->calculateCartTotals();
        
        return redirect()->back();
    }

    public function increaseQuantity($index)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$index])) {
            $cart[$index]['quantity']++;
            session()->put('cart', $cart);
            $this->calculateCartTotals();
        }
        
        return redirect()->back();
    }

    public function decreaseQuantity($index)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$index])) {
            if ($cart[$index]['quantity'] > 1) {
                $cart[$index]['quantity']--;
            } else {
                unset($cart[$index]);
                $cart = array_values($cart); // Re-index array
            }
            session()->put('cart', $cart);
            $this->calculateCartTotals();
        }
        
        return redirect()->back();
    }

    public function removeFromCart($index)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$index])) {
            unset($cart[$index]);
            $cart = array_values($cart); // Re-index array
            session()->put('cart', $cart);
            $this->calculateCartTotals();
        }
        
        return redirect()->back();
    }

    public function clearCart()
    {
        session()->forget(['cart', 'cart_subtotal', 'cart_total', 'cart_discount', 'cart_extra']);
        return redirect()->back();
    }

    public function applyDiscount(Request $request)
    {
        $discount = $request->discount ?? 0;
        session()->put('cart_discount', $discount);
        $this->calculateCartTotals();
        
        return redirect()->back();
    }

    public function applyExtraCharge(Request $request)
    {
        $extraCharge = $request->extra_charge ?? 0;
        session()->put('cart_extra', $extraCharge);
        $this->calculateCartTotals();
        
        return redirect()->back();
    }

    private function calculateCartTotals()
    {
        $cart = session()->get('cart', []);
        $subtotal = 0;
        
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        $discount = session()->get('cart_discount', 0);
        $extra = session()->get('cart_extra', 0);
        $total = $subtotal + $extra - $discount;
        
        session()->put('cart_subtotal', $subtotal);
        session()->put('cart_total', $total);
    }

    public function createOrder(Request $request)
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Cart is empty');
        }
        
        // Create order
        $order = Order::create([
            'order_number' => $request->order_number,
            'cashier_id' => Auth::id(),
            'cashier_name' => Auth::user()->name,
            'place' => $request->place,
            'table_no' => $request->table_no ?? null,
            'subtotal' => $request->subtotal,
            'discount' => $request->discount,
            'extra_charge' => $request->extra_charge,
            'total' => $request->total,
            'status' => 'pending',
            'payment_status' => 'unpaid'
        ]);
        
        // Create order items
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'item_name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['price'] * $item['quantity'],
                'image' => $item['image']
            ]);
        }
        
        // Clear cart
        session()->forget(['cart', 'cart_subtotal', 'cart_total', 'cart_discount', 'cart_extra']);
        
        return redirect()->route('admin.orders')->with('success', 'Order created successfully');
    }

    public function profile()
    {
        return view('cashier.profile');
    }

    public function updateProfile(Request $request)
{
    $user = Auth::user();

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'current_password' => 'nullable|required_with:new_password',
        'new_password' => 'nullable|min:8|confirmed',
        'avatar' => 'nullable|image|max:2048'
    ]);

    if ($request->filled('current_password')) {
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }
        $user->password = Hash::make($request->new_password);
    }

    $user->name = $validated['name'];
    $user->email = $validated['email'];

    if ($request->hasFile('avatar')) {
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }
        $user->avatar = $request->file('avatar')->store('avatars', 'public');
    }

    $user->save();

    return back()->with('success', 'Profile updated successfully!');
}
}