<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlists extends Model
{
    use HasFactory;
    
    protected $fillable = ['title', 'description', 'user_id'];


    public function author(){
        return $this->belongsTo(User::class, 'users_id');
    }
    
    public function comentarios(){
        return $this->hasMany(Comentarios::class);
    }
    
    public function canciones()
    {
        return $this->belongsToMany(Canciones::class, 'playlist_cancion', 'playlist_id', 'cancion_id');
    }
}
