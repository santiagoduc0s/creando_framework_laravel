<?php

class EMessages
{
    const CORRECTO = 'CORRECTO';
    const ERROR = 'ERROR';
    const LISTADO_EXITOSO = 'LISTADO_EXITOSO';
    const NO_HAY_REGISTROS = 'NO_HAY_REGISTROS';
    const BUSQUEDA_EXITOSA = 'BUSQUEDA_EXITOSA';
    const REGISTRO_NO_ENCONTRADO = 'REGISTRO_NO_ENCONTRADO';
    const INSERCION_EXITOSA = 'INSERCION_EXITOSA';
    const INSERCION_ERRONEA = 'INSERCION_ERRONEA';
    const ACTUALIZACION_EXITOSA = 'ACTUALIZACION_EXITOSA';
    const ACTUALIZACION_ERRONEA = 'ACTUALIZACION_ERRONEA';
    const ELIMINACION_EXITOSA = 'ELIMINACION_EXITOSA';
    const ELIMINACION_ERRONEA = 'ELIMINACION_ERRONEA';
    const CONEXION_BD_ERRONEA = 'CONEXION_BD_ERRONEA';
    const CORREO_DUPLICADO = 'CORREO_DUPLICADO';

    public static function getMessage($code)
    {
        switch ($code) {
            case EMessages::CORRECTO:
                return new Response(1, 'Se ha realizado la operacion de manera correcta.');
            case EMessages::LISTADO_EXITOSO:
                return new Response(1, 'Se ha listado los registro con éxito.');
            case EMessages::BUSQUEDA_EXITOSA:
                return new Response(1, 'Se ha encontrado el registro buscado.');
            case EMessages::INSERCION_EXITOSA:
                return new Response(1, 'Se ha insertado el registro con éxito.');
            case EMessages::ACTUALIZACION_EXITOSA:
                return new Response(1, 'Se ha actualizado el registro con éxito.');
            case EMessages::ELIMINACION_EXITOSA:
                return new Response(1, 'Se ha eliminado el registro con éxito.');

            case EMessages::ERROR:
                return new Response(-1, 'Se ha producido un error al realizar la operacion.');
            case EMessages::NO_HAY_REGISTROS:
                return new Response(0, 'No se encontraron registros.');
            case EMessages::REGISTRO_NO_ENCONTRADO:
                return new Response(0, 'No se ha encontrado el registro.');
            case EMessages::INSERCION_ERRONEA:
                return new Response(-1, 'Se ha producido un error en la inserción del registro.');
            case EMessages::ACTUALIZACION_ERRONEA:
                return new Response(-1, 'Se ha producido un error en la actualización del registro.');
            case EMessages::ELIMINACION_ERRONEA:
                return new Response(-1, 'Se ha producido un error en la eliminación del registro.');

            case EMessages::CONEXION_BD_ERRONEA:
                return new Response(-1, 'Ha ocurrido un error al conectar a la base de datos.');

            case EMessages::CORREO_DUPLICADO:
                return new Response(-1, 'El correo ingresado ya está registrado.');
        }
    }
}
