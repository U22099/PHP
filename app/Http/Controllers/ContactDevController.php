<?php

namespace App\Http\Controllers;

use App\Mail\MessageDev;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class ContactDevController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function sendMsg(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:1000',
        ]);

        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'email' => 'Invalid email address provided',
            ]);
        } else if ($user->last_dev_contact < Carbon::now()->subWeek()) {
            throw ValidationException::withMessages([
                'email' => 'You can only send a message once every week',
            ]);
        }

        Mail::to(env('DEV_EMAIL'))->send(
            new MessageDev($user, $request->input('message'))
        );

        $user->last_dev_contact = now();
        return back()->with('success', 'Message sent successfully!');
    }
}
