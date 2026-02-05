<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/')->with('success', 'Logged in successfully');
        }

        return back()->withErrors(['email' => 'The provided credentials do not match our records.'])->onlyInput('email');
    }

    public function destroy()
    {
        Auth::logout();

        // redirect to login
        return redirect()->intended('/login');
    }
}
