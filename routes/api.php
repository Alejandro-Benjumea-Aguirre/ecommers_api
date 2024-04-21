<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function () {
    return 'Consultando usuarios';
});

Route::get('/user/{id}', function () {
    return 'Consultando un usuario';
});

Route::post('/user', function () {
    return 'Creando usuarios';
});

Route::put('/user/{id}', function () {
    return 'Actualizando usuarios';
});

Route::delete('/user/{id}', function () {
    return 'Eliminando usuarios';
});


