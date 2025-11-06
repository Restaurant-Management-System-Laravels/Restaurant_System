<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
   public function index()
    {
        return view('settings.index');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'restaurant_name' => 'required|string|max:255',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'donation_amount' => 'required|numeric|min:0',
            'currency' => 'required|string|max:10',
        ]);

        // Store settings in config or database
        // For now, we'll use session
        session()->put('settings', $validated);

        return back()->with('success', 'Settings updated successfully!');
    }
}
