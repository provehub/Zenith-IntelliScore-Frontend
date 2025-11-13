<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Models\{Payment,User,Project};

class MainController extends Controller
{

    // index
    public function index(){ 

        return redirect()->route('login');
    }

    // dashboard
    public function dashboard(){ 
        $userType = Auth::user()->id;
        if ($userType != 1) {
            return Redirect::route('user.dashboard');
        }  
        else {
            return Redirect::route('admin.dashboard');
        }
    }

    // user dashboard
    public function userDashboard(Request $request){ 
        $check = $request->session()->get('current_project_id') ?? 0;
       // Get all projects for the logged-in user
        $projects = Project::where('user_id', Auth::id())->get();

        // If at least one project exists, store the first one's ID in session
        if ($projects->isNotEmpty()) {
            if($check == 0 ){
                $request->session()->put('current_project_id', $projects->first()->id);
            } else {
                $request->session()->put('current_project_id', $check);
            }
        }

        return inertia('Dashboard', [
            'info'    => 'Dashboard',
            'project' => $projects, // send all projects to frontend
        ]);
    }

    // 404
    public function fourofour(){ 
        return inertia('404');
    }
}
