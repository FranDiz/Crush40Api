<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Canciones extends Model

{

    protected $primaryKey = 'spotify_id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['spotify_id'];

    use HasFactory;

     public function playlists()
    {
        return $this->belongsToMany(Playlists::class, 'playlist_cancion', 'cancion_id', 'playlist_id');
    }
}
