<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CamisetasController;
use App\Http\Controllers\Admin\TallesController;
use App\Http\Controllers\Admin\UserController;
use App\Models\User;

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

/*
rutas para registro, inicio de sesión, cierre de sesión, ver perfil, actualizar perfil
*/

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
// Rutas protegidas
Route::group(['middleware' => 'auth'], function () {
    Route::post('/logout', [UserController::class, 'logout']);
    Route::get('/profile', [UserController::class, 'profile']);
    Route::put('/profile', [UserController::class, 'updateProfile']);
});


// Rutas protegidas para la gestión de usuarios (CRUD)
Route::middleware('auth:sanctum')->prefix('admin')->name('admin.')->group(function() {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/bulk-destroy', [UserController::class, 'bulkDestroy'])->name('users.bulk-destroy');
});


// Rutas para la API de Camisetas
Route::prefix('camisetas')->name('camisetas.')->group(function() {
    Route::get('/', [CamisetasController::class, 'apiIndex'])->name('index');
    Route::get('/clubes-nacionales', [CamisetasController::class, 'apiIndexClubesNacionales'])->name('clubes-nacionales');
    Route::get('/clubes-internacionales', [CamisetasController::class, 'apiIndexClubesInternacionales'])->name('clubes-internacionales');
    Route::get('/selecciones', [CamisetasController::class, 'apiIndexSelecciones'])->name('selecciones');
});

Route::get('/talles', [TallesController::class, 'apiIndex'])->name('index');