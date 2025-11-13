<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TableController extends Controller
{
    /**
     * Display a listing of the tables.
     */
    public function index()
    {
        $tables = Table::orderBy('table_number')->get();
        return view('admin.tables', compact('tables'));
    }

    /**
     * Store a newly created table.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'table_number' => 'required|string|unique:tables,table_number',
            'capacity' => 'required|integer|min:1|max:20',
            'status' => 'required|in:available,occupied,reserved,maintenance',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $table = Table::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Table created successfully',
            'table' => $table
        ], 201);
    }

    /**
     * Display the specified table.
     */
    public function show(Table $table)
    {
        return response()->json([
            'success' => true,
            'table' => $table
        ]);
    }

    /**
     * Update the specified table.
     */
    public function update(Request $request, Table $table)
    {
        $validator = Validator::make($request->all(), [
            'table_number' => 'required|string|unique:tables,table_number,' . $table->id,
            'capacity' => 'required|integer|min:1|max:20',
            'status' => 'required|in:available,occupied,reserved,maintenance',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $table->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Table updated successfully',
            'table' => $table
        ]);
    }

    /**
     * Remove the specified table.
     */
    public function destroy(Table $table)
    {
        $table->delete();

        return response()->json([
            'success' => true,
            'message' => 'Table deleted successfully'
        ]);
    }

    /**
     * Get tables for POS cashier
     */
    public function getAvailableTables()
    {
        $tables = Table::where('status', 'available')
                      ->orderBy('table_number')
                      ->get();
        
        return response()->json([
            'success' => true,
            'tables' => $tables
        ]);
    }

    /**
     * Update table status
     */
    public function updateStatus(Request $request, Table $table)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:available,occupied,reserved,maintenance'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $table->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'message' => 'Table status updated successfully',
            'table' => $table
        ]);
    }
}