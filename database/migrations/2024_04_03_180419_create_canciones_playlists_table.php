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
        Schema::create('canciones_playlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('playlist_id')->constrained()->onDelete('cascade'); 
            $table->string('spotify_id');
            $table->foreign('spotify_id')->references('spotify_id')->on('canciones')->onDelete('cascade'); 
            $table->timestamps();

            $table->unique(['playlist_id', 'spotify_id']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('canciones_playlists');
    }
};
