<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;
use App\Models\Ruangan;
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
        return Cache::remember("weather_{$city}", 1800, function () use ($city) {
            try {
                $response = Http::get("https://wttr.in/{$city}?format=j1");

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
            'temperature' => '27°C',
            'description' => 'Cerah Berawan',
            'humidity' => '75%',
            'wind_speed' => '8 km/h',
            'feels_like' => '32°C',
        ];
    }

    public function index()
    {
        $admin = Auth::user();

        // Statistik Peminjaman
        $totalPengajuan = Booking::count();
        $totalDisetujui = Booking::where('status', 'disetujui')->count();
        $totalBelumDisetujui = Booking::where('status', 'pending')->count();
        $totalDitolak = Booking::where('status', 'ditolak')->count();

        $totalOrganisasi = User::where('role', 'organisasi')->count();
        $totalRuangan = Ruangan::count();

        $latestBookings = Booking::with(['user', 'ruangan'])
            ->latest()
            ->take(10)
            ->get();

        $weather = $this->getWeather('Jember');

        // ==========================================
        // AMBIL DATA KUNJUNGAN DARI DATABASE
        // ==========================================
        $visitData = VisitorStat::where('user_id', Auth::id())->first();

        if (!$visitData) {
            $visitData = (object) [
                'visit_count' => 0,
                'first_visit' => null,
                'last_visit' => null,
            ];
        }

        return view('admin.dashboard', compact(
            'admin',
            'totalPengajuan',
            'totalDisetujui',
            'totalBelumDisetujui',
            'totalDitolak',
            'totalOrganisasi',
            'totalRuangan',
            'latestBookings',
            'weather',
            'visitData'
        ));
    }

    public function resetVisit(Request $request)
    {
        $visitor = VisitorStat::where('user_id', Auth::id())->first();

        if ($visitor) {
            $visitor->update([
                'visit_count' => 1,
                'first_visit' => Carbon::now('Asia/Jakarta'),
                'last_visit' => Carbon::now('Asia/Jakarta'),
            ]);
        } else {
            VisitorStat::create([
                'user_id' => Auth::id(),
                'visit_count' => 1,
                'first_visit' => Carbon::now('Asia/Jakarta'),
                'last_visit' => Carbon::now('Asia/Jakarta'),
            ]);
        }

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Hitungan kunjungan telah direset.');
    }
}
