<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data booking dengan relasi user dan ruangan
        $bookings = Booking::with(['user', 'ruangan'])
            ->latest()
            ->paginate(10);

        // Hitung statistik untuk ditampilkan di dashboard
        $totalPengajuan = Booking::count();
        $totalPending = Booking::where('status', 'pending')->count();
        $totalDisetujui = Booking::where('status', 'disetujui')->count();
        $totalDitolak = Booking::where('status', 'ditolak')->count();

        return view('admin.peminjaman.index', compact(
            'bookings',
            'totalPengajuan',
            'totalPending',
            'totalDisetujui',
            'totalDitolak'
        ));
    }

    /**
     * Approve peminjaman
     */
    public function approve(Booking $peminjaman)
    {
        // Cek apakah jadwal bentrok dengan booking lain yang sudah disetujui
        $bentrok = Booking::where('ruangan_id', $peminjaman->ruangan_id)
            ->where('status', 'disetujui')
            ->where('id', '!=', $peminjaman->id)
            ->where(function($q) use ($peminjaman) {
                $q->where('waktu_mulai', '<', $peminjaman->waktu_selesai)
                  ->where('waktu_selesai', '>', $peminjaman->waktu_mulai);
            })
            ->exists();

        if ($bentrok) {
            return redirect()->back()->with('error', 'Tidak dapat menyetujui karena jadwal bentrok dengan peminjaman lain yang sudah disetujui!');
        }

        // Update status peminjaman
        $peminjaman->update(['status' => 'disetujui']);

        // Update status ruangan menjadi dipinjam
        $ruangan = Ruangan::find($peminjaman->ruangan_id);
        if ($ruangan) {
            $ruangan->update(['status' => 'dipinjam']);
        }

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil disetujui');
    }

    public function reject(Request $request, Booking $peminjaman)
    {
        $request->validate([
            'alasan' => 'required|string|min:5|max:500'
        ], [
            'alasan.required' => 'Alasan penolakan wajib diisi!',
            'alasan.min' => 'Alasan penolakan minimal 5 karakter',
            'alasan.max' => 'Alasan penolakan maksimal 500 karakter'
        ]);

        $peminjaman->update([
            'status' => 'ditolak',
            'alasan_ditolak' => $request->alasan
        ]);

    return redirect()->route('admin.peminjaman.index')
        ->with('success', 'Peminjaman ditolak dengan alasan: ' . $request->alasan);
}

    public function show(Booking $peminjaman)
    {
        return view('admin.peminjaman.show', compact('peminjaman'));
    }

    public function getJson(Booking $peminjaman)
    {
        return response()->json([
            'success' => true,
            'data' => $peminjaman->load(['user', 'ruangan'])
        ]);
    }
}
