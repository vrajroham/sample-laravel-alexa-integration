<?php

namespace App\Http\Controllers;

use Develpr\AlexaApp\Facades\Alexa;
use Develpr\AlexaApp\Http\Routing\AlexaRoute;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;

class HomeController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // return view('home');
        $curl = curl_init();
        curl_setopt_array($curl, Array(
            CURLOPT_URL            => 'https://rss.simplecast.com/podcasts/279/rss',
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_ENCODING       => 'UTF-8'
        ));
        $data = curl_exec($curl);
        curl_close($curl);

        $xml = simplexml_load_string($data);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        // dd($array['channel']['item'][0]['enclosure']['@attributes']['url']);
        dd($array['channel']['item'][0]['title']);
    }

    public function oauthDashboard(Request $request)
    {
        return view('oauth-dashboard');
    }

    public function alexa()
    {
        
    }
}
