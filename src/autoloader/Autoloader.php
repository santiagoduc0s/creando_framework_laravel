<?php

class Autoloader
{

    public static function registrar()
    {
        /*
         *
         * Si su función de carga automática es un método de 
         * clase, puede llamar a spl_autoload_register con una 
         * matriz que especifica la clase y el método a ejecutar.
         * 
         * spl_autoload_register le pasa como parametro a la funcion
         * cargar($nombreDeLaClase), el nombre de la clase que se 
         * requiere cargar.
         *   
         */

        spl_autoload_register([Autoloader::class, 'cargar'], true, true);

        /*
         *
         * El segundo parametro especifica si se debe lanzar una
         * exepcion cuando no se pueda cargar alguna clase
         * 
         * El tercer parametro especifica que se priorizara el
         * autoloader en vez de posponerlo
         * 
         */
    }

    private static function cargar($clase)
    {
        //echo '<h1>'.$clase.'</h1>';
        $nombreArchivo = $clase . '.php'; // nombre del archivo buscado
        $carpetas = require PATH_CONFIG . 'autoloader.php'; // carpetas generales en donde buscar las clases

        foreach ($carpetas as $carpeta) { // recorrer carpetas
            if (self::buscarArchivo($carpeta, $nombreArchivo)) {
                //echo 'true';
                return true;
            }
        }
        return false;
    }

    private static function buscarArchivo($carpeta, $nombreArchivo)
    {
        $archivos = scandir($carpeta); // archivos dentro de la carpeta

        if ($archivo[0] = '.' && $archivo[1] = '..') {
            unset($archivos[0]); // .
            unset($archivos[1]); // ..
            $archivos = array_values($archivos);
        }

        foreach ($archivos as $archivo) { // recorrer archivos

            $rutaArchivo = realpath($carpeta . DIRECTORY_SEPARATOR . $archivo);

            if (is_file($rutaArchivo)) { // si el archivo no es una carpeta

                if ($nombreArchivo == $archivo) { // verifica si es el archivo buscado
                    require_once $rutaArchivo;
                    return true;
                }
            } else { // si el archivo es una carpeta

                if (self::buscarArchivo($rutaArchivo, $nombreArchivo)) {
                    return true;
                }
            }
        }

        return false; // si no se encuentra la clase buscada en la carpeta general actual
    }
}
