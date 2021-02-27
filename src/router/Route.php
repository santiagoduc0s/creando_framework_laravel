<?php

class Route
{
    public static $uris = [];

    public static function add($method, $uri, $callback = null)
    {
        self::$uris[] = new Uri(self::parseUri($uri), $method, $callback);
    }

    public static function get($uri, $funcion = null)
    {
        self::add('GET', $uri, $funcion);
    }

    public static function post($uri, $funcion = null)
    {
        self::add('POST', $uri, $funcion);
    }

    public static function put($uri, $funcion = null)
    {
        self::add('PUT', $uri, $funcion);
    }

    public static function delete($uri, $funcion = null)
    {
        self::add('DELETE', $uri, $funcion);
    }

    public static function any($uri, $function = null)
    {
        return Route::add("ANY", $uri, $function);
    }

    public static function load()
    {
        $uri = isset($_GET['uri']) ? self::parseUri($_GET['uri']) : '/';

        // Comprobamos si la url solicitada esta registrada
        foreach (Route::$uris as $recordUri) {
            if ($recordUri->match($uri)) { // Si lo esta
                $recordUri->call();
                return;
            }
        }

        //Si la uri no esta 
        self::uri_undefined($uri, $_SERVER['REQUEST_METHOD']);
    }

    private static function parseUri($uri) // saludame/santiago/
    {
        $uri = trim($uri, '/'); // saludame/santiago
        $uri = (strlen($uri) > 0) ? $uri : '/';
        return $uri;
    }

    private static function uri_undefined($uri, $method)
    {
        header("Content-Type: text/html");
        echo 'La uri (<a href="' . $uri . '">' . $uri . '</a>) no se encuentra regiostrada en el método ' . $method . '.';
    }
}
