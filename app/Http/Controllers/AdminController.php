<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Food;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Storage; 



class AdminController extends Controller
{
    public function dashboard()
    {
        return redirect()->route('admin.foods');
    }
    public function index()
    {
        // Fetch users who are not yet approved
        $pendingUsers = User::where('is_approved', false)
                            ->where('role', '!=', 'admin')
                            ->get();
        
        return view('admin.approvals', compact('pendingUsers'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->is_approved = true;
        $user->save();

        return redirect()->back()->with('status', "{$user->name} has been approved successfully!");
    }

    public function reject($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('status', "{$user->name} has been rejected and removed!");
    }


public function orders()
{
    $orders = \App\Models\Order::with('items')->latest()->get();
    return view('admin.orders', compact('orders'));
}
 public function foods(Request $request)
    {
        $query = Food::query();

        // Search filter
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Category filter
        if ($request->filled('category') && $request->category !== 'Select') {
            $query->where('category', $request->category);
        }

        // Price range filter
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        // Sorting
        $sortField = $request->get('sort', 'name');
        $sortDirection = $request->get('direction', 'asc');
        $query->orderBy($sortField, $sortDirection);

        $foods = $query->paginate(10);
        $categories = Food::distinct()->pluck('category');

        return view('admin.foods', compact('foods', 'categories'));
    }

    public function createFood()
    {
        return view('admin.create-food');
    }

    public function storeFood(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('foods', 'public');
        }

        Food::create($validated);

        return redirect()->route('admin.foods')->with('success', 'Food item added successfully!');
    }

    public function editFood($id)
    {
        $food = Food::findOrFail($id);
        return view('admin.edit-food', compact('food'));
    }

    public function updateFood(Request $request, $id)
    {
        $food = Food::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($food->image) {
                Storage::disk('public')->delete($food->image);
            }
            $validated['image'] = $request->file('image')->store('foods', 'public');
        }

        $food->update($validated);

        return redirect()->route('admin.foods')->with('success', 'Food item updated successfully!');
    }

    public function destroyFood($id)
    {
        $food = Food::findOrFail($id);
        
        if ($food->image) {
            Storage::disk('public')->delete($food->image);
        }
        
        $food->delete();
        
        return redirect()->route('admin.foods')->with('success', 'Food item deleted successfully!');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
            'avatar' => 'nullable|image|max:2048'
        ]);

        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }
            $user->password = Hash::make($request->new_password);
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}


