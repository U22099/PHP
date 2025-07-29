<?php

namespace App\Http\Controllers;

use App\Models\Bids;
use App\Models\Job;
use App\Models\Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = Job::with('user', 'tags', 'currency', 'bids');
        $allTags = Tags::whereHas('jobs')->orderBy('name')->get()->pluck('name');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q
                    ->where('body', 'like', '%' . $search . '%')
                    ->orWhere('title', 'like', '%' . $search . '%');
            });
        }

        if ($timeframe = $request->get('timeframe')) {
            switch ($timeframe) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
                    break;
                case 'year':
                    $query->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()]);
                    break;
            }
        }

        if ($request->get('budget_range')) {
            $budget_range = explode('-', $request->get('budget_range'));
            $query->whereBetween('min_budget', [
                (int) $budget_range[0],
                (int) $budget_range[1]
            ]);
        }

        if ($request->get('time_range')) {
            $time_range = explode('-', $request->get('time_range'));
            $query->whereBetween('time_budget', [
                (int) $time_range[0],
                (int) $time_range[1]
            ]);
        }

        if ($tagNames = $request->get('tags')) {
            if (!is_array($tagNames)) {
                $tagNames = [$tagNames];
            }
            $query->whereHas('tags', function ($q) use ($tagNames) {
                $q->whereIn('name', $tagNames);
            });
        }

        if ($currencyId = $request->get('currency_id')) {
            $query->where('currency_id', $currencyId);
        }

        $jobs = $query->latest()->simplePaginate(10);

        return view('jobs.index', [
            'jobs' => $jobs,
            'allTags' => $allTags
        ]);
    }

    public function create()
    {
        $availableTags = Tags::whereHas('articles')
            ->orWhereHas('jobs')
            ->pluck('name')
            ->toArray();

        return view('jobs.create', [
            'availableTags' => $availableTags
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'min:3'],
            'min_budget' => ['integer', 'required'],
            'max_budget' => ['integer', 'required'],
            'time_budget' => ['integer', 'required'],
            'currency_id' => ['string', 'required'],
            'description' => ['string'],
            'tags' => ['array'],
            'tags.*' => ['string', 'max:255']
        ]);

        $job = Job::create([
            'title' => $request->input('title'),
            'min_budget' => (int) $request->input('min_budget'),
            'max_budget' => (int) $request->input('max_budget'),
            'time_budget' => (int) $request->input('time_budget'),
            'description' => request('description'),
            'user_id' => Auth::user()->id
        ]);

        if ($request->has('tags')) {
            $tagNames = $request->input('tags');
            $tagIds = [];

            foreach ($tagNames as $tagName) {
                $tag = Tags::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }

            $job->tags()->sync($tagIds);
        } else {
            $job->tags()->sync([]);
        }

        $job->currencies_id = request('currency_id');
        $job->save();

        return redirect('/jobs');
    }

    public function show(Job $job)
    {
        return view('jobs.show', ['job' => $job]);
    }

    public function edit(Job $job)
    {
        $availableTags = Tags::whereHas('articles')
            ->orWhereHas('jobs')
            ->pluck('name')
            ->toArray();

        return view('jobs.edit', ['job' => $job, 'availableTags' => $availableTags]);
    }

    public function update(Request $request, Job $job)
    {
        $request->validate([
            'title' => ['required', 'min:3'],
            'min_budget' => ['integer', 'required'],
            'max_budget' => ['integer', 'required'],
            'time_budget' => ['integer', 'required'],
            'currency_id' => ['string', 'required'],
            'description' => ['string'],
            'tags' => ['array'],
            'tags.*' => ['string', 'max:255']
        ]);

        $job->updateOrFail([
            'title' => $request->input('title'),
            'min_budget' => (int) $request->input('min_budget'),
            'max_budget' => (int) $request->input('max_budget'),
            'time_budget' => (int) $request->input('time_budget'),
            'description' => request('description'),
            'currency_id' => request('currency_id'),
        ]);

        if ($request->has('tags')) {
            $tagNames = $request->input('tags');
            $tagIds = [];

            foreach ($tagNames as $tagName) {
                $tag = Tags::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }

            $job->tags()->sync($tagIds);
        } else {
            $job->tags()->sync([]);
        }

        return redirect('/jobs/' . $job->id);
    }

    public function destroy(Job $job)
    {
        $job->delete();

        return redirect('/jobs');
    }

    // Bids
    public function bids_list(Job $job)
    {
        return view('jobs.bids-list', ['bids' => $job->bids()->with('user', 'job')->get(), 'title' => $job->title]);
    }

    public function show_bid(Bid $bid)
    {
        return view('jobs.show_bid', ['bid' => $bid]);
    }

    public function store_bid(Request $request, Job $job)
    {
        $request->validate([
            'bid_amount' => ['required', 'numeric'],
            'bid_message' => ['required', 'string'],
            'bid_time_budget' => ['required', 'numeric'],
        ]);

        Bids::create([
            'bid_amount' => $request->input('bid_amount'),
            'bid_message' => $request->input('bid_message'),
            'bid_time_budget' => $request->input('bid_time_budget'),
            'job_listing_id' => $job->id,
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->route('jobs.bids_list')->with('success', 'Bid placed successfully!');
    }

    public function edit_bid(Bid $bid)
    {
        return view('jobs.edit_bid', ['bid' => $bid]);
    }

    public function update_bid(Request $request, Job $job, Bid $bid)
    {
        $request->validate([
            'bid_amount' => ['required', 'numeric'],
            'bid_message' => ['required', 'string'],
            'bid_time_budget' => ['required', 'numeric'],
        ]);

        $bid = $bid->updateOrFail([
            'bid_amount' => $request->input('bid_amount'),
            'bid_message' => $request->input('bid_message'),
            'bid_time_budget' => $request->input('bid_time_budget'),
        ]);

        return redirect()->route('job.show_bids', ['bid' => $bid]);
    }

    public function update_bid_status(Request $request, Job $job, Bid $bid)
    {
        $request->validate([
            'bid_status' => ['required', 'in:accepted,rejected,interviewing'],
        ]);

        $bid = $bid->updateOrFail([
            'bid_status' => $request->input('bid_status'),
        ]);

        return redirect()->route('jobs.bids_list');
    }
}
