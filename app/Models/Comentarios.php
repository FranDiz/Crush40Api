<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentarios extends Model
{
    public function playlists(){
        return $this->belongsTo(Playlists::class);
    }
    public function users(){
        return $this->belongsTo(User::class);
    }

    use HasFactory;
}
