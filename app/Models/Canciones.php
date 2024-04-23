<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Canciones extends Model
{
    public function playlists(){
        return $this->belongsToMany(Playlists::class);
    }
    use HasFactory;
}
