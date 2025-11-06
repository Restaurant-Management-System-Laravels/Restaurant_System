<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order #{{ $order->order_number }} - Print</title>
    <style>
        @media print {
            body { margin: 0; padding: 20px; }
            .no-print { display: none; }
        }
        body {
            font-family: 'Courier New', monospace;
            max-width: 300px;
            margin: 0 auto;
            padding: 20px;
        }
        h1, h2 { text-align: center; margin: 10px 0; }
        .line { border-top: 1px dashed #000; margin: 10px 0; }
        .item { display: flex; justify-content: space-between; margin: 5px 0; }
        .total { font-weight: bold; font-size: 1.2em; }
    </style>
</head>
<body>
    <h1>TASTY STATION</h1>
    <h2>Order Receipt</h2>
    
    <div class="line"></div>
    
    <p><strong>Order:</strong> #{{ $order->order_number }}</p>
    <p><strong>Table:</strong> {{ $order->table->table_number }}</p>
    <p><strong>Date:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
    <p><strong>People:</strong> {{ $order->number_of_people }}</p>
    
    <div class="line"></div>
    
    <h3>Items:</h3>
    @foreach($order->items as $item)
    <div class="item">
        <span>{{ $item->quantity }}x {{ $item->menuItem->name }}</span>
        <span>${{ number_format($item->price * $item->quantity, 2) }}</span>
    </div>
    @endforeach
    
    <div class="line"></div>
    
    <div class="item">
        <span>Subtotal:</span>
        <span>${{ number_format($order->subtotal, 2) }}</span>
    </div>
    <div class="item">
        <span>Tax (6%):</span>
        <span>${{ number_format($order->tax, 2) }}</span>
    </div>
    <div class="item">
        <span>Donation:</span>
        <span>${{ number_format($order->donation, 2) }}</span>
    </div>
    
    <div class="line"></div>
    
    <div class="item total">
        <span>TOTAL:</span>
        <span>${{ number_format($order->total, 2) }}</span>
    </div>
    
    @if($order->payment_method)
    <p style="text-align: center; margin-top: 20px;">
        <strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}
    </p>
    @endif
    
    <div class="line"></div>
    
    <p style="text-align: center; margin-top: 20px;">Thank you for your visit!</p>
    
    <div class="no-print" style="text-align: center; margin-top: 30px;">
        <button onclick="window.print()" style="padding: 10px 20px; font-size: 16px; cursor: pointer;">
            Print Receipt
        </button>
        <button onclick="window.close()" style="padding: 10px 20px; font-size: 16px; cursor: pointer; margin-left: 10px;">
            Close
        </button>
    </div>
</body>
</html>