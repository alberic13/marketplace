<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class AccountController extends Controller
{
    /**
     * Show the account creation form.
     */
    public function create()
    {
        return Inertia::render('account/Create');
    }

    /**
     * Store a newly created account.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'min:2'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^[\+]?[0-9\s\-\(\)]+$/'],
            'address' => ['nullable', 'string', 'max:500'],
            'terms' => ['required', 'accepted'],
        ], [
            'name.min' => 'Name must be at least 2 characters long.',
            'email.unique' => 'This email address is already registered. Please use a different email or login.',
            'phone.regex' => 'Please enter a valid phone number.',
            'terms.accepted' => 'You must accept the terms and conditions to create an account.',
        ]);

        try {
            $user = User::create([
                'name' => trim($request->name),
                'email' => strtolower(trim($request->email)),
                'password' => Hash::make($request->password),
                'phone' => $request->phone ? trim($request->phone) : null,
                'address' => $request->address ? trim($request->address) : null,
                'role' => 'user',
                'is_verified' => false,
            ]);

            Auth::login($user);

            return redirect()->route('dashboard')->with('success', 'Welcome to GameMarket! Your account has been created successfully.');
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'There was an error creating your account. Please try again.'])->withInput();
        }
    }
}
