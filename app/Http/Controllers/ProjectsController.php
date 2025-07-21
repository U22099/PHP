<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    /*
    public function index(Request $request)
    {
        $projects = Projects::with('user', 'tags')->latest();

        return view('projects.index', [
            'projects' => $projects
        ]);
    }

    public function create()
    {
        $availableTags = Tags::whereHas('articles')
            ->orWhereHas('projects')
            ->pluck('name')
            ->toArray();

        return view('projects.create', [
            'availableTags' => $availableTags
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['string', 'required', 'min:3'],
            'description' => ['string', 'required'],
            'link' => ['string', 'required', 'url'],
            'images' => ['array'],
            'images.*' => ['string', 'url'],
            'tags' => ['array'],
            'tags.*' => ['string', 'max:255']
        ]);

        $project = Projects::create($request);

        if ($request->has('tags')) {
            $tagNames = $request->input('tags');
            $tagIds = [];

            foreach ($tagNames as $tagName) {
                $tag = Tags::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }

            $project->tags()->sync($tagIds);
        } else {
            $project->tags()->sync([]);
        }

        return redirect('/projects');
    }

    public function show(Projects $project)
    {
        return view('projects.show', ['project' => $project]);
    }

    public function edit(Projects $project)
    {
        $availableTags = Tags::whereHas('projects')
            ->pluck('name')
            ->toArray();

        return view('projects.edit', ['project' => $project, 'availableTags' => $availableTags]);
    }

    public function update(Projects $project, Request $request)
    {
        $request->validate([
            'title' => ['string', 'required', 'min:3'],
            'description' => ['string', 'required'],
            'link' => ['string', 'required', 'url'],
            'images' => ['array'],
            'images.*' => ['string', 'url'],
            'tags' => ['array'],
            'tags.*' => ['string', 'max:255']
        ]);

        $project->updateOrFail($request);

        if ($request->has('tags')) {
            $tagNames = $request->input('tags');
            $tagIds = [];

            foreach ($tagNames as $tagName) {
                $tag = Tags::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }

            $project->tags()->sync($tagIds);
        } else {
            $project->tags()->sync([]);
        }

        return redirect('/projects/' . $project->id);
    }

    public function destroy(Projects $project)
    {
        $project->delete();

        return redirect('/projects');
    }
    */
}
