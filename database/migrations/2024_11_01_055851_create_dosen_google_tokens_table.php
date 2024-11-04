<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDosenGoogleTokensTable extends Migration
{
    public function up()
    {
        Schema::create('dosen_google_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->unique();  // Pertama definisikan kolom
            $table->text('access_token')->nullable();
            $table->text('refresh_token')->nullable();
            $table->integer('expires_in');
            $table->timestamp('created');
            $table->timestamps();

            // Kemudian tambahkan foreign key constraint secara terpisah
            $table->foreign('nip')
                  ->references('nip')
                  ->on('dosens')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dosen_google_tokens');
    }
}