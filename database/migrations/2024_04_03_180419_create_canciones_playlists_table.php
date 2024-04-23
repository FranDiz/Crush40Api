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
            $table->foreignId('playlists_id')->references('id')->on('playlists')->onDelete('cascade');
            $table->foreignId('canciones_id')->references('id')->on('canciones')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['playlists_id', 'canciones_id']);
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