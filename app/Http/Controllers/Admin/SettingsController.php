<?php

namespace App\Http\Controllers\Admin;

use App\Models\{Setting,Photo};
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 

class SettingsController extends Controller
{
    private $apiKey;
    private $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('EXCHANGE_RATES_API_KEY');
        $this->baseUrl = 'https://api.exchangeratesapi.io';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $settings = Setting::all();
        $photos = Photo::where('place','slider')->get();
        $country = json_decode($settings->where('field', 'base_country')->pluck('value')->first());
        return inertia('Admin/Settings/Settings',[
            'message' => 'Welcome Settings',
            'settings' => $settings,
            'country' => $country,
            'photos' => $photos,
        ]);
    }
    public function updateSettings(Request $request)
    {
        // dd();
        $sett = $request->input('sett');

        if ($sett == 'site_info') {
            Setting::updateValue('site_name', $request->name);
            Setting::updateValue('site_email', $request->email);
            Setting::updateValue('seo', $request->seo);
            Setting::updateValue('base_country', json_encode($request->input('base_country')));


            if ($request->hasFile('logo_dark')) {
                $uploadedLogoDark = $request->file('logo_dark')[0];
                $logoDarkName = 'logo_dark'.'.'.$uploadedLogoDark->getClientOriginalExtension();  
                $path = $uploadedLogoDark->storeAs('site', $logoDarkName, 'public');
                Setting::updateValue('logo_dark', $logoDarkName);
            }
            if ($request->hasFile('logo_white')) {
                $uploadedLogoWhite = $request->file('logo_white')[0];
                $logoWhiteName = 'logo_white'.'.'.$uploadedLogoWhite->getClientOriginalExtension();  
                $path = $uploadedLogoWhite->storeAs('site', $logoWhiteName, 'public');
                Setting::updateValue('logo_white', $logoWhiteName);
            }
            if ($request->hasFile('favicon')) {
                $uploadedFavicon = $request->file('favicon')[0];
                $faviconName = 'favicon'.'.'.$uploadedFavicon->getClientOriginalExtension();  
                $path = $uploadedFavicon->storeAs('site', $faviconName, 'public');
                Setting::updateValue('favicon', $faviconName);
            }

            return redirect()->back()->with('success', 'Site Info was updated!');
        }

        
        // $request->validate([
        //     'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);

        
        return redirect()->back();
        // dd($request->all());
    }

    public function convertManual(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'from_currency' => 'required|alpha|size:3',
            'to_currency' => 'required|alpha|size:3',
        ]);

        $amount = $request->input('amount');
        $fromCurrency = strtoupper($request->input('from_currency'));
        $toCurrency = strtoupper($request->input('to_currency'));

        $settings = Setting::all();

        $conversionRates = $settings->rates;
        $baseCurrency = $settings->base_currency;

        if (!isset($conversionRates[$fromCurrency]) || !isset($conversionRates[$toCurrency])) {
            return response()->json(['error' => 'Invalid currency pair'], 400);
        }

        $convertedAmount = $amount * ($conversionRates[$toCurrency] / $conversionRates[$fromCurrency]);

        return response()->json([
            'amount' => $amount,
            'from_currency' => $fromCurrency,
            'to_currency' => $toCurrency,
            'converted_amount' => $convertedAmount,
        ]);
    }


    public function convertAuto(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'from_currency' => 'required|alpha|size:3',
            'to_currency' => 'required|alpha|size:3',
        ]);

        $amount = $request->input('amount');
        $fromCurrency = strtoupper($request->input('from_currency'));
        $toCurrency = strtoupper($request->input('to_currency'));

        $conversionRates = $this->getConversionRates($fromCurrency);

        if (!isset($conversionRates[$toCurrency])) {
            return response()->json(['error' => 'Invalid to_currency'], 400);
        }

        $convertedAmount = $amount * $conversionRates[$toCurrency];

        return response()->json([
            'amount' => $amount,
            'from_currency' => $fromCurrency,
            'to_currency' => $toCurrency,
            'converted_amount' => $convertedAmount,
        ]);
    }

    private function getConversionRates($baseCurrency)
    {
        $response = Http::get("{$this->baseUrl}/latest", [
            'base' => $baseCurrency,
            'apikey' => $this->apiKey,
        ]);

        if ($response->failed()) {
            abort(500, 'Error fetching conversion rates');
        }

        $data = $response->json();
        return $data['rates'];
    }
 
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
