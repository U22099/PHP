<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = Job::with('user', 'tags');
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

        if ($tagNames = $request->get('tags')) {
            if (!is_array($tagNames)) {
                $tagNames = [$tagNames];
            }
            $query->whereHas('tags', function ($q) use ($tagNames) {
                $q->whereIn('name', $tagNames);
            });
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
            'salary' => ['required'],
            'tags' => ['array'],
            'tags.*' => ['string', 'max:255']
        ]);

        $job = Job::create([
            'title' => request('title'),
            'salary' => request('salary'),
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

    public function update(Job $job)
    {
        request()->validate([
            'title' => ['string', 'required', 'min:3'],
            'salary' => ['string', 'required'],
            'description' => ['string']
        ]);

        $job->updateOrFail([
            'title' => request('title'),
            'salary' => request('salary'),
            'description' => request('description')
        ]);

        return redirect('/jobs/' . $job->id);
    }

    public function destroy(Job $job)
    {
        $job->delete();

        return redirect('/jobs');
    }
}
