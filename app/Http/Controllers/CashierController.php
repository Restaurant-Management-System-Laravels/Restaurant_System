<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Food;


use Illuminate\Http\Request;

class CashierController extends Controller
{
  
    public function dashboard()
    {
        $foods = Food::all();
        $foodsByCategory = Food::all()->groupBy('category');
        $foodCount = Food::count();
         $burgerCount    = $foods->where('category', 'Burger')->count();
    $chickenCount   = $foods->where('category', 'Chicken')->count();
    $drinksCount    = $foods->where('category', 'Drinks')->count();
    $vegetableCount = $foods->where('category', 'Vegetable')->count();

        return view('cashier.dashboard', compact('foods', 'foodCount', 'burgerCount', 'chickenCount', 'drinksCount', 'vegetableCount', 'foodsByCategory'));


    }
    public function orders()
    {
        return view('cashier.orders');
    }

    public function orderDetails()
    {
        return view('cashier.order-details');
    }

    public function businessCentre()
    {
        return view('cashier.business-centre');
    }

    public function dayClosing()
    {
        return view('cashier.day-closing');
    }

    public function reservations()
    {
        return view('cashier.reservations');
    }

    public function reports()
    {
        return view('cashier.reports');
    }

    public function about()
    {
        return view('cashier.about');
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string',
            'price' => 'required|numeric'
        ]);

        $cart = session()->get('cart', []);
        
        // Check if item already exists in cart
        $itemExists = false;
        foreach ($cart as $index => $item) {
            if ($item['name'] === $request->item_name) {
                $cart[$index]['quantity']++;
                $itemExists = true;
                break;
            }
        }

        // If item doesn't exist, add new item
        if (!$itemExists) {
            $cart[] = [
                'name' => $request->item_name,
                'price' => $request->price,
                'quantity' => 1
            ];
        }

        session()->put('cart', $cart);
        
        // Calculate totals
        $this->calculateCartTotals();

        return redirect()->back()->with('success', 'Item added to cart!');
    }

    public function increaseQuantity(Request $request, $index)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$index])) {
            $cart[$index]['quantity']++;
            session()->put('cart', $cart);
            $this->calculateCartTotals();
        }

        return redirect()->back();
    }

    public function decreaseQuantity(Request $request, $index)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$index])) {
            if ($cart[$index]['quantity'] > 1) {
                $cart[$index]['quantity']--;
            } else {
                unset($cart[$index]);
                $cart = array_values($cart); // Reindex array
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
            $cart = array_values($cart); // Reindex array
            session()->put('cart', $cart);
            $this->calculateCartTotals();
        }

        return redirect()->back()->with('success', 'Item removed from cart!');
    }

    public function clearCart()
    {
        session()->forget('cart');
        session()->forget('cart_total');
        session()->forget('cart_tax');

        return redirect()->back()->with('success', 'Cart cleared!');
    }

    public function createOrder(Request $request)
{
    $cart = session('cart', []);
    $cartTotal = session('cart_total', 0);

    if (empty($cart)) {
        return redirect()->back()->with('error', 'Cart is empty!');
    }

    // Generate a unique order number (e.g. "ORD-20251108-001")
    $latestOrder = \App\Models\Order::latest()->first();
    $nextId = $latestOrder ? $latestOrder->id + 1 : 1;
    $orderNumber = 'ORD-' . now()->format('Ymd') . '-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

    $order = Order::create([
        'order_number' => $orderNumber,
        'place' => $request->place,
        'table_no' => $request->table_no,
        'total' => $cartTotal,
    ]);

    foreach ($cart as $item) {
        $order->items()->create([
            'item_name' => $item['name'],
            'price' => $item['price'],
            'quantity' => $item['quantity'],
        ]);
    }

    session()->forget('cart');
    session()->forget('cart_total');

    return redirect()->route('cashier.receipt', $order->id);
}

public function showReceipt($id)
{
    $order = \App\Models\Order::with('items')->findOrFail($id);

    return view('cashier.receipt', compact('order'));
}


    private function calculateCartTotals()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $tax = round($total * 0.10); // 10% tax
        
        session()->put('cart_total', $total);
        session()->put('cart_tax', $tax);
    }
}