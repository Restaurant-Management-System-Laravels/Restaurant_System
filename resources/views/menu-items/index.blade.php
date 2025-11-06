@extends('layouts.app')

@section('title', 'Manage Menu Items - Tasty Station')

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
@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Manage Menu Items</h2>
                    <a href="{{ route('menu-items.create') }}" class="px-4 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600">
                        <i data-lucide="plus" class="w-4 h-4 inline"></i> Add New Item
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($menuItems as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $item->name }}</div>
                                    <div class="text-sm text-gray-500">{{ Str::limit($item->description, 50) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->category }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($item->price, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-semibold rounded {{ $item->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $item->is_available ? 'Available' : 'Unavailable' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                    <a href="{{ route('menu-items.edit', $item) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                    <form action="{{ route('menu-items.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection