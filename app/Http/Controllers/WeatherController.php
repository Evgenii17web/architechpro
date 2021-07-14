<?php

namespace App\Http\Controllers;

use App\Models\Weather;

class WeatherController extends Controller
{
    public function weather(string $city)
    {
        switch ($city) {
            case 'kharkiv':
                $weather = new Weather('Kharkiv', 49.9935, 36.2304);
                break;
            case 'lviv':
                $weather = new Weather('Lviv', 49.8397, 24.0297);
                break;
            default:
                return 'Error';
        }

        return view('main', $weather->getWeather());
    }
}


