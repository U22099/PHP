<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'email' => ['email', 'string', 'max:255'],
            'password' => ['string', 'min:6']
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if ($user && !$user->email_verified_at) {
            return redirect('/register/verify?getCode=true&email=' . $user->email);
        }

        if (!Auth::attempt($attributes)) {
            throw ValidationException::withMessages([
                'email' => 'Sorry, those credentials do not match'
            ]);
        }

        $request->session()->regenerate();

        return redirect('/');
    }

    public function destroy()
    {
        Auth::logout();

        return redirect('/login');
    }
}
