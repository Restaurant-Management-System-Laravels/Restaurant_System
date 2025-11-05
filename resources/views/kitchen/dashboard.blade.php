<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            🍳 Kitchen Dashboard (KDS)
        </h2>
    </x-slot>

    <div class="p-6 bg-white shadow rounded">
        <p class="text-gray-700">
            Welcome, {{ Auth::user()->name }}! You can view and update cooking orders here.
        </p>

        <div class="mt-4">
            <button class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">
                View Pending Orders
            </button>
        </div>
    </div>
</x-app-layout>
