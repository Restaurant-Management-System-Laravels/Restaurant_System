<x-app-layout>
    <x-slot name="header">
        <h2 class="dashboard-title">💳 POS Dashboard</h2>
    </x-slot>

    <div class="pos-dashboard">

        {{-- ✅ Top Bar --}}
        <div class="top-bar">
            <input type="text" class="search-bar" placeholder="🔍 Search products...">
            <div class="user-info">
                <span class="username">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout-btn">Logout</button>
                </form>
            </div>
        </div>

        {{-- 📦 POS Layout --}}
        <div class="pos-layout">
            {{-- ✅ Left Side: Product Grid --}}
            <div class="product-grid">
                @foreach ($products as $product)
                    <div class="product-card">
                        <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}">
                        <h3>{{ $product->name }}</h3>
                        <p class="price">₱{{ number_format($product->price, 2) }}</p>
                        <button class="add-btn">Add</button>
                    </div>
                @endforeach
            </div>

            {{-- ✅ Right Side: Cart --}}
            <div class="cart-panel">
                <h3 class="cart-title">🛒 Order Summary</h3>
                <div class="cart-items">
                    @forelse ($cartItems as $item)
                        <div class="cart-item">
                            <span>{{ $item->name }}</span>
                            <span>₱{{ number_format($item->price, 2) }}</span>
                        </div>
                    @empty
                        <p class="empty-cart">No items yet.</p>
                    @endforelse
                </div>

                <div class="cart-footer">
                    <div class="total">
                        <span>Total:</span>
                        <strong>₱{{ number_format($total, 2) }}</strong>
                    </div>
                    <button class="checkout-btn">Checkout</button>
                </div>
            </div>
        </div>
    </div>

    {{-- 🎨 Inline Styles --}}
    <style>
        .pos-dashboard {
            background: #f9fafb;
            min-height: 100vh;
            padding: 30px 20px;
        }

        .dashboard-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 20px;
        }

        /* 🔹 Top Bar */
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            border-radius: 10px;
            padding: 12px 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            margin-bottom: 25px;
        }

        .search-bar {
            width: 50%;
            padding: 8px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .username {
            font-weight: 600;
            color: #1e293b;
        }

        .logout-btn {
            background: #dc2626;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .logout-btn:hover {
            background: #b91c1c;
        }

        /* 🔹 Layout */
        .pos-layout {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
        }

        /* 🔹 Product Grid */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 15px;
        }

        .product-card {
            background: white;
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            transition: 0.2s ease;
        }

        .product-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }

        .product-card img {
            width: 100%;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 8px;
        }

        .product-card h3 {
            font-size: 1rem;
            color: #1e293b;
            font-weight: 600;
        }

        .price {
            color: #16a34a;
            font-weight: 600;
            margin: 5px 0;
        }

        .add-btn {
            background: #2563eb;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            cursor: pointer;
        }

        .add-btn:hover {
            background: #1d4ed8;
        }

        /* 🔹 Cart Panel */
        .cart-panel {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .cart-title {
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 10px;
        }

        .cart-items {
            flex-grow: 1;
            overflow-y: auto;
            max-height: 400px;
            margin-bottom: 20px;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f1f5f9;
            font-weight: 500;
        }

        .empty-cart {
            text-align: center;
            color: #94a3b8;
            padding: 20px;
        }

        .cart-footer {
            border-top: 1px solid #e2e8f0;
            padding-top: 12px;
        }

        .total {
            display: flex;
            justify-content: space-between;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .checkout-btn {
            background: #16a34a;
            color: white;
            border: none;
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
        }

        .checkout-btn:hover {
            background: #15803d;
        }
    </style>
</x-app-layout>
