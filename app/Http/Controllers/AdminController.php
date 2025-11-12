<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    public function index()
    {
        // Fetch users who are not yet approved
        $pendingUsers = User::where('is_approved', false)
                            ->where('role', '!=', 'admin')
                            ->get();
        
        return view('admin.dashboard', compact('pendingUsers'));
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
}
