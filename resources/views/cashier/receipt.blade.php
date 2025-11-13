@extends('layouts.app')

@section('content')
<div class="p-8">
    <h1 class="text-2xl font-bold mb-4">Order Receipt</h1>

    <p>Order No: {{ $order['order_number'] }}</p>
    <p>Place: {{ $order['place'] }}</p>
    <p>Table No: {{ $order['table_no'] ?: '-' }}</p>

    <table class="w-full mt-4 border">
        <thead>
            <tr>
                <th class="border px-2 py-1">Item</th>
                <th class="border px-2 py-1">Price</th>
                <th class="border px-2 py-1">Qty</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order['items'] as $item)
            <tr>
                <td class="border px-2 py-1">{{ $item['name'] }}</td>
                <td class="border px-2 py-1">₱{{ $item['price'] }}</td>
                <td class="border px-2 py-1">{{ $item['quantity'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p class="mt-4 font-bold">Total: ₱{{ $order['total'] }}</p>
</div>
@endsection
