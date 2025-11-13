<?php

namespace App\Http\Controllers;

use App\Mail\GeneralEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Models\{Project,Plan,Personal,User};

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


    public function verifyPhone(Request $request)
    {
        
        // dd($pin);

        $checkData = Personal::where('user_id', Auth::id())->where('timezone',session()->get('current_project_id'))->first();
        // dd($vendor->verif);

        $pin = implode('', $request->input('pin'));

      if($pin != $checkData->alternate_phone){
            return redirect()->back()->with('error', 'The OTP code you entered is incorrect!');
        }
        $checkData->is_verified = 1;
        $checkData->alternate_phone = null;
        $checkData->save();

        $user = User::where('id',$checkData->user_id)->first();

        $url = [
            'url' => route('live.index', ['vendor' => session()->get('current_project_id'), 'extras' => $checkData->phone]), 
            'text' => 'Verify Now', 
       ];

        Mail::to($user->email)->send(new GeneralEmail('Zenith IntelliScore','Verify Your Liveness Check','In other to get started on Zenith IntelliScore, you need to verify if you are real or not. Ensure you have a device with nice camera and bright environment.',$url));
        

        return redirect()->back()->with('success', 'Complete Your AI liveness profile below, the data will be saved to continue your credit scoring!');

        // return redirect()->back()->with('success', 'Your AI liveness profile was created, the data has been saved to continue your credit scoring!');
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verify(Request $request)
    {
        // dd($request->all());
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

        $ver = rand(10000, 99999);

        // Save user
        $personals = new Personal();
        $personals->user_id = Auth::id();
        $personals->phone = $phone;
        $personals->alternate_phone = $ver;
        $personals->first_name = $request->nin;
        $personals->last_name = $request->bvn;
        $personals->timezone = session()->get('current_project_id');
        $personals->save();

        // OTP - email
        $user = Auth::user();

        $url = [
            'url' => 'https://zenithintelliscore.com/', 
            'text' => 'Verify Now', 
       ];
        // OTP - email
        Mail::to($user->email)->send(new GeneralEmail('Zenith IntelliScore','Verify to proceed','In other to get started on Zenith IntelliScore, you need to verify.: '.$ver,$url));

        // OTP - sms
        
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

    public function loadPlans(){
        return Plan::get();
    }
}
