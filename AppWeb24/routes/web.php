<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin.')->group(function () {
    // Rutas para administración de usuarios
    Route::prefix('admin-users')->name('admin-users/')->group(static function() {
        Route::get('/',                                             'AdminUsersController@index')->name('index');
        Route::get('/create',                                       'AdminUsersController@create')->name('create');
        Route::post('/',                                            'AdminUsersController@store')->name('store');
        Route::get('/{adminUser}/impersonal-login',                 'AdminUsersController@impersonalLogin')->name('impersonal-login');
        Route::get('/{adminUser}/edit',                             'AdminUsersController@edit')->name('edit');
        Route::post('/{adminUser}',                                 'AdminUsersController@update')->name('update');
        Route::delete('/{adminUser}',                               'AdminUsersController@destroy')->name('destroy');
        Route::get('/{adminUser}/resend-activation',                'AdminUsersController@resendActivationEmail')->name('resendActivationEmail');
    });
    
    // Rutas para el perfil y contraseña del usuario ADMINISTRADOR
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::get('/profile',                                      'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile',                                     'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password',                                     'ProfileController@editPassword')->name('edit-password');
        Route::post('/password',                                    'ProfileController@updatePassword')->name('update-password');
    });

    // Rutas para administración de CAMISETAS
    Route::prefix('camisetas')->name('camisetas/')->group(static function() {
        Route::get('/',                                             'CamisetasController@index')->name('index');
        Route::get('/create',                                       'CamisetasController@create')->name('create');
        Route::post('/',                                            'CamisetasController@store')->name('store');
        Route::get('/{camisetum}/edit',                             'CamisetasController@edit')->name('edit');
        Route::post('/bulk-destroy',                                'CamisetasController@bulkDestroy')->name('bulk-destroy');
        Route::post('/{camisetum}',                                 'CamisetasController@update')->name('update');
        Route::delete('/{camisetum}',                               'CamisetasController@destroy')->name('destroy');
        // Rutas para las subcategorías de CAMISETAS
        Route::get('/clubes-nacionales', 'CamisetasController@indexClubesNacionales')->name('clubes-nacionales');
        Route::get('/clubes-internacionales', 'CamisetasController@indexClubesInternacionales')->name('clubes-internacionales');
        Route::get('/selecciones', 'CamisetasController@indexSelecciones')->name('selecciones');
    });

    // Rutas para administración de TALLES
    Route::prefix('talles')->name('talles/')->group(static function() {
        Route::get('/',                                             'TallesController@index')->name('index');
        Route::get('/create',                                       'TallesController@create')->name('create');
        Route::post('/',                                            'TallesController@store')->name('store');
        Route::get('/{talle}/edit',                                 'TallesController@edit')->name('edit');
        Route::post('/bulk-destroy',                                'TallesController@bulkDestroy')->name('bulk-destroy');
        Route::post('/{talle}',                                     'TallesController@update')->name('update');
        Route::delete('/{talle}',                                   'TallesController@destroy')->name('destroy');
    });

    // Rutas adicionales para administración de usuarios
    Route::prefix('users')->name('users.')->group(static function() {
        Route::get('/', 'UserController@index')->name('index');
        Route::get('/create', 'UserController@create')->name('create');
        Route::post('/', 'UserController@store')->name('store');
        Route::get('/{user}/edit', 'UserController@edit')->name('edit');
        Route::post('/bulk-destroy', 'UserController@bulkDestroy')->name('bulk-destroy');
        Route::post('/{user}', 'UserController@update')->name('update');
        Route::delete('/{user}', 'UserController@destroy')->name('destroy');
    });

});