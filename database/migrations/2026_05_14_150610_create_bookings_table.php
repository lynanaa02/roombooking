<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('ruangan_id')->constrained()->onDelete('cascade');
            $table->date('tanggal_pengajuan');
            $table->string('kategori_kegiatan');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->string('bukti_surat_izin')->nullable();
            $table->string('proposal_kegiatan')->nullable();
            $table->text('keterangan_tambahan')->nullable();
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
