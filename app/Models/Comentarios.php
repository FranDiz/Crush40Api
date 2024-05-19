<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentarios extends Model
{
    protected $fillable = [
        'usuario',
        'comentario',
        'user_id',
        'playlist_id',
    ];

    public function playlists(){
        return $this->belongsTo(Playlists::class, 'playlist_id');
    }
    public function users(){
        return $this->belongsTo(User::class);
    }

    use HasFactory;
}
