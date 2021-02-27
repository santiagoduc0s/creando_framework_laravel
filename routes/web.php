<?php



Route::get('/', ControllerUsuarios::class.'@index');

Route::get("/prueba/:nombre", function ($nombre, Request $request) {
    return "El nombre es $nombre y el apellido {$request->apellido}";
});

Route::get('/listar_usuarios', ControllerUsuarios::class.'@listarUsuarios');

Route::post('/listar/usuarios', ControllerUsuarios::class.'@listarUsuarios');

Route::put('/listar/usuarios', ControllerUsuarios::class.'@listarUsuarios');

Route::delete('/listar/usuarios', ControllerUsuarios::class.'@listarUsuarios');