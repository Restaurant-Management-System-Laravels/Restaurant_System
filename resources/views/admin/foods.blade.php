<!-- ============================================ -->
<!-- resources/views/admin/foods.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OrderNow! - Food Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg flex flex-col">
            <div class="p-6">
                <div class="flex items-center space-x-2 text-red-500 text-xl font-bold">
                    <i class="fas fa-utensils"></i>
                    <span>Resta!</span>
                </div>
            </div>
            
            <nav class="mt-6 flex-1">
              
                <a href="{{ route('admin.foods') }}" class="flex items-center px-6 py-3 bg-red-50 text-red-500 border-r-4 border-red-500">
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
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
                    <i class="fas fa-shopping-cart mr-3"></i>
                    <span>Orders</span>
                </a>
            </nav>

            <div class="border-t mt-auto">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-6 py-3 text-gray-600 hover:bg-gray-100">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Header -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-8 py-4">
                    <div class="flex items-center space-x-2 text-gray-500">
                        <span>Dashboard</span>
                        <span>/</span>
                        <span class="text-gray-900">Food list</span>
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

                <!-- Page Title and Actions -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-drumstick-bite text-red-500 text-xl"></i>
                        <h1 class="text-2xl font-semibold text-gray-800">Foods and Drinks</h1>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button onclick="toggleFilters()" class="px-4 py-2 border border-gray-300 rounded-lg flex items-center space-x-2 hover:bg-gray-50">
                            <i class="fas fa-filter"></i>
                            <span>Filters</span>
                        </button>
                        <a href="{{ route('admin.foods.create') }}" class="px-4 py-2 bg-red-500 text-white rounded-lg flex items-center space-x-2 hover:bg-red-600">
                            <i class="fas fa-plus"></i>
                            <span>Add new</span>
                        </a>
                    </div>
                </div>

                <!-- Filters Panel -->
                <div id="filtersPanel" class="hidden bg-white p-6 rounded-lg shadow-sm mb-6">
                    <form method="GET" action="{{ route('admin.foods') }}">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                                <select name="category" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                    <option value="">Select</option>
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Price Range</label>
                                <div class="flex items-center space-x-2">
                                    <input type="number" name="price_min" placeholder="Min" step="0.01" value="{{ request('price_min') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                    <span>to</span>
                                    <input type="number" name="price_max" placeholder="Max" step="0.01" value="{{ request('price_max') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end space-x-3 mt-4">
                            <a href="{{ route('admin.foods') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Clear</a>
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">Apply</button>
                        </div>
                    </form>
                </div>

                <!-- Food List Table -->
                <div class="bg-white rounded-lg shadow-sm">
                    <!-- Search Bar -->
                    <div class="p-6 border-b">
                        <form method="GET" action="{{ route('admin.foods') }}">
                            <div class="relative">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Name" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                            </div>
                        </form>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="px-6 py-3 text-left">
                                        <div class="flex items-center space-x-2">
                                            <input type="checkbox" class="rounded">
                                            <span class="text-sm font-medium text-gray-700">Name</span>
                                            <a href="{{ route('admin.foods', array_merge(request()->all(), ['sort' => 'name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                                <i class="fas fa-sort text-gray-400"></i>
                                            </a>
                                        </div>
                                    </th>
                                    <th class="px-6 py-3 text-left">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-sm font-medium text-gray-700">Category</span>
                                            <a href="{{ route('admin.foods', array_merge(request()->all(), ['sort' => 'category', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                                <i class="fas fa-sort text-gray-400"></i>
                                            </a>
                                        </div>
                                    </th>
                                    
                                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-700">Price</th>
                                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @forelse($foods as $food)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-3">
                                            <input type="checkbox" class="rounded">
                                            <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
                                                @if($food->image)
                                                <img src="{{ asset('storage/' . $food->image) }}" alt="{{ $food->name }}" class="w-full h-full object-cover">
                                                @else
                                                <i class="fas fa-utensils text-gray-400"></i>
                                                @endif
                                            </div>
                                            <span class="font-medium text-gray-900">{{ $food->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-700">{{ $food->category }}</td>
                                   
                                    <td class="px-6 py-4 text-center text-gray-700">{{ number_format($food->price, 2) }} ₱</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('admin.foods.edit', $food->id) }}" class="text-gray-400 hover:text-blue-500">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.foods.destroy', $food->id) }}" onsubmit="return confirm('Are you sure you want to delete this item?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-500">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                        No food items found. <a href="{{ route('admin.foods.create') }}" class="text-red-500 hover:underline">Add your first item</a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t">
                        {{ $foods->links() }}
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        function toggleFilters() {
            const panel = document.getElementById('filtersPanel');
            panel.classList.toggle('hidden');
        }
    </script>
</body>
</html>