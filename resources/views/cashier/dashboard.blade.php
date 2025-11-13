@extends('layouts.app')

@section('content')
<div class="flex h-screen bg-gray-50">
    <!-- Sidebar -->
    <div class="w-64 bg-white shadow-lg">
        <div class="p-6">
            <h1 class="text-3xl font-bold text-gray-800">Restra</h1>
        </div>
        <nav class="mt-6">
            <a href="{{ route('cashier.dashboard') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-50">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                Dashboard
            </a>
            
           
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 overflow-auto">
        <div class="p-8">
            <!-- Header Section -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <div class="grid grid-cols-2 gap-4 mb-4">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Place</label>
                        <select id="place-select" name="place" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                            <option value="Take Away">Take Away</option>
                            <option value="Dine In">Dine In</option>
                            <option value="Delivery">Delivery</option>
                        </select>
                    </div>
                
                  <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Table No</label>
                        <select id="table-select" name="table_no" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                            <option value="Tb10">Tb10</option>
                            <option value="Tb11">Tb11</option>
                            <option value="Tb12">Tb12</option>
                        </select>
                  </div> 
                </div>
            </div>

            <!-- Category Tabs -->
           <div class="flex gap-4 mb-6">
    <button onclick="filterCategory('all', this)" class="category-btn flex items-center gap-2 px-6 py-3 bg-purple-600 text-white rounded-lg shadow hover:bg-purple-700 transition">
        All Food
        <span class="bg-white text-purple-600 px-2 py-1 rounded text-sm font-semibold">{{ $foodCount }}</span>
    </button>

    <button onclick="filterCategory('burger', this)" class="category-btn flex items-center gap-2 px-6 py-3 bg-white text-gray-700 rounded-lg shadow hover:bg-gray-50 transition">
        Burger
        <span class="text-gray-500 text-sm">{{ $burgerCount }}</span>
    </button>

    <button onclick="filterCategory('chicken', this)" class="category-btn flex items-center gap-2 px-6 py-3 bg-white text-gray-700 rounded-lg shadow hover:bg-gray-50 transition">
        Chicken
        <span class="text-gray-500 text-sm">{{ $chickenCount }}</span>
    </button>

    <button onclick="filterCategory('drinks', this)" class="category-btn flex items-center gap-2 px-6 py-3 bg-white text-gray-700 rounded-lg shadow hover:bg-gray-50 transition">
        Drinks
        <span class="text-gray-500 text-sm">{{ $drinksCount }}</span>
    </button>

    <button onclick="filterCategory('vegetable', this)" class="category-btn flex items-center gap-2 px-6 py-3 bg-white text-gray-700 rounded-lg shadow hover:bg-gray-50 transition">
        Vegetable
        <span class="text-gray-500 text-sm">{{ $vegetableCount }}</span>
    </button>
</div>


            <br><br>

            <!-- Menu Items Grid -->
            <div class="mb-8">
                <div class="grid grid-cols-5 gap-4">
                     @foreach ($foodsByCategory as $category => $foods)
                    @foreach ($foods as $food)
                    <form action="{{ route('cashier.add-to-cart') }}" method="POST" class="menu-item"data-category="{{ strtolower($food->category) }}">
                         
                        @csrf
                         <input type="hidden" name="item_name" value="{{ $food->name }}">
                         <input type="hidden" name="price" value="{{ $food->price }}">
                        <button type="submit" class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden w-full text-left">
                         <img src="{{ asset('images/' . ($food->image ?? 'placeholder.jpg')) }}" class="w-full h-32 object-cover"
                          alt="{{ $food->name }}">

                            <div class="p-4">
                                 <h3>{{ $food->name }}</h3>
                                 <p>₱{{ $food->price }} </p>
                            </div>
                        </button>
                    </form>

                    @endforeach
                     @endforeach

                </div>
            </div>  
        </div>
    </div>
    
    <!-- Right Sidebar (Cart) -->
    <div class="w-96 bg-white shadow-lg p-6 overflow-auto">
        <!-- Table Info -->
        <div class="mb-6">
            <div class="flex justify-between items-center mb-4">
                <button class="p-2 bg-cyan-400 text-white rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </button>
                <button class="p-2 bg-purple-400 text-white rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </button>
            </div>
            
            <div class="text-center mb-2">
                <span class="text-sm text-gray-600">Give Discount</span>
                <span class="mx-4"></span>
                <span class="text-sm text-gray-600">Extra Charge</span>
            </div>
            
            <div class="grid grid-cols-3 gap-2 text-center mb-4">
    <div>
        <p class="text-xs text-gray-500">Table No</p>
        <p class="font-bold text-lg" id="receipt-table">Tb10</p>
    </div>

    <div>
        <p class="text-xs text-gray-500">Place</p>
        <p class="font-bold text-lg" id="receipt-place">Take Away</p>
    </div>

    <div class="flex justify-between mb-4">
    <span class="text-sm text-gray-500">Order No:</span>
    <span class="font-bold text-lg" id="receipt-order-number">1</span>
</div>

</div>

        </div>

        <!-- Cart Items -->
        <div class="mb-6 space-y-4">
            @if(session('cart') && count(session('cart')) > 0)
                @foreach(session('cart') as $index => $item)
                <div class="flex items-center gap-3 bg-gray-50 p-3 rounded-lg">
                    <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=100&h=100&fit=crop" alt="{{ $item['name'] }}" class="w-16 h-16 rounded-lg object-cover">
                    <div class="flex-1">
                        <h4 class="font-semibold text-gray-800">{{  $item['name']  }}</h4>
                        <p class="text-sm text-gray-600">₱{{ $item['price'] }}</p>
                        <div class="flex items-center gap-2 mt-2">
                            <form action="{{ route('cashier.decrease-quantity', $index) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="w-6 h-6 bg-gray-200 rounded text-gray-700 hover:bg-gray-300">-</button>
                            </form>
                            <span class="font-semibold">{{ $item['quantity'] }}</span>
                            <form action="{{ route('cashier.increase-quantity', $index) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="w-6 h-6 bg-gray-200 rounded text-gray-700 hover:bg-gray-300">+</button>
                            </form>
                        </div>
                    </div>
                    <form action="{{ route('cashier.remove-from-cart', $index) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-gray-400 hover:text-red-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </form>
                </div>
                @endforeach
            @else
                <div class="text-center py-8 text-gray-400">
                    <svg class="w-16 h-16 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <p>No items in cart</p>
                </div>
            @endif
        </div>

        <!-- Summary -->
        <div class="border-t pt-4 space-y-3">
            <div class="flex justify-between text-gray-600">
                <span>Total</span>
                <span class="font-semibold">{{ session('total',0) }}.00</span>
            </div>
            <div class="flex justify-between text-gray-600">
                <span>Discount</span>
                <span class="font-semibold">00.00</span>
            </div>
            
            <div class="flex justify-between text-xl font-bold text-gray-800 pt-3 border-t">
                <span>Net Payable</span>
                <span>{{ session('cart_total', 0) }}</span>
            </div>
        </div>

        <!-- Actions -->
        <div class="mt-6 space-y-3">
            <label class="flex items-center">
                <input type="checkbox" class="mr-2" checked>
                <span class="text-sm text-gray-600">Auto Print</span>
            </label>
            
            <form action="{{ route('cashier.create-order') }}" method="POST">
    @csrf

    <!-- Hidden inputs for receipt/order -->
    <input type="hidden" name="order_number" id="order-number" value="{{ session('cart') ? count(session('cart')) + 1 : 1 }}">
    <input type="hidden" name="place" id="order-place">
    <input type="hidden" name="table_no" id="order-table">

    <button type="submit" class="w-full bg-purple-600 text-white py-3 rounded-lg font-semibold hover:bg-purple-700 transition">
        Create Order
    </button>
</form>

            <form action="{{ route('cashier.clear-cart') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full bg-white border border-gray-300 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-50 transition">
                    Cancel
                </button>
            </form>
        </div>
    </div>
</div>

<script>
// Category Filter
function filterCategory(category, button) {
    const foods = document.querySelectorAll('.menu-item');
    foods.forEach(food => {
        food.style.display = (category === 'all' || food.dataset.category === category) ? 'block' : 'none';
    });

    document.querySelectorAll('.category-btn').forEach(btn => {
        btn.classList.remove('bg-purple-600', 'text-white');
        btn.classList.add('bg-white', 'text-gray-700');
    });

    button.classList.add('bg-purple-600', 'text-white');
    button.classList.remove('bg-white', 'text-gray-700');
}

// Place & Table Dynamic Handling
const placeSelect = document.getElementById('place-select');
const tableSelect = document.getElementById('table-select');
const tableContainer = document.getElementById('table-container');
const orderPlace = document.getElementById('order-place');
const orderTable = document.getElementById('order-table');

function updateTableVisibility() {
    if (placeSelect.value === 'Dine In') {
        tableSelect.parentElement.style.display = 'block'; // show table select
        orderTable.value = tableSelect.value;            // set hidden input
    } else {
        tableSelect.parentElement.style.display = 'none'; // hide table select
        orderTable.value = '';                             // clear hidden input
    }
    orderPlace.value = placeSelect.value;                 // always set hidden input
}


placeSelect.addEventListener('change', updateTableVisibility);
tableSelect.addEventListener('change', () => orderTable.value = tableSelect.value);

// Initialize on page load
updateTableVisibility();

// Update receipt dynamically
const receiptPlace = document.getElementById('receipt-place');
const receiptTable = document.getElementById('receipt-table');

function updateReceipt() {
    receiptPlace.textContent = placeSelect.value;
    receiptTable.textContent = placeSelect.value === 'Dine In' ? tableSelect.value : '-';
}

// Call it whenever the dropdowns change
placeSelect.addEventListener('change', () => {
    updateTableVisibility();
    updateReceipt();
});

tableSelect.addEventListener('change', updateReceipt);

// Initialize on page load
updateReceipt();

</script>


@endsection