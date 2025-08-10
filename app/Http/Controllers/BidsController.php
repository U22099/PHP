<?php

namespace App\Http\Controllers;

use App\Models\Bids;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BidsController extends Controller
{
    public function index(Job $job)
    {
        if (Auth::user()->role === 'freelancer') {
            $user_bid = $job->bids->where('user_id', Auth::id())->first()->load('user.freelancer_details:user_id,professional_name,country,city,availability,response_time');
        } else {
            $user_bid = null;
        }

        $bids = $job->bids()->where('bid_status', '!=', 'rejected')->with('user.freelancer_details:user_id,professional_name,country,city,availability,response_time')->oldest()->get();

        $user_ranked = $user_bid ? $bids->search(fn($bid) => $bid->id === $user_bid->id) : false;

        return view('bids.index', ['bids' => $bids, 'job' => $job, 'user_bid' => $user_bid, 'user_ranked' => $user_ranked]);
    }

    public function store(Request $request, Job $job)
    {
        $maxMessageLength = Auth::user()->is_premium
            ? env('BID_MESSAGE_LIMIT_PER_USER_PREMIUM')
            : env('BID_MESSAGE_LIMIT_PER_USER');

        $request->validate([
            'bid_amount' => ['required', 'numeric'],
            'bid_message' => ['required', 'string', 'max:' . $maxMessageLength],
            'bid_time_budget' => ['required', 'numeric'],
        ]);

        Bids::create([
            'bid_amount' => $request->input('bid_amount'),
            'bid_message' => $request->input('bid_message'),
            'bid_time_budget' => $request->input('bid_time_budget'),
            'job_listing_id' => $job->id,
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->route('bids.index', ['job' => $job])->with('success', 'Bid placed successfully!');
    }

    public function edit(Job $job, Bids $bid)
    {
        return view('bids.edit', ['bid' => $bid, 'job' => $job]);
    }

    public function update(Request $request, Job $job, Bids $bid)
    {
        $maxMessageLength = Auth::user()->is_premium
            ? env('BID_MESSAGE_LIMIT_PER_USER_PREMIUM')
            : env('BID_MESSAGE_LIMIT_PER_USER');

        $request->validate([
            'bid_amount' => ['required', 'numeric'],
            'bid_message' => ['required', 'string', 'max:' . $maxMessageLength],
            'bid_time_budget' => ['required', 'numeric'],
        ]);

        $bid = $bid->updateOrFail([
            'bid_amount' => $request->input('bid_amount'),
            'bid_message' => $request->input('bid_message'),
            'bid_time_budget' => $request->input('bid_time_budget'),
        ]);

        return redirect()->route('bids.index', ['job' => $job]);
    }

    public function update_status(Request $request, Job $job, Bids $bid)
    {
        $request->validate([
            'bid_status' => ['required', 'in:accepted,rejected,interviewing'],
        ]);

        $bid->updateOrFail([
            'bid_status' => $request->input('bid_status'),
        ]);

        return redirect()->route('bids.index', ['job' => $job]);
    }

    public function mass_reject(Request $request, Job $job)
    {
        $request->validate([
            'bids_ids' => ['required', 'string'],
        ]);

        $idsString = $request->input('bids_ids');

        $ids = explode(',', $idsString);

        $cleanIds = collect($ids)
            ->filter(function ($id) {
                return is_numeric($id) && (int) $id > 0;
            })
            ->map(function ($id) {
                return (int) $id;
            })
            ->unique()
            ->toArray();

        Bids::whereIn('id', $cleanIds)->update(['bid_status' => 'rejected']);

        return redirect()->route('bids.index', ['job' => $job]);
    }

    public function delete(Job $job, Bids $bid)
    {
        $bid->delete();

        return redirect()->route('jobs.show', ['job' => $job]);
    }
}
