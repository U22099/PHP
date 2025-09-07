<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use App\Models\Stacks;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mews\Purifier\Facades\Purifier;
use \Illuminate\Support\Facades\Validator;

class ProjectsController extends Controller
{
    public function show($project)
    {
        $user = Auth::user();
        $project = Projects::where('user_id', $user->id)->where('id', $project)->first();

        if (empty($project)) {
            return response('404 Not Found', 404);
        }

        return view('projects.show', ['project' => $project]);
    }

    public function show_user($username, $project)
    {
        $user = User::where('username', $username)->first();
        $project = Projects::where('user_id', $user->id)->where('id', $project)->first();

        if (empty($project)) {
            return response('404 Not Found', 404);
        }

        return view('projects.show', ['project' => $project]);
    }

    public function create(Projects $project)
    {
        $availableStacks = Stacks::whereHas('projects')
            ->pluck('name')
            ->toArray();

        return view('projects.create', ['availableStacks' => $availableStacks]);
    }

    public function edit(Projects $project)
    {
        $availableStacks = Stacks::whereHas('projects')
            ->pluck('name')
            ->toArray();

        return view('projects.edit', ['project' => $project, 'availableStacks' => $availableStacks]);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => ['string', 'required', 'min:3'],
                'description' => ['string', 'required'],
                'link' => ['string', 'required', 'url'],
                'images' => ['required', 'array'],
                'images.*' => ['string', 'url'],
                'stacks' => ['array'],
                'stacks.*' => ['string', 'max:255']
            ]);

            $project = Projects::create([
                'title' => $validatedData['title'],
                'description' => str_replace('"', "'", Purifier::clean($validatedData['description'])),
                'link' => $validatedData['link'],
                'images' => $request->input('images') ?? [],
                'user_id' => Auth::user()->id,
            ]);

            if ($request->has('stacks')) {
                $stackNames = $request->input('stacks');
                $stackIds = [];

                foreach ($stackNames as $stackName) {
                    $stack = Stacks::firstOrCreate(['name' => $stackName]);
                    $stackIds[] = $stack->id;
                }

                $project->stacks()->sync($stackIds);
            } else {
                $project->stacks()->sync([]);
            }

            return redirect('/profile?tab=projects');
        } catch (ValidationException $e) {
            return redirect('/profile?tab=projects&error=project-form-error')
                ->withErrors($e->errors())
                ->withInput();
        }
    }

    public function update(Projects $project, Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => ['string', 'required', 'min:3'],
                'description' => ['string', 'required'],
                'link' => ['string', 'required', 'url'],
                'images' => ['required', 'array'],
                'images.*' => ['string', 'url'],
                'stacks' => ['array'],
                'stacks.*' => ['string', 'max:255']
            ]);

            $project->updateOrFail([
                'title' => $validatedData['title'],
                'description' => Purifier::clean($validatedData['description']),
                'link' => $validatedData['link'],
                'images' => $request->input('images') ?? [],
                'user_id' => Auth::user()->id,
            ]);

            if ($request->has('stacks')) {
                $stackNames = $request->input('stacks');
                $stackIds = [];
                foreach ($stackNames as $stackName) {
                    $stack = Stacks::firstOrCreate(['name' => $stackName]);
                    $stackIds[] = $stack->id;
                }
                $project->stacks()->sync($stackIds);
            } else {
                $project->stacks()->sync([]);
            }
            return redirect('/profile?tab=projects');
        } catch (ValidationException $e) {
            return redirect('/profile?tab=projects&error=project-form-error')
                ->withErrors($e->errors())
                ->withInput();
        }
    }

    public function destroy(Projects $project)
    {
        if (!empty($project->images)) {
            foreach ($project->public_ids as $public_id) {
                $deleted = Storage::disk('cloudinary')->delete($public_id);
                if ($deleted) {
                    Auth::user()->image_uploads()->where('public_id', $publicId)->delete();
                }
            }
        }

        $project->delete();

        return redirect('/profile?tab=projects');
    }
}
