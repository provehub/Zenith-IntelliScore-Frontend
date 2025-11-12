<?php
namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use App\Models\{Listing, ListingImage};

class SmsService
{

    public function sendSmsTermii($to, $sms)
    {
        $client = new Client();

        $url = config('services.termii.baseUrl').'/api/sms/send';

        $response = $client->post($url, [
            'json' => [
                'to' => $to,
                'from' => config('services.termii.sender_id'),
                'sms' => $sms,
                'type' => 'plain',
                'channel' => 'dnd',
                'api_key' => config('services.termii.api_key')
            ]
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

}
