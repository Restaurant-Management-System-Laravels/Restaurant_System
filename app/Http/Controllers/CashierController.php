<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\MenuItem;
use App\Models\Table;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    public function index()
    {
        $orders = Order::with(['table', 'items.menuItem'])
            ->whereDate('created_at', today())
            ->whereIn('status', ['pending', 'in_kitchen', 'ready'])
            ->latest()
            ->get();

        $menuItems = MenuItem::where('is_available', true)->get();
        $tables = Table::all();

        return view('cashier.dashboard', compact('orders', 'menuItems', 'tables'));
    }

    public function getOrder($id)
    {
        $order = Order::with(['table', 'items.menuItem'])->findOrFail($id);
        return response()->json($order);
    }

    public function getMenuItems(Request $request)
    {
        $category = $request->get('category');
        
        $query = MenuItem::where('is_available', true);
        
        if ($category && $category !== 'all') {
            $query->where('category', $category);
        }
        
        $items = $query->get();
        
        return response()->json($items);
    }
}