<?php

namespace App\Http\Controllers\Organisasi;

use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use App\Models\Booking;
use App\Models\VisitorStat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class DashboardController extends Controller
{
    private function getWeather($city = 'Jember')
    {
        return Cache::remember("weather_organisasi_{$city}", 1800, function () use ($city) {
            try {
                $response = Http::timeout(10)->get("https://wttr.in/{$city}?format=j1");

                if ($response->successful()) {
                    $data = $response->json();

                    if (isset($data['current_condition'][0])) {
                        $current = $data['current_condition'][0];
                        return [
                            'city' => $city,
                            'temperature' => $current['temp_C'] . '°C',
                            'description' => $current['weatherDesc'][0]['value'] ?? 'Cerah',
                            'humidity' => $current['humidity'] . '%',
                            'wind_speed' => $current['windspeedKmph'] . ' km/h',
                            'feels_like' => $current['FeelsLikeC'] . '°C',
                        ];
                    }
                }

                return $this->getFallbackWeather($city);
            } catch (\Exception $e) {
                return $this->getFallbackWeather($city);
            }
        });
    }

    private function getFallbackWeather($city = 'Jember')
    {
        return [
            'city' => $city,
            'temperature' => '30°C',
            'description' => 'Cerah Berawan',
            'humidity' => '75%',
            'wind_speed' => '8 km/h',
            'feels_like' => '32°C',
        ];
    }

    public function index()
    {
        $user = Auth::user();

        $ruangans = Ruangan::all();

        $totalRuanganTersedia = Ruangan::where('status', 'tersedia')->count();
        $totalDisetujui = Booking::where('user_id', $user->id)->where('status', 'disetujui')->count();
        $totalPending = Booking::where('user_id', $user->id)->where('status', 'pending')->count();
        $totalDitolak = Booking::where('user_id', $user->id)->where('status', 'ditolak')->count();

        $riwayatBookings = Booking::where('user_id', $user->id)
            ->with('ruangan')
            ->latest()
            ->take(10)
            ->get();

        $recommendedRuangan = Ruangan::inRandomOrder()->take(4)->get();

        $weather = $this->getWeather('Jember');

        $visitStat = VisitorStat::where('user_id', $user->id)->first();

        if (!$visitStat) {
            $visitStat = VisitorStat::create([
                'user_id' => $user->id,
                'visit_count' => 1,
                'first_visit' => Carbon::now('Asia/Jakarta'),
                'last_visit' => Carbon::now('Asia/Jakarta'),
            ]);
        } else {
            $visitStat->increment('visit_count');
            $visitStat->update(['last_visit' => Carbon::now('Asia/Jakarta')]);
        }

        $visitData = (object) [
            'visit_count' => $visitStat->visit_count,
            'first_visit' => $visitStat->first_visit,
            'last_visit' => $visitStat->last_visit,
        ];

        return view('organisasi.dashboard', compact(
            'ruangans',
            'totalRuanganTersedia',
            'totalDisetujui',
            'totalPending',
            'totalDitolak',
            'riwayatBookings',
            'recommendedRuangan',
            'weather',
            'visitData'
        ));
    }

    public function ruanganIndex(Request $request)
    {
        $query = Ruangan::query();

        // SEARCH berdasarkan nama atau lokasi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_ruangan', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%")
                  ->orWhere('kode_ruangan', 'like', "%{$search}%");
            });
        }

        // FILTER KAPASITAS
        if ($request->filled('kapasitas')) {
            $kapasitas = (int) $request->kapasitas;
            $query->where('kapasitas', '>=', $kapasitas);
        }

        // FILTER FASILITAS
        if ($request->filled('fasilitas')) {
            $fasilitas = $request->fasilitas;
            $query->where('fasilitas', 'like', "%{$fasilitas}%");
        }

        // FILTER STATUS
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $ruangans = $query->paginate(9);
        $totalRuangan = Ruangan::count();

        return view('organisasi.ruangan.index', compact('ruangans', 'totalRuangan'));
    }
}
