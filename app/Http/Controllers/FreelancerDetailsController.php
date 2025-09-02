<?php

namespace App\Http\Controllers;

use App\Models\FreelancerDetails;
use App\Models\Stacks;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validation\Exception;

class FreelancerDetailsController extends Controller
{
    public function show_user(String $username, FreelancerDetails $freelancerDetails)
    {
        $freelancerDetails->load('user', 'stacks');

        if (!$freelancerDetails->user->is(User::where('username', $username)->first())) {
            abort(403, "You are not authorized to view this freelancer's details");
        }

        return view('freelancer.show', [
            'freelancerDetails' => $freelancerDetails
        ]);
    }

    public function show()
    {
        $freelancerDetails = Auth::user()->freelancer_details ?? new FreelancerDetails();

        return view('freelancer.show', [
            'freelancerDetails' => $freelancerDetails
        ]);
    }

    public function edit()
    {
        $freelancerDetails = Auth::user()->freelancer_details ?? new FreelancerDetails();
        $availableStacks = Stacks::pluck('name')
            ->toArray();

        return view('freelancer.edit', [
            'freelancerDetails' => $freelancerDetails,
            'availableStacks' => $availableStacks
        ]);
    }

    public function update(Request $request)
    {
        try {
            $user = Auth::user();

            $freelancerDetails = $user->freelancer_details ?? new FreelancerDetails();
            if (!$user->freelancer_details)
                $freelancerDetails->user_id = $user->id;

            $validatedData = $request->validate([
                'professional_name' => 'string|max:255',
                'professional_summary' => 'string:max:' . $maxSummaryLength,
                'country' => 'string|max:255',
                'city' => 'nullable|string|max:255',
                'phone_number' => 'string|phone|max:20',
                'skills' => 'string',
                'portfolio_link' => 'nullable|url|max:255',
                'years_of_experience' => 'integer|min:0',
                'education' => 'nullable|string',
                'certifications' => 'nullable|string',
                'languages' => 'string',
                'availability' => 'in:Full-time,Part-time,Hourly',
                'response_time' => 'in:Within an hour,Within a few hours,Within a day',
                'linkedin_profile' => 'nullable|url|max:255',
            ]);

            // Convert comma-separated strings to JSON arrays
            if (isset($validatedData['skills'])) {
                $validatedData['skills'] = json_encode(array_map('trim', explode(',', $validatedData['skills'])));
            }
            if (isset($validatedData['languages'])) {
                $validatedData['languages'] = json_encode(array_map('trim', explode(',', $validatedData['languages'])));
            }

            $freelancerDetails->fill($validatedData);
            $freelancerDetails->save();

            if ($request->has('stacks')) {
                $stackNames = $request->input('stacks');
                $stackIds = [];

                foreach ($stackNames as $stackName) {
                    $stack = Stacks::firstOrCreate(['name' => $stackName]);
                    $stackIds[] = $stack->id;
                }

                $freelancerDetails->stacks()->sync($stackIds);
            } else {
                $freelancerDetails->stacks()->sync([]);
            }

            return redirect('/profile')->with('success', 'Freelancer details updated successfully!');
        } catch (ValidationException $e) {
            return redirect('/profile?error=freelancer-form-error')
                ->withErrors($e->errors())
                ->withInput();
        }
    }
}
