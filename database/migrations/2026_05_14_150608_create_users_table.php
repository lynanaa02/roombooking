<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'organisasi']);
            $table->string('nama_organisasi')->nullable();
            $table->string('ketua_organisasi')->nullable();
            $table->enum('jenis_organisasi', ['UKM', 'BEM', 'Himpunan'])->nullable();
            $table->integer('jumlah_anggota')->nullable();
            $table->string('no_telp')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
