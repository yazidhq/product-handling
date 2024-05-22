<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('titik_antars', function (Blueprint $table) {
            $table->id();
            $table->string('kota');
            $table->string('kode_pos');
            $table->string('alamat_lengkap');
            $table->string('kontak_nama');
            $table->string('kontak_nomor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('titik_antars');
    }
};
