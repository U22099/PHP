<?php

namespace App\Http\Controllers;

use App\Mail\VerificationMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class RegisterUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function verify(Request $request)
    {
        $email = $request->input('email');
        $user = User::where('email', $email)->first();

        if ($user && $request->input('getCode')) {
            return $this->sendVerificationCode($user);
        }

        if (!$user) {
            return back()->withErrors(['verifying_email' => 'User not found.']);
        }

        return view('auth.verify-email', [
            'email' => $email,
            'user' => $user
        ]);
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

        $user = User::where('email', $request->input('email'))->exists();
        $username = User::where('username', $request->input('username'))->exists();

        if ($user) {
            throw ValidationException::withMessages([
                'email' => 'This email is already associated with an account.   '
            ]);
        } elseif ($username) {
            throw ValidationException::withMessages([
                'username' => 'This username is already take.'
            ]);
        }

        $user = User::create($attributes);

        return $this->sendVerificationCode($user);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'verifying_email' => ['string', 'email', 'max:255'],
            'verification_code' => ['string', 'max:6'],
        ]);

        $user = User::where('email', $request->input('verifying_email'))->first();

        if (!$user) {
            return redirect('/register');
        }

        if ($user->verification_code_expires && $user->verification_code_expires < now()) {
            return back()->withErrors(['verification_code_expired' => 'Expired verification code.']);
        } elseif ($user->verification_code && Hash::check($request->input('verification_code'), $user->verification_code)) {
            $user->email_verified_at = now();
            $user->verification_code = null;
            $user->verification_code_expires = null;
            $user->save();

            Auth::login($user);

            return redirect()->intended('/profile')->with('success', 'Email verified successfully!');
        } else {
            return back()->withErrors(['verification_code' => 'Incorrect verification code.']);
        }
    }

    public function sendVerificationCode(User $user)
    {
        $verificationCode = null;
        do {
            $verificationCode = random_int(100000, 999999);
        } while (User::where('verification_code', Hash::make($verificationCode))->exists());

        $user->verification_code = Hash::make($verificationCode);

        $user->verification_code_expires = now()->addMinutes(2);
        $user->save();

        Mail::to($user->email)->send(
            new VerificationMail($user, $verificationCode)
        );

        return redirect('/register/verify?email=' . $user->email);
    }
}
