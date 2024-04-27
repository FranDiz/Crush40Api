<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/saludo', function () {
    return response()->json(['mensaje' => 'Hola Mundo']);
});
Route::post('/storePlaylist',[ApiController::class, 'store']);
Route::post('/storeUser',[UsersController::class,'storeUser']);


//Rutas de autenticación
Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('/user', [AuthController::class,'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::post('/login', [AuthController::class, 'login',])->name('login');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register']);
