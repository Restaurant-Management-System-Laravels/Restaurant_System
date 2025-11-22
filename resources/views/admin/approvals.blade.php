<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Approvals - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>
<body class="bg-gray-50 min-h-screen">
    <div class="flex min-h-screen">
     <aside class="w-64 bg-white shadow-lg flex flex-col">
            <div class="p-6">
                <div class="flex items-center space-x-2 text-red-500 text-xl font-bold">
                    <i class="fas fa-utensils"></i>
                    <span>Resta!</span>
                </div>
            </div>
            
            <nav class="mt-6 flex-1">
               
                <a href="{{ route('admin.foods') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
                    <i class="fas fa-drumstick-bite mr-3"></i>
                    <span>Foods</span>
                </a>
                
                <a href="{{ route('admin.tables') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
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

            
        </aside>

         <div class="flex-1">
            <!-- Header -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-8 py-4">
                    <div class="flex items-center space-x-2 text-gray-500">
                        <span>Dashboard</span>
                        <span>/</span>
                        <span class="text-gray-900">User Approvals</span>
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

            <main class="max-w-7xl mx-auto p-6">
        <!-- Success Message -->
        @if(session('status'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-white shadow rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pendingUsers as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($user->role) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('admin.approve', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button class="text-green-600 hover:underline">Approve</button>
                                </form>
                                <form action="{{ route('admin.reject', $user->id) }}" method="POST" class="inline ml-2">
                                    @csrf
                                    <button class="text-red-600 hover:underline">Reject</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">No pending users</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
