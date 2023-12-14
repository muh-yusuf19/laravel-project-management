<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Project;
use Illuminate\Contracts\Database\Eloquent\Builder;

class DashboardController extends Controller
{
    public function index()
    {

        $data = Project::whereHas('tasks', function(Builder $query){
            $query->where('user_id', '=', auth()->user()->id);
        })->get();

        // dd($data);
        return Inertia::render('Dashboard/Dashboard', [
            'projects' => $data
        ]);
    }

    public function detail(Project $project)
    {

        $data = Project::query()->with(['tasks' => function(Builder $query){
            $query->where('user_id', '=', auth()->user()->id);
        }])->where('id', '=', $project->id)->first();

        // dd($data);

        // if(!data){
        //     abort(404);
        // }

        return Inertia::render('Dashboard/DetailProject', [
            'project' => $data
        ]);
    
    }
}
