<?php

namespace App\Http\Controllers;

use App\Models\Playlists;
use App\Models\User; 
use App\Models\Favorite;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function createPlaylist(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:20',
                'description' => 'nullable|string',
                'user_id' => 'required|exists:users,id', 
            ]);

            $playlist = new Playlists(); 
            $playlist->title = $request->input('title');
            $playlist->description = $request->input('description');
            $playlist->user_id = $request->input('user_id');
            $playlist->save();

            return response()->json($playlist, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error en el servidor'], 500);
        }
    }
    public function getPlaylists(Request $request)
    {
        try {
            // Obtiene todas las playlists de la base de datos
            $playlists = Playlists::all();
    
            // Devuelve las playlists con un código de estado 200 (OK)
            return response()->json($playlists, 200);
        } catch (\Exception $e) {
            // En caso de error, devuelve un mensaje de error con un código de estado 500 (Error interno del servidor)
            return response()->json(['error' => 'Error en el servidor: ' . $e->getMessage()], 500);
        }
    }
    
}
