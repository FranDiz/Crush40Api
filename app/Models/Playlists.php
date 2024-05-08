<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlists extends Model
{
    use HasFactory;

    public function author(){
        return $this->belongsTo(User::class, 'users_id');
    }
    
    public function comentarios(){
        return $this->hasMany(Comentarios::class);
    }
    
    public function canciones(){
        return $this->belongsToMany(Canciones::class, 'canciones_playlists', 'playlist_id', 'spotify_id');
    }
}
