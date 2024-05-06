<?php

// App\Models\Favorite.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    public $incrementing = false;  // Indica que el modelo no debe autoincrementar el ID
    protected $primaryKey = ['id', 'user_id'];  // Define las claves primarias compuestas
    protected $keyType = 'string';  // Ajusta si el ID no es un entero
    public $incrementKeyType = 'string';  // Ajusta si el ID no es un entero
    protected $fillable = ['id', 'user_id'];  // Los campos que pueden ser asignados masivamente

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
