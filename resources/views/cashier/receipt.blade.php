@extends('layouts.app')

@section('content')
<div class="p-8 max-w-md mx-auto bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-4">Order Receipt</h2>

    <div class="mb-4">
        <div class="flex justify-between mb-2">
            <span>Order No:</span>
            <span class="font-bold">{{ $order->order_number }}</span>
        </div>
        <div class="flex justify-between mb-2">
            <span>Place:</span>
            <span>{{ $order->place }}</span>
        </div>
        @if($order->place === 'Dine In')
        <div class="flex justify-between mb-2">
            <span>Table No:</span>
            <span>{{ $order->table_no }}</span>
        </div>
        @endif
    </div>

    <div class="border-t pt-2">
        @foreach($order->items as $item)
        <div class="flex justify-between">
            <span>{{ $item->item_name }} x {{ $item->quantity }}</span>
            <span>₱{{ $item->price * $item->quantity }}</span>
        </div>
        @endforeach
        <div class="flex justify-between mt-2 font-bold">
            <span>Total:</span>
            <span>₱{{ $order->total }}</span>
        </div>
    </div>
</div>
@endsection
