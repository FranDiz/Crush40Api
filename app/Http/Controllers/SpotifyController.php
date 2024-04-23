<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SpotifyController extends Controller
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

    public function search(Request $request)
    {
        $this->authenticate();  // Asegura que tengamos un token
        $type = $request->input('type'); // Asegúrate de que 'type' se esté capturando correctamente
        $query = $request->input('query'); // Asegúrate de que 'query' se esté capturando correctamente
    
        if (!$query) { // Verifica si 'query' está vacío y retorna un error antes de llamar a Spotify
            return response()->json(['error' => ['message' => 'No search query', 'status' => 400]], 400);
        }
    
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->token}",
        ])->get("https://api.spotify.com/v1/search", [
            'type' => $type,
            'q' => $query
        ]);
    
        return $response->json();  // Devuelve la respuesta JSON directamente al cliente
    }
}