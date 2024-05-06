<?php

namespace App\Http\Controllers;

use App\Models\User; // Asegúrate de importar el modelo User
use App\Models\Favorite; // Importa el modelo Favorite
use Illuminate\Http\Request;

    class FavoritesController extends Controller
    {
        // Obtener los favoritos de un usuario
        public function getUserFavorites(Request $request)
        {
            // Validar que el userId está presente en la solicitud
            $validatedData = $request->validate([
                'userId' => 'required|integer'  // Asegúrate de que el userId sea un entero y sea requerido
            ]);
        
            $userId = $validatedData['userId'];
        
            // Buscar el usuario utilizando el userId
            $user = User::find($userId);
            if (!$user) {
                // Devolver un error si el usuario no se encuentra
                return response()->json(['error' => 'Usuario no encontrado'], 404);
            }
        
            // Recuperar los favoritos del usuario
            $favorites = $user->favorites;
        
            // Devolver los favoritos como respuesta JSON
            return response()->json($favorites);
        }   
        

        // Añadir un nuevo favorito
        public function addFavorite(Request $request)
        {
            $request->validate([
                'userId' => 'required|exists:users,id',
                'favoriteId' => 'required|string' // Asumiendo que el ID de favorito es un string
            ]);
        
            $userId = $request->input('userId');
            $favoriteId = $request->input('favoriteId');
        
            // Crear una nueva instancia de Favorite
            $favorite = new Favorite([
                'id' => $favoriteId,
                'user_id' => $userId
            ]);
        
            // Guardar el nuevo favorito
            $favorite->save();
        
            // Opcionalmente, devolver el usuario y sus favoritos para confirmar la adición
            $user = User::with('favorites')->find($userId);
        
            return response()->json($user);
        }
        

        // Eliminar un favorito
        public function deleteFavorite(Request $request)
        {
            $request->validate([
                'userId' => 'required|exists:users,id',
                'favoriteId' => 'required|string'  // Asumiendo que el ID de favorito es un string
            ]);
        
            $userId = $request->input('userId');
            $favoriteId = $request->input('favoriteId');
        
            // Encontrar el favorito específico
            $favorite = Favorite::where('user_id', $userId)->where('id', $favoriteId);
        
            if (!$favorite) {
                // Si el favorito no se encuentra, devolver un error
                return response()->json(['error' => 'Favorito no encontrado'], 404);
            }
        
            // Eliminar el favorito encontrado
            $favorite->delete();
        
            // Devolver una respuesta indicando que el favorito fue eliminado correctamente
            return response()->json(['message' => 'Favorito eliminado correctamente'], 200);
        }
    }
