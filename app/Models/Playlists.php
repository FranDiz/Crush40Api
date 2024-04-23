<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlists extends Model
{
    public function author(){
        return $this->belongsTo(User::class, 'users_id');
    }
    public function canciones(){
        return $this->hasMany(Canciones::class);
    }
    public function comentarios(){
        return $this->hasMany(Comentarios::class);
    }
    use HasFactory;
}