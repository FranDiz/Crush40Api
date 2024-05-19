<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Comentarios;
use App\Models\Playlists;
use Exception;

class UsersController extends Controller
{
    public function storeUser(Request $request)
    {
        // Validación inicial de los datos enviados
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        // Si la validación falla, devuelve un error 400 con los mensajes de validación
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try {
            // Creación del usuario
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password); // Hashea la contraseña antes de guardarla
            $user->save();

            // Devuelve el usuario creado con un código de estado 201
            return response()->json($user, 201);
        } catch (\Exception $e) {
            // Loguear el error sería una buena práctica para debuggear si algo sale mal
            return response()->json(['error' => 'Error en el servidor'], 500);
        }
    }
    public function createComment(Request $request)
    {
        try {
            // Validación de datos
            $request->validate([
                'usuario' => 'required|string|max:255',
                'comentario' => 'required|string',
                'user_id' => 'required|exists:users,id',
                'playlists_id' => 'required|exists:playlists,id',
            ]);
        } catch (Exception $e) {
            // Manejar la excepción de validación
            return response()->json(['message' => 'Error en la validación: ' . $e->getMessage()], 400);
        }

        // Crear un nuevo comentario
        $comentario = new Comentarios();
        $comentario->usuario = $request->usuario;
        $comentario->comentario = $request->comentario;
        $comentario->user_id = $request->user_id;
        $comentario->playlists_id = $request->playlists_id;
        $comentario->save();

        // Redireccionar o devolver una respuesta JSON
        return response()->json(['message' => 'Comentario creado correctamente'], 201);
    }
}