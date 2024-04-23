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
        Schema::create('canciones', function (Blueprint $table) {
            $table->id();
            $table->string('spotify_id')->unique(); 
            $table->string('titulo'); 
            $table->string('artista'); 
            $table->string('album'); 
            $table->integer('duracion_ms'); 
            $table->string('url_preview')->nullable(); 
            $table->date('fecha_lanzamiento');
            $table->string('imagen_album')->nullable();
            $table->timestamps(); 
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('canciones');
    }
};
