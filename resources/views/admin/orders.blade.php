<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Restra - Orders Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg">
            <div class="p-6">
                <div class="flex items-center space-x-2 text-red-500 text-xl font-bold">
                    <i class="fas fa-utensils"></i>
                    <span>Resta!</span>
                </div>
            </div>
            <nav class="mt-6">

                <a href="{{ route('admin.foods') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
                    <i class="fas fa-drumstick-bite mr-3"></i>
                    <span>Foods</span>
                </a>
                
                <a href="{{route('admin.tables')}}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
                    <i class="fas fa-table mr-3"></i>
                    <span>Tables</span>
                </a>
                <a href="{{route('admin.approvals')}}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
                    <i class="fas fa-qrcode mr-3"></i>
                    <span>Approvals</span>
                </a>
                
                 <a href="{{route('admin.orders')}}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
                    <i class="fas fa-shopping-cart mr-3"></i>
                    <span>Orders</span>
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
       <div class="flex-1">
            <!-- Header -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-8 py-4">
                    <div class="flex items-center space-x-2 text-gray-500">
                        <span>Dashboard</span>
                        <span>/</span>
                        <span class="text-gray-900">Order List</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.profile') }}" class="flex items-center space-x-2 hover:text-red-500">
                            <span class="text-gray-700">{{ Auth::user()->name }}</span>
                            @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="w-8 h-8 rounded-full object-cover">
                            @else
                            <i class="fas fa-user-circle text-2xl text-gray-400"></i>
                            @endif
                        </a>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="p-8">
                <!-- Success Message -->
                @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                    <button onclick="this.parentElement.remove()" class="absolute top-0 right-0 px-4 py-3">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                @endif

            <!-- Filter Tabs -->
            <div class="flex gap-4 mb-6">
                <button onclick="filterOrders('all')" class="filter-btn px-6 py-2 bg-purple-600 text-white rounded-lg">All Orders</button>
                <button onclick="filterOrders('pending')" class="filter-btn px-6 py-2 bg-white text-gray-700 rounded-lg shadow">Pending</button>
                <button onclick="filterOrders('preparing')" class="filter-btn px-6 py-2 bg-white text-gray-700 rounded-lg shadow">Preparing</button>
                <button onclick="filterOrders('ready')" class="filter-btn px-6 py-2 bg-white text-gray-700 rounded-lg shadow">Ready</button>
                <button onclick="filterOrders('completed')" class="filter-btn px-6 py-2 bg-white text-gray-700 rounded-lg shadow">Completed</button>
            </div>

            <!-- Orders Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order #</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cashier</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Place</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Table</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($orders as $order)
                        <tr class="order-row hover:bg-gray-50" data-status="{{ $order->status }}">
                            <td class="px-6 py-4 whitespace-nowrap font-semibold">#{{ $order->order_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->cashier_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->place }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $order->table_no ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap font-bold text-purple-600">₱{{ number_format($order->total, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('admin.order.status', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" onchange="this.form.submit()" class="px-3 py-1 rounded-full text-sm font-semibold
                                        {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $order->status === 'preparing' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $order->status === 'ready' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $order->status === 'completed' ? 'bg-gray-100 text-gray-800' : '' }}
                                        {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>Preparing</option>
                                        <option value="ready" {{ $order->status === 'ready' ? 'selected' : '' }}>Ready</option>
                                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('admin.order.payment', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <select name="payment_status" onchange="this.form.submit()" class="px-3 py-1 rounded-full text-sm font-semibold
                                        {{ $order->payment_status === 'unpaid' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                        <option value="unpaid" {{ $order->payment_status === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                        <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                                    </select>
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format('M d, Y h:i A') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <button onclick="viewOrderDetails({{ $order->id }})" class="text-purple-600 hover:text-purple-800 mr-3">View</button>
                                <form action="{{ route('admin.order.delete', $order->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this order?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-6 py-8 text-center text-gray-500">No orders found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        </div>
    </div>

    <!-- Order Details Modal -->
    <div id="order-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-8 max-w-2xl w-full max-h-[90vh] overflow-auto">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold">Order Details</h3>
                <button onclick="closeOrderModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div id="order-details-content"></div>
        </div>
    </div>

    <script>
        function filterOrders(status) {
            const rows = document.querySelectorAll('.order-row');
            const buttons = document.querySelectorAll('.filter-btn');
            
            buttons.forEach(btn => {
                btn.classList.remove('bg-purple-600', 'text-white');
                btn.classList.add('bg-white', 'text-gray-700', 'shadow');
            });
            
            event.target.classList.add('bg-purple-600', 'text-white');
            event.target.classList.remove('bg-white', 'text-gray-700', 'shadow');
            
            rows.forEach(row => {
                if (status === 'all' || row.dataset.status === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function viewOrderDetails(orderId) {
            fetch(`/admin/orders/${orderId}`)
                .then(response => response.json())
                .then(data => {
                    const content = `
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Order Number</p>
                                    <p class="font-bold">#${data.order_number}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Cashier</p>
                                    <p class="font-bold">${data.cashier_name}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Place</p>
                                    <p class="font-bold">${data.place}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Table</p>
                                    <p class="font-bold">${data.table_no || '-'}</p>
                                </div>
                            </div>
                            
                            <div class="border-t pt-4">
                                <h4 class="font-bold mb-3">Order Items</h4>
                                ${data.items.map(item => `
                                    <div class="flex items-center gap-3 mb-3 p-3 bg-gray-50 rounded">
                                        <img src="/storage/${item.image}" alt="${item.item_name}" class="w-16 h-16 rounded object-cover">
                                        <div class="flex-1">
                                            <p class="font-semibold">${item.item_name}</p>
                                            <p class="text-sm text-gray-600">₱${parseFloat(item.price).toFixed(2)} x ${item.quantity}</p>
                                        </div>
                                        <p class="font-bold">₱${parseFloat(item.subtotal).toFixed(2)}</p>
                                    </div>
                                `).join('')}
                            </div>
                            
                            <div class="border-t pt-4 space-y-2">
                                <div class="flex justify-between">
                                    <span>Subtotal</span>
                                    <span>₱${parseFloat(data.subtotal).toFixed(2)}</span>
                                </div>
                                <div class="flex justify-between text-green-600">
                                    <span>Extra Charge</span>
                                    <span>₱${parseFloat(data.extra_charge).toFixed(2)}</span>
                                </div>
                                <div class="flex justify-between text-red-600">
                                    <span>Discount</span>
                                    <span>-₱${parseFloat(data.discount).toFixed(2)}</span>
                                </div>
                                <div class="flex justify-between text-xl font-bold border-t pt-2">
                                    <span>Total</span>
                                    <span>₱${parseFloat(data.total).toFixed(2)}</span>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    document.getElementById('order-details-content').innerHTML = content;
                    document.getElementById('order-modal').classList.remove('hidden');
                })
                .catch(error => console.error('Error:', error));
        }

        function closeOrderModal() {
            document.getElementById('order-modal').classList.add('hidden');
        }
    </script>
</body>
</html>