<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViajesController;

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
    return view('app');
})->name('app');

// Ruta para el guardado de viajes, utiliza el método "store" del controlador "ViajesController".
Route::post('/', [ViajesController::class, 'store'])->name('viajes.store');