<?php

namespace App\Http\Controllers\Organisasi;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Booking::where('user_id', $user->id)->with('ruangan');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('ruangan', function($sub) use ($search) {
                    $sub->where('nama_ruangan', 'like', "%{$search}%")
                        ->orWhere('kode_ruangan', 'like', "%{$search}%");
                })->orWhere('kategori_kegiatan', 'like', "%{$search}%");
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $riwayat = $query->latest()->paginate(10);

        // Statistik
        $totalPengajuan = Booking::where('user_id', $user->id)->count();
        $totalPending = Booking::where('user_id', $user->id)->where('status', 'pending')->count();
        $totalDisetujui = Booking::where('user_id', $user->id)->where('status', 'disetujui')->count();
        $totalDitolak = Booking::where('user_id', $user->id)->where('status', 'ditolak')->count();

        return view('organisasi.riwayat.index', compact('riwayat', 'totalPengajuan', 'totalPending', 'totalDisetujui', 'totalDitolak'));
    }
}
