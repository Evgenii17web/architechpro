<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Weather extends Model
{
    private $title;
    private $lng;
    private $lat;

    public function __construct(string $title, int $lat, int $lng, array $attributes = [])
    {
        parent::__construct($attributes);
        $this->title = $title;
        $this->lat = $lat;
        $this->lng = $lng;
    }

    public function getCurlWeather()
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.ambeedata.com/weather/latest/by-lat-lng?lat={$this->lat}&lng={$this->lng}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Content-type: application/json",
                "x-api-key: 94255c6cbf61e210acde0f12fa5435a4b6ba5e5cbdce7d6d4d95df2b30392e40"
            ],
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            $response = json_decode($response, true);

            return $this->getData($response);
        }
    }

    public function getHttpWeather(): array
    {
        $response = Http::withHeaders([
            "x-api-key" => "94255c6cbf61e210acde0f12fa5435a4b6ba5e5cbdce7d6d4d95df2b30392e40"
        ])->get('https://api.ambeedata.com/weather/latest/by-lat-lng?lat=49.9935&lng=36.2304');
        $response = json_decode($response, true);

        return $this->getData($response);
    }

    private function getData(array $response): array
    {
        $icon = $this->getIcon($response['data']['icon']);
        $temperatureInCelsius = ceil(($response['data']['temperature'] - 32) / 1.8);

        return [
            'title' => $this->title,
            'icon' => $icon,
            'temperature' => $temperatureInCelsius,
            'humidity' => $response['data']['humidity'],
            'windSpeed' => $response['data']['windSpeed'],
        ];
    }

    private function getIcon(string $icon): string
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://assetambee.s3-us-west-2.amazonaws.com/weatherIcons/PNG/{$icon}.png",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Content-type: application/json",
                "x-api-key: 94255c6cbf61e210acde0f12fa5435a4b6ba5e5cbdce7d6d4d95df2b30392e40"
            ],
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            file_put_contents("images/$icon.png", $response);
            return $icon . '.png';
        }
    }
}
