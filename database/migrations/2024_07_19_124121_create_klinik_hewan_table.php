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
        Schema::create('klinik_hewan', function (Blueprint $table) {
            $table->id();
            $table->string('klinik_hewan');
            $table->string('alamat');
            $table->string('notelp');
            $table->time('jadwal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('klinik_hewan');
    }
};
