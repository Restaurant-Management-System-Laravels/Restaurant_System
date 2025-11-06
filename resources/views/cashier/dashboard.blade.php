
@extends('layouts.app')

@section('title', 'Cashier Dashboard - Tasty Station')

@section('content')
<div x-data="cashierDashboard()" x-init="init()" class="flex h-screen bg-gray-50">
    <!-- Sidebar -->
    <div class="w-64 bg-white border-r border-gray-200 flex flex-col">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-teal-500 rounded-lg flex items-center justify-center">
                    <i data-lucide="coffee" class="w-5 h-5 text-white"></i>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-gray-900">Tasty</h1>
                    <p class="text-xs text-gray-500">Station</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 p-4 space-y-2">
            <a href="{{ route('cashier.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg transition">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('cashier.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 bg-teal-50 text-teal-600 rounded-lg transition">
                <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                <span>Order Line</span>
            </a>
            <a href="{{ route('tables.index') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg transition">
                <i data-lucide="utensils-crossed" class="w-5 h-5"></i>
                <span>Manage Table</span>
            </a>
            <a href="{{ route('menu-items.index') }}" class="flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg transition">
                <i data-lucide="coffee" class="w-5 h-5"></i>
                <span>Manage Dishes</span>
            </a>
            
        </nav>

        <div class="p-4 border-t border-gray-200 space-y-2">
            
            <form method="POST" action="{{ route('logout') }}" class="inline w-full">
                @csrf
                <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg transition text-left">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Header -->
        <header class="bg-white border-b border-gray-200 px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex-1 max-w-xl">
                    <div class="relative">
                        <i data-lucide="search" class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400"></i>
                        <input
                            type="text"
                            x-model="searchQuery"
                            placeholder="Search menu, orders and more"
                            class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                        />
                    </div>
                </div>
                <div class="flex items-center space-x-4 ml-8">
                    <button class="p-2 hover:bg-gray-100 rounded-lg relative">
                        <i data-lucide="bell" class="w-5 h-5 text-gray-600"></i>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>
                    <div class="flex items-center space-x-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=14b8a6&color=fff" alt="User" class="w-10 h-10 rounded-full" />
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ auth()->user()->name ?? 'User' }}</p>
                            <p class="text-xs text-gray-500">{{ auth()->user()->role ?? 'Cashier' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="flex-1 overflow-hidden flex">
            <!-- Orders and Menu -->
            <div class="flex-1 overflow-y-auto p-8">
                <!-- Order Line Section -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Order Line</h2>
                    <div class="flex space-x-2 mb-6">
                        <button @click="filterStatus = 'all'" :class="filterStatus === 'all' ? 'bg-teal-500 text-white' : 'bg-gray-100 text-gray-600'" class="px-4 py-2 rounded-full text-sm font-medium">
                            All <span class="ml-1" :class="filterStatus === 'all' ? 'bg-white text-teal-500' : ''" class="px-2 rounded-full" x-text="orders.length"></span>
                        </button>
                        <button @click="filterStatus = 'in_kitchen'" :class="filterStatus === 'in_kitchen' ? 'bg-teal-500 text-white' : 'bg-gray-100 text-gray-600'" class="px-4 py-2 rounded-full text-sm font-medium">
                            In Kitchen <span class="ml-1" x-text="orders.filter(o => o.status === 'in_kitchen').length"></span>
                        </button>
                        <button @click="filterStatus = 'pending'" :class="filterStatus === 'pending' ? 'bg-teal-500 text-white' : 'bg-gray-100 text-gray-600'" class="px-4 py-2 rounded-full text-sm font-medium">
                            Wait List <span class="ml-1" x-text="orders.filter(o => o.status === 'pending').length"></span>
                        </button>
                        <button @click="filterStatus = 'ready'" :class="filterStatus === 'ready' ? 'bg-teal-500 text-white' : 'bg-gray-100 text-gray-600'" class="px-4 py-2 rounded-full text-sm font-medium">
                            Ready <span class="ml-1" x-text="orders.filter(o => o.status === 'ready').length"></span>
                        </button>
                    </div>

                    <div class="grid grid-cols-3 gap-4 mb-8">
                        <template x-for="order in filteredOrders" :key="order.id">
                            <div @click="selectOrder(order)" :class="getOrderColorClass(order.status)" class="p-4 rounded-xl cursor-pointer hover:shadow-md transition">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900" x-text="'Order #' + order.order_number"></p>
                                        <p class="text-xs text-gray-600" x-text="'Item: ' + order.items.reduce((sum, item) => sum + item.quantity, 0) + 'X'"></p>
                                    </div>
                                    <p class="text-sm font-medium text-gray-700" x-text="'Table ' + order.table.table_number"></p>
                                </div>
                                <div class="flex justify-between items-center">
                                    <p class="text-xs text-gray-600" x-text="getTimeAgo(order.created_at)"></p>
                                    <span :class="getStatusBadgeClass(order.status)" class="px-3 py-1 rounded-full text-xs font-medium" x-text="getStatusText(order.status)"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Foodies Menu -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Foodies Menu</h2>
                    <div class="flex space-x-2 mb-6 overflow-x-auto">
                        <template x-for="cat in categories" :key="cat.id">
                            <button
                                @click="selectedCategory = cat.id"
                                :class="selectedCategory === cat.id ? 'bg-white border-2 border-teal-500 text-gray-900' : 'bg-white border border-gray-200 text-gray-600'"
                                class="px-6 py-3 rounded-xl text-sm font-medium whitespace-nowrap"
                            >
                                <div class="flex items-center space-x-2">
                                    <span class="text-xl" x-text="cat.icon"></span>
                                    <div class="text-left">
                                        <p x-text="cat.name"></p>
                                        <p class="text-xs text-gray-500" x-text="cat.count + ' Items'"></p>
                                    </div>
                                </div>
                            </button>
                        </template>
                    </div>

                    <div class="grid grid-cols-4 gap-4">
                        <template x-for="item in filteredMenuItems" :key="item.id">
                            <div class="bg-white border border-gray-200 rounded-xl p-4">
                                <div class="text-5xl mb-3 text-center">🍽️</div>
                                <p class="text-xs text-gray-500 mb-1" x-text="item.category"></p>
                                <p class="text-sm font-semibold text-gray-900 mb-3" x-text="item.name"></p>
                                <div class="flex items-center justify-between">
                                    <p class="text-lg font-bold text-gray-900" x-text="'$' + parseFloat(item.price).toFixed(2)"></p>
                                    <button 
                                        @click="addItemToOrder(item)"
                                        class="w-8 h-8 bg-teal-500 rounded-lg flex items-center justify-center hover:bg-teal-600"
                                    >
                                        <i data-lucide="plus" class="w-4 h-4 text-white"></i>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Order Summary Sidebar -->
            <div class="w-96 bg-white border-l border-gray-200 flex flex-col" x-show="currentOrder">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900" x-text="'Table No #' + (currentOrder?.table?.table_number || 'N/A')"></h3>
                            <p class="text-sm text-gray-500" x-text="'Order #' + (currentOrder?.order_number || 'N/A')"></p>
                        </div>
                        <div class="flex space-x-2">
                            <button @click="editOrder()" class="p-2 hover:bg-gray-100 rounded-lg">
                                <i data-lucide="edit" class="w-5 h-5 text-gray-600"></i>
                            </button>
                            <button @click="deleteOrder()" class="p-2 hover:bg-gray-100 rounded-lg">
                                <i data-lucide="trash-2" class="w-5 h-5 text-gray-600"></i>
                            </button>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600" x-text="(currentOrder?.number_of_people || 0) + ' People'"></p>
                </div>

                <div class="flex-1 overflow-y-auto p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="font-semibold text-gray-900">Ordered Items</h4>
                        <span class="text-sm text-gray-500" x-text="String(currentOrder?.items?.reduce((sum, item) => sum + item.quantity, 0) || 0).padStart(2, '0')"></span>
                    </div>

                    <div class="space-y-4 mb-6">
                        <template x-for="item in currentOrder?.items || []" :key="item.id">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900" x-text="item.quantity + 'x ' + item.menu_item.name"></p>
                                </div>
                                <p class="text-sm font-semibold text-gray-900" x-text="'$' + (item.price * item.quantity).toFixed(2)"></p>
                            </div>
                        </template>
                    </div>

                    <div class="border-t border-gray-200 pt-4 space-y-3">
                        <h4 class="font-semibold text-gray-900 mb-4">Payment Summary</h4>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium text-gray-900" x-text="'$' + parseFloat(currentOrder?.subtotal || 0).toFixed(2)"></span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tax</span>
                            <span class="font-medium text-gray-900" x-text="'$' + parseFloat(currentOrder?.tax || 0).toFixed(2)"></span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Donation for Palestine</span>
                            <span class="font-medium text-gray-900" x-text="'$' + parseFloat(currentOrder?.donation || 0).toFixed(2)"></span>
                        </div>
                        <div class="flex justify-between text-lg font-bold pt-3 border-t border-gray-200">
                            <span>Total Payable</span>
                            <span x-text="'$' + parseFloat(currentOrder?.total || 0).toFixed(2)"></span>
                        </div>
                    </div>
                </div>

                <div class="p-6 border-t border-gray-200 space-y-4">
                    <div>
                        <h4 class="font-semibold text-gray-900 mb-3">Payment Method</h4>
                        <div class="grid grid-cols-3 gap-2">
                            <button @click="paymentMethod = 'cash'" :class="paymentMethod === 'cash' ? 'bg-teal-50 border-2 border-teal-500 text-teal-600' : 'border border-gray-200'" class="px-4 py-3 rounded-lg text-sm hover:border-teal-500">
                                💵 Cash
                            </button>
                            <button @click="paymentMethod = 'card'" :class="paymentMethod === 'card' ? 'bg-teal-50 border-2 border-teal-500 text-teal-600' : 'border border-gray-200'" class="px-4 py-3 rounded-lg text-sm hover:border-teal-500">
                                💳 Card
                            </button>
                            <button @click="paymentMethod = 'scan'" :class="paymentMethod === 'scan' ? 'bg-teal-50 border-2 border-teal-500 text-teal-600' : 'border border-gray-200'" class="px-4 py-3 rounded-lg text-sm hover:border-teal-500">
                                📱 Scan
                            </button>
                        </div>
                    </div>

                    <div class="flex space-x-2">
                        <button @click="printOrder()" class="flex-1 px-4 py-3 border border-gray-200 rounded-lg text-sm font-medium hover:bg-gray-50">
                            🖨️ Print
                        </button>
                        <button @click="processPayment()" class="flex-1 px-4 py-3 bg-teal-500 text-white rounded-lg text-sm font-medium hover:bg-teal-600">
                            🛒 Place Order
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function cashierDashboard() {
    return {
        orders: @json($orders),
        menuItems: @json($menuItems),
        tables: @json($tables),
        currentOrder: null,
        filterStatus: 'all',
        selectedCategory: 'special',
        searchQuery: '',
        paymentMethod: 'card',
        categories: [
            { id: 'all', name: 'All Menu', icon: '🍽️', count: 154 },
            { id: 'special', name: 'Special', icon: '⭐', count: 19 },
            { id: 'soups', name: 'Soups', icon: '🍲', count: 5 },
            { id: 'desserts', name: 'Desserts', icon: '🍰', count: 19 },
            { id: 'chickens', name: 'Chickens', icon: '🍗', count: 10 }
        ],

        init() {
            if (this.orders.length > 0) {
                this.selectOrder(this.orders[0]);
            }
            setTimeout(() => lucide.createIcons(), 100);
        },

        get filteredOrders() {
            if (this.filterStatus === 'all') {
                return this.orders;
            }
            return this.orders.filter(order => order.status === this.filterStatus);
        },

        get filteredMenuItems() {
            if (this.selectedCategory === 'all') {
                return this.menuItems;
            }
            return this.menuItems.filter(item => 
                item.category.toLowerCase() === this.selectedCategory.toLowerCase()
            );
        },

        selectOrder(order) {
            this.currentOrder = order;
        },

        getOrderColorClass(status) {
            const colors = {
                'in_kitchen': 'bg-teal-100',
                'pending': 'bg-red-100',
                'ready': 'bg-purple-100',
                'served': 'bg-green-100'
            };
            return colors[status] || 'bg-gray-100';
        },

        getStatusBadgeClass(status) {
            const colors = {
                'in_kitchen': 'bg-teal-500 text-white',
                'pending': 'bg-orange-500 text-white',
                'ready': 'bg-purple-500 text-white',
                'served': 'bg-green-500 text-white'
            };
            return colors[status] || 'bg-gray-500 text-white';
        },

        getStatusText(status) {
            const texts = {
                'in_kitchen': 'In Kitchen',
                'pending': 'Wait List',
                'ready': 'Ready',
                'served': 'Served',
                'paid': 'Paid'
            };
            return texts[status] || status;
        },

        getTimeAgo(date) {
            const seconds = Math.floor((new Date() - new Date(date)) / 1000);
            if (seconds < 60) return 'Just Now';
            const minutes = Math.floor(seconds / 60);
            if (minutes < 60) return minutes + ' mins ago';
            const hours = Math.floor(minutes / 60);
            return hours + ' hours ago';
        },

        addItemToOrder(menuItem) {
            if (!this.currentOrder) {
                alert('Please select or create an order first');
                return;
            }
            
            // Add item logic here
            console.log('Adding item:', menuItem);
        },

        async processPayment() {
            if (!this.currentOrder) return;
            
            if (!confirm('Process payment for this order?')) return;

            try {
                const response = await fetch(`/orders/${this.currentOrder.id}/pay`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        payment_method: this.paymentMethod
                    })
                });

                const data = await response.json();
                
                if (data.success) {
                    alert('Payment processed successfully!');
                    location.reload();
                } else {
                    alert('Payment failed: ' + data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Failed to process payment');
            }
        },

        printOrder() {
            if (!this.currentOrder) return;
            window.open(`/orders/${this.currentOrder.id}/print`, '_blank');
        },

        async deleteOrder() {
            if (!this.currentOrder) return;
            
            if (!confirm('Are you sure you want to delete this order?')) return;

            try {
                const response = await fetch(`/orders/${this.currentOrder.id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                const data = await response.json();
                
                if (data.success) {
                    alert('Order deleted successfully!');
                    location.reload();
                } else {
                    alert('Failed to delete order: ' + data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Failed to delete order');
            }
        },

        editOrder() {
            alert('Edit functionality coming soon!');
        }
    }
}
</script>
@endpush
@endsection
