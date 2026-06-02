<?php

namespace App\Http\Controllers\Organisasi;
use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BookingController extends Controller
{
    //  * Cek ketersediaan ruangan pada waktu tertentu
    private function cekKetersediaanRuangan($ruanganId, $waktuMulai, $waktuSelesai, $excludeBookingId = null)
    {
        $query = Booking::where('ruangan_id', $ruanganId)
            ->where('status', 'disetujui')
            ->where(function($q) use ($waktuMulai, $waktuSelesai) {
                $q->whereBetween('waktu_mulai', [$waktuMulai, $waktuSelesai])
                  ->orWhereBetween('waktu_selesai', [$waktuMulai, $waktuSelesai])
                  ->orWhere(function($sub) use ($waktuMulai, $waktuSelesai) {
                      $sub->where('waktu_mulai', '<=', $waktuMulai)
                          ->where('waktu_selesai', '>=', $waktuSelesai);
                  });
            });

        if ($excludeBookingId) {
            $query->where('id', '!=', $excludeBookingId);
        }

        return $query->count() === 0;
    }

    public function create($ruanganId = null)
    {
        $ruangans = Ruangan::all();
        $selectedRuangan = null;

        if ($ruanganId) {
            $selectedRuangan = Ruangan::find($ruanganId);
        }

        return view('organisasi.booking.create', compact('ruangans', 'selectedRuangan'));
    }

    public function cekKetersediaan(Request $request)
    {
        $request->validate([
            'ruangan_id' => 'required|exists:ruangans,id',
            'tanggal_pinjam' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
        ]);

        $waktuMulai = Carbon::parse($request->tanggal_pinjam . ' ' . $request->waktu_mulai);
        $waktuSelesai = Carbon::parse($request->tanggal_pinjam . ' ' . $request->waktu_selesai);

        $tersedia = $this->cekKetersediaanRuangan(
            $request->ruangan_id,
            $waktuMulai,
            $waktuSelesai
        );

        $bentrok = null;
        if (!$tersedia) {
            $bentrokBooking = Booking::where('ruangan_id', $request->ruangan_id)
                ->where('status', 'disetujui')
                ->where(function($q) use ($waktuMulai, $waktuSelesai) {
                    $q->whereBetween('waktu_mulai', [$waktuMulai, $waktuSelesai])
                      ->orWhereBetween('waktu_selesai', [$waktuMulai, $waktuSelesai])
                      ->orWhere(function($sub) use ($waktuMulai, $waktuSelesai) {
                          $sub->where('waktu_mulai', '<=', $waktuMulai)
                              ->where('waktu_selesai', '>=', $waktuSelesai);
                      });
                })
                ->with('user')
                ->first();

            if ($bentrokBooking) {
                $bentrok = [
                    'organisasi' => $bentrokBooking->user->nama_organisasi ?? $bentrokBooking->user->name,
                    'waktu_mulai' => Carbon::parse($bentrokBooking->waktu_mulai)->setTimezone('Asia/Jakarta')->format('d/m/Y H:i'),
                    'waktu_selesai' => Carbon::parse($bentrokBooking->waktu_selesai)->setTimezone('Asia/Jakarta')->format('d/m/Y H:i'),
                    'kegiatan' => $bentrokBooking->kategori_kegiatan,
                ];
            }
        }

        return response()->json([
            'tersedia' => $tersedia,
            'bentrok' => $bentrok
        ]);
    }


    public function store(Request $request)
{
    // ========== 1. VALIDASI INPUT ==========
    $request->validate([
        'ruangan_id' => 'required|exists:ruangans,id',
        'kategori_kegiatan' => 'required|string|max:255',
        'tanggal_pengajuan' => 'required|date',
        'tanggal_pinjam' => 'required|date|after_or_equal:today',
        'waktu_mulai' => 'required',
        'waktu_selesai' => 'required',
        'bukti_surat_izin' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'proposal_kegiatan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'keterangan_tambahan' => 'nullable|string'
    ]);

    // ========== 2. PROSES WAKTU ==========
    $waktuMulai = Carbon::parse($request->tanggal_pinjam . ' ' . $request->waktu_mulai);
    $waktuSelesai = Carbon::parse($request->tanggal_pinjam . ' ' . $request->waktu_selesai);

    if ($waktuMulai->isPast() && $waktuMulai->startOfDay()->isToday()) {
        return back()->withInput()->with('error', 'Waktu mulai tidak boleh kurang dari sekarang.');
    }

    if ($waktuSelesai <= $waktuMulai) {
        return back()->withInput()->with('error', 'Waktu selesai harus setelah waktu mulai.');
    }

    // ========== 3. CEK KETERSEDIAAN RUANGAN ==========
    $tersedia = $this->cekKetersediaanRuangan(
        $request->ruangan_id,
        $waktuMulai,
        $waktuSelesai
    );

    if (!$tersedia) {
        $ruangan = Ruangan::find($request->ruangan_id);
        return back()
            ->withInput()
            ->with('error', 'Maaf, ruangan "' . $ruangan->nama_ruangan . '" sudah dipesan pada tanggal ' . $request->tanggal_pinjam . ' jam ' . $request->waktu_mulai . ' - ' . $request->waktu_selesai . '. Silakan pilih jadwal lain.');
    }

    // ========== 4. SIAPKAN DATA BOOKING ==========
    $data = [
        'user_id' => Auth::id(),
        'ruangan_id' => $request->ruangan_id,
        'kategori_kegiatan' => $request->kategori_kegiatan,
        'tanggal_pengajuan' => $request->tanggal_pengajuan,
        'tanggal_pinjam' => $request->tanggal_pinjam,
        'waktu_mulai' => $waktuMulai,
        'waktu_selesai' => $waktuSelesai,
        'keterangan_tambahan' => $request->keterangan_tambahan,
        'status' => 'pending'
    ];

    // ========== 5. UPLOAD FILE (PERBAIKAN UTAMA) ==========

    // Upload bukti surat izin
    if ($request->hasFile('bukti_surat_izin')) {
        $file = $request->file('bukti_surat_izin');
        // nama file (hapus karakter berbahaya)
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $cleanName = preg_replace('/[^a-zA-Z0-9_-]/', '', $originalName);
        $filename = time() . '_surat_' . $cleanName . '.' . $extension;

        // Memastikan folder tujuan ada
        $destinationPath = public_path('uploads/bukti_surat');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Memindahkan file
        $file->move($destinationPath, $filename);

        // Simpan path yang benar (tanpa storage/)
        $data['bukti_surat_izin'] = 'uploads/bukti_surat/' . $filename;
    }

    // Upload proposal kegiatan
    if ($request->hasFile('proposal_kegiatan')) {
        $file = $request->file('proposal_kegiatan');

        // nama file
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $cleanName = preg_replace('/[^a-zA-Z0-9_-]/', '', $originalName);
        $filename = time() . '_proposal_' . $cleanName . '.' . $extension;

        // Memastikan folder tujuan ada
        $destinationPath = public_path('uploads/proposal');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Memindahkan file
        $file->move($destinationPath, $filename);

        // Menyimpan path yang benar
        $data['proposal_kegiatan'] = 'uploads/proposal/' . $filename;
    }

    // ========== 6. DEBUG LOG (UNTUK MENCARI MASALAH) ==========
    \Log::info('Booking Store - Upload Debug', [
        'has_surat' => $request->hasFile('bukti_surat_izin'),
        'has_proposal' => $request->hasFile('proposal_kegiatan'),
        'surat_path' => $data['bukti_surat_izin'] ?? null,
        'proposal_path' => $data['proposal_kegiatan'] ?? null,
    ]);

    // ========== 7. SIMPAN KE DATABASE ==========
    Booking::create($data);

    return redirect()->route('organisasi.dashboard')
        ->with('success', 'Pengajuan peminjaman berhasil dikirim! Menunggu persetujuan admin.');
}

    public function getJson($id)
    {
        $booking = Booking::with('ruangan')->where('user_id', Auth::id())->find($id);
        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $booking
        ]);
    }

    public function show(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('organisasi.booking.show', compact('booking'));
    }

    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized');
        }

        if ($booking->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya peminjaman dengan status pending yang dapat dibatalkan');
        }

        if ($booking->bukti_surat_izin && Storage::exists('public/' . $booking->bukti_surat_izin)) {
            Storage::delete('public/' . $booking->bukti_surat_izin);
        }
        if ($booking->proposal_kegiatan && Storage::exists('public/' . $booking->proposal_kegiatan)) {
            Storage::delete('public/' . $booking->proposal_kegiatan);
        }

        $booking->delete();
        return redirect()->route('organisasi.riwayat.index')
            ->with('success', 'Peminjaman berhasil dibatalkan');
    }
}
