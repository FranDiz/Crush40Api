<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Canciones extends Model

{

    protected $fillable = [
        'spotify_id',  // Agrega todos los campos que deseas ser asignables masivamente
    ];

    use HasFactory;

    public function playlists(){
        // Asegurándonos de especificar la tabla intermedia correcta y los identificadores correctos
        return $this->belongsToMany(Playlists::class, 'canciones_playlists', 'spotify_id', 'playlist_id');
    }
}
