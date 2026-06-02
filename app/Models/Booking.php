<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';

    protected $fillable = [
        'user_id',
        'ruangan_id',
        'tanggal_pengajuan',
        'tanggal_pinjam',
        'kategori_kegiatan',
        'waktu_mulai',
        'waktu_selesai',
        'bukti_surat_izin',
        'proposal_kegiatan',
        'keterangan_tambahan',
        'alasan_ditolak',
        'status'
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'date',
        'tanggal_pinjam' => 'date',
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    //  * Relasi ke User (peminjam)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class)->withTrashed();
    }

    // Scope untuk booking yang aktif (disetujui)
    public function scopeAktif($query)
    {
        return $query->where('status', 'disetujui');
    }
    // Scope untuk cek bentrok jadwal
    public function scopeBentrokJadwal($query, $ruanganId, $waktuMulai, $waktuSelesai)
    {
        return $query->where('ruangan_id', $ruanganId)
            ->where('status', 'disetujui')
            ->where(function($q) use ($waktuMulai, $waktuSelesai) {
                $q->whereBetween('waktu_mulai', [$waktuMulai, $waktuSelesai])
                  ->orWhereBetween('waktu_selesai', [$waktuMulai, $waktuSelesai])
                  ->orWhere(function($sub) use ($waktuMulai, $waktuSelesai) {
                      $sub->where('waktu_mulai', '<=', $waktuMulai)
                          ->where('waktu_selesai', '>=', $waktuSelesai);
                  });
            });
    }
}
