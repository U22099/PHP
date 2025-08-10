<?php

namespace App\Http\Controllers;

use App\Models\Bids;
use App\Models\Job;
use App\Models\Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Mews\Purifier\Facades\Purifier;

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
        $availableTags = Tags::whereHas('jobs')
            ->pluck('name')
            ->toArray();

        return view('jobs.create', [
            'availableTags' => $availableTags
        ]);
    }

    public function store(Request $request)
    {
        $maxDescriptionLength = Auth::user()->is_premium
            ? env('JOB_DESCRIPTION_LIMIT_PER_USER_PREMIUM')
            : env('JOB_DESCRIPTION_LIMIT_PER_USER');

        $request->validate([
            'title' => ['required', 'min:3'],
            'min_budget' => ['integer', 'required'],
            'max_budget' => ['integer', 'required', 'gte:min_budget'],
            'time_budget' => ['integer', 'required'],
            'currency_id' => ['string', 'required'],
            'description' => ['string', 'required', 'max:' . $maxDescriptionLength],
            'images' => ['sometimes', 'array'],
            'images.*' => ['string', 'url'],
            'publicIds' => ['sometimes', 'array', 'required_with:images'],
            'publicIds.*' => ['string'],
            'tags' => ['array'],
            'tags.*' => ['string', 'max:255']
        ]);

        $job = Job::create([
            'user_id' => Auth::user()->id,
            'title' => $request->input('title'),
            'min_budget' => (int) $request->input('min_budget'),
            'max_budget' => (int) $request->input('max_budget'),
            'time_budget' => (int) $request->input('time_budget'),
            'description' => str_replace('"', "'", Purifier::clean(request('description'))),
            'images' => $request->input('screenshots'),
            'public_ids' => $request->input('publicIds'),
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
        $availableTags = Tags::whereHas('jobs')
            ->pluck('name')
            ->toArray();

        return view('jobs.edit', ['job' => $job, 'availableTags' => $availableTags]);
    }

    public function update(Request $request, Job $job)
    {
        $maxDescriptionLength = Auth::user()->is_premium
            ? env('JOB_DESCRIPTION_LIMIT_PER_USER_PREMIUM')
            : env('JOB_DESCRIPTION_LIMIT_PER_USER');

        $request->validate([
            'title' => ['required', 'min:3'],
            'min_budget' => ['integer', 'required'],
            'max_budget' => ['integer', 'required', 'gte:min_budget'],
            'time_budget' => ['integer', 'required'],
            'currency_id' => ['string', 'required'],
            'description' => ['string', 'required', 'max:' . $maxDescriptionLength],
            'images' => ['sometimes', 'array'],
            'images.*' => ['string', 'url'],
            'publicIds' => ['sometimes', 'array', 'required_with:images'],
            'publicIds.*' => ['string'],
            'tags' => ['array'],
            'tags.*' => ['string', 'max:255']
        ]);

        $job->updateOrFail([
            'title' => $request->input('title'),
            'min_budget' => (int) $request->input('min_budget'),
            'max_budget' => (int) $request->input('max_budget'),
            'time_budget' => (int) $request->input('time_budget'),
            'description' => str_replace('"', "'", Purifier::clean($request->input('description'))),
            'currency_id' => $request->input('currency_id'),
            'images' => $request->input('screenshots'),
            'public_ids' => $request->input('publicIds'),
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
}
