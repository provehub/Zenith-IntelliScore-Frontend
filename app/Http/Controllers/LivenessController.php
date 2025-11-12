<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{LivenessResult,Vendor};


class LivenessController extends Controller
{

    public function show($vendor, $extras)
    {
        $results = LivenessResult::where('vendor_id', $vendor)
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
            'vendor' => Vendor::where('id',$vendor)->where('extras',$extras)->first(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'vendor_id' => 'required|numeric',
            'extras' => 'nullable',
            'age' => 'nullable|numeric',
            'gender' => 'nullable|string',
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
                'vendor_id' => $validated['vendor_id'],
                'extras' => $validated['extras'],
            ],
            [
                'age' => $validated['age'],
                'gender' => $validated['gender'],
                'steps' => $validated['steps'],
                'snapshots' => $paths,
            ]
        );

        // Optional: Update vendor status
        $vendor = Vendor::where('id', $validated['vendor_id'])->first();
        if ($vendor) {
            $vendor->status = 3;
            $vendor->save();
        }

        return back()->with('success', 'Liveness result saved!');
    }

}
