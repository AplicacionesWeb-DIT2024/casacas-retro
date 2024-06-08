<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CamisetasController;
use App\Http\Controllers\Admin\TallesController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas para la API de Camisetas
Route::prefix('camisetas')->name('camisetas.')->group(function() {
    Route::get('/', [CamisetasController::class, 'apiIndex'])->name('index');
    Route::get('/clubes-nacionales', [CamisetasController::class, 'apiIndexClubesNacionales'])->name('clubes-nacionales');
    Route::get('/clubes-internacionales', [CamisetasController::class, 'apiIndexClubesInternacionales'])->name('clubes-internacionales');
    Route::get('/selecciones', [CamisetasController::class, 'apiIndexSelecciones'])->name('selecciones');
});

Route::get('/talles', [TallesController::class, 'apiIndex'])->name('index');