<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'firstname' => ['string', 'max:255'],
            'lastname' => ['string', 'max:255'],
            'username' => ['string', 'max:255'],
            'email' => ['email', 'string', 'max:255'],
            'password' => ['string', 'min:6', 'confirmed']
        ]);

        $user = User::create($attributes);
        
        Auth::login($user);

        return redirect('/');
    }
}
