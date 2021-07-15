<?php

namespace App\Http\Controllers;

use App\Models\Weather;

class WeatherController extends Controller
{
    /**
     * @param string $city
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function weather(string $city)
    {
        switch ($city) {
            case 'kharkiv':
                $weather = new Weather('Kharkiv', 49.9935, 36.2304);
                return view('main', $weather->getCurlWeather());
            case 'lviv':
                $weather = new Weather('Lviv', 49.8397, 24.0297);
                return view('main', $weather->getHttpWeather());
            default:
                abort(404, 'Error');
        }
    }
}
