<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\FavoritesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpotifyController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/spotify/authenticate', [SpotifyController::class, 'authenticate']);
Route::get('/spotify/search', [SpotifyController::class, 'search']);
Route::get('/spotify/getAlbumTracks',[SpotifyController::class, 'getAlbumTracks']);
Route::get('/spotify/getSong',[SpotifyController::class, 'getSong']);

Route::get('/favorites/getUserFavorites', [FavoritesController::class, 'getUserFavorites']);
Route::post('/favorites/addFavorite', [FavoritesController::class, 'addFavorite']);
Route::delete('/favorites/deleteFavorite', [FavoritesController::class, 'deleteFavorite']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/saludo', function () {
    return response()->json(['mensaje' => 'Hola Mundo']);
});
Route::post('/createPlaylist',[ApiController::class, 'createPlaylist']);
Route::post('/storeUser',[UsersController::class,'storeUser']);
Route::get('/getPlaylists', [ApiController::class, 'getPlaylists']);

//Rutas de autenticación
Route::middleware(['auth:sanctum'])->group(function(){
    
    Route::post('/logout', [AuthController::class, 'logout']);
});
Route::middleware('auth:sanctum')->get('/user', [AuthController::class, 'user']);
Route::post('/login', [AuthController::class, 'login',])->name('login');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register']);
