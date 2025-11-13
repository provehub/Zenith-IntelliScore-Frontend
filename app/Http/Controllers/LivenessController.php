<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{LivenessResult,Project};


class LivenessController extends Controller
{

    public function show($vendor, $extras)
    {
        $results = LivenessResult::where('project_id', $vendor)
            ->where('extras', $extras)
            ->first();

        return inertia('LivenessShow', [
            'vendor' => $vendor,
            'extras' => $extras,
            'result' => $results,
        ]);
    }


    public function index(Request $request, $vendor, $extras){ 
        return inertia('Liveness',[
            'vendor' => Project::where('id',$vendor)->first(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|numeric',
            'extras' => 'nullable',
            'age' => 'nullable|numeric', // for AI verification side
            'gender' => 'nullable|string', // for AI verification side
            'steps' => 'required|array',
            'snapshots.*' => 'nullable|image|max:2048', // as images
        ]);

        $paths = [];
        if ($request->hasFile('snapshots')) {
            foreach ($request->file('snapshots') as $file) {
                $paths[] = $file->store('liveness_snaps', 'public');
            }
        }

        // Use updateOrCreate: checks for vendor_id + extras combo
        $result = LivenessResult::updateOrCreate(
            [
                'project_id' => $validated['project_id'],
                'extras' => $validated['extras'],
            ],
            [
                'age' => $validated['age'], // for AI verification side
                'gender' => $validated['gender'], // for AI verification side
                'steps' => $validated['steps'],
                'snapshots' => $paths,
            ]
        );

        // Optional: Update vendor status
        $vendor = Project::where('id', $validated['project_id'])->first();
        if ($vendor) {
            $vendor->status = 3;
            $vendor->save();
        }

        return back()->with('success', 'Liveness result saved!');
    }

}
