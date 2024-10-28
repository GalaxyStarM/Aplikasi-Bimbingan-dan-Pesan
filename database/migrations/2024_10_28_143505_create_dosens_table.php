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
        Schema::create('dosen', function (Blueprint $table) {
            $table->string('nip')->primary();
            $table->string('nama');
            $table->string('nama_singkat');
            $table->string('email')->unique();
            $table->string('password');
            $table->datetime('created_at');
            $table->datetime('updated_at');
            $table->unsignedBigInteger('prodi_id');
            $table->unsignedBigInteger('role_id');
            $table->rememberToken();

            $table->foreign('prodi_id')->references('id')->on('prodi');
            $table->foreign('role_id')->references('id')->on('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen');
    }
};
