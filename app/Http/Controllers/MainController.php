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
use App\Models\{Photo,Payment,Category,Listing,Country,State,City,Vendor,User,Contract,Project};

class MainController extends Controller
{
    //  public function verifyEmail(User $user){ 
    //     $user->verify_email = null;
    //     $user->save();

    //     Mail::to($user->email)->send(new WelcomeEmail($user));
        
    //     return Redirect::route('login')->with('success', 'Your email has been verified!');
    // }

    // see contract
    public function contract(Contract $contract){ 
        return inertia('Index/Contract',[
            'datum' => $contract,
        ]);
    }

    public function upload(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Store the uploaded image
        if ($request->file('file')) {
            $image = $request->file('file');
            $imageName = Str::random(10) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('uploads', $imageName, 'public');

            // Return the URL for TinyMCE to use, properly formatted as JSON
            return response()->json(['location' => Storage::url($path)]);
        }

        // Return an error response if the upload fails
        return response()->json(['error' => 'Image upload failed.'], 400);
    }

    public function checkEmail(Request $request)
    {
        $exists = User::where('email', $request->email)->exists();
        return ['exists' => $exists];
    }

    // index
    public function index(){ 

        return redirect()->route('login');
    }

    // apply
    public function apply(){ 
        return inertia('Index/APPLY',[
            'info' => 'apply',
        ]);
    }
    // apply
    public function applied(Request $request)
    {
        $validated = $request->validate([
            'fullName' => 'required|string|min:2',
            'email' => 'required|email',
            'password' => 'required|min:2|confirmed',
            'favoriteDrink' => 'required|in:coffee,tea,soda',
        ]);

        dd($request->all());
    }

    // osth
    public function osth(){ 
        return inertia('Index/OSTH',[
            'info' => 'OSTH',
        ]);
    }
    // aec
    public function aec(){ 
        return inertia('Index/AEC',[
            'info' => 'AEC',
        ]);
    }

    // about
    public function about(){ 
        return inertia('Index/About',[
            'info' => 'About',
        ]);
    }

    // contact
    public function contact(){ 
        return inertia('Index/Contact',[
            'info' => 'Contact',
        ]);
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

    // videos
    public function addVideos(){ 
        return inertia('AddVideos',[
            'info' => 'Add Videos',
        ]);
    }
    public function videos(){ 
        return inertia('Videos',[
            'info' => 'Videos',
            'photos' => Photo::where('place','slider')->get(),
        ]);
    }


    // bookmarks
    public function bookmarks(){ 
        // return Payment::where('user_id', Auth::id())
        // ->orderBy('created_at', 'desc') 
        // ->paginate(9)
        // ->withQueryString();

        return inertia('Donations',[
            'info' => 'bookmarks',
            'payments' => Payment::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc') // Sorting by latest
            ->paginate(9)
            ->withQueryString()
        ]);
    }

    // location
    public function locationall(Request $request, $country_id,$state_id,$city_id,$location_name){ 
        $location = [
            'country_id'=>$country_id,
            'state_id'=>$state_id,
            'city_id'=>$city_id,
            'location_name'=>$location_name,
        ];
        Cache::put('locationsall', $location, 86400);
        return redirect()->back();
    }
    // location
    public function locationCity(Request $request, City $city){ 
        Cache::put('locationCity', $city, 86400);
        return redirect()->back();
    }

    // 404
    public function fourofour(){ 
        return inertia('404');
    }
    // test
    public function test(){ 
        return inertia('Test',[
            'info' => 'Welcome',
            'photos' => Photo::where('place','slider')->get(),
        ]);
    }
    public function testone(){ 
        return inertia('TestOne');
    }
    public function testtwo(){ 
        return inertia('TestTwo');
    }
    public function testthree(){ 
        return inertia('TestThree');
    }
}
