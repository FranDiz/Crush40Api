<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class CancionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $clientId = 'b94ff936eb4b484397fabf9f5822d61d';
        $clientSecret = '23237797c4354eae8b699e6691d8efa2';

        // Obtener el token de acceso
        $response = Http::asForm()->withBasicAuth($clientId, $clientSecret)->post('https://accounts.spotify.com/api/token', [
            'grant_type' => 'client_credentials',
        ]);

        $accessToken = $response->json()['access_token'];

        // Obtener datos de canciones. Asegúrate de que la playlist tenga al menos 20 canciones.
        $response = Http::withToken($accessToken)->get('https://api.spotify.com/v1/playlists/2Kfew3xw5lnnpVJJq0YoEZ/tracks', [
            'limit' => 20, // Especifica el límite de canciones a obtener.
        ]);

        $songs = $response->json()['items'];

        // Insertar canciones en la base de datos
        foreach ($songs as $song) {
            $track = $song['track'];
            $album = $track['album'];
            
            // Ajustar la fecha de lanzamiento
            $releaseDate = $album['release_date'];
            $releaseDateFormat = $album['release_date_precision']; // Esto puede ser 'year', 'month', o 'day'
            
            if ($releaseDateFormat == 'year') {
                $releaseDate = $releaseDate . '-01-01'; // Asume el primer día del año
            } elseif ($releaseDateFormat == 'month') {
                $releaseDate = $releaseDate . '-01'; // Asume el primer día del mes
            }
            // Si el formato es 'day', ya es una fecha completa
        
            DB::table('canciones')->insert([
                'spotify_id' => $track['id'],
                'titulo' => $track['name'],
                'artista' => implode(', ', array_map(function ($artist) { return $artist['name']; }, $track['artists'])),
                'album' => $album['name'],
                'duracion_ms' => $track['duration_ms'],
                'url_preview' => $track['preview_url'] ?? null,
                'fecha_lanzamiento' => $releaseDate,
                'imagen_album' => $album['images'][0]['url'] ?? null,
            ]);
        }
    }
}
