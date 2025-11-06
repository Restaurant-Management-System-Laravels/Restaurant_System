<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
  public function index()
    {
        $tables = Table::withCount(['orders' => function ($query) {
            $query->whereIn('status', ['pending', 'in_kitchen', 'ready']);
        }])->get();

        return view('tables.index', compact('tables'));
    }

    public function create()
    {
        return view('tables.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'table_number' => 'required|string|unique:tables,table_number',
            'capacity' => 'required|integer|min:1|max:20',
            'status' => 'required|in:available,occupied,reserved'
        ]);

        Table::create($validated);

        return redirect()->route('tables.index')->with('success', 'Table created successfully!');
    }

    public function edit(Table $table)
    {
        return view('tables.edit', compact('table'));
    }

    public function update(Request $request, Table $table)
    {
        $validated = $request->validate([
            'table_number' => 'required|string|unique:tables,table_number,' . $table->id,
            'capacity' => 'required|integer|min:1|max:20',
            'status' => 'required|in:available,occupied,reserved'
        ]);

        $table->update($validated);

        return redirect()->route('tables.index')->with('success', 'Table updated successfully!');
    }

    public function destroy(Table $table)
    {
        // Check if table has active orders
        if ($table->orders()->whereIn('status', ['pending', 'in_kitchen', 'ready'])->exists()) {
            return back()->with('error', 'Cannot delete table with active orders!');
        }

        $table->delete();

        return redirect()->route('tables.index')->with('success', 'Table deleted successfully!');
    }
}

