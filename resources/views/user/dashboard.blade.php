<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            👤 Customer Dashboard
        </h2>
    </x-slot>

    <div class="p-6 bg-white shadow rounded">
        <p class="text-gray-700">
            Welcome, {{ Auth::user()->name }}! You can browse items, place orders, and view your order history here.
        </p>

        <div class="mt-4">
            <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Browse Menu
            </button>
            <button class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                View Orders
            </button>
        </div>
    </div>
</x-app-layout>
