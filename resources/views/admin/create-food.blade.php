
<!-- ============================================ -->
<!-- resources/views/admin/create-food.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Food - OrderNow!</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="max-w-4xl mx-auto py-8 px-4">
        <div class="mb-6">
            <a href="{{ route('admin.foods') }}" class="text-red-500 hover:underline">
                <i class="fas fa-arrow-left mr-2"></i>Back to Foods
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Add New Food Item</h1>

            <form method="POST" action="{{ route('admin.foods.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 @error('name') border-red-500 @enderror">
                        @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                            <select name="category" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 @error('category') border-red-500 @enderror">
                                <option value="">Select Category</option>
                                <option value="Burger" {{ old('category') == 'burger' ? 'selected' : '' }}>Burger</option>
                                <option value="Chicken" {{ old('category') == 'chicken' ? 'selected' : '' }}>Chicken</option>
                                <option value="Vegetables" {{ old('category') == 'vegetables' ? 'selected' : '' }}>Vegetables</option>
                                <option value="DrinkS" {{ old('category') == 'drinks' ? 'selected' : '' }}>Drinks</option>
                            </select>
                            @error('category')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                   
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Price (₱) *</label>
                            <input type="number" name="price" value="{{ old('price') }}" required step="0.01" min="0" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 @error('price') border-red-500 @enderror">
                            @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                       </div> 
                    

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Image</label>
                        <input type="file" name="image" accept="image/*" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 @error('image') border-red-500 @enderror">
                        @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-8">
                    <a href="{{ route('admin.foods') }}" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50">Cancel</a>
                    <button type="submit" class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">Save Food Item</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>