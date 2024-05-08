<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('playlist_cancion', function (Blueprint $table) {
            $table->foreignId('playlist_id')->constrained()->onDelete('cascade');
            $table->string('cancion_id')->constrained('canciones', 'spotify_id')->onDelete('cascade');
            $table->timestamps();

            $table->primary(['playlist_id', 'cancion_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('playlist_cancion');
    }
};
