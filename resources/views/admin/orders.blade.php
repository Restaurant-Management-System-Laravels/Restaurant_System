@extends('layouts.app')

@section('content')
<div class="p-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Admin - All Orders</h1>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $order->order_number }}</td>
                    <td class="px-6 py-4">{{ $order->created_at->format('M d, Y H:i') }}</td>
                    <td class="px-6 py-4">{{ $order->items->count() }} items</td>
                    <td class="px-6 py-4 font-semibold">{{ number_format($order->total, 2) }} Nu</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs rounded-full
                            @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->status == 'preparing') bg-blue-100 text-blue-800
                            @elseif($order->status == 'ready') bg-green-100 text-green-800
                            @elseif($order->status == 'completed') bg-gray-200 text-gray-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>

                    <td class="px-6 py-4">
                        <a href="#" class="text-purple-600 hover:text-purple-900 mr-3">View</a>
                        <a href="#" class="text-red-600 hover:text-red-900">Cancel</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                        No orders found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4 bg-gray-50">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
