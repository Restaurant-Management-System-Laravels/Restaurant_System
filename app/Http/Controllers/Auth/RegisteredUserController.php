<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'role' => 'required|string|in:admin,cashier,kitchen,customer',
    ]);

    $autoApprovedRoles = ['admin', 'customer'];

    // create user
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        'is_approved' => in_array($request->role, $autoApprovedRoles),
    ]);

    event(new Registered($user));

    // Auto-login only approved roles
    if (in_array($user->role, $autoApprovedRoles)) {
        Auth::login($user);
        return redirect(RouteServiceProvider::HOME);
    }

    // Cashier & kitchen → show pending page
    return redirect()->route('pending')
        ->with('status', 'Your account is waiting for admin approval.');
}

}
