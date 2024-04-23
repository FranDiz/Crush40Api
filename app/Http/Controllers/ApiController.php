<?php

namespace App\Http\Controllers;

use App\Models\Playlists; // Asegúrate de que el nombre del modelo sea correcto
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:20',
                'description' => 'nullable|string',
                'user_id' => 'required|exists:users,id', // Valida que el user_id sea requerido y exista en la tabla de usuarios
            ]);

            $playlist = new Playlists(); // Asegúrate de que el nombre de la clase sea correcto
            $playlist->title = $request->input('title');
            $playlist->description = $request->input('description');
            $playlist->user_id = $request->input('user_id'); // Asigna el user_id desde la petición
            $playlist->save();

            return response()->json($playlist, 201);
        } catch (\Exception $e) {
            // Considera loguear el error para tener más detalles sobre el mismo
            return response()->json(['error' => 'Error en el servidor'], 500);
        }
    }
}
