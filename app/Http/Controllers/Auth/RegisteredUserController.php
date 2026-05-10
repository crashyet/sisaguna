<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role'     => ['required', 'in:donatur,penerima'],
            'kota'     => ['required', 'string', 'max:100'],
            'phone'    => ['required', 'string', 'max:20'],
            'bio'      => ['required', 'string', 'max:1000'],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'kota'     => $request->kota,
            'phone'    => $request->phone,
            'bio'      => $request->bio,
        ]);

        event(new Registered($user));
        Auth::login($user);

        // Redirect berdasarkan role
        if ($user->role === 'donatur') {
            return redirect()->route('donatur.dashboard');
        }

        return redirect()->route('penerima.dashboard');
    }
}