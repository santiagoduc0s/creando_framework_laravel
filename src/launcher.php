<?php

require_once './src/Roots.php';
require_once PATH_SRC . 'autoloader/Autoloader.php';

Autoloader::registrar();

$rutas = scandir(PATH_ROUTES);

foreach ($rutas as $archivo) {
    $rutaArchivo = realpath(PATH_ROUTES . $archivo);
    if (is_file($rutaArchivo)) {
        require $rutaArchivo;
    }
}

Route::load();
