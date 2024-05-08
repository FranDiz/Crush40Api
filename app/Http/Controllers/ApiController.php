<?php

namespace App\Http\Controllers;

use App\Models\Playlists;
use App\Models\Canciones;
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
    public function getPlaylistDetails(Request $request, $id)
    {
        try {
            // Busca la playlist por ID. Si no la encuentra, retorna un error 404.
            $playlist = Playlists::findOrFail($id);
    
            // Si la playlist es encontrada, devuelve los detalles de la playlist con un código de estado 200 (OK)
            return response()->json($playlist, 200);
        } catch (\Exception $e) {
            // En caso de error en la búsqueda, devuelve un mensaje de error con un código de estado 500 (Error interno del servidor)
         return response()->json(['error' => 'Error en el servidor: ' . $e->getMessage()], 500);
    }
    }
    public function addSongToPlaylist(Request $request)
    {
        $validated = $request->validate([
            'playlistId' => 'required|exists:playlists,id',
            'spotifyId' => 'required|string|max:255'
        ]);

        // Crear o encontrar la canción por su Spotify ID
        $cancion = Canciones::firstOrCreate([
            'spotify_id' => $validated['spotifyId']
        ]);

        // Encontrar la playlist y asociar la canción
        $playlist = Playlists::find($validated['playlistId']);
        if (!$playlist) {
            return response()->json(['message' => 'Playlist no encontrada'], 404);
        }

        // Asociar la canción con la playlist evitando duplicados
        $playlist->canciones()->syncWithoutDetaching($cancion->id);

        return response()->json(['message' => 'Canción añadida a la playlist correctamente']);
    }
    
}
