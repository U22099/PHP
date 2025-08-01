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

        return view('projects.show', ['project' => $project]);
    }

    public function show_user($username, $project)
    {
        $user = User::where('username', $username)->first();
        $project = Projects::where('user_id', $user->id)->where('id', $project)->first();

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
                'images' => ['nullable', 'array'],
                'images.*' => ['string', 'url'],
                'stacks' => ['array'],
                'stacks.*' => ['string', 'max:255']
            ]);

            // $images = json_decode($request->input('images'), true);

            // $validator = Validator::make(['images' => $images], [
            //     'images' => ['required', 'array'],
            //     'images.*' => ['string', 'url'],
            // ]);

            // if ($validator->fails()) {
            //     return redirect()
            //         ->back()
            //         ->withErrors($validator)
            //         ->withInput();
            // }

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
                'images' => ['nullable', 'array'],
                'images.*' => ['string', 'url'],
                'stacks' => ['array'],
                'stacks.*' => ['string', 'max:255']
            ]);

            // $validator = Validator::make(['images' => $images], [
            //     'images' => ['required', 'array'],
            //     'images.*' => ['string', 'url'],
            // ]);

            // if ($validator->fails()) {
            //     return redirect()
            //         ->back()
            //         ->withErrors($validator)
            //         ->withInput();
            // }

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
        $project->delete();

        return redirect('/profile?tab=projects');
    }
}
