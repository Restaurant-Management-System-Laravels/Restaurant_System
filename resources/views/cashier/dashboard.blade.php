<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Restra - Cashier Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="flex items-center justify-between px-8 py-4">
            <div class="p-6">
                <h1 class="text-3xl font-bold text-gray-800">Restra</h1>
            </div>
            <!-- Profile Section -->
            <div class="flex items-center space-x-3">
                    <a href="{{ route('cashier.profile') }}" class="flex items-center gap-3 hover:bg-gray-50 px-4 py-2 rounded-lg transition">
                            <div class="text-right">
                                <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-purple-100 overflow-hidden flex items-center justify-center">
                                @if(Auth::user()->profile_picture)
                                <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile" class="w-full h-full object-cover">
                                @else
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                @endif
                            </div>
                        </a>
            </div>
        </div>
    </header>
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg">
           
            <nav class="mt-6">
                <a href="{{ route('cashier.dashboard') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    Dashboard
                </a>

                <form action="{{ route('logout') }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-6 py-3 text-red-600 hover:bg-red-50">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
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
                            </select>
                        </div>
                    
                        <div id="table-container">
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
                    <button onclick="filterCategory('all', this)" class="category-btn flex items-center gap-2 px-6 py-3 bg-white text-gray-700 rounded-lg shadow hover:bg-purple-700 transition">
                        All Food
                        <span class="text-white-500 text-sm">{{ $foodCount }}</span>
                    </button>

                    <button onclick="filterCategory('burger', this)" class="category-btn flex items-center gap-2 px-6 py-3 bg-white text-gray-700 rounded-lg shadow hover:bg-purple-700 transition">
                        Burger
                        <span class="text-white-500 text-sm">{{ $burgerCount }}</span>
                    </button>

                    <button onclick="filterCategory('chicken', this)" class="category-btn flex items-center gap-2 px-6 py-3 bg-white text-gray-700 rounded-lg shadow hover:bg-purple-700 transition">
                        Chicken
                        <span class="text-gray-500 text-sm">{{ $chickenCount }}</span>
                    </button>

                    <button onclick="filterCategory('drinks', this)" class="category-btn flex items-center gap-2 px-6 py-3 bg-white text-gray-700 rounded-lg shadow hover:bg-purple-700 transition">
                        Drinks
                        <span class="text-gray-500 text-sm">{{ $drinksCount }}</span>
                    </button>

                    <button onclick="filterCategory('vegetable', this)" class="category-btn flex items-center gap-2 px-6 py-3 bg-white text-gray-700 rounded-lg shadow hover:bg-purple-700 transition">
                        Vegetable
                        <span class="text-gray-500 text-sm">{{ $vegetableCount }}</span>
                    </button>
                </div>

                <!-- Menu Items Grid -->
                <div class="mb-8">
                    <div class="grid grid-cols-5 gap-4">
                        @foreach ($foodsByCategory as $category => $foods)
                            @foreach ($foods as $food)
                            <form action="{{ route('cashier.add-to-cart') }}" method="POST" class="menu-item" data-category="{{ strtolower($food->category) }}">
                                @csrf
                                <input type="hidden" name="item_name" value="{{ $food->name }}">
                                <input type="hidden" name="price" value="{{ $food->price }}">
                                <input type="hidden" name="image" value="{{ $food->image }}">

                                <button type="submit" class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden w-full text-left">
                                    <img src="{{ asset('storage/' . $food->image) }}" alt="{{ $food->name }}" class="w-full h-32 object-cover">
                                    <div class="p-4">
                                        <h3 class="font-semibold text-gray-800">{{ $food->name }}</h3>
                                        <p class="text-purple-600 font-bold">₱{{ $food->price }}</p>
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
            <!-- Discount/Extra Charge Buttons -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-4">
                    <button onclick="showDiscountModal()" class="p-2 bg-cyan-400 text-white rounded-lg hover:bg-cyan-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                    <button onclick="showExtraChargeModal()" class="p-2 bg-purple-400 text-white rounded-lg hover:bg-purple-500">
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

                    <div>
                        <p class="text-xs text-gray-500">Order No</p>
                        <p class="font-bold text-lg" id="receipt-order-number">{{ session('next_order_number', 1) }}</p>
                    </div>
                </div>
            </div>

            <!-- Cart Items -->
            <div class="mb-6 space-y-4">
                @if(session('cart') && count(session('cart')) > 0)
                    @foreach(session('cart') as $index => $item)
                    <div class="flex items-center gap-3 bg-gray-50 p-3 rounded-lg">
                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-16 h-16 rounded-lg object-cover">
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-800">{{ $item['name'] }}</h4>
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
                    <span>Subtotal</span>
                    <span class="font-semibold">₱{{ number_format(session('cart_subtotal', 0), 2) }}</span>
                </div>

                <div class="flex justify-between text-gray-600">
                    <span>Extra Charge</span>
                    <span class="font-semibold">₱{{ number_format(session('cart_extra', 0), 2) }}</span>
                </div>

                <div class="flex justify-between text-gray-600">
                    <span>Discount</span>
                    <span class="font-semibold text-red-600">-₱{{ number_format(session('cart_discount', 0), 2) }}</span>
                </div>

                <div class="flex justify-between text-xl font-bold text-gray-800 pt-3 border-t">
                    <span>Net Payable</span>
                    <span>₱{{ number_format(session('cart_total', 0), 2) }}</span>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-6 space-y-3">
                <label class="flex items-center">
                    <input type="checkbox" id="auto-print" class="mr-2" checked>
                    <span class="text-sm text-gray-600">Auto Print</span>
                </label>

                <form action="{{ route('cashier.create-order') }}" method="POST" id="create-order-form">
                    @csrf
                    <input type="hidden" name="order_number" id="order-number" value="{{ session('next_order_number', 1) }}">
                    <input type="hidden" name="place" id="order-place">
                    <input type="hidden" name="table_no" id="order-table">
                    <input type="hidden" name="discount" value="{{ session('cart_discount', 0) }}">
                    <input type="hidden" name="extra_charge" value="{{ session('cart_extra', 0) }}">
                    <input type="hidden" name="subtotal" value="{{ session('cart_subtotal', 0) }}">
                    <input type="hidden" name="total" value="{{ session('cart_total', 0) }}">

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

    <!-- Discount Modal -->
    <div id="discount-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-96">
            <h3 class="text-xl font-bold mb-4">Apply Discount</h3>
            <form action="{{ route('cashier.apply-discount') }}" method="POST">
                @csrf
                <input type="number" name="discount" step="0.01" placeholder="Enter discount amount" class="w-full px-4 py-2 border rounded-lg mb-4">
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-purple-600 text-white py-2 rounded-lg hover:bg-purple-700">Apply</button>
                    <button type="button" onclick="closeDiscountModal()" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Extra Charge Modal -->
    <div id="extra-charge-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-96">
            <h3 class="text-xl font-bold mb-4">Apply Extra Charge</h3>
            <form action="{{ route('cashier.apply-extra-charge') }}" method="POST">
                @csrf
                <input type="number" name="extra_charge" step="0.01" placeholder="Enter extra charge amount" class="w-full px-4 py-2 border rounded-lg mb-4">
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-purple-600 text-white py-2 rounded-lg hover:bg-purple-700">Apply</button>
                    <button type="button" onclick="closeExtraChargeModal()" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400">Cancel</button>
                </div>
            </form>
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

        // Modal functions
        function showDiscountModal() {
            document.getElementById('discount-modal').classList.remove('hidden');
        }

        function closeDiscountModal() {
            document.getElementById('discount-modal').classList.add('hidden');
        }

        function showExtraChargeModal() {
            document.getElementById('extra-charge-modal').classList.remove('hidden');
        }

        function closeExtraChargeModal() {
            document.getElementById('extra-charge-modal').classList.add('hidden');
        }

        // Place & Table Dynamic Handling
        const placeSelect = document.getElementById('place-select');
        const tableSelect = document.getElementById('table-select');
        const orderPlace = document.getElementById('order-place');
        const orderTable = document.getElementById('order-table');
        const receiptPlace = document.getElementById('receipt-place');
        const receiptTable = document.getElementById('receipt-table');

        function updateTableVisibility() {
            if (placeSelect.value === 'Dine In') {
                tableSelect.parentElement.style.display = 'block';
                orderTable.value = tableSelect.value;
                receiptTable.textContent = tableSelect.value;
            } else {
                tableSelect.parentElement.style.display = 'none';
                orderTable.value = '';
                receiptTable.textContent = '-';
            }
            orderPlace.value = placeSelect.value;
            receiptPlace.textContent = placeSelect.value;
        }

        placeSelect.addEventListener('change', updateTableVisibility);
        tableSelect.addEventListener('change', () => {
            orderTable.value = tableSelect.value;
            receiptTable.textContent = tableSelect.value;
        });

        // Initialize on page load
        updateTableVisibility();
    </script>
</body>
</html>