<?php

namespace App\Http\Controllers;

use App\Models\Playlists;
use App\Models\Canciones;
use App\Models\User; 
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    private $token;
    public function authenticate()
    {
        $response = Http::asForm()->post('https://accounts.spotify.com/api/token', [
            'grant_type' => 'client_credentials',
            'client_id' => env('SPOTIFY_CLIENT_ID'),
            'client_secret' => env('SPOTIFY_CLIENT_SECRET'),
        ]);

        $this->token = $response['access_token'];
    }


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
    public function getPlaylistDetails(Request $request)
    {
        $playlistId = $request->input('playlistId');
        try {
            // Busca la playlist por ID. Si no la encuentra, retorna un error 404.
            $playlist = Playlists::findOrFail($playlistId);
    
            // Si la playlist es encontrada, devuelve los detalles de la playlist con un código de estado 200 (OK)
            return response()->json($playlist, 200);
        } catch (\Exception $e) {
            // En caso de error en la búsqueda, devuelve un mensaje de error con un código de estado 500 (Error interno del servidor)
         return response()->json(['error' => 'Error en el servidor: ' . $e->getMessage()], 500);
    }
    }
    public function addSongToPlaylist(Request $request)
    {
    $playlistId = $request->input('playlistId');
    $cancionId = $request->input('cancionId');

    $playlist = Playlists::find($playlistId);
    if (!$playlist) {
        return response()->json(['message' => 'Playlist not found'], 404);
    }

    $playlist->canciones()->attach($cancionId);

    return response()->json(['message' => 'Cancion added to playlist']);
    }

    public function getPlaylistSongs(Request $request){
            $playlistId = $request->input('playlistId');
            $playlist = Playlists::with('canciones')->find($playlistId);
        if (!$playlist) {
            return response()->json(['message' => 'Playlist not found'], 404);
        }
        return response()->json($playlist->canciones);
    }


    public function removeSongFromPlaylist(Request $request, )
{
    $playlistId = $request->input('playlistId');
    $cancionId = $request->input('cancionId');

    // Buscar la playlist por su ID
    $playlist = Playlists::find($playlistId);

    // Verificar si la playlist existe
    if (!$playlist) {
        // Si la playlist no se encuentra, retornar un error 404
        return response()->json(['message' => 'Playlist not found'], 404);
    }

    // Eliminar la canción específica de la playlist
    $playlist->canciones()->detach($cancionId);

    // Retornar una respuesta confirmando que la canción fue eliminada
    return response()->json(['message' => 'Cancion removed from playlist']);
}

}
