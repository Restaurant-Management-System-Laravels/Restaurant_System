<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MenuItem;

class MenuItemController extends Controller
{
  public function index()
    {
        $menuItems = MenuItem::orderBy('category')->orderBy('name')->get();
        $categories = MenuItem::distinct()->pluck('category');

        return view('menu-items.index', compact('menuItems', 'categories'));
    }

    public function create()
    {
        $categories = ['Lunch', 'Salad', 'Pasta', 'Beef', 'Rice', 'Dessert', 'Chicken', 'Soups'];
        return view('menu-items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'is_available' => 'boolean'
        ]);

        $validated['is_available'] = $request->has('is_available');

        MenuItem::create($validated);

        return redirect()->route('menu-items.index')->with('success', 'Menu item created successfully!');
    }

    public function edit(MenuItem $menuItem)
    {
        $categories = ['Lunch', 'Salad', 'Pasta', 'Beef', 'Rice', 'Dessert', 'Chicken', 'Soups'];
        return view('menu-items.edit', compact('menuItem', 'categories'));
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string',
            'is_available' => 'boolean'
        ]);

        $validated['is_available'] = $request->has('is_available');

        $menuItem->update($validated);

        return redirect()->route('menu-items.index')->with('success', 'Menu item updated successfully!');
    }

    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();

        return redirect()->route('menu-items.index')->with('success', 'Menu item deleted successfully!');
    }
}
