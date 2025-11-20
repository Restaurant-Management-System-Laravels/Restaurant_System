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
        $foodsByCategory = $foods->groupBy('category');

        $foodCount    = $foods->count();
        $burgerCount  = $foods->where('category', 'Burger')->count();
        $chickenCount = $foods->where('category', 'Chicken')->count();
        $drinksCount  = $foods->where('category', 'Drinks')->count();
        $vegetableCount = $foods->where('category', 'Vegetable')->count();

        return view('cashier.dashboard', compact(
            'foods', 'foodCount', 'burgerCount', 'chickenCount', 
            'drinksCount', 'vegetableCount', 'foodsByCategory'
        ));
    }

   public function addToCart(Request $request)
    {
        $request->validate([
            'item_name' => 'required|string',
            'price'     => 'required|numeric',
            'image'     => 'required|string',
        ]);

        $cart = session()->get('cart', []);

        $itemExists = false;
        foreach ($cart as $index => $item) {
            if ($item['name'] === $request->item_name) {
                $cart[$index]['quantity']++;
                $itemExists = true;
                break;
            }
        }

        if (!$itemExists) {
            $cart[] = [
                'name'     => $request->item_name,
                'price'    => (float) $request->price,
                'quantity' => 1,
                'image'    => $request->image,
            ];
        }

        session()->put('cart', $cart);

        // Recalculate totals using any existing discount/extra values in session
        $this->calculateCartTotals();

        return redirect()->back()->with('success', 'Item added to cart!');
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
                $cart = array_values($cart);
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
            $cart = array_values($cart);
            session()->put('cart', $cart);
            $this->calculateCartTotals();
        }
        return redirect()->back()->with('success', 'Item removed from cart!');
    }

    public function clearCart()
    {
        session()->forget(['cart', 'cart_total', 'cart_tax', 'cart_subtotal', 'cart_discount', 'cart_extra']);
        return redirect()->back()->with('success', 'Cart cleared!');
    }

    // New: apply discount (absolute amount)
    public function applyDiscount(Request $request)
{
    $discount = $request->discount ?? 0;

    session()->put('cart_discount', $discount);

    return redirect()->back()->with('success', 'Discount Applied!');
}


    // New: apply extra charge (absolute amount)
    public function applyExtraCharge(Request $request)
    {
        $request->validate([
            'extra_charge' => 'nullable|numeric|min:0',
        ]);

        $extra = $request->input('extra_charge', 0);
        session()->put('cart_extra', (float) $extra);

        $this->calculateCartTotals();

        return redirect()->back()->with('success', 'Extra charge applied.');
    }

    public function createOrder(Request $request)
    {
        $cart = session('cart', []);
        $cartTotal = session('cart_total', 0);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Cart is empty!');
        }

        // Generate unique order number
        $latestOrder = Order::latest()->first();
        $nextId = $latestOrder ? $latestOrder->id + 1 : 1;
        $orderNumber = 'ORD-' . now()->format('Ymd') . '-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        // Save order to DB
        // NOTE: Ensure orders table has columns for discount & extra_charge if you want to store them.
        $order = Order::create([
            'order_number' => $orderNumber,
            'place'        => $request->place,
            'table_no'     => $request->table_no,
            'total'        => $cartTotal,
            'discount'     => session('cart_discount', 0),
            'extra_charge' => session('cart_extra', 0),
        ]);

        // Save order items
        foreach ($cart as $item) {
            $order->items()->create([
                'item_name' => $item['name'],
                'price'     => $item['price'],
                'quantity'  => $item['quantity'],
            ]);
        }

        // Clear cart
        session()->forget(['cart', 'cart_total', 'cart_tax', 'cart_subtotal', 'cart_discount', 'cart_extra']);

        return redirect()->route('cashier.receipt', $order->id);
    }

    public function showReceipt($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('cashier.receipt', compact('order'));
    }

    private function calculateCartTotals()
    {
        $cart = session()->get('cart', []);
        $subtotal = 0;

        foreach ($cart as $item) {
            $subtotal += ($item['price'] * $item['quantity']);
        }

        // 10% tax
        $tax = round($subtotal * 0.10, 2);

        $discount = (float) session('cart_discount', 0);
        $extra = (float) session('cart_extra', 0);

        // Net total calculation
        // Net = subtotal + tax + extra - discount
        $net = $subtotal + $tax + $extra - $discount;
        if ($net < 0) {
            $net = 0;
        }

        // Store nicely in session (2 decimal places)
        session()->put('cart_subtotal', round($subtotal, 2));
        session()->put('cart_tax', round($tax, 2));
        session()->put('cart_discount', round($discount, 2));
        session()->put('cart_extra', round($extra, 2));
        session()->put('cart_total', round($net, 2));
    }
}
