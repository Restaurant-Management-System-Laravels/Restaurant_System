<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
     public function index()
    {
        // Example method
        $orders = Order::all();
        return view('orders.print', compact('orders'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'table_id' => 'required|exists:tables,id',
            'number_of_people' => 'required|integer|min:1',
            'items' => 'required|array|min:1',
            'items.*.menu_item_id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'table_id' => $validated['table_id'],
                'user_id' => auth()->id(),
                'number_of_people' => $validated['number_of_people'],
                'status' => 'pending'
            ]);

            foreach ($validated['items'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $item['menu_item_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            $order->calculateTotals();

            // Update table status
            Table::find($validated['table_id'])->update(['status' => 'occupied']);

            DB::commit();

            return response()->json([
                'success' => true,
                'order' => $order->load('items.menuItem', 'table'),
                'message' => 'Order created successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create order: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'items' => 'sometimes|array',
            'items.*.menu_item_id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'status' => 'sometimes|in:pending,in_kitchen,ready,served,paid'
        ]);

        DB::beginTransaction();
        try {
            if (isset($validated['items'])) {
                // Delete existing items
                $order->items()->delete();

                // Add new items
                foreach ($validated['items'] as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'menu_item_id' => $item['menu_item_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ]);
                }

                $order->calculateTotals();
            }

            if (isset($validated['status'])) {
                $order->update(['status' => $validated['status']]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'order' => $order->load('items.menuItem', 'table'),
                'message' => 'Order updated successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update order: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_kitchen,ready,served,paid'
        ]);

        $order->update(['status' => $validated['status']]);

        return response()->json([
            'success' => true,
            'order' => $order,
            'message' => 'Order status updated successfully'
        ]);
    }

    public function pay(Request $request, Order $order)
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:cash,card,scan'
        ]);

        DB::beginTransaction();
        try {
            $order->update([
                'status' => 'paid',
                'payment_method' => $validated['payment_method'],
                'paid_at' => now()
            ]);

            // Update table status to available
            $order->table->update(['status' => 'available']);

            DB::commit();

            return response()->json([
                'success' => true,
                'order' => $order,
                'message' => 'Payment processed successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to process payment: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Order $order)
    {
        try {
            // Update table status if order is not paid
            if ($order->status !== 'paid') {
                $order->table->update(['status' => 'available']);
            }

            $order->delete();

            return response()->json([
                'success' => true,
                'message' => 'Order deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete order: ' . $e->getMessage()
            ], 500);
        }
    }

    public function print(Order $order)
    {
        $order->load('items.menuItem', 'table');
        return view('orders.print', compact('order'));
    }
}

