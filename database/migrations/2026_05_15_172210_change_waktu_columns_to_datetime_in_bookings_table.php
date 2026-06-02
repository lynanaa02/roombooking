<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Hapus kolom lama
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['waktu_mulai', 'waktu_selesai']);
        });

        // Buat kolom baru dengan tipe datetime
        Schema::table('bookings', function (Blueprint $table) {
            $table->dateTime('waktu_mulai')->nullable()->after('tanggal_pinjam');
            $table->dateTime('waktu_selesai')->nullable()->after('waktu_mulai');
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['waktu_mulai', 'waktu_selesai']);
            $table->time('waktu_mulai')->nullable();
            $table->time('waktu_selesai')->nullable();
        });
    }
};
