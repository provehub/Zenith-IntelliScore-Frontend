<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\{Project,Plan};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ProjectController extends Controller
{
     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'plan_id' => 'required',
        ]);

        $project = new Project();
        $project->name = $request->name;
        $project->plan_id = $request->plan_id;
        $project->user_id = Auth::id();
        $project->save();

        $request->session()->forget('current_project_id');
        $request->session()->put('current_project_id', $project->id);

        return redirect()->back()->with('success', 'Your account '.$request->name. ' verification has started.');
    }

    public function setCurrentProject(Request $request, Project $project)
    {
        $request->session()->forget('current_project_id');
        $request->session()->put('current_project_id', $project->id);

        return 'Done';
    }
}
