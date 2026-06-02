<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->index(['ruangan_id', 'waktu_mulai', 'waktu_selesai', 'status']);
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex(['ruangan_id', 'waktu_mulai', 'waktu_selesai', 'status']);
        });
    }
};
