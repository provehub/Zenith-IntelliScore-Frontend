<?php

use App\Models\{Setting,Country};
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/* @function favicon() */
if (!function_exists('favicon')) {
    function favicon()
    {
        $png = asset("storage/site/favicon.png");
        $ico = asset("storage/site/favicon.ico");

        $pngPath = 'site/favicon.png';
        $icoPath = 'site/favicon.png';

        $favicon = (Storage::disk('public')->exists($pngPath)) ? $png : ((Storage::disk('public')->exists($icoPath)) ? $ico : null);

        return $favicon;
    }
}

/* @function logo_dark() */
if (!function_exists('logo_dark')) {
    function logo_dark()
    {
        $logo_dark = asset("storage/site/logo_dark.png");

        $path = 'site/logo_dark.png';

        $logo_dark = (Storage::disk('public')->exists($path)) ? $logo_dark : null;

        return $logo_dark;
    }
}

/* @function icon_dark() */
if (!function_exists('icon_dark')) {
    function icon_dark()
    {
        $icon_dark = asset("storage/site/icon_dark.png");

        $path = 'site/icon_dark.png';

        $icon_dark = (Storage::disk('public')->exists($path)) ? $icon_dark : null;

        return $icon_dark;
    }
}

/* @function logo_white() */
if (!function_exists('logo_white')) {
    function logo_white()
    {
        $logo_white = asset("storage/site/logo_white.png");

        $path = 'site/logo_white.png';

        $logo_white = (Storage::disk('public')->exists($path)) ? $logo_white : null;

        return $logo_white;
    }
}

/* @function icon_white() */
if (!function_exists('icon_white')) {
    function icon_white()
    {
        $icon_white = asset("storage/site/icon_white.png");

        $path = 'site/icon_white.png';

        $icon_white = (Storage::disk('public')->exists($path)) ? $icon_white : null;

        return $icon_white;
    }
}

/* @function img_share() */
if (!function_exists('img_share')) {
    function img_share()
    {
        $m = asset("storage/site/m.jpg");
        $one = asset("storage/site/1.jpg");
        $ten = asset("storage/site/10.jpg");
        $six = asset("storage/site/6.jpg");
        $four = asset("storage/site/4.jpg");
        $nine = asset("storage/site/9.jpg");
        $three = asset("storage/site/3.jpg");
        $eight = asset("storage/site/8.jpg");
        $seven = asset("storage/site/7.jpg");
        $eleven = asset("storage/site/11.jpg");
        $twelve = asset("storage/site/12.jpg");
        $sixteen = asset("storage/site/16.jpg");
        $thirteen = asset("storage/site/13.jpg");
        $fourteen = asset("storage/site/14.jpg");
        $seventeen = asset("storage/site/17.jpg");

        $googleplay = asset("storage/site/googleplay.svg");
        $applestore = asset("storage/site/applestore.svg");

        return [
            'm' => $m,
            'one' => $one,
            'ten' => $ten,
            'six' => $six,
            'four' => $four,
            'nine' => $nine,
            'three' => $three,
            'seven' => $seven,
            'eight' => $eight,
            'eleven' => $eleven,
            'twelve' => $twelve,
            'sixteen' => $sixteen,
            'thirteen' => $thirteen,
            'fourteen' => $fourteen,
            'seventeen' => $seventeen,
            'googleplay' => $googleplay,
            'applestore' => $applestore,
        ];
    }
}

/* @function seo() */
if (!function_exists('seo')) {
    function seo()
    {
        $settings = Setting::all();
            if (!empty($settings)) {
                $site_name = $settings->where('field', 'seo')->pluck('value')->first();
                return $site_name;
            } else {
                // handle the case where the settings are empty
            }
    }
}

/* @function keywords() */
if (!function_exists('keywords')) {
    function keywords()
    {
        $settings = Setting::all();
            if (!empty($settings)) {
                $site_name = $settings->where('field', 'keywords')->pluck('value')->first();
                return $site_name;
            } else {
                // handle the case where the settings are empty
            }
    }
}



/* @function get_site() */
if (!function_exists('get_site')) {
    function get_site()
    {
        $host = str_replace('www.', '', request()->getHost());
        $path = str_replace('/index.php', '', request()->getScriptName());
        if($path == "") {
            $path = "/";
        }
        return $host.$path;
    }
}

/* @function get_c() */
if (!function_exists('get_c')) {
    function get_c()
    {
        if (Cache::has('si')) {
            // cache exists, retrieve the value
            $c = Cache::get('si');
            return $c;
        } else {
            // cache doesn't exist, retrieve from database and store in cache
            $settings = Setting::all();
            if (!empty($settings)) {
                $country = json_decode($settings->where('field', 'base_country')->pluck('value')->first());
                $c = Country::find($country->id);
                Cache::put('si', $c, 86400);
                return $c;
            } else {
                // handle the case where the settings are empty
            }
        }
        
        // use the $c value here        
    }
}

/* @function get_site_name() */
if (!function_exists('get_site_name')) {
    function get_site_name()
    {
        if (Cache::has('site_name')) {
            $site_name = Cache::get('site_name');
            return $site_name;
        } else {
            $settings = Setting::all();
            if (!empty($settings)) {
                $site_name = $settings->where('field', 'site_name')->pluck('value')->first();
                Cache::put('site_name', $site_name, 86400);
                return $site_name;
            } else {
                // handle the case where the settings are empty
            }
        }
        
        // use the $c value here        
    }
}

/* @function get_current_project() */
if (!function_exists('get_current_project')) {
    function get_current_project()
    {
        session()->get('current_project_id') ?? 0;      
    }
}