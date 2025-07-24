<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use App\Models\Tags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\Validator;

class ProjectsController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['string', 'required', 'min:3'],
            'description' => ['string', 'required'],
            'link' => ['string', 'required', 'url'],
            'images' => ['nullable'],
            'tags' => ['array'],
            'tags.*' => ['string', 'max:255']
        ]);

        $images = json_decode($request->input('images'), true);

        $validator = Validator::make(['images' => $images], [
            'images' => ['nullable', 'array'],
            'images.*' => ['string', 'url'],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $project = Projects::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'link' => $validatedData['link'],
            'images' => $images,
            'user_id' => Auth::user()->id,
        ]);

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

        return redirect('/profile?tab=projects');
    }

    public function update(Projects $project, Request $request)
    {
        $validatedData = $request->validate([
            'title' => ['string', 'required', 'min:3'],
            'description' => ['string', 'required'],
            'link' => ['string', 'required', 'url'],
            'images' => ['nullable'],
            'tags' => ['array'],
            'tags.*' => ['string', 'max:255']
        ]);

        $images = json_decode($request->input('images'), true);

        $validator = Validator::make(['images' => $images], [
            'images' => ['nullable', 'array'],
            'images.*' => ['string', 'url'],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $project->updateOrFail([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'link' => $validatedData['link'],
            'images' => $images,
            'user_id' => Auth::user()->id,
        ]);

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
        return redirect('/profile?tab=projects');
    }

    public function destroy(Projects $project)
    {
        $project->delete();

        return redirect('/profile?tab=projects');
    }
}
