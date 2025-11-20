<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
   public function my_home() {
    return view('home.dashboard');
}

 public function index()
    {
        return view('home.reservation');
    }

    public function dashboard()
    {
        $user = auth()->user();
        return view('home.dashboard', compact('user'));
    }

    /**
     * Store a newly created reservation.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'guests' => 'required|string',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
            'occasion' => 'nullable|string',
            'message' => 'nullable|string|max:1000',
        ]);

        // Create reservation
        Reservation::create($validated);

        // You can also send email notification here
        // Mail::to($validated['email'])->send(new ReservationConfirmation($validated));

        return redirect()->route('reservation')->with('success', 'Your reservation has been confirmed! We look forward to serving you.');
    }
}