<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class WeatherService
{
    public function getWeather($city = 'Surabaya')
    {
        // Cache selama 30 menit agar tidak terlalu sering request
        return Cache::remember("weather_{$city}", 1800, function () use ($city) {
            try {
                $response = Http::get("https://wttr.in/{$city}?format=j1");

                if ($response->successful()) {
                    $data = $response->json();
                    $current = $data['current_condition'][0];

                    return [
                        'city' => $city,
                        'temperature' => $current['temp_C'] . '°C',
                        'description' => $current['weatherDesc'][0]['value'] ?? 'Tidak diketahui',
                        'humidity' => $current['humidity'] . '%',
                        'wind_speed' => $current['windspeedKmph'] . ' km/h',
                        'feels_like' => $current['FeelsLikeC'] . '°C',
                        'icon' => $current['weatherIconUrl'][0]['value'] ?? null,
                    ];
                }

                return $this->getFallbackWeather();
            } catch (\Exception $e) {
                \Log::error('Weather API failed: ' . $e->getMessage());
                return $this->getFallbackWeather();
            }
        });
    }

    private function getFallbackWeather()
    {
        return [
            'city' => 'Surabaya',
            'temperature' => '30°C',
            'description' => 'Cerah Berawan',
            'humidity' => '70%',
            'wind_speed' => '10 km/h',
            'feels_like' => '33°C',
            'icon' => null,
        ];
    }
}
