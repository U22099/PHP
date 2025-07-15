<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index()
    {
        return view('jobs.index', [
            'jobs' => Job::with('user', 'tags')->latest()->simplePaginate()
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
