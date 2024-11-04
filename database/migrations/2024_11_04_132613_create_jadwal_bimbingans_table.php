<?php
// database/migrations/2024_11_04_create_jadwal_bimbingans_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jadwal_bimbingans', function (Blueprint $table) {
            $table->id();
            $table->string('event_id')->unique(); // ID event dari Google Calendar
            $table->string('nip');
            $table->foreign('nip')->references('nip')->on('dosens')->onDelete('cascade');
            $table->dateTime('waktu_mulai');
            $table->dateTime('waktu_selesai');
            $table->text('catatan')->nullable();
            $table->string('status')->default('tersedia');
            $table->integer('kapasitas')->default(1);
            $table->integer('sisa_kapasitas')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jadwal_bimbingans');
    }
};