<!-- resources/views/admin/profile.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - OrderNow!</title>
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
                    <span>OrderNow!</span>
                </div>
            </div>
            
            <nav class="mt-6 flex-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
                    <i class="fas fa-chart-line mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.foods') }}" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
                    <i class="fas fa-drumstick-bite mr-3"></i>
                    <span>Foods</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
                    <i class="fas fa-plus-circle mr-3"></i>
                    <span>Food Add-Ons</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
                    <i class="fas fa-book-open mr-3"></i>
                    <span>Menus</span>
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-gray-600 hover:bg-gray-100">
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
                        <span class="text-gray-900">Profile</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.profile') }}" class="flex items-center space-x-2">
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

                <div class="max-w-3xl">
                    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Profile Settings</h1>

                    <div class="bg-white rounded-lg shadow-sm p-8">
                        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
<!-- Avatar Section -->
<div class="mb-8">
    <label class="block text-sm font-medium text-gray-700 mb-3">Profile Picture</label>
    <div class="flex items-center space-x-6">
        <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
            @if(Auth::user()->avatar)
            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
            @else
            <i class="fas fa-user-circle text-5xl text-gray-400"></i>
            @endif
        </div>
        <div>
            <input type="file" name="avatar" accept="image/*" id="avatar" class="hidden" onchange="previewAvatar(event)">
            <label for="avatar" class="px-4 py-2 bg-red-500 text-white rounded-lg cursor-pointer hover:bg-red-600 inline-block">
                Change Picture
            </label>
            <p class="text-sm text-gray-500 mt-2">JPG, PNG or GIF. Max 2MB</p>
        </div>
    </div>
    @error('avatar')
    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
    @enderror
</div>


                            <div class="space-y-6">
                                <!-- Name -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 @error('name') border-red-500 @enderror">
                                    @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 @error('email') border-red-500 @enderror">
                                    @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Change Password Section -->
                                <div class="border-t pt-6 mt-6">
                                    <h3 class="text-lg font-medium text-gray-800 mb-4">Change Password</h3>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                                            <input type="password" name="current_password" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 @error('current_password') border-red-500 @enderror">
                                            @error('current_password')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                                            <input type="password" name="new_password" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 @error('new_password') border-red-500 @enderror">
                                            @error('new_password')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                                            <input type="password" name="new_password_confirmation" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end space-x-3 mt-8">
                                <a href="{{ route('admin.foods') }}" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</a>
                                <button type="submit" class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        function previewAvatar(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.querySelector('img[alt="Avatar"]');
                    if (img) {
                        img.src = e.target.result;
                    } else {
                        const container = document.querySelector('.w-24.h-24');
                        container.innerHTML = `<img src="${e.target.result}" alt="Avatar" class="w-full h-full object-cover">`;
                    }
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>