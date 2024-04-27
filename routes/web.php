<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpotifyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/spotify/search', [SpotifyController::class, 'search']);

Route::get('/{any}', function () {
    return view('welcome'); // Asegúrate de que 'welcome' es la vista que contiene tu app Vue
})->where('any', '.*');