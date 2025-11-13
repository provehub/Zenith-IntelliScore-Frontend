<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\{Project,Plan,Personal};

class ProjectController extends Controller
{
    public function tester()
    {
        $ver = rand(10000, 99999);

        $client = new \Twilio\Rest\Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));

        $client->messages->create(
            '+2347073040622', 
            [
                'from' => env('TWILIO_FROM'),
                'body' => 'Your ZIS Verification Pin is '.$ver.' It expires in 90 minutes. ZIS'
            ]
        );

        return 'sent';
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'nin' => 'required',
            'bvn' => 'required',
        ]);

        // Format phone
        $phone = preg_replace('/\D/', '', $request->phone);
        if (substr($phone, 0, 1) === '0') {
            $phone = '+234' . substr($phone, 1);
        } elseif (substr($phone, 0, 3) === '234') {
            $phone = '+' . $phone;
        } else {
            $phone = '+' . $phone;
        }

        // Save user
        $personals = new Personal();
        $personals->phone = $phone;
        $personals->first_name = $request->nin;
        $personals->last_name = $request->bvn;
        $personals->timezone = session()->get('current_project_id');
        $personals->save();

        // OTP
        $ver = rand(10000, 99999);
        $client = new \Twilio\Rest\Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));

        $client->messages->create(
            $phone,
            [
                'from' => env('TWILIO_FROM'),
                'body' => 'Your ZIS Verification Pin is '.$ver.' It expires in 90 minutes. ZIS'
            ]
        );

        return redirect()->back()->with('success', 'We have sent a 5-digit PIN to your phone number.');
    }

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
