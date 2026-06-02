<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Ruangan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_ruangan',
        'kode_ruangan',
        'lokasi',
        'kapasitas',
        'fasilitas',
        'status',
        'foto'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
