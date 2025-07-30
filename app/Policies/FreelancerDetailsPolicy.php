<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FreelancerDetailsPolicy
{
    public function edit()
    {
        return Auth::user()->role === 'freelancer';
    }
}